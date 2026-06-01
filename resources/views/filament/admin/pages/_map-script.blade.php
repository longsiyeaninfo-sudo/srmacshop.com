{{--
  Defines window.ppMap — the Leaflet location picker used by the step-2 "Location"
  card on the Add Product page.

  MUST be @include'd from the page's TOP-LEVEL @push('scripts') (initial load), NOT
  left inside the step-2 block. Livewire morphs (the step1→step2 transition) do NOT
  execute <script> tags, so a definition living inside the morphed-in step-2 content
  never runs and Alpine throws "ppMap is not defined". Pushing it at page level makes
  ppMap available on window before the morph brings in the map element.

  Requires Leaflet (loaded just above in the same @push('scripts')).
--}}
<script>
    window.ppMap = (lat, lng) => ({
        map: null,
        marker: null,
        init(el) {
            if (!window.L) return setTimeout(() => this.init(el), 200);
            if (!el || this.map || el._leaflet_id) return;   // bail if no element or already initialised
            const start = [lat || 11.4991644, lng || 104.7708382];
            this.map = L.map(el).setView(start, 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(this.map);
            this.marker = L.marker(start, { draggable: true }).addTo(this.map);
            const send = (latlng) => {
                if (window.Livewire && window.Livewire.find) {
                    const id = el.closest('[wire\\:id]')?.getAttribute('wire:id');
                    if (id) {
                        const comp = window.Livewire.find(id);
                        comp?.set('latitude', latlng.lat, false);
                        comp?.set('longitude', latlng.lng, false);
                    }
                }
            };
            this.marker.on('dragend', (e) => send(e.target.getLatLng()));
            this.map.on('click', (e) => { this.marker.setLatLng(e.latlng); send(e.latlng); });
            setTimeout(() => this.map.invalidateSize(), 200);
        }
    });
</script>
