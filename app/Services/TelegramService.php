<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use App\Models\TradeIn;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private string $token;
    private string $chatId;
    private array $settings;

    public function __construct()
    {
        $this->settings = Setting::get('telegram', []) ?: [];
        $this->token  = $this->settings['bot_token']     ?? config('services.telegram.bot_token', '');
        $this->chatId = $this->settings['admin_chat_id'] ?? config('services.telegram.chat_id', '');
    }

    public function notifyNewOrder(Order $order): void
    {
        if (! $this->token || ! $this->chatId) {
            return;
        }
        if (array_key_exists('notify_new', $this->settings) && ! $this->settings['notify_new']) {
            return;
        }

        $items = $order->items->map(fn ($i) =>
            "  • {$i->product_name_snapshot} × {$i->quantity} = \${$this->fmt($i->line_total)}"
        )->join("\n");

        $status = ucfirst($order->status->value ?? $order->status);
        $payment = ucfirst($order->payment_method);

        $text = "🛍 *New Order — SR MAC SHOP*\n\n"
            . "📋 *Order:* `{$order->order_number}`\n"
            . "👤 *Customer:* {$order->customer_name}\n"
            . "📞 *Phone:* {$order->customer_phone}\n"
            . "📍 *Address:* {$order->customer_address}\n"
            . "💳 *Payment:* {$payment}\n"
            . "📦 *Status:* {$status}\n\n"
            . "*Items:*\n{$items}\n\n"
            . ($order->discount > 0 ? "🏷 *Discount:* -\${$this->fmt($order->discount)}\n" : '')
            . "🧾 *Tax (10%):* \${$this->fmt($order->tax)}\n"
            . "💰 *TOTAL: \${$this->fmt($order->total)}*\n\n"
            . ($order->notes ? "📝 *Notes:* {$order->notes}\n\n" : '')
            . "⏰ " . $order->created_at->format('d M Y H:i');

        $this->send($text);
    }

    public function notifyOrderStatus(Order $order): void
    {
        if (! $this->token || ! $this->chatId) {
            return;
        }
        if (array_key_exists('notify_status', $this->settings) && ! $this->settings['notify_status']) {
            return;
        }

        $emoji = match ($order->status->value ?? $order->status) {
            'confirmed'  => '✅',
            'delivered'  => '🚚',
            'cancelled'  => '❌',
            default      => '🔔',
        };

        $status = ucfirst($order->status->value ?? $order->status);

        $text = "{$emoji} *Order Status Updated*\n\n"
            . "📋 Order: `{$order->order_number}`\n"
            . "👤 Customer: {$order->customer_name}\n"
            . "📞 Phone: {$order->customer_phone}\n"
            . "🔄 New Status: *{$status}*";

        $this->send($text);
    }

    public function notifyNewTradeIn(TradeIn $tradeIn): void
    {
        if (! $this->token || ! $this->chatId) {
            return;
        }
        if (array_key_exists('notify_new', $this->settings) && ! $this->settings['notify_new']) {
            return;
        }

        $device = trim("{$tradeIn->device_type} {$tradeIn->model}");
        $extra = collect([
            $tradeIn->storage ?: null,
            $tradeIn->condition_grade ? "Grade {$tradeIn->condition_grade}" : null,
            $tradeIn->battery_health ? "Battery {$tradeIn->battery_health}%" : null,
        ])->filter()->implode(', ');

        $text = "💵 *New Trade-in — SR MAC SHOP*\n\n"
            . "🎫 *Ref:* `{$tradeIn->ticket_number}`\n"
            . "📱 *Device:* {$device}\n"
            . ($extra ? "🔧 *Details:* {$extra}\n" : '')
            . ($tradeIn->asking_price ? "💰 *Asking:* \${$this->fmt($tradeIn->asking_price)}\n" : '')
            . "👤 *Seller:* {$tradeIn->customer_name}\n"
            . "📞 *Phone:* {$tradeIn->customer_phone}\n"
            . ($tradeIn->contact_method ? "💬 *Prefers:* " . ucfirst($tradeIn->contact_method) . "\n" : '')
            . ($tradeIn->description ? "📝 *Notes:* {$tradeIn->description}\n" : '')
            . "\n⏰ " . $tradeIn->created_at->format('d M Y H:i');

        $this->send($text);
    }

    private function send(string $text): void
    {
        try {
            Http::timeout(5)->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id'    => $this->chatId,
                'text'       => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Throwable $e) {
            Log::warning('Telegram notification failed: ' . $e->getMessage());
        }
    }

    private function fmt(int $cents): string
    {
        return number_format($cents / 100, 2);
    }
}
