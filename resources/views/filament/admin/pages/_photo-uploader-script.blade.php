{{--
  photoUploader() Alpine component definition.
  Pushed once to the page-level scripts stack so it is present on initial page load.
  IMPORTANT: it must NOT live inside the step-2 partial — that block is rendered into the
  DOM by a Livewire morph (when the owner clicks "Continue"), and Livewire morphs do not
  execute <script> tags, which would leave window.photoUploader undefined.
--}}
<script>
    window.photoUploader = function (config) {
        return {
            mode: config.mode,
            max: config.max || 8,
            cfgExisting: config.existing || [],
            items: [],            // {type:'existing'|'new', id, url, file?}
            drag: false,
            uploading: false,
            // crop state
            cropOpen: false,
            cropper: null,
            aspect: 1,
            baseRotate: 0,   // accumulated 90° steps from the ↺/↻ buttons
            straighten: 0,   // fine angle from the dial (-45..45)
            scaleX: 1,       // -1 = flipped horizontally
            scaleY: 1,       // -1 = flipped vertically
            _cropFile: null,
            _cropResolve: null,
            _recropItem: null,

            init() {
                this.items = this.cfgExisting.map((m) => ({ type: 'existing', id: 'ex-' + m.id, mediaId: m.id, url: m.url }));
                this._ensure('Sortable', () => this._initSort());
            },

            _ensure(name, cb) {
                if (window[name]) return cb();
                let n = 0;
                const t = setInterval(() => {
                    if (window[name] || n++ > 50) { clearInterval(t); if (window[name]) cb(); }
                }, 100);
            },

            _initSort() {
                this.sortable = window.Sortable.create(this.$refs.grid, {
                    animation: 150,
                    draggable: '.pp-photo',
                    ghostClass: 'sortable-ghost',
                    onEnd: (evt) => {
                        if (evt.oldIndex === evt.newIndex || evt.oldIndex == null) return;
                        const moved = this.items.splice(evt.oldIndex, 1)[0];
                        this.items.splice(evt.newIndex, 0, moved);
                        this.items = [...this.items]; // force Alpine re-render to match keys
                        this.sync();
                    },
                });
            },

            uid() { return 'n-' + Date.now() + '-' + Math.random().toString(36).slice(2, 8); },

            canCrop(file) {
                return /^image\/(jpeg|jpg|png|webp|gif)$/i.test(file.type);
            },

            async handleFiles(fileList) {
                const arr = Array.from(fileList || []);
                for (const file of arr) {
                    if (this.items.length >= this.max) break;
                    if (!file.type.startsWith('image/')) continue;
                    let out = file;
                    if (this.canCrop(file)) {
                        out = await this.openCropper(file);
                    }
                    if (!out) continue;
                    this.items.push({ type: 'new', id: this.uid(), file: out, url: URL.createObjectURL(out) });
                }
                this.sync();
            },

            remove(it) {
                if (it.type === 'new' && it.url) URL.revokeObjectURL(it.url);
                this.items = this.items.filter((x) => x.id !== it.id);
                this.sync();
            },

            async recrop(it) {
                const cropped = await this.openCropper(it.file);
                if (!cropped) return;
                if (it.url) URL.revokeObjectURL(it.url);
                it.file = cropped;
                it.url = URL.createObjectURL(cropped);
                this.items = [...this.items];
                this.sync();
            },

            sync() {
                const existingIds = this.items.filter((i) => i.type === 'existing').map((i) => i.mediaId);
                const newFiles = this.items.filter((i) => i.type === 'new').map((i) => i.file);
                if (this.mode === 'edit') {
                    this.$wire.set('existing_media_ids', existingIds, false);
                }
                this.uploading = newFiles.length > 0;
                this.$wire.uploadMultiple('photos', newFiles,
                    () => { this.uploading = false; },
                    () => { this.uploading = false; });
            },

            // ---- Cropper modal ----
            openCropper(file) {
                return new Promise((resolve) => {
                    if (!window.Cropper) { resolve(file); return; } // lib not ready -> keep original
                    this._cropFile = file;
                    this._cropResolve = resolve;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.cropOpen = true;
                        this.$nextTick(() => {
                            const img = this.$refs.cropImg;
                            img.src = e.target.result;
                            if (this.cropper) { this.cropper.destroy(); this.cropper = null; }
                            // fresh transform state for each photo
                            this.baseRotate = 0;
                            this.straighten = 0;
                            this.scaleX = 1;
                            this.scaleY = 1;
                            this.cropper = new window.Cropper(img, {
                                viewMode: 1,
                                autoCropArea: 1,
                                aspectRatio: this.aspect ? 1 : NaN,
                                background: false,
                                movable: true,
                                zoomable: true,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                });
            },

            // 90° steps — keep the fine straighten offset applied on top
            rotate(deg) {
                if (!this.cropper) return;
                this.baseRotate = (this.baseRotate + deg) % 360;
                this.cropper.rotateTo(this.baseRotate + this.straighten);
            },

            // fine straighten dial (-45..45) on top of the base rotation
            applyAngle() {
                if (this.cropper) this.cropper.rotateTo(this.baseRotate + this.straighten);
            },

            flipX() {
                if (!this.cropper) return;
                this.scaleX = -this.scaleX;
                this.cropper.scaleX(this.scaleX);
            },

            flipY() {
                if (!this.cropper) return;
                this.scaleY = -this.scaleY;
                this.cropper.scaleY(this.scaleY);
            },

            setAspect(a) {
                this.aspect = a ? 1 : 0;
                if (this.cropper) this.cropper.setAspectRatio(this.aspect ? 1 : NaN);
            },

            applyCrop() {
                if (!this.cropper) return this.skipCrop();
                const canvas = this.cropper.getCroppedCanvas({ maxWidth: 2200, maxHeight: 2200, imageSmoothingQuality: 'high' });
                if (!canvas) return this.skipCrop();
                canvas.toBlob((blob) => {
                    const base = (this._cropFile.name || 'photo').replace(/\.[^.]+$/, '');
                    const f = new File([blob], base + '.jpg', { type: 'image/jpeg' });
                    const resolve = this._cropResolve;
                    this._closeCrop();
                    resolve(f);
                }, 'image/jpeg', 0.92);
            },

            skipCrop() {
                const original = this._cropFile;
                const resolve = this._cropResolve;
                this._closeCrop();
                if (resolve) resolve(original);
            },

            // ✕ / Cancel — close without adding this photo at all
            cancelCrop() {
                const resolve = this._cropResolve;
                this._closeCrop();
                if (resolve) resolve(null);
            },

            _closeCrop() {
                if (this.cropper) { this.cropper.destroy(); this.cropper = null; }
                this.cropOpen = false;
                this._cropFile = null;
                this._cropResolve = null;
            },
        };
    };
</script>
