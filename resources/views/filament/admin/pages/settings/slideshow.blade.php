<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">

        {{-- ── Master switch ── --}}
        <div class="st-card">
            <h2 class="st-h">🖼 Homepage slideshow</h2>
            <p class="st-sub">The big photo carousel at the top of your homepage. Slides come from <strong>Marketing → Homepage Slideshow</strong>; this page controls how the section looks and behaves.</p>

            <label class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Show slideshow on homepage</div>
                    <div class="st-tg-d">Turn off to hide the entire slideshow section without deleting any slides.</div>
                </div>
                <div class="st-sw {{ $enabled ? 'on' : '' }}" wire:click="$toggle('enabled')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>
        </div>

        {{-- ── Section heading ── --}}
        <div class="st-card">
            <h2 class="st-h">✏️ Section heading <span class="st-bdg">optional</span></h2>
            <p class="st-sub">Shows a small label + title above the slideshow. Leave both blank for no heading.</p>

            <div class="st-row2">
                <div class="st-f">
                    <label>Eyebrow label (English)</label>
                    <input type="text" class="st-input" wire:model.live="eyebrowEn"
                           placeholder="✨ Featured" maxlength="60">
                    @error('eyebrowEn') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Title (English)</label>
                    <input type="text" class="st-input" wire:model.live="headingEn"
                           placeholder="Today's spotlight" maxlength="120">
                    @error('headingEn') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="st-row2">
                <div class="st-f">
                    <label>Eyebrow — ខ្មែរ (Khmer) <span class="st-bdg">optional</span></label>
                    <input type="text" class="st-input" wire:model="eyebrowKm" maxlength="80">
                    @error('eyebrowKm') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Title — ខ្មែរ (Khmer) <span class="st-bdg">optional</span></label>
                    <input type="text" class="st-input" wire:model="headingKm" maxlength="160">
                    @error('headingKm') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="st-row2">
                <div class="st-f">
                    <label>Eyebrow — 中文 (Chinese) <span class="st-bdg">optional</span></label>
                    <input type="text" class="st-input" wire:model="eyebrowZh" maxlength="60">
                    @error('eyebrowZh') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Title — 中文 (Chinese) <span class="st-bdg">optional</span></label>
                    <input type="text" class="st-input" wire:model="headingZh" maxlength="120">
                    @error('headingZh') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="st-hint">Khmer / Chinese are optional — if blank, the English text is shown for those languages.</div>
        </div>

        {{-- ── Behaviour ── --}}
        <div class="st-card">
            <h2 class="st-h">⚙️ Behaviour</h2>

            <label class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Autoplay</div>
                    <div class="st-tg-d">Automatically advance to the next slide on a timer.</div>
                </div>
                <div class="st-sw {{ $autoplay ? 'on' : '' }}" wire:click="$toggle('autoplay')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>

            <div class="st-row2" style="margin-top:14px">
                <div class="st-f">
                    <label>Slide speed (seconds)</label>
                    <input type="number" class="st-input" wire:model="interval"
                           min="2" max="15" step="0.5" placeholder="4.5">
                    <div class="st-hint">How long each slide stays before advancing. 2–15 seconds. Ignored when autoplay is off.</div>
                    @error('interval') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Max products to show</label>
                    <input type="number" class="st-input" wire:model="maxItems"
                           min="1" max="24" step="1" placeholder="8">
                    <div class="st-hint">Limit how many slides/products appear in the carousel. 1–24.</div>
                    @error('maxItems') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>

            <label class="st-toggle-row" style="margin-top:14px">
                <div>
                    <div class="st-tg-l">Show thumbnail strip</div>
                    <div class="st-tg-d">Display the row of small clickable thumbnails under the main image.</div>
                </div>
                <div class="st-sw {{ $showThumbnails ? 'on' : '' }}" wire:click="$toggle('showThumbnails')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>
        </div>

        <button type="submit" class="st-save">💾 Save slideshow settings</button>
    </form>
</x-filament-panels::page>
