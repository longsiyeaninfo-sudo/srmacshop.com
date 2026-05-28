<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class SeoSettings extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon  = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationLabel = 'SEO & Analytics';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int    $navigationSort  = 15;
    protected static ?string $title           = 'SEO & Analytics';
    protected static string  $view            = 'filament.admin.pages.settings.seo-settings';

    // ── Meta ────────────────────────────────────────────────────────────────

    #[Validate('nullable|string|max:120')]
    public string $defaultTitle = '';

    #[Validate('nullable|string|max:60')]
    public string $titleSuffix  = '';

    #[Validate('nullable|string|max:320')]
    public string $metaDescription = '';

    // ── OG image ────────────────────────────────────────────────────────────

    #[Validate('nullable|image|max:4096')]
    public $ogImageUpload = null;

    public string $ogImagePath = '';

    // ── Analytics ────────────────────────────────────────────────────────────

    #[Validate('nullable|string|max:30')]
    public string $googleAnalyticsId = '';

    #[Validate('nullable|string|max:30')]
    public string $facebookPixelId   = '';

    // ── Lifecycle ────────────────────────────────────────────────────────────

    public function mount(): void
    {
        $s = Setting::get('site.seo', []) ?: [];

        $this->defaultTitle       = $s['default_title']        ?? 'SR MAC SHOP — Think Different. Buy Smarter.';
        $this->titleSuffix        = $s['title_suffix']         ?? ' | SR MAC SHOP';
        $this->metaDescription    = $s['meta_description']     ?? 'Buy authentic MacBooks, iPhones & iPads in Cambodia with official Apple warranty. Same-day delivery in Phnom Penh.';
        $this->ogImagePath        = $s['og_image_path']        ?? '';
        $this->googleAnalyticsId  = $s['google_analytics_id']  ?? '';
        $this->facebookPixelId    = $s['facebook_pixel_id']    ?? '';
    }

    // ── Save ─────────────────────────────────────────────────────────────────

    public function save(): void
    {
        $this->validate([
            'ogImageUpload'     => 'nullable|image|max:4096',
            'defaultTitle'      => 'nullable|string|max:120',
            'titleSuffix'       => 'nullable|string|max:60',
            'metaDescription'   => 'nullable|string|max:320',
            'googleAnalyticsId' => 'nullable|string|max:30',
            'facebookPixelId'   => 'nullable|string|max:30',
        ]);

        if ($this->ogImageUpload) {
            if ($this->ogImagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->ogImagePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->ogImagePath);
            }
            $this->ogImagePath   = $this->ogImageUpload->store('seo', 'public');
            $this->ogImageUpload = null;
        }

        Setting::set('site.seo', [
            'default_title'       => trim($this->defaultTitle),
            'title_suffix'        => trim($this->titleSuffix),
            'meta_description'    => trim($this->metaDescription),
            'og_image_path'       => $this->ogImagePath ?: null,
            'google_analytics_id' => trim($this->googleAnalyticsId),
            'facebook_pixel_id'   => trim($this->facebookPixelId),
        ]);

        Notification::make()->title('SEO settings saved!')->success()->send();
    }

    public function removeOgImage(): void
    {
        if ($this->ogImagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->ogImagePath)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($this->ogImagePath);
        }
        $this->ogImagePath = '';
        $seo = Setting::get('site.seo', []) ?: [];
        $seo['og_image_path'] = null;
        Setting::set('site.seo', $seo);
        Notification::make()->title('OG image removed')->success()->send();
    }
}
