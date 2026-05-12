<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Sales';

    protected static ?int $sort = 2;

    public ?string $filter = 'month';

    protected function getData(): array
    {
      $data = $this->getSalesData();

        return [
            'datasets' => [
                [
               'label' => 'Revenue',
             'data' => $data['revenue'],
               'borderColor' => 'rgb(59, 130, 246)',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
           ],
                [
                    'label' => 'Orders',
                    'data' => $data['orders'],
                  'borderColor' => 'rgb(16, 185, 129)',
                 'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                ],
            ],
        'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last 7 days',
            'month' => 'Last 30 days',
            'year' => 'This year',
        ];
    }

    protected function getSalesData(): array
    {
        $filter = $this->filter;
      $labels = [];
      $revenue = [];
        $orders = [];

        if ($filter === 'week') {
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('M d');

                $dayRevenue = Order::where('payment_status', 'paid')
                ->whereDate('created_at', $date)
         ->sum('grand_total');
              $revenue[] = round($dayRevenue, 2);

             $dayOrders = Order::whereDate('created_at', $date)->count();
                $orders[] = $dayOrders;
            }
        } elseif ($filter === 'month') {
            for ($i = 29; $i >= 0; $i--) {
           $date = now()->subDays($i);
                $labels[] = $date->format('M d');

                $dayRevenue = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
               ->sum('grand_total');
                $revenue[] = round($dayRevenue, 2);

            $dayOrders = Order::whereDate('created_at', $date)->count();
                $orders[] = $dayOrders;
          }
      } else {
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
              $labels[] = $date->format('M Y');

            $monthRevenue = Order::where('payment_status', 'paid')
                 ->whereMonth('created_at', $date->month)
                 ->whereYear('created_at', $date->year)
             ->sum('grand_total');
              $revenue[] = round($monthRevenue, 2);

             $monthOrders = Order::whereMonth('created_at', $date->month)
              ->whereYear('created_at', $date->year)
             ->count();
              $orders[] = $monthOrders;
         }
      }

        return [
            'labels' => $labels,
         'revenue' => $revenue,
      'orders' => $orders,
        ];
    }
}
