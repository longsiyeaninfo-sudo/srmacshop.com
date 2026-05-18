<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Livewire\Attributes\Url;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = -100;
    protected static string $view = 'filament.admin.pages.dashboard';

    #[Url(except: 'week')]
    public string $period = 'week';

    public function setPeriod(string $period): void
    {
        $this->period = in_array($period, ['today', 'week', 'month', 'ytd'], true) ? $period : 'week';
    }

    /** @return array<string,string> */
    public function getPeriodOptions(): array
    {
        return [
            'today' => 'Today',
            'week'  => 'Week',
            'month' => 'Month',
            'ytd'   => 'YTD',
        ];
    }

    // Our view embeds widgets explicitly — don't auto-render the global widget grid.
    public function getWidgets(): array
    {
        return [];
    }
}
