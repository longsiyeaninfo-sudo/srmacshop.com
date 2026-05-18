@extends('layouts.storefront')

@section('title', 'Order Placed! — SR MAC SHOP')

@section('content')
<section class="shop-section" style="background:var(--bg);padding-top:4rem">
    <div class="inner" style="max-width:560px;text-align:center">
        <div class="success-modal">
            <span class="success-icon">🎉</span>
            <div class="success-title" data-en="Order Placed!" data-km="បញ្ជាទិញជោគជ័យ!">Order Placed!</div>
            <div class="success-sub" data-en="Thank you! We'll contact you shortly to confirm delivery." data-km="អរគុណ! យើងនឹងទំនាក់ទំនងអ្នកក្នុងពេលឆាប់ៗ។">
                Thank you! We'll contact you shortly to confirm delivery.
            </div>
            <div class="order-id-pill">{{ $order->order_number }}</div>

            <div style="background:var(--card);border-radius:var(--r);padding:20px;margin:20px 0;text-align:left;border:1px solid var(--border2)">
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border2);font-size:13px">
                    <span style="color:var(--text2)">Customer</span>
                    <span style="font-weight:600">{{ $order->customer_name }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border2);font-size:13px">
                    <span style="color:var(--text2)">Phone</span>
                    <span style="font-weight:600">{{ $order->customer_phone }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border2);font-size:13px">
                    <span style="color:var(--text2)">Payment</span>
                    <span style="font-weight:600;text-transform:capitalize">{{ $order->payment_method }}</span>
                </div>
                @foreach($order->items as $item)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border2);font-size:13px">
                        <span style="color:var(--text2)">{{ $item->product_name_snapshot }} × {{ $item->quantity }}</span>
                        <span style="font-weight:600">${{ number_format($item->line_total / 100, 2) }}</span>
                    </div>
                @endforeach
                @if($order->discount > 0)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border2);font-size:13px;color:var(--green)">
                        <span>Discount</span>
                        <span style="font-weight:600">-${{ number_format($order->discount / 100, 2) }}</span>
                    </div>
                @endif
                <div style="display:flex;justify-content:space-between;padding:12px 0 0;font-size:17px;font-weight:800">
                    <span>Total</span>
                    <span>${{ number_format($order->total / 100, 2) }}</span>
                </div>
            </div>

            <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('home') }}" class="btn btn-blue" data-en="Continue Shopping" data-km="ទិញបន្ត">Continue Shopping</a>
                <a href="{{ route('invoice', $order) }}" target="_blank" class="btn" style="background:var(--bg3);color:var(--text)">🧾 Print Invoice</a>
            </div>

            <p style="margin-top:1.5rem;font-size:13px;color:var(--text2)">
                Questions?
                <a href="https://wa.me/85598334755" style="color:var(--blue);font-weight:600">WhatsApp us</a>
                or
                <a href="https://t.me/srmacshop" style="color:var(--blue);font-weight:600">Telegram</a>
            </p>
        </div>
    </div>
</section>
@endsection
