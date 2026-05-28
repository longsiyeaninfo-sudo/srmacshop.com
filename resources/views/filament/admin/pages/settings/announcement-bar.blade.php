<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
        <style>
        .ann-preview{padding:10px 18px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:18px;position:relative;min-height:40px;transition:background .2s}
        .ann-preview-cta{color:#fff;font-weight:800;text-decoration:underline}
        .ann-preview-x{position:absolute;right:12px;opacity:.7;font-size:16px}
        .ann-color-grid{display:flex;gap:10px;flex-wrap:wrap;margin-top:6px}
        .ann-color-swatch{width:32px;height:32px;border-radius:50%;cursor:pointer;border:3px solid transparent;transition:transform .15s,border-color .15s;flex-shrink:0}
        .ann-color-swatch:hover{transform:scale(1.15)}
        .ann-color-swatch.selected{border-color:#fff;box-shadow:0 0 0 2px #007aff}
        </style>
    @endphp

    @php
        $presets = [
            '#FF2D55' => 'Red (hot sale)',
            '#007AFF' => 'Blue (info)',
            '#34C759' => 'Green (in stock)',
            '#FF9500' => 'Orange (promo)',
            '#AF52DE' => 'Purple',
            '#1C1C1E' => 'Dark',
        ];
    @endphp

    <form wire:submit.prevent="save" class="st-wrap">

        {{-- ── Live preview ── --}}
        <div class="st-card">
            <h2 class="st-h">👁 Live preview</h2>
            <p class="st-sub">How the bar looks at the very top of every page.</p>

            <div class="ann-preview" style="background:{{ $bgColor }}">
                <span>{{ $text ?: 'Your announcement text will appear here.' }}</span>
                @if($linkText)
                    <span class="ann-preview-cta">{{ $linkText }}</span>
                @endif
                @if($dismissible)
                    <span class="ann-preview-x">×</span>
                @endif
            </div>
        </div>

        {{-- ── On/Off ── --}}
        <div class="st-card">
            <h2 class="st-h">📢 Announcement bar</h2>
            <p class="st-sub">Appears at the very top of every page — above the navbar. Use it for sales, events, or important notices.</p>

            <label class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Show announcement bar</div>
                    <div class="st-tg-d">Turn on to display the bar on your storefront. Turn off to hide it without deleting the text.</div>
                </div>
                <div class="st-sw {{ $enabled ? 'on' : '' }}" wire:click="$toggle('enabled')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>
        </div>

        {{-- ── Message ── --}}
        <div class="st-card">
            <h2 class="st-h">✏️ Message</h2>

            <div class="st-f">
                <label>Announcement text</label>
                <input type="text" class="st-input" wire:model.live="text"
                       placeholder="🔥 FREE delivery in Phnom Penh this week! Limited time only."
                       maxlength="200">
                <div class="st-hint">Keep it short and punchy — max 200 characters.</div>
                @error('text') <div class="st-err">{{ $message }}</div> @enderror
            </div>

            <div class="st-row2">
                <div class="st-f">
                    <label>CTA button text <span class="st-bdg">optional</span></label>
                    <input type="text" class="st-input" wire:model.live="linkText"
                           placeholder="Shop Now →" maxlength="60">
                    @error('linkText') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>CTA link URL <span class="st-bdg">optional</span></label>
                    <input type="url" class="st-input" wire:model="linkUrl"
                           placeholder="https://srmacshop.com/shop">
                    @error('linkUrl') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ── Style ── --}}
        <div class="st-card">
            <h2 class="st-h">🎨 Color</h2>

            <div class="st-f">
                <label>Background color</label>
                <div class="ann-color-grid">
                    @foreach($presets as $hex => $label)
                        <button type="button"
                                class="ann-color-swatch {{ $bgColor === $hex ? 'selected' : '' }}"
                                style="background:{{ $hex }}"
                                title="{{ $label }}"
                                wire:click="$set('bgColor', '{{ $hex }}')"></button>
                    @endforeach
                </div>
                <div style="margin-top:10px;display:flex;align-items:center;gap:8px">
                    <input type="color" wire:model.live="bgColor" value="{{ $bgColor }}"
                           style="width:36px;height:36px;border:none;border-radius:8px;cursor:pointer;padding:0;background:none">
                    <input type="text" class="st-input st-mono" wire:model.live="bgColor"
                           value="{{ $bgColor }}" placeholder="#FF2D55" maxlength="7"
                           style="flex:1;max-width:120px">
                    <span style="font-size:12px;color:var(--text2)">or pick any color above / type a hex code</span>
                </div>
            </div>

            <label class="st-toggle-row" style="margin-top:8px">
                <div>
                    <div class="st-tg-l">Allow customers to dismiss (×)</div>
                    <div class="st-tg-d">Show a close button so customers can hide the bar. They won't see it again until the message changes.</div>
                </div>
                <div class="st-sw {{ $dismissible ? 'on' : '' }}" wire:click="$toggle('dismissible')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>
        </div>

        <button type="submit" class="st-save">💾 Save announcement bar</button>
    </form>
</x-filament-panels::page>
