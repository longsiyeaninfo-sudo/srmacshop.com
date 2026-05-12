<?php

namespace App\Livewire;

use App\Models\Order;
use App\Services\OrderTrackingService;
use Livewire\Component;

class OrderTracking extends Component
{
    public Order $order;
    public array $trackingInfo = [];
    public array $statusHistory = [];

    public function mount($orderNumber)
    {
    $this->order = Order::where('order_number', $orderNumber)
            ->with('user', 'items.productVariant.product')
            ->firstOrFail();

        // Check if user owns this order
        if (auth()->check() && $this->order->user_id !== auth()->id()) {
            abort(403);
        }

        $trackingService = app(OrderTrackingService::class);
        $this->trackingInfo = $trackingService->getTrackingInfo($this->order);
        $this->statusHistory = $trackingService->getStatusHistory($this->order);
    }

    public function render()
    {
        return view('livewire.order-tracking');
    }
}
