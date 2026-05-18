<?php

namespace App\Filament\Admin\Resources;

use App\Enums\OrderStatus;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Services\TelegramService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Main';
    protected static ?string $navigationBadgeColor = 'warning';

    public static function getNavigationBadge(): ?string
    {
        $count = Order::where('status', OrderStatus::Pending)->count();
        return $count > 0 ? (string) $count : null;
    }

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
                Tables\Columns\TextColumn::make('order_number')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('customer_name')->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('items_count')->counts('items')->label('Items'),
                Tables\Columns\TextColumn::make('total')->money('USD', divideBy: 100)->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('payment_method')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'cash' => 'success', 'card' => 'info', 'qr' => 'warning', 'aba' => 'primary', default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (OrderStatus $state) => $state->label())
                    ->color(fn (OrderStatus $state) => $state->color()),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
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
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Order $r) => $r->status === OrderStatus::Pending)
                    ->action(function (Order $r) {
                        $r->update(['status' => OrderStatus::Confirmed]);
                        app(TelegramService::class)->notifyOrderStatus($r->refresh());
                    }),
                Tables\Actions\Action::make('deliver')
                    ->label('Delivered')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->visible(fn (Order $r) => $r->status === OrderStatus::Confirmed)
                    ->action(function (Order $r) {
                        $r->update(['status' => OrderStatus::Delivered]);
                        app(TelegramService::class)->notifyOrderStatus($r->refresh());
                    }),
                Tables\Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Order $r) => in_array($r->status, [OrderStatus::Pending, OrderStatus::Confirmed], true))
                    ->action(function (Order $r) {
                        $r->update(['status' => OrderStatus::Cancelled]);
                        app(TelegramService::class)->notifyOrderStatus($r->refresh());
                    }),
                Tables\Actions\Action::make('invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->url(fn (Order $r) => route('invoice', $r))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn (Order $r) => \App\Filament\Admin\Pages\OrderDetail::getUrl(['record' => $r->id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_csv')
                        ->label('Export CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(fn (Collection $records) => self::exportCsv($records)),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function exportCsv(Collection $orders): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $orders->load('items');
        $filename = 'orders-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order #', 'Customer', 'Phone', 'Address', 'Payment', 'Status', 'Items', 'Subtotal', 'Discount', 'Tax', 'Total', 'Notes', 'Date']);
            foreach ($orders as $order) {
                $itemSummary = $order->items->map(fn ($i) => "{$i->product_name_snapshot} x{$i->quantity}")->join('; ');
                fputcsv($handle, [
                    $order->order_number,
                    $order->customer_name,
                    $order->customer_phone,
                    $order->customer_address,
                    $order->payment_method,
                    $order->status->value ?? $order->status,
                    $itemSummary,
                    number_format($order->subtotal / 100, 2),
                    number_format($order->discount / 100, 2),
                    number_format($order->tax / 100, 2),
                    number_format($order->total / 100, 2),
                    $order->notes,
                    $order->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
        ];
    }
}
