<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">
        {{-- Headline deal --}}
        <div class="st-card">
            <h2 class="st-h">🔥 Headline Deal</h2>
            <p class="st-sub">Shown big at the top of the home page hero and on the mobile sticky bar. Leave blank to auto-pick the highest-discount product.</p>

            <div class="st-f">
                <label>Headline product</label>
                <select wire:model="headline_product_id" class="st-input">
                    <option value="">Auto (highest-discount product)</option>
                    @foreach($this->products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} — ${{ number_format($p->price/100, 0) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="st-row2">
                <div class="st-f">
                    <label>Pre-headline text — EN</label>
                    <input type="text" class="st-input" wire:model="headline_text" placeholder="🔥 Today's Deal">
                </div>
                <div class="st-f">
                    <label>Pre-headline — Khmer (KM)</label>
                    <input type="text" class="st-input" wire:model="headline_text_km" placeholder="🔥 ការផ្តល់ជូនថ្ងៃនេះ">
                </div>
            </div>
            <div class="st-f">
                <label>Pre-headline — Chinese (ZH)</label>
                <input type="text" class="st-input" wire:model="headline_text_zh" placeholder="🔥 今日特惠">
            </div>

            <div class="st-row2">
                <div class="st-f">
                    <label>Override price ($) — optional</label>
                    <input type="number" min="0" step="0.01" class="st-input" wire:model="headline_price" placeholder="Uses product's own price if blank">
                </div>
                <div class="st-f">
                    <label>Sale ends at — optional (drives countdown)</label>
                    <input type="datetime-local" class="st-input" wire:model="headline_ends_at">
                </div>
            </div>
        </div>

        {{-- Telegram --}}
        <div class="st-card">
            <h2 class="st-h">✈️ Telegram Channel</h2>
            <p class="st-sub">Promoted on the home page banner + embed widget + floating button.</p>

            <div class="st-row2">
                <div class="st-f">
                    <label>Channel handle</label>
                    <input type="text" class="st-input st-mono" wire:model="telegram_channel" placeholder="@srmacshop">
                </div>
                <div class="st-f">
                    <label>Subscriber count to display</label>
                    <input type="number" min="0" class="st-input" wire:model="telegram_subscribers" placeholder="1200">
                </div>
            </div>
            <div class="st-hint">The subscriber count is shown as social proof on the banner ("Join 1,200+ MacBook fans"). Update manually when your channel grows.</div>
        </div>

        {{-- Section toggles --}}
        <div class="st-card">
            <h2 class="st-h">📋 Home page sections</h2>
            <p class="st-sub">Toggle entire sections on/off without deploying.</p>

            <div wire:click="$toggle('flash_deals_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">⚡ Flash Deals reel</div>
                    <div class="st-tg-d">Swipeable carousel of products marked "🔥 Feature in Flash Deals".</div>
                </div>
                <div class="st-sw {{ $flash_deals_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            <div wire:click="$toggle('telegram_section_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">✈️ Telegram banner + embed</div>
                    <div class="st-tg-d">Full-width Telegram banner and channel post embed on the home page.</div>
                </div>
                <div class="st-sw {{ $telegram_section_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            <div wire:click="$toggle('sticky_cta_enabled')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">📱 Mobile sticky "Order Now" bar</div>
                    <div class="st-tg-d">Fixed bottom CTA shown only on phones with the headline deal.</div>
                </div>
                <div class="st-sw {{ $sticky_cta_enabled ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>
        </div>

        <button type="submit" class="st-save">💾 Save home promotions</button>
    </form>
</x-filament-panels::page>
