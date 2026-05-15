<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Revenue (last 7 days)';

    protected function getData(): array
    {
      $days = collect(range(6, 0))->map(fn ($i) => Carbon::today()->subDays($i));

        $totals = $days->map(function (Carbon $day) {
            $cents = Order::whereDate('created_at', $day)
                ->whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
                ->sum('total');
            return $cents / 100;
        });

      return [
            'datasets' => [[
             'label' => 'Revenue ($)',
            'data' => $totals->all(),
                'backgroundColor' => '#007AFF',
         ]],
        'labels' => $days->map(fn ($d) => $d->format('M j'))->all(),
        ];
  }

    protected function getType(): string
    {
        return 'bar';
    }
}
