<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family:sans-serif;color:#111">
    <h2>{{ __('Order Confirmation') }} — {{ $order->order_number }}</h2>
    <p>{{ __('Thank you for your order') }}, {{ $order->customer_name }}.</p>
    <p><strong>{{ __('Total') }}:</strong> ${{ number_format($order->total / 100, 2) }}</p>
    <p>{{ __('We will contact you on') }} {{ $order->customer_phone }} {{ __('shortly to confirm delivery.') }}</p>
</body>
</html>
