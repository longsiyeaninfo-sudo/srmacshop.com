<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class TaxShipping extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Tax & Shipping';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 13;
    protected static ?string $title = 'Tax & Shipping';
    protected static string $view = 'filament.admin.pages.settings.tax-shipping';

    public bool $tax_enabled = true;

    #[Validate('required|numeric|min:0|max:100')]
    public ?float $tax_percent = 10;

    public bool $free_delivery_enabled = true;

    #[Validate('nullable|numeric|min:0')]
    public ?float $free_delivery_threshold = 500;

    #[Validate('nullable|numeric|min:0')]
    public ?float $default_delivery_fee = 5;

    #[Validate('nullable|numeric|min:0')]
    public ?float $province_delivery_fee = 10;

    public function mount(): void
    {
        $t = Setting::get('tax_shipping', []);
        $this->tax_enabled             = $t['tax_enabled']             ?? true;
        $this->tax_percent             = $t['tax_percent']             ?? 10;
        $this->free_delivery_enabled   = $t['free_delivery_enabled']   ?? true;
        $this->free_delivery_threshold = $t['free_delivery_threshold'] ?? 500;
        $this->default_delivery_fee    = $t['default_delivery_fee']    ?? 5;
        $this->province_delivery_fee   = $t['province_delivery_fee']   ?? 10;
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('tax_shipping', [
            'tax_enabled'             => $this->tax_enabled,
            'tax_percent'             => $this->tax_percent,
            'free_delivery_enabled'   => $this->free_delivery_enabled,
            'free_delivery_threshold' => $this->free_delivery_threshold,
            'default_delivery_fee'    => $this->default_delivery_fee,
            'province_delivery_fee'   => $this->province_delivery_fee,
        ]);

        Notification::make()->title('Tax & shipping saved')->success()->send();
    }
}
