<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
        <style>
        .tc-preview-bar{height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:18px;transition:background .15s;font-weight:700;color:#fff;font-size:14px;letter-spacing:-.01em}
        .tc-preview-btn{padding:9px 22px;border-radius:980px;border:none;font-size:13px;font-weight:700;color:#fff;cursor:default;transition:background .15s}
        .tc-preset-grid{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}
        .tc-preset{width:36px;height:36px;border-radius:50%;cursor:pointer;border:3px solid transparent;transition:transform .15s,border-color .15s;flex-shrink:0}
        .tc-preset:hover{transform:scale(1.18)}
        .tc-preset.sel{border-color:#fff;box-shadow:0 0 0 2px currentColor}
        </style>
    @endpush

    @php
        $presets = [
            '#007AFF' => 'Apple Blue (default)',
            '#FF2D55' => 'Apple Red',
            '#FF9500' => 'Orange',
            '#34C759' => 'Green',
            '#AF52DE' => 'Purple',
            '#FF375F' => 'Pink',
            '#00C7BE' => 'Teal',
            '#1C1C1E' => 'Dark',
        ];
    @endphp

    <form wire:submit.prevent="save" class="st-wrap">

        {{-- Live preview --}}
        <div class="st-card">
            <h2 class="st-h">👁 Live preview</h2>
            <p class="st-sub">How buttons, badges, and links will look with the selected color.</p>

            <div class="tc-preview-bar" style="background:{{ $accentColor }}">
                <span>Accent color preview</span>
                <span class="tc-preview-btn" style="background:rgba(255,255,255,.2)">Shop Now →</span>
            </div>
        </div>

        {{-- Color picker --}}
        <div class="st-card">
            <h2 class="st-h">🎨 Accent color</h2>
            <p class="st-sub">Applied to buttons, badges, links, logo prefix text, and the cart button across the whole storefront.</p>

            <div class="st-f">
                <label>Quick presets</label>
                <div class="tc-preset-grid">
                    @foreach($presets as $hex => $label)
                        <button type="button"
                                class="tc-preset {{ strtoupper($accentColor) === strtoupper($hex) ? 'sel' : '' }}"
                                style="background:{{ $hex }};box-shadow:{{ strtoupper($accentColor) === strtoupper($hex) ? '0 0 0 3px '.$hex : 'none' }}"
                                title="{{ $label }}"
                                wire:click="$set('accentColor', '{{ $hex }}')"></button>
                    @endforeach
                </div>
            </div>

            <div class="st-f">
                <label>Custom hex color</label>
                <div style="display:flex;align-items:center;gap:10px">
                    <input type="color" wire:model.live="accentColor" value="{{ $accentColor }}"
                           style="width:40px;height:40px;border:none;border-radius:8px;cursor:pointer;padding:2px;background:none;flex-shrink:0">
                    <input type="text" class="st-input st-mono" wire:model.live="accentColor"
                           value="{{ $accentColor }}" placeholder="#007AFF" maxlength="7"
                           style="max-width:130px">
                    <span style="font-size:12px;color:#6e6e73">Any valid 6-digit hex code</span>
                </div>
                @error('accentColor') <div class="st-err">{{ $message }}</div> @enderror
            </div>

            <div class="st-hint" style="margin-top:4px;padding:10px 14px;background:rgba(0,122,255,.06);border-radius:8px">
                💡 The color is applied instantly via a CSS variable (<code>--blue</code>) — no rebuild needed. Changes take effect on the next page load for visitors.
            </div>
        </div>

        <div style="display:flex;gap:10px">
            <button type="submit" class="st-save" style="flex:1">💾 Save color</button>
            <button type="button" class="st-save" style="flex:0 0 auto;width:auto;padding:11px 20px;background:rgba(0,0,0,.06);color:#1d1d1f;box-shadow:none"
                    wire:click="resetToDefault">↺ Reset to Blue</button>
        </div>
    </form>
</x-filament-panels::page>
