<?php

namespace App\Http\Controllers;
use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $secret = config('services.stripe.webhook_secret') ?: env('STRIPE_WEBHOOK_SECRET');
        $sig = $request->header('Stripe-Signature');

      try {
            $event = Webhook::constructEvent($request->getContent(), $sig, $secret ?? '');
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook signature failed', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false], 400);
        }

        match ($event->type) {
            'checkout.session.completed' => $this->markPaid($event->data->object),
            'checkout.session.async_payment_failed',
            'checkout.session.expired' => $this->markCancelled($event->data->object),
        default => null,
      };

        return response()->json(['ok' => true]);
    }

    private function markPaid($session): void
    {
        $order = Order::where('stripe_session_id', $session->id ?? null)->first();
        $order?->update(['status' => OrderStatus::Confirmed]);
    }

    private function markCancelled($session): void
    {
        $order = Order::where('stripe_session_id', $session->id ?? null)->first();
        $order?->update(['status' => OrderStatus::Cancelled]);
    }
}
