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
    .pp-crop-backdrop{position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.7);display:flex;align-items:center;
        justify-content:center;padding:20px}
    .pp-crop-modal{background:#fff;border-radius:14px;max-width:680px;width:100%;overflow:hidden;display:flex;flex-direction:column}
    .dark .pp-crop-modal{background:#1f2937}
    .pp-crop-stage{background:#111;max-height:60vh;min-height:280px;display:flex;align-items:center;justify-content:center}
    .pp-crop-stage img{max-width:100%;display:block}
    .pp-crop-tools{display:flex;align-items:center;gap:8px;padding:12px 14px;flex-wrap:wrap}
    .pp-crop-tools button{border:1px solid #d1d5db;background:#fff;color:#111827;border-radius:8px;padding:8px 12px;
        font-size:13px;font-weight:600;cursor:pointer}
    .dark .pp-crop-tools button{background:#374151;border-color:#4b5563;color:#f9fafb}
    .pp-crop-tools button.on{border-color:#2563eb;color:#2563eb;background:#eff6ff}
    .dark .pp-crop-tools button.on{background:#1e3a8a;color:#fff}
    .pp-crop-spacer{flex:1}
    .pp-crop-apply{background:#2563eb!important;border-color:#2563eb!important;color:#fff!important}
    .pp-crop-straighten{display:flex;align-items:center;gap:10px;padding:12px 14px 0}
    .pp-crop-straighten input[type=range]{flex:1;height:4px;accent-color:#2563eb;cursor:pointer}
    .pp-crop-angle{font-size:13px;font-weight:700;color:#2563eb;min-width:48px;text-align:center;font-variant-numeric:tabular-nums}
    .pp-crop-angle-reset{border:1px solid #d1d5db;background:#fff;color:#111827;border-radius:8px;
        padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer}
    .dark .pp-crop-angle-reset{background:#374151;border-color:#4b5563;color:#f9fafb}
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
        <div class="pp-crop-modal" @click.outside="skipCrop()">
            <div class="pp-crop-stage"><img x-ref="cropImg" alt="crop"></div>

            {{-- Straighten dial (fine rotation) --}}
            <div class="pp-crop-straighten">
                <span class="pp-crop-angle" x-text="(straighten > 0 ? '+' : '') + straighten + '°'"></span>
                <input type="range" min="-45" max="45" step="1" x-model.number="straighten" @input="applyAngle()" title="Straighten">
                <button type="button" class="pp-crop-angle-reset" x-show="straighten !== 0"
                        @click="straighten = 0; applyAngle()">Reset</button>
            </div>

            <div class="pp-crop-tools">
                <button type="button" @click="rotate(-90)" title="Rotate left">↺</button>
                <button type="button" @click="rotate(90)" title="Rotate right">↻</button>
                <button type="button" @click="flipX()" :class="scaleX === -1 && 'on'" title="Flip horizontal">⇆</button>
                <button type="button" @click="flipY()" :class="scaleY === -1 && 'on'" title="Flip vertical">⇅</button>
                <button type="button" @click="setAspect(1)" :class="aspect === 1 && 'on'">Square</button>
                <button type="button" @click="setAspect(0)" :class="!aspect && 'on'">Free</button>
                <span class="pp-crop-spacer"></span>
                <button type="button" @click="skipCrop()">Skip</button>
                <button type="button" class="pp-crop-apply" @click="applyCrop()">Apply ✓</button>
            </div>
        </div>
    </div>
</div>

@error('photos') <div class="pp-err" style="margin-top:8px">{{ $message }}</div> @enderror
@error('photos.*') <div class="pp-err" style="margin-top:8px">{{ $message }}</div> @enderror

