<x-mail::message>
# Your Order Has Shipped!

Hello {{ $order->user->name }},

Great news! Your order has been shipped and is on its way to you.

## Order Details

**Order Number:** {{ $order->order_number }}
**Shipped Date:** {{ now()->format('F d, Y') }}
@if($trackingNumber)
**Tracking Number:** {{ $trackingNumber }}
@endif

<x-mail::table>
| Product | Quantity |
|:--------|:------:|
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} |
@endforeach
</x-mail::table>

## Shipping Address

{{ $order->shipping_address_line1 }}
@if($order->shipping_address_line2)
{{ $order->shipping_address_line2 }}
@endif
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
{{ $order->shipping_country }}

<x-mail::button :url="route('account.orders')">
Track Your Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
