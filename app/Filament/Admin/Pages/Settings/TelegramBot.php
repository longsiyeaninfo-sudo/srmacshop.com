<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;

class TelegramBot extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Telegram Bot';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 11;
    protected static ?string $title = 'Telegram Bot';
    protected static string $view = 'filament.admin.pages.settings.telegram-bot';

    #[Validate('nullable|string|max:255')]
    public string $bot_token = '';

    #[Validate('nullable|string|max:64')]
    public string $admin_chat_id = '';

    public bool $notify_new = true;
    public bool $notify_status = true;
    public bool $notify_low_stock = false;

    public ?string $testResult = null;

    public function mount(): void
    {
        $tg = Setting::get('telegram', []);
        $this->bot_token        = $tg['bot_token']        ?? config('services.telegram.bot_token', '');
        $this->admin_chat_id    = $tg['admin_chat_id']    ?? config('services.telegram.chat_id', '');
        $this->notify_new       = $tg['notify_new']       ?? true;
        $this->notify_status    = $tg['notify_status']    ?? true;
        $this->notify_low_stock = $tg['notify_low_stock'] ?? false;
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('telegram', [
            'bot_token'        => $this->bot_token,
            'admin_chat_id'    => $this->admin_chat_id,
            'notify_new'       => $this->notify_new,
            'notify_status'    => $this->notify_status,
            'notify_low_stock' => $this->notify_low_stock,
        ]);

        Notification::make()->title('Telegram settings saved')->success()->send();
    }

    public function testConnection(): void
    {
        $this->testResult = null;

        if (! $this->bot_token || ! $this->admin_chat_id) {
            $this->testResult = '⚠ Add both bot token and chat ID first.';
            return;
        }

        try {
            $r = Http::timeout(5)->post("https://api.telegram.org/bot{$this->bot_token}/sendMessage", [
                'chat_id'    => $this->admin_chat_id,
                'text'       => "✅ SR MAC SHOP Telegram connection test successful.\n_Sent " . now()->format('d M Y H:i') . "_",
                'parse_mode' => 'Markdown',
            ]);
            $this->testResult = $r->successful()
                ? '✓ Test message sent — check your Telegram'
                : '✗ Telegram API replied: ' . ($r->json('description') ?? 'unknown error');
        } catch (\Throwable $e) {
            $this->testResult = '✗ Could not reach Telegram: ' . $e->getMessage();
        }
    }
}
