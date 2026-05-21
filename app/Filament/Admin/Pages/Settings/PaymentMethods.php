<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class PaymentMethods extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Payment Methods';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 12;
    protected static ?string $title = 'Payment Methods';
    protected static string $view = 'filament.admin.pages.settings.payment-methods';

    public bool $cash_enabled = true;
    public bool $aba_qr_enabled = true;
    public bool $card_enabled = false;

    #[Validate('nullable|string|max:120')]
    public string $aba_account_name = '';

    #[Validate('nullable|string|max:64')]
    public string $aba_account_number = '';

    #[Validate('nullable|string|max:255')]
    public string $aba_qr_image_url = '';

    #[Validate('nullable|string|max:120')]
    public string $card_stripe_key = '';

    public function mount(): void
    {
        $p = Setting::get('payment', []);
        $this->cash_enabled       = $p['cash_enabled']       ?? true;
        $this->aba_qr_enabled     = $p['aba_qr_enabled']     ?? true;
        $this->card_enabled       = $p['card_enabled']       ?? false;
        $this->aba_account_name   = $p['aba_account_name']   ?? '';
        $this->aba_account_number = $p['aba_account_number'] ?? '';
        $this->aba_qr_image_url   = $p['aba_qr_image_url']   ?? '';
        $this->card_stripe_key    = $p['card_stripe_key']    ?? '';
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('payment', [
            'cash_enabled'       => $this->cash_enabled,
            'aba_qr_enabled'     => $this->aba_qr_enabled,
            'card_enabled'       => $this->card_enabled,
            'aba_account_name'   => $this->aba_account_name,
            'aba_account_number' => $this->aba_account_number,
            'aba_qr_image_url'   => $this->aba_qr_image_url,
            'card_stripe_key'    => $this->card_stripe_key,
        ]);

        Notification::make()->title('Payment methods saved')->success()->send();
    }
}
