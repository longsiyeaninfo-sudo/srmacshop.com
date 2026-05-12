<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                      TextInput::make('order_number')
                     ->disabled()
                         ->dehydrated(false),
               
            Select::make('user_id')
                        ->relationship('user', 'name')
                ->searchable()
                 ->preload()
                    ->label('Customer'),
                  
              TextInput::make('email')
                       ->email()
                     ->required(),
                
                  TextInput::make('phone')
             ->tel()
                         ->required(),
              ])->columns(2),
                
         Section::make('Status')
               ->schema([
                        Select::make('status')
                         ->options([
                     'pending' => 'Pending',
                  'paid' => 'Paid',
                   'processing' => 'Processing',
                            'shipped' => 'Shipped',
                     'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                       ])
                ->required()
                            ->default('pending'),
                        
                    Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                            'paid' => 'Paid',
                      'failed' => 'Failed',
                         'refunded' => 'Refunded',
                      ])
                 ->required()
                            ->default('pending'),
                 
               TextInput::make('payment_method')
                      ->required(),
                        
                  DateTimePicker::make('paid_at'),
                  DateTimePicker::make('shipped_at'),
                 DateTimePicker::make('delivered_at'),
                  ])->columns(3),
           
                Section::make('Pricing')
               ->schema([
                   TextInput::make('subtotal')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                  
                        TextInput::make('discount_total')
                         ->numeric()
                ->prefix('$')
                     ->default(0),
               
                      TextInput::make('shipping_total')
                ->numeric()
                 ->prefix('$')
          ->default(0),
                
                 TextInput::make('tax_total')
                          ->numeric()
                    ->prefix('$')
                            ->default(0),
                 
               TextInput::make('grand_total')
                        ->numeric()
                       ->prefix('$')
              ->required(),
                  
                    TextInput::make('coupon_code'),
              ])->columns(3),
             
             Section::make('Notes')
             ->schema([
               Textarea::make('notes')
                      ->rows(3)
                    ->columnSpanFull(),
             ]),
        ]);
    }
}
