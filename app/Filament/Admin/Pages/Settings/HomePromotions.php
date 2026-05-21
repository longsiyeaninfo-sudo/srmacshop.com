<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Product;
use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class HomePromotions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Home Promotions';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 15;
    protected static ?string $title = 'Home Page Promotions';
    protected static string $view = 'filament.admin.pages.settings.home-promotions';

    // Headline deal
    #[Validate('nullable|integer|exists:products,id')]
    public ?int $headline_product_id = null;

    public ?string $headline_text = '';
    public ?string $headline_text_km = '';
    public ?string $headline_text_zh = '';

    #[Validate('nullable|numeric|min:0')]
    public ?float $headline_price = null;

    #[Validate('nullable|date')]
    public ?string $headline_ends_at = null;

    // Telegram banner
    #[Validate('nullable|integer|min:0')]
    public ?int $telegram_subscribers = 1200;

    public string $telegram_channel = '@srmacshop';

    // Section toggles
    public bool $flash_deals_enabled = true;
    public bool $telegram_section_enabled = true;
    public bool $sticky_cta_enabled = true;

    public function mount(): void
    {
        $promo = Setting::get('home_promo', []);
        $this->headline_product_id    = $promo['headline_product_id']    ?? null;
        $this->headline_text          = $promo['headline_text']          ?? '🔥 Today\'s Deal';
        $this->headline_text_km       = $promo['headline_text_km']       ?? '🔥 ការផ្តល់ជូនថ្ងៃនេះ';
        $this->headline_text_zh       = $promo['headline_text_zh']       ?? '🔥 今日特惠';
        $this->headline_price         = isset($promo['headline_price']) ? $promo['headline_price'] / 100 : null;
        $this->headline_ends_at       = $promo['headline_ends_at']       ?? null;
        $this->telegram_subscribers   = $promo['telegram_subscribers']   ?? 1200;
        $this->telegram_channel       = $promo['telegram_channel']       ?? '@srmacshop';
        $this->flash_deals_enabled    = $promo['flash_deals_enabled']    ?? true;
        $this->telegram_section_enabled = $promo['telegram_section_enabled'] ?? true;
        $this->sticky_cta_enabled     = $promo['sticky_cta_enabled']     ?? true;
    }

    public function getProductsProperty()
    {
        return Product::where('is_active', true)->orderBy('name')->get();
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('home_promo', [
            'headline_product_id'       => $this->headline_product_id,
            'headline_text'             => trim($this->headline_text ?? ''),
            'headline_text_km'          => trim($this->headline_text_km ?? ''),
            'headline_text_zh'          => trim($this->headline_text_zh ?? ''),
            'headline_price'            => $this->headline_price ? (int) round($this->headline_price * 100) : null,
            'headline_ends_at'          => $this->headline_ends_at ?: null,
            'telegram_subscribers'      => $this->telegram_subscribers ?: 0,
            'telegram_channel'          => trim($this->telegram_channel ?: '@srmacshop'),
            'flash_deals_enabled'       => $this->flash_deals_enabled,
            'telegram_section_enabled'  => $this->telegram_section_enabled,
            'sticky_cta_enabled'        => $this->sticky_cta_enabled,
        ]);

        Notification::make()
            ->title('Home promotions saved')
            ->body('The home page will reflect the new promo settings on the next load.')
            ->success()
            ->send();
    }
}
