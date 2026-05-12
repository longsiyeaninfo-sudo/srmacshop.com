<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PopularProducts extends TableWidget
{
    protected ?string $heading = 'Popular Products';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
     return $table
            ->query(
                Product::query()
               ->select('products.*', DB::raw('COUNT(order_items.id) as total_sales'))
                    ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
                    ->groupBy('products.id')
                    ->orderBy('total_sales', 'desc')
                ->limit(10)
            )
            ->columns([
          TextColumn::make('name')
                 ->label('Product')
                ->searchable()
             ->sortable(),

                TextColumn::make('category.name')
             ->label('Category')
               ->sortable(),

                TextColumn::make('base_price')
               ->label('Price')
             ->money('usd')
                    ->sortable(),

            TextColumn::make('total_sales')
                    ->label('Total Sales')
                 ->sortable()
                    ->badge()
               ->color('success'),

                TextColumn::make('condition')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                   'new' => 'success',
                        'refurbished' => 'warning',
                        'used' => 'info',
                 }),
            ])
         ->defaultSort('total_sales', 'desc');
    }
}
