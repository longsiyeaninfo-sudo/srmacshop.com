@extends('layouts.storefront')

@section('title', 'Order Placed! — SR MAC SHOP')

@section('content')
<style>
.suc-wrap{max-width:920px;margin:0 auto;padding:var(--space-12) var(--space-6) var(--space-16)}
.suc-hero{text-align:center;margin-bottom:var(--space-8)}
.suc-check{width:88px;height:88px;border-radius:50%;background:rgba(52,199,89,.12);display:flex;align-items:center;justify-content:center;margin:0 auto var(--space-5)}
.suc-check svg{width:48px;height:48px}
.suc-check circle{stroke:#34c759;stroke-width:3;stroke-dasharray:170;stroke-dashoffset:170;animation:sucDrawCircle 600ms .15s ease-out forwards;fill:none}
.suc-check path{stroke:#34c759;stroke-width:4;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:48;stroke-dashoffset:48;animation:sucDrawCheck 400ms 650ms cubic-bezier(.65,0,.45,1) forwards;fill:none}
@keyframes sucDrawCircle{to{stroke-dashoffset:0}}
@keyframes sucDrawCheck{to{stroke-dashoffset:0}}
.suc-h{font-size:clamp(1.8rem,4vw,2.4rem);font-weight:700;letter-spacing:-.025em;margin-bottom:var(--space-2)}
.suc-sub{font-size:15px;color:var(--text2);max-width:480px;margin:0 auto var(--space-5)}
.suc-pill{display:inline-flex;align-items:center;gap:8px;background:var(--card);border:1px solid var(--hairline);border-radius:var(--radius-pill);padding:8px 18px;font-size:13px;font-weight:600;color:var(--text2);box-shadow:var(--shadow-sm)}
.suc-pill strong{color:var(--text);letter-spacing:.5px}

/* 2-column order summary */
.suc-grid{display:grid;grid-template-columns:1.4fr 1fr;gap:var(--space-5);margin-top:var(--space-8)}
@media(max-width:720px){.suc-grid{grid-template-columns:1fr}}
.suc-card{background:var(--card);border:1px solid var(--hairline);border-radius:var(--radius-lg);padding:var(--space-5);box-shadow:var(--shadow-sm)}
.suc-card-title{font-size:11px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.5px;margin-bottom:var(--space-4)}

.suc-item{display:flex;justify-content:space-between;align-items:flex-start;padding:var(--space-3) 0;border-bottom:1px solid var(--hairline);gap:var(--space-3)}
.suc-item:last-child{border-bottom:none}
.suc-item-name{font-size:14px;font-weight:600}
.suc-item-meta{font-size:12px;color:var(--text2);margin-top:2px}
.suc-item-price{font-size:14px;font-weight:600;white-space:nowrap;font-variant-numeric:tabular-nums}

.suc-detail{display:flex;justify-content:space-between;padding:var(--space-2) 0;font-size:13px;border-bottom:1px solid var(--hairline)}
.suc-detail:last-child{border-bottom:none}
.suc-detail-l{color:var(--text2)}
.suc-detail-v{font-weight:500;text-align:right;max-width:55%;word-break:break-word}

.suc-total{display:flex;justify-content:space-between;padding:var(--space-3) 0 0;font-size:18px;font-weight:700;border-top:1px solid var(--hairline);margin-top:var(--space-3);letter-spacing:-.02em;font-variant-numeric:tabular-nums}
.suc-actions{display:flex;gap:var(--space-2);justify-content:center;flex-wrap:wrap;margin-top:var(--space-8)}
.suc-tip{margin-top:var(--space-5);font-size:13px;color:var(--text2);text-align:center}
.suc-tip a{color:var(--blue);font-weight:600;text-decoration:none}
.suc-tip a:hover{text-decoration:underline}
</style>

<div class="suc-wrap">
    <div class="suc-hero">
        <div class="suc-check">
            <svg viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                <circle cx="30" cy="30" r="27"/>
                <path d="M18 30 L26 38 L42 22"/>
            </svg>
        </div>
        <h1 class="suc-h" data-en="Order placed" data-km="ការបញ្ជាទិញត្រូវបានដាក់">Order placed</h1>
        <p class="suc-sub" data-en="Thank you! We'll contact you shortly to confirm delivery." data-km="អរគុណ! យើងនឹងទំនាក់ទំនងអ្នកក្នុងពេលឆាប់ៗ ដើម្បីបញ្ជាក់ការដឹកជញ្ជូន។">
            Thank you! We'll contact you shortly to confirm delivery.
        </p>
        <span class="suc-pill">
            <span data-en="Order" data-km="ការបញ្ជាទិញ">Order</span>
            <strong>{{ $order->order_number }}</strong>
        </span>
    </div>

    <div class="suc-grid">
        {{-- Items column --}}
        <div class="suc-card">
            <div class="suc-card-title" data-en="Items" data-km="ផលិតផល">Items</div>
            @foreach($order->items as $item)
                <div class="suc-item">
                    <div>
                        <div class="suc-item-name">{{ $item->product_name_snapshot }}</div>
                        <div class="suc-item-meta">{{ $item->product_spec_snapshot ?: '—' }} · ×{{ $item->quantity }}</div>
                    </div>
                    <div class="suc-item-price">${{ number_format($item->line_total / 100, 2) }}</div>
                </div>
            @endforeach
        </div>

        {{-- Summary column --}}
        <div class="suc-card">
            <div class="suc-card-title" data-en="Customer" data-km="អតិថិជន">Customer</div>
            <div class="suc-detail">
                <span class="suc-detail-l" data-en="Name" data-km="ឈ្មោះ">Name</span>
                <span class="suc-detail-v">{{ $order->customer_name }}</span>
            </div>
            <div class="suc-detail">
                <span class="suc-detail-l" data-en="Phone" data-km="ទូរស័ព្ទ">Phone</span>
                <span class="suc-detail-v">{{ $order->customer_phone }}</span>
            </div>
            <div class="suc-detail">
                <span class="suc-detail-l" data-en="Address" data-km="អាសយដ្ឋាន">Address</span>
                <span class="suc-detail-v">{{ $order->customer_address }}</span>
            </div>
            <div class="suc-detail">
                <span class="suc-detail-l" data-en="Payment" data-km="ការទូទាត់">Payment</span>
                <span class="suc-detail-v" style="text-transform:capitalize">{{ $order->payment_method }}</span>
            </div>

            <div class="suc-card-title" style="margin-top:var(--space-5);margin-bottom:var(--space-3)" data-en="Totals" data-km="សរុប">Totals</div>
            <div class="suc-detail">
                <span class="suc-detail-l">Subtotal</span>
                <span class="suc-detail-v">${{ number_format($order->subtotal / 100, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="suc-detail" style="color:var(--green)">
                    <span>Discount</span>
                    <span class="suc-detail-v">-${{ number_format($order->discount / 100, 2) }}</span>
                </div>
            @endif
            @if($order->tax > 0)
                <div class="suc-detail">
                    <span class="suc-detail-l">Tax</span>
                    <span class="suc-detail-v">${{ number_format($order->tax / 100, 2) }}</span>
                </div>
            @endif
            @if(($order->delivery_fee ?? 0) > 0)
                <div class="suc-detail">
                    <span class="suc-detail-l">Delivery</span>
                    <span class="suc-detail-v">${{ number_format($order->delivery_fee / 100, 2) }}</span>
                </div>
            @endif
            <div class="suc-total">
                <span>Total</span>
                <span>${{ number_format($order->total / 100, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="suc-actions">
        <a href="{{ route('home') }}" class="btn btn-blue" data-en="Continue shopping" data-km="ទិញបន្ត">Continue shopping</a>
        <a href="{{ route('track-order') }}?order={{ $order->order_number }}" class="btn" style="background:var(--bg3);color:var(--text)">📦 <span data-en="Track order" data-km="តាមដាន">Track order</span></a>
        <a href="{{ route('invoice', $order) }}" target="_blank" class="btn" style="background:var(--bg3);color:var(--text)">🧾 <span data-en="Print invoice" data-km="បោះពុម្ពវិក្កយបត្រ">Print invoice</span></a>
    </div>

    <p class="suc-tip">
        <span data-en="Questions?" data-km="មានសំណួរ?">Questions?</span>
        <a href="https://wa.me/85598334755" target="_blank" rel="noopener">WhatsApp us</a>
        <span data-en="or" data-km="ឬ">or</span>
        <a href="https://t.me/srmacshop" target="_blank" rel="noopener">Telegram</a>
    </p>
</div>
@endsection
