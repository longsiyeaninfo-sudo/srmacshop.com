@extends('layouts.storefront')

@section('title', __('Order Placed') . ' — SR MAC SHOP')

@section('content')
    <section style="max-width:720px;margin:0 auto;padding:48px 16px;text-align:center">
        <div style="font-size:64px">✅</div>
        <h1>{{ __('Thank you for your order!') }}</h1>
        <p>{{ __('Your order number is') }}: <strong>{{ $order->order_number }}</strong></p>
        <p>{{ __('Total') }}: <strong>${{ number_format($order->total / 100, 2) }}</strong></p>

      <div style="margin-top:24px">
         <a href="{{ route('invoice', $order) }}" target="_blank"
        style="display:inline-block;padding:12px 24px;background:#007AFF;color:#fff;border-radius:14px;text-decoration:none">
        {{ __('Print Invoice') }}
            </a>
            <a href="{{ route('home') }}" style="display:inline-block;padding:12px 24px;margin-left:8px">
                {{ __('Continue Shopping') }}
        </a>
        </div>
    </section>
@endsection
