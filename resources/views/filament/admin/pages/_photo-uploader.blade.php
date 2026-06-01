{{--
  Shared product photo uploader.
  Drag-drop + instant previews + crop/rotate (Cropper.js) + drag-to-reorder (SortableJS).
  Requires Cropper.js + SortableJS loaded via the page's @push('scripts'/'styles').

  Props:
    $mode   'create' | 'edit'   (default 'create')
    On edit pages the component reads $record + $existing_media_ids to seed existing thumbs.
--}}
@php
    $mode = $mode ?? 'create';
    $initialExisting = [];
    if ($mode === 'edit' && isset($record)) {
        foreach ($record->getMedia('gallery') as $m) {
            if (in_array($m->id, $existing_media_ids ?? [], true)) {
                $initialExisting[] = ['id' => $m->id, 'url' => $m->getUrl()];
            }
        }
    }
@endphp

<style>
    [x-cloak]{display:none!important}
    .pp-photo-add{width:100%}
    .pp-photo-add.is-drag{border-color:#3b82f6;background:#eff6ff}
    .dark .pp-photo-add.is-drag{background:#1e3a8a}
    .pp-photo{cursor:grab}
    .pp-photo.sortable-ghost{opacity:.35}
    .pp-photo-main{position:absolute;bottom:6px;left:6px;background:#2563eb;color:#fff;font-size:10px;font-weight:700;
        padding:2px 7px;border-radius:980px;letter-spacing:.02em;pointer-events:none}
    .pp-photo-crop{position:absolute;top:6px;left:6px;width:24px;height:24px;border-radius:50%;background:rgba(0,0,0,.6);
        color:#fff;border:none;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center}
    .pp-photo-crop:hover{background:rgba(37,99,235,.95)}
    .pp-reorder-hint{font-size:12px;color:#9ca3af;margin-top:8px}
    /* ---- Crop modal (redesigned: clear header, labelled groups, big actions) ---- */
    .pp-crop-backdrop{position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.72);
        -webkit-backdrop-filter:blur(3px);backdrop-filter:blur(3px);
        display:flex;align-items:center;justify-content:center;padding:16px}
    .pp-crop-modal{background:#fff;border-radius:18px;max-width:560px;width:100%;max-height:94vh;overflow:hidden;
        display:flex;flex-direction:column;box-shadow:0 24px 60px rgba(0,0,0,.45)}
    .dark .pp-crop-modal{background:#1f2937}
    .pp-crop-head{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #eef2f7}
    .dark .pp-crop-head{border-color:#374151}
    .pp-crop-title{font-size:16px;font-weight:700;color:#0f172a;letter-spacing:-.01em}
    .dark .pp-crop-title{color:#f9fafb}
    .pp-crop-close{width:34px;height:34px;border-radius:50%;border:none;background:#f1f5f9;color:#334155;
        font-size:17px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center}
    .pp-crop-close:hover{background:#e2e8f0}
    .dark .pp-crop-close{background:#374151;color:#e5e7eb}
    .pp-crop-stage{background:#0b0b0c;max-height:50vh;min-height:240px;display:flex;align-items:center;justify-content:center}
    .pp-crop-stage img{max-width:100%;display:block}
    .pp-crop-hint{font-size:12px;color:#94a3b8;text-align:center;padding:10px 16px 0;line-height:1.5}
    .pp-crop-row{display:flex;align-items:center;gap:12px;padding:12px 16px 0}
    .pp-crop-row-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#64748b;min-width:74px}
    .dark .pp-crop-row-lbl{color:#9ca3af}
    .pp-crop-straighten input[type=range]{flex:1;height:6px;accent-color:#2563eb;cursor:pointer}
    .pp-crop-angle{font-size:13px;font-weight:700;color:#2563eb;min-width:44px;text-align:right;font-variant-numeric:tabular-nums}
    .pp-crop-mini{border:1px solid #d1d5db;background:#fff;color:#334155;border-radius:8px;
        padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer}
    .dark .pp-crop-mini{background:#374151;border-color:#4b5563;color:#f9fafb}
    .pp-crop-tools{display:flex;align-items:flex-start;gap:16px;padding:14px 16px;flex-wrap:wrap}
    .pp-crop-group{display:flex;flex-direction:column;gap:6px}
    .pp-crop-group-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8}
    .pp-crop-group-btns{display:flex;gap:6px}
    .pp-crop-tools button{border:1px solid #d1d5db;background:#fff;color:#0f172a;border-radius:10px;
        min-width:46px;height:40px;padding:0 12px;font-size:16px;font-weight:600;cursor:pointer;
        display:flex;align-items:center;justify-content:center}
    .pp-crop-tools button:hover{border-color:#94a3b8}
    .dark .pp-crop-tools button{background:#374151;border-color:#4b5563;color:#f9fafb}
    .pp-crop-tools button.on{border-color:#2563eb;color:#2563eb;background:#eff6ff}
    .dark .pp-crop-tools button.on{background:#1e3a8a;color:#fff;border-color:#3b82f6}
    .pp-crop-shape button{font-size:13px;font-weight:700}
    .pp-crop-foot{display:flex;gap:10px;padding:12px 16px 16px;border-top:1px solid #eef2f7;margin-top:2px}
    .dark .pp-crop-foot{border-color:#374151}
    .pp-crop-original{height:50px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;
        border:1px solid #d1d5db;background:#fff;color:#475569;padding:0 18px}
    .dark .pp-crop-original{background:#374151;border-color:#4b5563;color:#f9fafb}
    .pp-crop-apply{flex:1;height:50px;border-radius:12px;font-size:16px;font-weight:700;cursor:pointer;
        border:1px solid #2563eb;background:#2563eb;color:#fff;box-shadow:0 8px 18px rgba(37,99,235,.32)}
    .pp-crop-apply:hover{background:#1d4ed8;border-color:#1d4ed8}
    @media(max-width:560px){
        .pp-crop-backdrop{padding:8px}
        .pp-crop-stage{max-height:42vh}
        .pp-crop-row-lbl{min-width:62px}
        .pp-crop-original{padding:0 12px}
    }
</style>

<div class="pp-card"
     wire:ignore
     x-data="photoUploader({ mode: '{{ $mode }}', existing: @js($initialExisting), max: 8 })">

    <div class="pp-section-head">
        <h2 class="pp-h2">📷 Photos</h2>
        <span class="pp-sub"
              :style="(items.length >= max) ? 'color:#f97316;font-weight:700' : ''"
              x-text="items.length + ' / ' + max + ' photos'"></span>
    </div>

    {{-- Thumbnail grid (Sortable target) --}}
    <div class="pp-photos-grid" x-ref="grid">
        <template x-for="(it, idx) in items" :key="it.id">
            <div class="pp-photo" :data-id="it.id">
                <img :src="it.url" alt="">
                <span class="pp-photo-main" x-show="idx === 0">Main</span>
                <button type="button" class="pp-photo-x" title="Remove"
                        @click="remove(it)">✕</button>
                <button type="button" class="pp-photo-crop" title="Crop" x-show="it.type === 'new'"
                        @click="recrop(it)">✂</button>
            </div>
        </template>
    </div>

    {{-- Dropzone --}}
    <label class="pp-photo-add" x-show="items.length < max" :class="drag && 'is-drag'"
           @dragover.prevent="drag = true"
           @dragleave.prevent="drag = false"
           @drop.prevent="drag = false; handleFiles($event.dataTransfer.files)">
        <input type="file" multiple accept="image/*" style="display:none"
               @change="handleFiles($event.target.files); $event.target.value = ''">
        <div class="pp-photo-add-inner">
            <span class="pp-photo-ico">🖼️</span>
            <span>Drag &amp; Drop your photos here, <span class="pp-link">or Click to Browse</span></span>
            <span class="pp-photo-hint">Crop &amp; rotate before saving · supports jpg, png, webp, gif, heic</span>
        </div>
        <div x-show="uploading" class="pp-uploading">Uploading…</div>
    </label>

    <div class="pp-reorder-hint" x-show="items.length > 1">↕ Drag photos to reorder · the first photo is the main image.</div>

    {{-- Crop / rotate modal --}}
    <div class="pp-crop-backdrop" x-show="cropOpen" x-cloak style="display:none">
        <div class="pp-crop-modal">
            {{-- Header --}}
            <div class="pp-crop-head">
                <span class="pp-crop-title">✂️ Crop photo</span>
                <button type="button" class="pp-crop-close" title="Cancel" @click="cancelCrop()">✕</button>
            </div>

            {{-- Image stage --}}
            <div class="pp-crop-stage"><img x-ref="cropImg" alt="crop"></div>
            <p class="pp-crop-hint">Drag the photo to move it · drag the corners to resize · only what's inside the frame is saved.</p>

            {{-- Straighten dial (fine rotation) --}}
            <div class="pp-crop-row pp-crop-straighten">
                <span class="pp-crop-row-lbl">Straighten</span>
                <input type="range" min="-45" max="45" step="1" x-model.number="straighten" @input="applyAngle()" title="Straighten">
                <span class="pp-crop-angle" x-text="(straighten > 0 ? '+' : '') + straighten + '°'"></span>
                <button type="button" class="pp-crop-mini" x-show="straighten !== 0"
                        @click="straighten = 0; applyAngle()">Reset</button>
            </div>

            {{-- Tool groups --}}
            <div class="pp-crop-tools">
                <div class="pp-crop-group">
                    <span class="pp-crop-group-lbl">Rotate</span>
                    <div class="pp-crop-group-btns">
                        <button type="button" @click="rotate(-90)" title="Rotate left">↺</button>
                        <button type="button" @click="rotate(90)" title="Rotate right">↻</button>
                    </div>
                </div>
                <div class="pp-crop-group">
                    <span class="pp-crop-group-lbl">Flip</span>
                    <div class="pp-crop-group-btns">
                        <button type="button" @click="flipX()" :class="scaleX === -1 && 'on'" title="Flip horizontal">⇆</button>
                        <button type="button" @click="flipY()" :class="scaleY === -1 && 'on'" title="Flip vertical">⇅</button>
                    </div>
                </div>
                <div class="pp-crop-group pp-crop-shape">
                    <span class="pp-crop-group-lbl">Shape</span>
                    <div class="pp-crop-group-btns">
                        <button type="button" @click="setAspect(1)" :class="aspect === 1 && 'on'">Square</button>
                        <button type="button" @click="setAspect(0)" :class="!aspect && 'on'">Free</button>
                    </div>
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="pp-crop-foot">
                <button type="button" class="pp-crop-original" @click="skipCrop()">Use original</button>
                <button type="button" class="pp-crop-apply" @click="applyCrop()">Apply ✓</button>
            </div>
        </div>
    </div>
</div>

@error('photos') <div class="pp-err" style="margin-top:8px">{{ $message }}</div> @enderror
@error('photos.*') <div class="pp-err" style="margin-top:8px">{{ $message }}</div> @enderror

