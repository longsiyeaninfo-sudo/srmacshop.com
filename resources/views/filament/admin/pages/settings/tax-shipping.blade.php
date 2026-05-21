<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">
        <div class="st-card">
            <h2 class="st-h">🧾 Tax</h2>
            <p class="st-sub">Applied to the subtotal at checkout.</p>

            <div wire:click="$toggle('tax_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Charge tax on orders</div>
                    <div class="st-tg-d">Turn off if your prices are tax-inclusive.</div>
                </div>
                <div class="st-sw {{ $tax_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            @if($tax_enabled)
                <div class="st-f">
                    <label>Tax rate (%)</label>
                    <input type="number" min="0" max="100" step="0.5" class="st-input" wire:model="tax_percent" style="max-width:160px">
                    @error('tax_percent') <div class="st-err">{{ $message }}</div> @enderror
                </div>
            @endif
        </div>

        <div class="st-card">
            <h2 class="st-h">🚚 Delivery</h2>
            <p class="st-sub">Fee added to the order total based on the customer's location.</p>

            <div wire:click="$toggle('free_delivery_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Free delivery threshold</div>
                    <div class="st-tg-d">Waive the fee when the cart subtotal is high enough.</div>
                </div>
                <div class="st-sw {{ $free_delivery_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            @if($free_delivery_enabled)
                <div class="st-f">
                    <label>Free delivery above ($)</label>
                    <input type="number" min="0" step="1" class="st-input" wire:model="free_delivery_threshold" style="max-width:200px">
                </div>
            @endif

            <div class="st-row2">
                <div class="st-f">
                    <label>Phnom Penh delivery ($)</label>
                    <input type="number" min="0" step="0.5" class="st-input" wire:model="default_delivery_fee">
                </div>
                <div class="st-f">
                    <label>Province delivery ($)</label>
                    <input type="number" min="0" step="0.5" class="st-input" wire:model="province_delivery_fee">
                </div>
            </div>
        </div>

        <button type="submit" class="st-save">💾 Save tax & shipping</button>
    </form>
</x-filament-panels::page>
