<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminOrderNotifications extends Component
{
    /** Refresh when Filament dispatches an order-related event. */
    #[On('order.updated')]
    public function refresh(): void {}

    public function render()
    {
        $orders = Order::orderByDesc('created_at')
            ->take(15)
            ->withCount('items')
            ->get();

        $pendingCount  = Order::where('status', OrderStatus::Pending)->count();
        $todayCount    = Order::whereDate('created_at', today())->count();
        $latestOrderId = Order::max('id') ?? 0;

        return view('livewire.admin-order-notifications', [
            'orders'        => $orders,
            'pendingCount'  => $pendingCount,
            'todayCount'    => $todayCount,
            'latestOrderId' => $latestOrderId,
        ]);
    }
}
