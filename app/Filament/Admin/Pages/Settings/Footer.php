<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class Footer extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-bars-3-bottom-left';
    protected static ?string $navigationLabel = 'Footer';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int    $navigationSort  = 12;
    protected static ?string $title           = 'Footer Settings';
    protected static string  $view            = 'filament.admin.pages.settings.footer';

    // ── Description block ────────────────────────────────────────────────────

    #[Validate('nullable|string|max:300')]
    public string $descriptionEn = '';

    // ── Bottom bar ───────────────────────────────────────────────────────────

    #[Validate('nullable|string|max:200')]
    public string $copyrightText = '';

    #[Validate('nullable|string|max:100')]
    public string $madeWith = '';

    // ── Float pills ──────────────────────────────────────────────────────────

    public bool $showFloatWa = true;
    public bool $showFloatTg = true;

    #[Validate('nullable|string|max:300')]
    public string $waMessage = '';

    // ── Lifecycle ────────────────────────────────────────────────────────────

    public function mount(): void
    {
        $f = Setting::get('site.footer', []) ?: [];

        $this->descriptionEn = $f['description_en'] ?? "Cambodia's most trusted Apple specialist — iPhones, iPads & MacBooks since 2018.";
        $this->copyrightText = $f['copyright_text'] ?? '';
        $this->madeWith      = $f['made_with']      ?? 'Made with ❤️ in Phnom Penh';
        $this->showFloatWa   = (bool) ($f['show_float_wa'] ?? true);
        $this->showFloatTg   = (bool) ($f['show_float_tg'] ?? true);
        $this->waMessage     = $f['wa_message'] ?? "Hi SR MAC SHOP! I'd like to enquire about a product.";
    }

    // ── Save ─────────────────────────────────────────────────────────────────

    public function save(): void
    {
        $this->validate();

        Setting::set('site.footer', [
            'description_en' => trim($this->descriptionEn),
            'copyright_text' => trim($this->copyrightText),
            'made_with'      => trim($this->madeWith),
            'show_float_wa'  => $this->showFloatWa,
            'show_float_tg'  => $this->showFloatTg,
            'wa_message'     => trim($this->waMessage),
        ]);

        Notification::make()->title('Footer settings saved!')->success()->send();
    }
}
