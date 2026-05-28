<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Branding extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon  = 'heroicon-o-swatch';
    protected static ?string $navigationLabel = 'Branding & Logo';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int    $navigationSort  = 5;
    protected static ?string $title           = 'Branding & Logo';
    protected static string  $view            = 'filament.admin.pages.settings.branding';

    /** Temporary Livewire upload — null when no new file chosen. */
    #[Validate('nullable|image|max:2048')]
    public $logoUpload = null;

    /** Currently-stored relative path inside the public disk (e.g. logos/abc.png). */
    public string $logoPath = '';

    /** The blue/accent prefix word shown before the store name (e.g. "SR"). */
    #[Validate('nullable|string|max:20')]
    public string $logoPrefix = 'SR';

    /** The main store name text (e.g. "MAC SHOP"). */
    #[Validate('nullable|string|max:60')]
    public string $logoText = 'MAC SHOP';

    /** Whether to show the text next to the image in the navbar. */
    public bool $showText = true;

    // ── Lifecycle ────────────────────────────────────────────────────────────

    public function mount(): void
    {
        $b = Setting::get('site.branding', []) ?: [];

        $this->logoPath   = $b['logo_path']   ?? '';
        $this->logoPrefix = $b['logo_prefix'] ?? 'SR';
        $this->logoText   = $b['logo_text']   ?? 'MAC SHOP';
        $this->showText   = (bool) ($b['show_text'] ?? true);
    }

    // ── Actions ──────────────────────────────────────────────────────────────

    public function save(): void
    {
        $this->validate([
            'logoUpload' => 'nullable|image|max:2048',
            'logoPrefix' => 'nullable|string|max:20',
            'logoText'   => 'nullable|string|max:60',
        ]);

        // Store the uploaded file if one was provided.
        if ($this->logoUpload) {
            if ($this->logoPath && Storage::disk('public')->exists($this->logoPath)) {
                Storage::disk('public')->delete($this->logoPath);
            }
            $this->logoPath   = $this->logoUpload->store('logos', 'public');
            $this->logoUpload = null;
        }

        Setting::set('site.branding', [
            'logo_path'   => $this->logoPath ?: null,
            'logo_prefix' => trim($this->logoPrefix) ?: 'SR',
            'logo_text'   => trim($this->logoText)   ?: 'MAC SHOP',
            'show_text'   => $this->showText,
        ]);

        Notification::make()->title('Branding saved!')->success()->send();
    }

    /** Reset back to the default built-in SVG. */
    public function removeLogo(): void
    {
        if ($this->logoPath && Storage::disk('public')->exists($this->logoPath)) {
            Storage::disk('public')->delete($this->logoPath);
        }

        $this->logoPath   = '';
        $this->logoUpload = null;

        $branding              = Setting::get('site.branding', []) ?: [];
        $branding['logo_path'] = null;
        Setting::set('site.branding', $branding);

        Notification::make()->title('Logo reset to default SVG')->success()->send();
    }
}
