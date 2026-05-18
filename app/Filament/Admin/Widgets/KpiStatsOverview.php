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
    public string $period = 'week';

    protected function getStats(): array
    {
        [$start, $end, $label] = self::range($this->period);

        $rangeOrders = Order::whereBetween('created_at', [$start, $end])->count();
        $rangeRevenue = Order::whereBetween('created_at', [$start, $end])
            ->whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
            ->sum('total');

        $totalRevenue = Order::whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
            ->sum('total');

        $pendingOrders = Order::where('status', OrderStatus::Pending)->count();
        $lowStock = Product::where('is_active', true)->where('stock', '<=', 3)->where('stock', '>', 0)->count();
        $outOfStock = Product::where('is_active', true)->where('stock', 0)->count();

        return [
            Stat::make('Revenue (' . $label . ')', '$' . number_format($rangeRevenue / 100, 2))
                ->description("All time: $" . number_format($totalRevenue / 100, 2))
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Orders (' . $label . ')', $rangeOrders)
                ->description('Includes all statuses')
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

    /**
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    public static function range(string $period): array
    {
        return match ($period) {
            'today' => [Carbon::today(), Carbon::today()->endOfDay(), 'Today'],
            'month' => [Carbon::today()->startOfMonth(), Carbon::today()->endOfDay(), 'Month'],
            'ytd'   => [Carbon::today()->startOfYear(), Carbon::today()->endOfDay(), 'YTD'],
            default => [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->endOfDay(), 'Week'],
        };
    }
}
