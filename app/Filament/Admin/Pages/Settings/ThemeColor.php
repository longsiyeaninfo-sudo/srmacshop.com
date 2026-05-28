<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class ThemeColor extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-paint-brush';
    protected static ?string $navigationLabel = 'Theme Color';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int    $navigationSort  = 7;
    protected static ?string $title           = 'Theme Color';
    protected static string  $view            = 'filament.admin.pages.settings.theme-color';

    #[Validate('nullable|string|max:7')]
    public string $accentColor = '#007AFF';

    public function mount(): void
    {
        $t = Setting::get('site.theme', []) ?: [];
        $this->accentColor = $t['accent_color'] ?? '#007AFF';
    }

    public function save(): void
    {
        $this->validate();

        // Ensure it's a valid hex color.
        $hex = ltrim(trim($this->accentColor), '#');
        if (! preg_match('/^[0-9a-fA-F]{3}$|^[0-9a-fA-F]{6}$/', $hex)) {
            $this->accentColor = '#007AFF';
        } else {
            $this->accentColor = '#' . strtoupper($hex);
        }

        Setting::set('site.theme', [
            'accent_color' => $this->accentColor,
        ]);

        Notification::make()->title('Theme color saved!')->success()->send();
    }

    public function resetToDefault(): void
    {
        $this->accentColor = '#007AFF';
        Setting::set('site.theme', ['accent_color' => '#007AFF']);
        Notification::make()->title('Reset to Apple Blue (#007AFF)')->success()->send();
    }
}
