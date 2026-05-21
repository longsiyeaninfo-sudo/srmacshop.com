<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
        <style>
        .tg-test-btn{padding:7px 14px;border:1px solid #d2d2d7;border-radius:8px;background:#fff;color:#1d1d1f;font-weight:700;font-size:12.5px;cursor:pointer;font-family:inherit;transition:all .12s}
        .dark .tg-test-btn{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
        .tg-test-btn:hover{background:rgba(0,122,255,.06);border-color:#007aff;color:#007aff}
        .tg-result{margin-top:10px;padding:10px 12px;border-radius:8px;font-size:12.5px;font-weight:600}
        .tg-result.ok{background:#dcfce7;color:#15803d}
        .tg-result.err{background:#fee2e2;color:#b91c1c}
        .tg-result.warn{background:#fff7ed;color:#c2410c}
        </style>
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">
        <div class="st-card">
            <h2 class="st-h">🤖 Bot credentials <span class="st-bdg">Required</span></h2>
            <p class="st-sub">Get a bot token from <strong>@BotFather</strong> on Telegram, then save your chat ID below.</p>

            <div class="st-f">
                <label>Bot token</label>
                <input type="text" class="st-input st-mono" wire:model="bot_token" placeholder="123456789:ABCdefGHIjklMNOpqrSTUvwxyz">
                @error('bot_token') <div class="st-err">{{ $message }}</div> @enderror
                <div class="st-hint">From BotFather. Format: <code>&lt;numbers&gt;:&lt;letters&gt;</code></div>
            </div>

            <div class="st-f">
                <label>Admin chat ID</label>
                <input type="text" class="st-input st-mono" wire:model="admin_chat_id" placeholder="-1001234567890 or 123456789">
                @error('admin_chat_id') <div class="st-err">{{ $message }}</div> @enderror
                <div class="st-hint">Your personal chat ID or a group ID. Get it from <strong>@userinfobot</strong>.</div>
            </div>

            <button type="button" wire:click="testConnection" class="tg-test-btn">📡 Send test message</button>
            @if($testResult)
                <div class="tg-result {{ str_starts_with($testResult, '✓') ? 'ok' : (str_starts_with($testResult, '✗') ? 'err' : 'warn') }}">
                    {{ $testResult }}
                </div>
            @endif
        </div>

        <div class="st-card">
            <h2 class="st-h">🔔 Notification triggers</h2>
            <p class="st-sub">Pick which events ping your Telegram.</p>

            <div wire:click="$toggle('notify_new')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">New order placed</div>
                    <div class="st-tg-d">Get notified the moment a customer checks out.</div>
                </div>
                <div class="st-sw {{ $notify_new ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            <div wire:click="$toggle('notify_status')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Order status changed</div>
                    <div class="st-tg-d">Pings on confirm / deliver / cancel from the admin.</div>
                </div>
                <div class="st-sw {{ $notify_status ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>

            <div wire:click="$toggle('notify_low_stock')" class="st-toggle-row">
                <div>
                    <div class="st-tg-l">Low stock warning</div>
                    <div class="st-tg-d">Daily summary of products with ≤ 3 units left.</div>
                </div>
                <div class="st-sw {{ $notify_low_stock ? 'on' : '' }}"><div class="st-sw-dot"></div></div>
            </div>
        </div>

        <button type="submit" class="st-save">💾 Save Telegram settings</button>
    </form>
</x-filament-panels::page>
