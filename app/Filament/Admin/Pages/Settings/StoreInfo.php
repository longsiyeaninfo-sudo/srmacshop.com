<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class StoreInfo extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Store Info';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 10;
    protected static ?string $title = 'Store Info';
    protected static string $view = 'filament.admin.pages.settings.store-info';

    #[Validate('required|string|max:120')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public string $tagline = '';

    #[Validate('nullable|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:32')]
    public string $phone = '';

    #[Validate('nullable|string|max:500')]
    public string $address = '';

    #[Validate('nullable|url|max:255')]
    public string $facebook = '';

    #[Validate('nullable|url|max:255')]
    public string $instagram = '';

    #[Validate('nullable|string|max:255')]
    public string $telegram_channel = '';

    #[Validate('nullable|url|max:255')]
    public string $telegram_url = '';

    #[Validate('nullable|url|max:255')]
    public string $tiktok = '';

    public function mount(): void
    {
        $info = Setting::get('store.info', []);
        $this->name             = $info['name']             ?? 'SR MAC SHOP';
        $this->tagline          = $info['tagline']          ?? "Cambodia's most trusted MacBook specialist since 2018.";
        $this->email            = $info['email']            ?? '';
        $this->phone            = $info['phone']            ?? '+855 98 33 47 55';
        $this->address          = $info['address']          ?? 'Sangkat Kambol, Khan Kambol, Phnom Penh';
        $this->facebook         = $info['facebook']         ?? '';
        $this->instagram        = $info['instagram']        ?? '';
        $this->telegram_channel = $info['telegram_channel'] ?? '';
        $this->telegram_url     = $info['telegram_url']     ?? '';
        $this->tiktok           = $info['tiktok']           ?? '';
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('store.info', [
            'name'             => $this->name,
            'tagline'          => $this->tagline,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'address'          => $this->address,
            'facebook'         => $this->facebook,
            'instagram'        => $this->instagram,
            'telegram_channel' => $this->telegram_channel,
            'telegram_url'     => $this->telegram_url,
            'tiktok'           => $this->tiktok,
        ]);

        Notification::make()->title('Store info saved')->success()->send();
    }
}
