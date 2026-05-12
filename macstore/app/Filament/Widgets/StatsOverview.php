<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todayRevenue = Order::whereDate('created_at', today())
       ->where('payment_status', 'paid')
            ->sum('grand_total');
            
        $monthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
       ->sum('grand_total');
            
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $lowStockProducts = Product::whereHas('variants', function ($query) {
            $query->where('stock_quantity', '<', 5);
        })->count();

        return [
            Stat::make('Today Revenue', '$' . number_format($todayRevenue, 2))
             ->description('Revenue from today')
         ->descriptionIcon('heroicon-m-arrow-trending-up')
          ->color('success'),
                
            Stat::make('Month Revenue', '$' . number_format($monthRevenue, 2))
           ->description('Revenue this month')
           ->descriptionIcon('heroicon-m-currency-dollar')
              ->color('success'),
                
            Stat::make('Pending Orders', $pendingOrders)
            ->description('Orders awaiting processing')
            ->descriptionIcon('heroicon-m-shopping-bag')
              ->color('warning'),
           
          Stat::make('Low Stock Products', $lowStockProducts)
             ->description('Products with less than 5 units')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
              ->color('danger'),
        ];
    }
}
