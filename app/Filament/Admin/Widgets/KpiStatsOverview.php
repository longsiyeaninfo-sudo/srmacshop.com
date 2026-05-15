<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KpiStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
     $revenueCents = Order::whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
            ->sum('total');

        return [
          Stat::make('Total Revenue', '$'.number_format($revenueCents / 100, 2))
                ->color('success'),
            Stat::make('Total Orders', Order::count())
              ->color('primary'),
        Stat::make('Products', Product::where('is_active', true)->count())
              ->color('warning'),
        Stat::make('Customers', User::where('role', 'customer')->count())
                ->color('info'),
        ];
    }
}
