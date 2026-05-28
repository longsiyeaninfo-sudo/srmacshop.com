<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
        <style>
        /* ── branding-specific extras ── */
        .br-preview{display:flex;align-items:center;gap:14px;padding:18px 20px;background:rgba(0,0,0,.03);border:1px solid rgba(0,0,0,.07);border-radius:12px;margin-bottom:18px}
        .dark .br-preview{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.1)}
        .br-preview-img{width:36px;height:36px;border-radius:50%;object-fit:contain;flex-shrink:0;background:#fff;padding:2px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
        .br-preview-name{font-size:17px;font-weight:700;letter-spacing:-.5px;color:#1d1d1f;line-height:1}
        .dark .br-preview-name{color:#f5f5f7}
        .br-preview-name span{color:#007aff;font-weight:800}
        .br-preview-label{font-size:11px;color:#6e6e73;margin-top:2px}

        .br-upload-area{border:2px dashed #d2d2d7;border-radius:12px;padding:26px 20px;text-align:center;background:rgba(0,0,0,.015);cursor:pointer;transition:all .15s}
        .dark .br-upload-area{border-color:rgba(255,255,255,.14);background:rgba(255,255,255,.02)}
        .br-upload-area:hover{border-color:#007aff;background:rgba(0,122,255,.04)}
        .br-upload-area input[type=file]{display:none}
        .br-upload-ico{font-size:32px;margin-bottom:6px}
        .br-upload-lbl{font-size:13px;font-weight:600;color:#007aff;margin-bottom:3px}
        .br-upload-hint{font-size:11.5px;color:#6e6e73}
        .br-upload-name{font-size:12px;color:#34c759;margin-top:6px;font-weight:600}

        .br-current-logo{display:flex;align-items:center;gap:10px;margin-bottom:12px}
        .br-current-img{width:48px;height:48px;border-radius:8px;object-fit:contain;background:#f5f5f7;border:1px solid rgba(0,0,0,.06);padding:4px}
        .dark .br-current-img{background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.1)}
        .br-current-meta{flex:1}
        .br-current-title{font-size:13px;font-weight:600;color:#1d1d1f;margin-bottom:2px}
        .dark .br-current-title{color:#f5f5f7}
        .br-current-sub{font-size:11.5px;color:#6e6e73}
        .br-remove-btn{font-size:12px;padding:5px 12px;border:1px solid rgba(255,59,48,.35);border-radius:6px;background:transparent;color:#ff3b30;cursor:pointer;font-family:inherit;font-weight:600;transition:all .12s}
        .br-remove-btn:hover{background:rgba(255,59,48,.08)}
        </style>
    @endpush

    @php
        $storedUrl  = $logoPath
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($logoPath)
            : asset('img/srmac-logo.svg');
        $previewUrl = $logoUpload ? $logoUpload->temporaryUrl() : $storedUrl;
        $hasCustom  = (bool) $logoPath;
    @endphp

    <form wire:submit.prevent="save" class="st-wrap">

        {{-- ── Live preview ── --}}
        <div class="st-card">
            <h2 class="st-h">👁 Live preview</h2>
            <p class="st-sub">How your logo appears in the top navbar right now.</p>

            <div class="br-preview">
                <img src="{{ $previewUrl }}" alt="logo preview" class="br-preview-img"
                     wire:key="logo-preview-{{ $logoPath }}">
                @if($showText)
                    <div>
                        <div class="br-preview-name">
                            <span>{{ $logoPrefix ?: 'SR' }}</span> {{ $logoText ?: 'MAC SHOP' }}
                        </div>
                        <div class="br-preview-label">Navbar logo preview</div>
                    </div>
                @else
                    <div class="br-preview-label">Text hidden — image only</div>
                @endif
            </div>
        </div>

        {{-- ── Logo image ── --}}
        <div class="st-card">
            <h2 class="st-h">🖼 Logo image</h2>
            <p class="st-sub">PNG, JPG, SVG or WebP. Square or circle works best (e.g. 80×80). Max 2 MB.</p>

            @if($hasCustom)
            <div class="br-current-logo">
                <img src="{{ $storedUrl }}" alt="current logo" class="br-current-img">
                <div class="br-current-meta">
                    <div class="br-current-title">Custom logo active</div>
                    <div class="br-current-sub">{{ basename($logoPath) }}</div>
                </div>
                <button type="button" class="br-remove-btn" wire:click="removeLogo"
                        wire:confirm="Reset to the default SVG logo?">Reset to default</button>
            </div>
            @endif

            <label class="br-upload-area" for="logoUploadInput">
                <div class="br-upload-ico">📁</div>
                <div class="br-upload-lbl">Click to choose a new logo file</div>
                <div class="br-upload-hint">or drag & drop here</div>
                <input id="logoUploadInput" type="file" wire:model="logoUpload"
                       accept="image/png,image/jpeg,image/svg+xml,image/webp,image/gif">
                @if($logoUpload)
                    <div class="br-upload-name">✅ {{ $logoUpload->getClientOriginalName() }}</div>
                @endif
            </label>
            @error('logoUpload') <div class="st-err">{{ $message }}</div> @enderror
            <div class="st-hint" style="margin-top:8px">Leave blank to keep the current logo unchanged.</div>
        </div>

        {{-- ── Logo text ── --}}
        <div class="st-card">
            <h2 class="st-h">✏️ Logo text</h2>
            <p class="st-sub">The store name displayed next to the logo image in the navbar.</p>

            <div class="st-row2">
                <div class="st-f">
                    <label>Prefix <span class="st-bdg">blue / accent</span></label>
                    <input type="text" class="st-input" wire:model.live="logoPrefix"
                           placeholder="SR" maxlength="20">
                    <div class="st-hint">The bold colored word before the name (e.g. "SR").</div>
                    @error('logoPrefix') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Store name</label>
                    <input type="text" class="st-input" wire:model.live="logoText"
                           placeholder="MAC SHOP" maxlength="60">
                    <div class="st-hint">Main name after the prefix (e.g. "MAC SHOP").</div>
                    @error('logoText') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Show / hide text toggle --}}
            <label class="st-toggle-row" style="margin-top:6px">
                <div>
                    <div class="st-tg-l">Show text next to logo</div>
                    <div class="st-tg-d">Hide for an image-only logo (text removed on mobile anyway).</div>
                </div>
                <div class="st-sw {{ $showText ? 'on' : '' }}" wire:click="$toggle('showText')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>
        </div>

        <button type="submit" class="st-save">💾 Save branding</button>
    </form>
</x-filament-panels::page>
