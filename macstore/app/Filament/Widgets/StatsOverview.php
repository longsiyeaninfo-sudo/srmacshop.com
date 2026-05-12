<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Calculate revenue stats
        $totalRevenue = Order::where('payment_status', 'paid')->sum('grand_total');
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('grand_total');
        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
        ->sum('grand_total');
        $revenueChange = $lastMonthRevenue > 0
            ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
       : 0;

        // Calculate order stats
        $totalOrders = Order::count();
        $monthlyOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $ordersChange = $lastMonthOrders > 0
          ? (($monthlyOrders - $lastMonthOrders) / $lastMonthOrders) * 100
            : 0;

        // Calculate customer stats
        $totalCustomers = User::whereHas('orders')->count();
        $newCustomersThisMonth = User::whereHas('orders')
        ->whereMonth('created_at', now()->month)
          ->whereYear('created_at', now()->year)
            ->count();

        // Calculate average order value
        $avgOrderValue = Order::where('payment_status', 'paid')->avg('grand_total');

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
             ->description($revenueChange >= 0 ? '+' . number_format($revenueChange, 1) . '% from last month' : number_format($revenueChange, 1) . '% from last month')
              ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
        ->chart($this->getRevenueChartData()),
            Stat::make('Total Orders', number_format($totalOrders))
                ->description($ordersChange >= 0 ? '+' . number_format($ordersChange, 1) . '% from last month' : number_format($ordersChange, 1) . '% from last month')
              ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger')
            ->chart($this->getOrdersChartData()),

          Stat::make('Total Customers', number_format($totalCustomers))
           ->description($newCustomersThisMonth . ' new this month')
            ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Average Order Value', '$' . number_format($avgOrderValue, 2))
                ->description('Across all orders')
            ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),
        ];
    }

    protected function getRevenueChartData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Order::where('payment_status', 'paid')
                ->whereDate('created_at', $date)
          ->sum('grand_total');
            $data[] = $revenue;
        }
        return $data;
    }

    protected function getOrdersChartData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $orders = Order::whereDate('created_at', $date)->count();
            $data[] = $orders;
        }
        return $data;
    }
}
