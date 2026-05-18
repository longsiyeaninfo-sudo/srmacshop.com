<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    public string $period = 'week';

    public function getHeading(): string
    {
        return 'Revenue — ' . KpiStatsOverview::range($this->period)[2];
    }

    protected function getData(): array
    {
        // Buckets: today=hours(24), week=days(7), month=days(in month), ytd=months(12)
        [$labels, $totals] = match ($this->period) {
            'today' => $this->byHour(),
            'month' => $this->byDay(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth()),
            'ytd'   => $this->byMonth(),
            default => $this->byDay(Carbon::today()->subDays(6), Carbon::today()),
        };

        return [
            'datasets' => [[
                'label' => 'Revenue ($)',
                'data' => $totals,
                'backgroundColor' => '#f97316',
                'borderColor' => '#f97316',
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * @return array{0: array<int,string>, 1: array<int,float>}
     */
    protected function byDay(Carbon $start, Carbon $end): array
    {
        $days = collect();
        for ($d = $start->copy(); $d <= $end; $d->addDay()) {
            $days->push($d->copy());
        }
        $labels = $days->map(fn (Carbon $d) => $d->format('M j'))->all();
        $totals = $days->map(fn (Carbon $d) => Order::whereDate('created_at', $d)
            ->whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
            ->sum('total') / 100)->all();
        return [$labels, $totals];
    }

    /**
     * @return array{0: array<int,string>, 1: array<int,float>}
     */
    protected function byHour(): array
    {
        $labels = [];
        $totals = [];
        for ($h = 0; $h < 24; $h++) {
            $labels[] = sprintf('%02d:00', $h);
            $start = Carbon::today()->setHour($h);
            $end = Carbon::today()->setHour($h)->endOfHour();
            $totals[] = Order::whereBetween('created_at', [$start, $end])
                ->whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
                ->sum('total') / 100;
        }
        return [$labels, $totals];
    }

    /**
     * @return array{0: array<int,string>, 1: array<int,float>}
     */
    protected function byMonth(): array
    {
        $labels = [];
        $totals = [];
        $year = Carbon::today()->year;
        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($year, $m, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $labels[] = $start->format('M');
            $totals[] = Order::whereBetween('created_at', [$start, $end])
                ->whereIn('status', [OrderStatus::Confirmed->value, OrderStatus::Delivered->value])
                ->sum('total') / 100;
        }
        return [$labels, $totals];
    }
}
