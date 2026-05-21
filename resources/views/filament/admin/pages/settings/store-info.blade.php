<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">
        <div class="st-card">
            <h2 class="st-h">🏪 Identity</h2>
            <p class="st-sub">Shown on invoices, the storefront, and customer notifications.</p>

            <div class="st-f">
                <label>Store name</label>
                <input type="text" class="st-input" wire:model="name">
                @error('name') <div class="st-err">{{ $message }}</div> @enderror
            </div>
            <div class="st-f">
                <label>Tagline</label>
                <input type="text" class="st-input" wire:model="tagline">
            </div>
        </div>

        <div class="st-card">
            <h2 class="st-h">📞 Contact</h2>
            <p class="st-sub">Phone and email customers use to reach you.</p>

            <div class="st-row2">
                <div class="st-f">
                    <label>Phone</label>
                    <input type="tel" class="st-input" wire:model="phone">
                    @error('phone') <div class="st-err">{{ $message }}</div> @enderror
                </div>
                <div class="st-f">
                    <label>Email</label>
                    <input type="email" class="st-input" wire:model="email">
                    @error('email') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="st-f">
                <label>Physical address</label>
                <textarea class="st-input" wire:model="address" rows="2"></textarea>
            </div>
        </div>

        <div class="st-card">
            <h2 class="st-h">🌐 Social</h2>
            <p class="st-sub">Linked from your storefront footer.</p>

            <div class="st-f">
                <label>Facebook URL</label>
                <input type="url" class="st-input" wire:model="facebook" placeholder="https://facebook.com/srmacshop">
                @error('facebook') <div class="st-err">{{ $message }}</div> @enderror
            </div>
            <div class="st-f">
                <label>Instagram URL</label>
                <input type="url" class="st-input" wire:model="instagram" placeholder="https://instagram.com/srmacshop">
                @error('instagram') <div class="st-err">{{ $message }}</div> @enderror
            </div>
            <div class="st-f">
                <label>Telegram channel</label>
                <input type="text" class="st-input" wire:model="telegram_channel" placeholder="@srmacshop">
            </div>
        </div>

        <button type="submit" class="st-save">💾 Save store info</button>
    </form>
</x-filament-panels::page>
