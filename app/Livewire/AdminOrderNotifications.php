<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminOrderNotifications extends Component
{
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function close(): void
    {
        $this->open = false;
    }

    /** Refresh when Filament dispatches an order-related event. */
    #[On('order.updated')]
    public function refresh(): void {}

    public function render()
    {
        $orders = Order::orderByDesc('created_at')
            ->take(12)
            ->get();

        $pendingCount = Order::where('status', OrderStatus::Pending)->count();

        return view('livewire.admin-order-notifications', [
            'orders'       => $orders,
            'pendingCount' => $pendingCount,
        ]);
    }
}
