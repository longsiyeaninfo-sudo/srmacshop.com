<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
  public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
    $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
        $webhookSecret
            );

          $paymentService = app(PaymentService::class);
            $result = $paymentService->handleWebhook($event->jsonSerialize());

            if ($result['success']) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'error'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
       return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
