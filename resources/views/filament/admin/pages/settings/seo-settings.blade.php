<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
        <style>
        .seo-og-preview{display:flex;align-items:center;gap:10px;margin-bottom:12px}
        .seo-og-img{width:80px;height:80px;border-radius:8px;object-fit:cover;border:1px solid rgba(0,0,0,.08);flex-shrink:0;background:#f5f5f7}
        .seo-og-meta{flex:1}
        .seo-og-title{font-size:13px;font-weight:700;color:#1d1d1f;margin-bottom:3px}
        .dark .seo-og-title{color:#f5f5f7}
        .seo-og-sub{font-size:11.5px;color:#6e6e73;line-height:1.4}
        .seo-upload-area{border:2px dashed #d2d2d7;border-radius:12px;padding:22px 20px;text-align:center;background:rgba(0,0,0,.015);cursor:pointer;transition:all .15s}
        .dark .seo-upload-area{border-color:rgba(255,255,255,.14);background:rgba(255,255,255,.02)}
        .seo-upload-area:hover{border-color:#007aff;background:rgba(0,122,255,.04)}
        .seo-upload-area input[type=file]{display:none}
        </style>
    @endpush

    @php
        $ogUrl = $ogImagePath
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($ogImagePath)
            : asset('og-image.jpg');
    @endphp

    <form wire:submit.prevent="save" class="st-wrap">

        {{-- ── Page titles ── --}}
        <div class="st-card">
            <h2 class="st-h">🔤 Page titles</h2>
            <p class="st-sub">Controls the browser tab title and how your site appears in Google search results.</p>

            <div class="st-f">
                <label>Default title (homepage / fallback)</label>
                <input type="text" class="st-input" wire:model="defaultTitle" maxlength="120"
                       placeholder="SR MAC SHOP — Think Different. Buy Smarter.">
                <div class="st-hint">Shown when a page doesn't set its own title. Ideal length: 50–60 characters.</div>
                @error('defaultTitle') <div class="st-err">{{ $message }}</div> @enderror
            </div>

            <div class="st-f">
                <label>Title suffix <span class="st-bdg">appended to all pages</span></label>
                <input type="text" class="st-input" wire:model="titleSuffix" maxlength="60"
                       placeholder=" | SR MAC SHOP">
                <div class="st-hint">Added after every product/shop page title — e.g. "MacBook Pro M4 | SR MAC SHOP".</div>
                @error('titleSuffix') <div class="st-err">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ── Meta description ── --}}
        <div class="st-card">
            <h2 class="st-h">📝 Meta description</h2>
            <p class="st-sub">The snippet shown under your site name in Google results. Keep it under 160 characters.</p>

            <div class="st-f">
                <label>Default meta description</label>
                <textarea class="st-input" wire:model="metaDescription" rows="3" maxlength="320"
                    placeholder="Buy authentic MacBooks, iPhones & iPads in Cambodia with official Apple warranty. Same-day delivery in Phnom Penh."></textarea>
                @error('metaDescription') <div class="st-err">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ── OG image ── --}}
        <div class="st-card">
            <h2 class="st-h">🖼 Social share image (OG)</h2>
            <p class="st-sub">Shown when someone shares your site on Facebook, Telegram, or WhatsApp. 1200×630 px recommended.</p>

            @if($ogImagePath)
            <div class="seo-og-preview">
                <img src="{{ $ogUrl }}" alt="OG image" class="seo-og-img">
                <div class="seo-og-meta">
                    <div class="seo-og-title">Current OG image</div>
                    <div class="seo-og-sub">{{ basename($ogImagePath) }}</div>
                </div>
                <button type="button" class="br-remove-btn" wire:click="removeOgImage"
                        wire:confirm="Remove the OG image?" style="font-size:12px;padding:5px 12px;border:1px solid rgba(255,59,48,.35);border-radius:6px;background:transparent;color:#ff3b30;cursor:pointer;font-family:inherit;font-weight:600">Remove</button>
            </div>
            @endif

            <label class="seo-upload-area" for="ogImageInput">
                <div style="font-size:28px;margin-bottom:6px">🖼</div>
                <div style="font-size:13px;font-weight:600;color:#007aff;margin-bottom:3px">Click to upload OG image</div>
                <div style="font-size:11.5px;color:#6e6e73">PNG or JPG · 1200×630 px · Max 4 MB</div>
                <input id="ogImageInput" type="file" wire:model="ogImageUpload" accept="image/png,image/jpeg,image/webp">
                @if($ogImageUpload)
                    <div style="font-size:12px;color:#34c759;margin-top:6px;font-weight:600">✅ {{ $ogImageUpload->getClientOriginalName() }}</div>
                @endif
            </label>
            @error('ogImageUpload') <div class="st-err">{{ $message }}</div> @enderror
        </div>

        {{-- ── Analytics ── --}}
        <div class="st-card">
            <h2 class="st-h">📊 Analytics & Pixel</h2>
            <p class="st-sub">Paste your tracking IDs — no code editing needed. Leave blank to disable.</p>

            <div class="st-row2">
                <div class="st-f">
                    <label>Google Analytics ID</label>
                    <input type="text" class="st-input st-mono" wire:model="googleAnalyticsId"
                           placeholder="G-XXXXXXXXXX" maxlength="30">
                    <div class="st-hint">Format: G-XXXXXXXXXX (GA4) or UA-XXXXXX-X (old)</div>
                    @error('googleAnalyticsId') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Facebook Pixel ID</label>
                    <input type="text" class="st-input st-mono" wire:model="facebookPixelId"
                           placeholder="1234567890123456" maxlength="30">
                    <div class="st-hint">15-16 digit number from Meta Events Manager.</div>
                    @error('facebookPixelId') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="st-save">💾 Save SEO settings</button>
    </form>
</x-filament-panels::page>
