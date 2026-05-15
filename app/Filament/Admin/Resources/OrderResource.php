<?php

namespace App\Filament\Admin\Resources;

use App\Enums\OrderStatus;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Main';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('order_number')->disabled(),
            Forms\Components\TextInput::make('customer_name')->required(),
            Forms\Components\TextInput::make('customer_phone')->tel()->required(),
            Forms\Components\Textarea::make('customer_address')->required()->columnSpanFull(),
        Forms\Components\Select::make('payment_method')
          ->options(['cash' => 'Cash', 'card' => 'Card', 'qr' => 'QR', 'aba' => 'ABA'])
            ->required(),
        Forms\Components\Select::make('status')
          ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])->all())
                ->required(),
            Forms\Components\TextInput::make('coupon_code'),
            Forms\Components\Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
                Tables\Columns\TextColumn::make('order_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('customer_name')->searchable(),
          Tables\Columns\TextColumn::make('items_count')
             ->counts('items')
                  ->label('Items'),
          Tables\Columns\TextColumn::make('total')->money('USD', divideBy: 100)->sortable(),
        Tables\Columns\TextColumn::make('payment_method')->badge(),
         Tables\Columns\TextColumn::make('status')
              ->badge()
                ->formatStateUsing(fn (OrderStatus $state) => $state->label())
                ->color(fn (OrderStatus $state) => $state->color()),
         Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
       ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                  ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])->all()),
             Tables\Filters\SelectFilter::make('payment_method')
                  ->options(['cash' => 'Cash', 'card' => 'Card', 'qr' => 'QR', 'aba' => 'ABA']),
            ])
         ->actions([
                Tables\Actions\Action::make('confirm')
              ->label('Mark Confirmed')
                  ->icon('heroicon-o-check-circle')
               ->visible(fn (Order $r) => $r->status === OrderStatus::Pending)
                    ->action(fn (Order $r) => $r->update(['status' => OrderStatus::Confirmed])),
         Tables\Actions\Action::make('deliver')
            ->label('Mark Delivered')
            ->icon('heroicon-o-truck')
            ->visible(fn (Order $r) => $r->status === OrderStatus::Confirmed)
                  ->action(fn (Order $r) => $r->update(['status' => OrderStatus::Delivered])),
            Tables\Actions\Action::make('cancel')
                ->label('Cancel')
                  ->icon('heroicon-o-x-circle')
                  ->color('danger')
                ->visible(fn (Order $r) => in_array($r->status, [OrderStatus::Pending, OrderStatus::Confirmed], true))
            ->action(fn (Order $r) => $r->update(['status' => OrderStatus::Cancelled])),
             Tables\Actions\Action::make('invoice')
                ->label('Print Invoice')
            ->icon('heroicon-o-printer')
              ->url(fn (Order $r) => route('invoice', $r))
                ->openUrlInNewTab(),
         Tables\Actions\EditAction::make(),
        ]);
    }

  public static function getPages(): array
    {
        return [
        'index' => Pages\ListOrders::route('/'),
        'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
