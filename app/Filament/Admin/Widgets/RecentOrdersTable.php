<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Orders';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
      return $table
            ->query(Order::query()->latest()->limit(10))
       ->columns([
        TextColumn::make('order_number')->label('#'),
           TextColumn::make('customer_name')->label('Customer'),
                TextColumn::make('payment_method')->badge(),
                TextColumn::make('total')
                    ->money('USD', divideBy: 100),
          TextColumn::make('status')
            ->badge()
                ->color(fn (OrderStatus $state) => $state->color()),
            TextColumn::make('created_at')->since(),
         ]);
  }
}
