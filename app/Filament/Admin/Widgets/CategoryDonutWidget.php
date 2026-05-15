<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CategoryDonutWidget extends ChartWidget
{
    protected static ?string $heading = 'Sales by Category';

    protected function getData(): array
    {
        $rows = Category::query()
          ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
        ->select('categories.name', DB::raw('COALESCE(SUM(order_items.line_total), 0) AS sales_cents'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get();

        return [
            'datasets' => [[
                'label' => 'Sales',
                'data' => $rows->map(fn ($r) => ($r->sales_cents ?? 0) / 100)->all(),
        'backgroundColor' => ['#007AFF', '#34c759', '#FF9500', '#AF52DE', '#FF3B30'],
            ]],
         'labels' => $rows->pluck('name')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
