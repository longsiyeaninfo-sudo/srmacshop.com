<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
    @endpush

    @php
        // Show the current store phone & email so the admin knows what will render.
        $previewInfo = \App\Models\Setting::get('store.info', []) ?: [];
        $previewPhone = $previewInfo['phone'] ?? '+855 98 33 47 55';
        $previewEmail = $previewInfo['email'] ?? 'hello@srmacshop.com';
        $storeName = \App\Models\Setting::get('site.branding', [])['logo_prefix'] ?? 'SR';
        $storeName .= ' ' . (\App\Models\Setting::get('site.branding', [])['logo_text'] ?? 'MAC SHOP');
    @endphp

    <form wire:submit.prevent="save" class="st-wrap">

        {{-- ── Description ── --}}
        <div class="st-card">
            <h2 class="st-h">📝 Footer description</h2>
            <p class="st-sub">Short tagline shown below the logo in the footer. Keep it under 200 characters.</p>

            <div class="st-f">
                <label>Description (English)</label>
                <textarea class="st-input" wire:model="descriptionEn" rows="2" maxlength="300"
                    placeholder="Cambodia's most trusted Apple specialist — iPhones, iPads & MacBooks since 2018."></textarea>
                <div class="st-hint">Khmer and Chinese translations remain in the template and auto-apply for those languages.</div>
                @error('descriptionEn') <div class="st-err">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ── Bottom bar ── --}}
        <div class="st-card">
            <h2 class="st-h">©️ Bottom bar</h2>
            <p class="st-sub">The two lines at the very bottom of the page.</p>

            <div class="st-hint" style="margin-bottom:12px;padding:10px 14px;background:rgba(0,122,255,.06);border-radius:8px;font-size:12px">
                💡 Phone and email come from <strong>Settings › Store Info</strong>.<br>
                Current phone: <strong>{{ $previewPhone }}</strong> · Email: <strong>{{ $previewEmail }}</strong>
            </div>

            <div class="st-f">
                <label>Copyright text</label>
                <input type="text" class="st-input" wire:model="copyrightText"
                       placeholder="© {{ date('Y') }} {{ $storeName }} · {{ $previewPhone }} · www.srmacshop.com"
                       maxlength="200">
                <div class="st-hint">Leave blank to auto-build from store name + phone. Year is always current.</div>
                @error('copyrightText') <div class="st-err">{{ $message }}</div> @enderror
            </div>
            <div class="st-f">
                <label>Right-side tagline</label>
                <input type="text" class="st-input" wire:model="madeWith"
                       placeholder="Made with ❤️ in Phnom Penh" maxlength="100">
                <div class="st-hint">Shown on the right side of the bottom bar.</div>
                @error('madeWith') <div class="st-err">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ── Floating contact pills ── --}}
        <div class="st-card">
            <h2 class="st-h">💬 Floating contact pills</h2>
            <p class="st-sub">The Telegram and WhatsApp buttons that float in the bottom-left corner of every page.</p>

            <label class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Show WhatsApp pill</div>
                    <div class="st-tg-d">Floating green "WhatsApp Us" button. Uses the phone from Store Info.</div>
                </div>
                <div class="st-sw {{ $showFloatWa ? 'on' : '' }}" wire:click="$toggle('showFloatWa')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>

            <label class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Show Telegram pill</div>
                    <div class="st-tg-d">Floating blue "Telegram" button. Uses the Telegram URL from Store Info.</div>
                </div>
                <div class="st-sw {{ $showFloatTg ? 'on' : '' }}" wire:click="$toggle('showFloatTg')">
                    <div class="st-sw-dot"></div>
                </div>
            </label>

            <div class="st-f" style="margin-top:14px">
                <label>WhatsApp pre-fill message</label>
                <input type="text" class="st-input" wire:model="waMessage"
                       placeholder="Hi SR MAC SHOP! I'd like to enquire about a product."
                       maxlength="300">
                <div class="st-hint">Sent automatically when a customer taps the WhatsApp button.</div>
                @error('waMessage') <div class="st-err">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit" class="st-save">💾 Save footer settings</button>
    </form>
</x-filament-panels::page>
