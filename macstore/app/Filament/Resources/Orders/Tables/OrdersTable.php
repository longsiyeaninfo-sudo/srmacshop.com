<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
          ->columns([
              TextColumn::make('order_number')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
              
                TextColumn::make('user.name')
               ->label('Customer')
                ->searchable()
             ->sortable()
                    ->placeholder('Guest'),
                
                TextColumn::make('email')
        ->searchable()
             ->toggleable(),
                 
                TextColumn::make('grand_total')
                    ->money('USD')
                    ->sortable(),
                  
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
              'paid' => 'info',
                   'processing' => 'warning',
          'shipped' => 'primary',
                    'delivered' => 'success',
              'cancelled' => 'danger',
                    }),
                    
              TextColumn::make('payment_status')
            ->badge()
                 ->color(fn (string $state): string => match ($state) {
                      'pending' => 'gray',
                  'paid' => 'success',
                   'failed' => 'danger',
             'refunded' => 'warning',
                    }),
                    
                TextColumn::make('created_at')
                  ->dateTime()
                 ->sortable()
               ->label('Order Date'),
          ])
            ->filters([
                SelectFilter::make('status')
             ->options([
                     'pending' => 'Pending',
                        'paid' => 'Paid',
                     'processing' => 'Processing',
                        'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
                 ]),
          
                SelectFilter::make('payment_status')
              ->options([
                        'pending' => 'Pending',
                'paid' => 'Paid',
                'failed' => 'Failed',
                      'refunded' => 'Refunded',
           ]),
            ])
            ->actions([
          ViewAction::make(),
                EditAction::make(),
         ])
            ->defaultSort('created_at', 'desc');
    }
}
