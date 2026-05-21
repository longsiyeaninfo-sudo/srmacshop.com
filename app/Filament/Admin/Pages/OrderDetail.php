<?php

namespace App\Filament\Admin\Pages;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\TelegramService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class OrderDetail extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Order Details';
    protected static string $view = 'filament.admin.pages.order-detail';

    public static function getRoutePath(): string
    {
        return '/order/{record}';
    }

    public Order $record;

    public function mount(Order $record): void
    {
        $this->record = $record->load('items.product.media');
    }

    public function confirm(): void
    {
        if ($this->record->status !== OrderStatus::Pending) return;
        $this->record->update(['status' => OrderStatus::Confirmed]);
        app(TelegramService::class)->notifyOrderStatus($this->record->refresh());
        $this->notify('Order confirmed', 'success');
    }

    public function deliver(): void
    {
        if ($this->record->status !== OrderStatus::Confirmed) return;
        $this->record->update(['status' => OrderStatus::Delivered]);
        app(TelegramService::class)->notifyOrderStatus($this->record->refresh());
        $this->notify('Order marked as delivered', 'success');
    }

    public function cancelOrder(): void
    {
        if (! in_array($this->record->status, [OrderStatus::Pending, OrderStatus::Confirmed], true)) return;
        $this->record->update(['status' => OrderStatus::Cancelled]);
        app(TelegramService::class)->notifyOrderStatus($this->record->refresh());
        $this->notify('Order cancelled', 'warning');
    }

    protected function notify(string $title, string $color): void
    {
        Notification::make()->title($title)->color($color)->send();
        $this->record->refresh();
    }

    /**
     * Status timeline: array of [step name, status, css class]
     */
    public function getTimelineProperty(): array
    {
        $status = $this->record->status;
        $isCancelled = $status === OrderStatus::Cancelled;

        $order = [OrderStatus::Pending, OrderStatus::Confirmed, OrderStatus::Delivered];
        $currentIdx = $isCancelled ? -1 : array_search($status, $order, true);

        $steps = [];
        foreach ($order as $i => $s) {
            $steps[] = [
                'label' => $s->label(),
                'icon' => match ($s) {
                    OrderStatus::Pending => '⏳',
                    OrderStatus::Confirmed => '✓',
                    OrderStatus::Delivered => '📦',
                    default => '•',
                },
                'state' => $isCancelled ? 'cancelled' : ($i < $currentIdx ? 'done' : ($i === $currentIdx ? 'current' : 'future')),
            ];
        }

        if ($isCancelled) {
            $steps[] = ['label' => 'Cancelled', 'icon' => '✕', 'state' => 'cancelled-final'];
        }

        return $steps;
    }
}
