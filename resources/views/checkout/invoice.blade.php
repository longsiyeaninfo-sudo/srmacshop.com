<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #111; font-size: 12px; }
        h1 { margin: 0; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #111; padding-bottom: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
      th, td { padding: 8px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #fafafa; }
   .totals td { border: none; }
        .totals .grand { font-weight: 700; font-size: 16px; border-top: 2px solid #111; }
    </style>
</head>
<body>
    {{-- TODO Phase 4 (post-prototype): match the prototype's invoice-modal styling --}}
    <div class="header">
      <div>
            <h1>SR MAC SHOP</h1>
            <div>{{ \App\Models\Setting::get('shop_address') }}</div>
            <div>{{ \App\Models\Setting::get('shop_phone') }}</div>
    </div>
        <div style="text-align:right">
          <h2>{{ __('INVOICE') }}</h2>
            <div>#{{ $order->order_number }}</div>
            <div>{{ $order->created_at->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    <div>
      <strong>{{ __('Bill to') }}:</strong><br>
        {{ $order->customer_name }}<br>
      {{ $order->customer_phone }}<br>
      {{ $order->customer_address }}
    </div>

    <table>
        <thead>
            <tr>
        <th>{{ __('Item') }}</th>
                <th>{{ __('Qty') }}</th>
            <th>{{ __('Price') }}</th>
                <th>{{ __('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
           <td>
        {{ $item->product_name_snapshot }}<br>
              <small style="color:#666">{{ $item->product_spec_snapshot }}</small>
                </td>
              <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price / 100, 2) }}</td>
              <td>${{ number_format($item->line_total / 100, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals" style="margin-top:16px">
        <tr><td>{{ __('Subtotal') }}</td><td style="text-align:right">${{ number_format($order->subtotal/100, 2) }}</td></tr>
        @if($order->discount > 0)
        <tr><td>{{ __('Discount') }} ({{ $order->coupon_code }})</td><td style="text-align:right">-${{ number_format($order->discount/100, 2) }}</td></tr>
      @endif
        <tr><td>{{ __('Tax') }}</td><td style="text-align:right">${{ number_format($order->tax/100, 2) }}</td></tr>
        <tr class="grand"><td>{{ __('Total') }}</td><td style="text-align:right">${{ number_format($order->total/100, 2) }}</td></tr>
    </table>

    <p style="margin-top:24px;color:#666">{{ __('Thank you for shopping with SR MAC SHOP.') }}</p>
</body>
</html>
