<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
         Order::query()->latest()->limit(10)
            )
            ->columns([
           Tables\Columns\TextColumn::make('order_number')
                 ->searchable()
                    ->sortable(),
                    
             Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
              ->placeholder('Guest'),
                    
                Tables\Columns\TextColumn::make('grand_total')
                    ->money('USD'),
                 
            Tables\Columns\TextColumn::make('status')
                ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                   'paid' => 'info',
                    'processing' => 'warning',
                  'shipped' => 'primary',
                    'delivered' => 'success',
                      'cancelled' => 'danger',
                  }),
                  
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
