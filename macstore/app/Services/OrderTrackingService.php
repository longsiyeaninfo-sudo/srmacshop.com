<?php

namespace App\Services;

use App\Models\Order;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class OrderTrackingService
{
    public function updateTracking(Order $order, array $data): Order
    {
        $statusHistory = json_decode($order->status_history ?? '[]', true);

        $statusHistory[] = [
            'status' => $data['status'] ?? $order->status,
            'timestamp' => now()->toIso8601String(),
       'note' => $data['note'] ?? null,
        ];

        $order->update([
            'tracking_number' => $data['tracking_number'] ?? $order->tracking_number,
            'carrier' => $data['carrier'] ?? $order->carrier,
            'tracking_url' => $data['tracking_url'] ?? $order->tracking_url,
            'status' => $data['status'] ?? $order->status,
            'status_history' => json_encode($statusHistory),
        ]);

        return $order->fresh();
    }

    public function markAsShipped(Order $order, string $trackingNumber, string $carrier, ?string $trackingUrl = null): Order
    {
      $order->update([
          'status' => 'shipped',
            'tracking_number' => $trackingNumber,
            'carrier' => $carrier,
            'tracking_url' => $trackingUrl,
            'shipped_at' => now(),
        ]);

        $this->addStatusHistory($order, 'shipped', 'Order has been shipped');

        // Send shipping notification email
        Mail::to($order->user->email)->queue(new OrderShipped($order, $trackingNumber));

      return $order->fresh();
    }

    public function markAsDelivered(Order $order): Order
    {
        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $this->addStatusHistory($order, 'delivered', 'Order has been delivered');

        return $order->fresh();
    }

    public function addStatusHistory(Order $order, string $status, ?string $note = null): void
    {
      $statusHistory = json_decode($order->status_history ?? '[]', true);

        $statusHistory[] = [
            'status' => $status,
            'timestamp' => now()->toIso8601String(),
            'note' => $note,
        ];

        $order->update([
            'status_history' => json_encode($statusHistory),
        ]);
    }

    public function getStatusHistory(Order $order): array
    {
        return json_decode($order->status_history ?? '[]', true);
    }

    public function getTrackingInfo(Order $order): array
    {
        return [
            'order_number' => $order->order_number,
            'status' => $order->status,
         'tracking_number' => $order->tracking_number,
      'carrier' => $order->carrier,
            'tracking_url' => $order->tracking_url,
            'shipped_at' => $order->shipped_at,
            'delivered_at' => $order->delivered_at,
            'status_history' => $this->getStatusHistory($order),
        ];
    }

    public function generateTrackingUrl(string $carrier, string $trackingNumber): ?string
    {
        $carriers = [
            'ups' => "https://www.ups.com/track?tracknum={$trackingNumber}",
            'fedex' => "https://www.fedex.com/fedextrack/?tracknumbers={$trackingNumber}",
            'usps' => "https://tools.usps.com/go/TrackConfirmAction?tLabels={$trackingNumber}",
          'dhl' => "https://www.dhl.com/en/express/tracking.html?AWB={$trackingNumber}",
        ];

        return $carriers[strtolower($carrier)] ?? null;
    }
}
