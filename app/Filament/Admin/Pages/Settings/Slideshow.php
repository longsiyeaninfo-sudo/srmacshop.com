<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class Slideshow extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Slideshow';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int    $navigationSort  = 9;
    protected static ?string $title           = 'Homepage Slideshow';
    protected static string  $view            = 'filament.admin.pages.settings.slideshow';

    public bool $enabled = true;

    #[Validate('nullable|string|max:60')]
    public string $eyebrowEn = '';
    #[Validate('nullable|string|max:80')]
    public string $eyebrowKm = '';
    #[Validate('nullable|string|max:60')]
    public string $eyebrowZh = '';

    #[Validate('nullable|string|max:120')]
    public string $headingEn = '';
    #[Validate('nullable|string|max:160')]
    public string $headingKm = '';
    #[Validate('nullable|string|max:120')]
    public string $headingZh = '';

    #[Validate('integer|min:1|max:24')]
    public int $maxItems = 8;

    public bool $autoplay = true;

    #[Validate('numeric|min:2|max:15')]
    public float $interval = 4.5;

    public bool $showThumbnails = true;

    public function mount(): void
    {
        $s = Setting::get('site.slideshow', []) ?: [];

        $this->enabled        = (bool)  ($s['enabled']         ?? true);
        $this->eyebrowEn      =          $s['eyebrow_en']      ?? '';
        $this->eyebrowKm      =          $s['eyebrow_km']      ?? '';
        $this->eyebrowZh      =          $s['eyebrow_zh']      ?? '';
        $this->headingEn      =          $s['heading_en']      ?? '';
        $this->headingKm      =          $s['heading_km']      ?? '';
        $this->headingZh      =          $s['heading_zh']      ?? '';
        $this->maxItems       = (int)   ($s['max_items']       ?? 8);
        $this->autoplay       = (bool)  ($s['autoplay']        ?? true);
        $this->interval       = (float) ($s['interval']        ?? 4.5);
        $this->showThumbnails = (bool)  ($s['show_thumbnails'] ?? true);
    }

    public function save(): void
    {
        $this->validate();

        // Defensive clamps (in case validation is bypassed)
        $this->maxItems = max(1, min(24, $this->maxItems));
        $this->interval = max(2, min(15, $this->interval));

        Setting::set('site.slideshow', [
            'enabled'         => $this->enabled,
            'eyebrow_en'      => trim($this->eyebrowEn),
            'eyebrow_km'      => trim($this->eyebrowKm),
            'eyebrow_zh'      => trim($this->eyebrowZh),
            'heading_en'      => trim($this->headingEn),
            'heading_km'      => trim($this->headingKm),
            'heading_zh'      => trim($this->headingZh),
            'max_items'       => $this->maxItems,
            'autoplay'        => $this->autoplay,
            'interval'        => $this->interval,
            'show_thumbnails' => $this->showThumbnails,
        ]);

        Notification::make()->title('Slideshow settings saved!')->success()->send();
    }
}
