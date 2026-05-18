<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class KpiStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Order::whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
            ->sum('total');

        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
            ->sum('total');

        $pendingOrders = Order::where('status', OrderStatus::Pending)->count();
        $lowStock = Product::where('is_active', true)->where('stock', '<=', 3)->where('stock', '>', 0)->count();
        $outOfStock = Product::where('is_active', true)->where('stock', 0)->count();

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue / 100, 2))
                ->description('Confirmed + Delivered orders')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make("Today's Orders", $todayOrders)
                ->description('Revenue today: $' . number_format($todayRevenue / 100, 2))
                ->color('primary')
                ->icon('heroicon-o-calendar'),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Awaiting confirmation')
                ->color($pendingOrders > 0 ? 'warning' : 'success')
                ->icon('heroicon-o-clock'),

            Stat::make('Stock Alerts', $lowStock + $outOfStock)
                ->description("Low stock: {$lowStock} · Out: {$outOfStock}")
                ->color($outOfStock > 0 ? 'danger' : ($lowStock > 0 ? 'warning' : 'success'))
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
