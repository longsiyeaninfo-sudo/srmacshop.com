<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
    public function createPaymentIntent(Order $order): array
    {
        try {
        $paymentIntent = PaymentIntent::create([
          'amount' => $this->convertToStripeAmount($order->grand_total),
            'currency' => config('services.stripe.currency', 'usd'),
           'metadata' => [
        'order_id' => $order->id,
             'order_number' => $order->order_number,
              ],
            'description' => "Order #{$order->order_number}",
         ]);

          return [
          'success' => true,
          'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
         ];
        }
    }

    public function confirmPayment(string $paymentIntentId): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            return [
                'success' => true,
             'status' => $paymentIntent->status,
                'payment_intent' => $paymentIntent,
            ];
     } catch (ApiErrorException $e) {
            return [
          'success' => false,
                'error' => $e->getMessage(),
        ];
        }
    }

    public function handleWebhook(array $payload): array
    {
        try {
            $event = \Stripe\Event::constructFrom($payload);
            switch ($event->type) {
             case 'payment_intent.succeeded':
                    $this->handlePaymentSuccess($event->data->object);
                    break;

         case 'payment_intent.payment_failed':
                  $this->handlePaymentFailure($event->data->object);
                    break;
            }

            return ['success' => true];
        } catch (\Exception $e) {
            return [
                'success' => false,
             'error' => $e->getMessage(),
            ];
        }
    }

    protected function handlePaymentSuccess($paymentIntent): void
    {
        $orderId = $paymentIntent->metadata->order_id ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
              $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'stripe',
                    'transaction_id' => $paymentIntent->id,
                ]);
            }
        }
    }

  protected function handlePaymentFailure($paymentIntent): void
    {
        $orderId = $paymentIntent->metadata->order_id ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
          $order->update([
                  'payment_status' => 'failed',
            'payment_method' => 'stripe',
                ]);
        }
        }
    }

    protected function convertToStripeAmount(float $amount): int
    {
        return (int) ($amount * 100);
    }
}
