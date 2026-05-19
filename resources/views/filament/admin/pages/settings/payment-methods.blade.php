<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">
        <div class="st-card">
            <h2 class="st-h">💳 Accepted payment methods</h2>
            <p class="st-sub">Toggle the methods customers see at checkout.</p>

            <div wire:click="$toggle('cash_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">💵 Cash on delivery</div>
                    <div class="st-tg-d">Customer pays the driver in cash on arrival.</div>
                </div>
                <div class="st-sw {{ $cash_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            <div wire:click="$toggle('aba_qr_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">📱 ABA KHQR</div>
                    <div class="st-tg-d">Customer scans your KHQR to pay via any Cambodian bank app.</div>
                </div>
                <div class="st-sw {{ $aba_qr_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            <div wire:click="$toggle('card_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">💳 Credit / debit card</div>
                    <div class="st-tg-d">Visa / Mastercard via Stripe (requires API key).</div>
                </div>
                <div class="st-sw {{ $card_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>
        </div>

        @if($aba_qr_enabled)
            <div class="st-card">
                <h2 class="st-h">ABA KHQR details</h2>
                <p class="st-sub">Shown to customers when they pick ABA QR at checkout.</p>

                <div class="st-row2">
                    <div class="st-f">
                        <label>Account name</label>
                        <input type="text" class="st-input" wire:model="aba_account_name" placeholder="SR MAC SHOP">
                    </div>
                    <div class="st-f">
                        <label>Account number</label>
                        <input type="text" class="st-input st-mono" wire:model="aba_account_number" placeholder="000 123 456">
                    </div>
                </div>
                <div class="st-f">
                    <label>QR image URL</label>
                    <input type="text" class="st-input" wire:model="aba_qr_image_url" placeholder="https://srmacshop.com/img/khqr.png">
                    <div class="st-hint">Direct link to your KHQR PNG/SVG. Upload to <code>public/img/</code> and paste the URL here.</div>
                </div>
            </div>
        @endif

        @if($card_enabled)
            <div class="st-card">
                <h2 class="st-h">Stripe credentials</h2>
                <p class="st-sub">For credit card processing. Keep these secret.</p>

                <div class="st-f">
                    <label>Stripe publishable key</label>
                    <input type="text" class="st-input st-mono" wire:model="card_stripe_key" placeholder="pk_live_...">
                </div>
            </div>
        @endif

        <button type="submit" class="st-save">💾 Save payment methods</button>
    </form>
</x-filament-panels::page>
