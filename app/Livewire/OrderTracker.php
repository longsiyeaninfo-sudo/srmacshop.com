<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderTracker extends Component
{
    public string $orderNumber = '';
    public string $phone = '';
    public ?Order $order = null;
    public ?string $error = null;
    public bool $searched = false;

    public function track(): void
    {
        $this->validate([
            'orderNumber' => 'required|string',
            'phone'       => 'required|string',
        ]);

        $this->error = null;
        $this->order = null;
        $this->searched = true;

        $order = Order::with('items')
            ->where('order_number', strtoupper(trim($this->orderNumber)))
            ->where('customer_phone', trim($this->phone))
            ->first();

        if (! $order) {
            $this->error = 'No order found. Please check your order number and phone number.';
            return;
        }

        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.order-tracker');
    }
}
