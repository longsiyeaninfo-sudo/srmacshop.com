<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Validate;

class AnnouncementBar extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Announcement Bar';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int    $navigationSort  = 8;
    protected static ?string $title           = 'Announcement Bar';
    protected static string  $view            = 'filament.admin.pages.settings.announcement-bar';

    public bool   $enabled      = false;

    #[Validate('nullable|string|max:200')]
    public string $text         = '';

    #[Validate('nullable|url|max:255')]
    public string $linkUrl      = '';

    #[Validate('nullable|string|max:60')]
    public string $linkText     = '';

    public string $bgColor      = '#FF2D55';
    public bool   $dismissible  = true;

    // ── Lifecycle ────────────────────────────────────────────────────────────

    public function mount(): void
    {
        $a = Setting::get('site.announcement', []) ?: [];

        $this->enabled     = (bool) ($a['enabled']     ?? false);
        $this->text        = $a['text']       ?? '';
        $this->linkUrl     = $a['link_url']   ?? '';
        $this->linkText    = $a['link_text']  ?? '';
        $this->bgColor     = $a['bg_color']   ?? '#FF2D55';
        $this->dismissible = (bool) ($a['dismissible'] ?? true);
    }

    // ── Save ─────────────────────────────────────────────────────────────────

    public function save(): void
    {
        $this->validate();

        Setting::set('site.announcement', [
            'enabled'     => $this->enabled,
            'text'        => trim($this->text),
            'link_url'    => trim($this->linkUrl),
            'link_text'   => trim($this->linkText),
            'bg_color'    => $this->bgColor,
            'dismissible' => $this->dismissible,
        ]);

        Notification::make()->title('Announcement bar saved!')->success()->send();
    }
}
