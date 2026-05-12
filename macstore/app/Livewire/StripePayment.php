<?php

namespace App\Livewire;

use App\Models\Order;
use App\Services\PaymentService;
use Livewire\Component;

class StripePayment extends Component
{
    public Order $order;
    public $clientSecret;
    public $paymentIntentId;
    public $paymentStatus = 'pending';

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->initializePayment();
    }

    public function initializePayment()
    {
        $paymentService = app(PaymentService::class);
        $result = $paymentService->createPaymentIntent($this->order);

        if ($result['success']) {
            $this->clientSecret = $result['client_secret'];
            $this->paymentIntentId = $result['payment_intent_id'];
        } else {
            session()->flash('error', $result['error']);
        }
    }

    public function confirmPayment()
    {
      $paymentService = app(PaymentService::class);
        $result = $paymentService->confirmPayment($this->paymentIntentId);

        if ($result['success'] && $result['status'] === 'succeeded') {
          $this->paymentStatus = 'succeeded';
            $this->order->update([
           'payment_status' => 'paid',
                'payment_method' => 'stripe',
                'transaction_id' => $this->paymentIntentId,
        ]);

         session()->flash('success', __('Payment successful!'));
          return redirect()->route('account.orders');
        } else {
            $this->paymentStatus = 'failed';
            session()->flash('error', __('Payment failed. Please try again.'));
        }
    }

    public function render()
    {
        return view('livewire.stripe-payment');
    }
}
