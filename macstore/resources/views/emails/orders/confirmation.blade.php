<x-mail::message>
# Order Confirmation

Hello {{ $order->user->name }},

Thank you for your order! We've received your order and will process it shortly.

## Order Details

**Order Number:** {{ $order->order_number }}
**Order Date:** {{ $order->created_at->format('F d, Y') }}

<x-mail::table>
| Product | Quantity | Price |
|:--------|:--------:|------:|
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | ${{ number_format($item->unit_price, 2) }} |
@endforeach
</x-mail::table>

**Subtotal:** ${{ number_format($order->subtotal, 2) }}
@if($order->discount > 0)
**Discount:** -${{ number_format($order->discount, 2) }}
@endif
**Tax:** ${{ number_format($order->tax, 2) }}
**Shipping:** ${{ number_format($order->shipping_cost, 2) }}
**Total:** ${{ number_format($order->grand_total, 2) }}

## Shipping Address

{{ $order->shipping_address_line1 }}
@if($order->shipping_address_line2)
{{ $order->shipping_address_line2 }}
@endif
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
{{ $order->shipping_country }}

<x-mail::button :url="route('account.orders')">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
