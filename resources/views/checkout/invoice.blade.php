<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_number }} — SR MAC SHOP</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; background: #f5f5f5; color: #000; }
        .inv-wrapper { max-width: 820px; margin: 0 auto; padding: 20px; }
        .inv-toolbar { background: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .inv-toolbar-title { font-size: 14px; font-weight: 700; color: #333; }
        .inv-toolbar-btns { display: flex; gap: 8px; }
        .inv-tbtn { padding: 7px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; font-family: Arial, sans-serif; transition: all .15s; }
        .inv-print { background: #0071E3; color: #fff; }
        .inv-print:hover { background: #0077ED; }
        .inv-close-btn { background: #f0f0f0; color: #333; }
        .inv-close-btn:hover { background: #e0e0e0; }
        .inv-paper { background: #fff; padding: 32px 36px; color: #000; font-family: 'Arial', sans-serif; font-size: 12px; line-height: 1.5; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,.1); }
        .inv-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #2563EB; }
        .inv-logo-wrap { display: flex; align-items: center; gap: 12px; }
        .inv-logo-icon { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; flex-shrink: 0; display: block; }
        .inv-shop-name { font-size: 18px; font-weight: 900; color: #1a3a8f; letter-spacing: .5px; }
        .inv-shop-sub { font-size: 10px; color: #666; margin-top: 2px; }
        .inv-shop-addr { font-size: 10px; color: #444; margin-top: 4px; line-height: 1.5; }
        .inv-header-right { text-align: right; }
        .inv-doc-title { font-size: 22px; font-weight: 900; color: #2563EB; letter-spacing: 1px; margin-bottom: 6px; }
        .inv-meta-table td { font-size: 11px; padding: 1px 6px 1px 0; color: #333; }
        .inv-meta-table td:first-child { color: #888; white-space: nowrap; }
        .inv-meta-table td:last-child { font-weight: 700; }
        .inv-parties { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 16px 0; padding: 12px 0; border-top: 1px solid #e8e8e8; border-bottom: 1px solid #e8e8e8; }
        .inv-party-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 6px; }
        .inv-party-name { font-size: 14px; font-weight: 800; color: #1a3a8f; margin-bottom: 3px; }
        .inv-party-detail { font-size: 11px; color: #555; line-height: 1.6; }
        .inv-items-table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 11px; }
        .inv-items-table thead tr { background: #2563EB; color: #fff; }
        .inv-items-table thead th { padding: 8px 10px; text-align: left; font-weight: 700; font-size: 11px; }
        .inv-items-table thead th:last-child, .inv-items-table thead th:nth-last-child(2) { text-align: right; }
        .inv-items-table tbody tr { border-bottom: 1px solid #f0f0f0; }
        .inv-items-table tbody tr:nth-child(even) { background: #f8f9ff; }
        .inv-items-table tbody td { padding: 9px 10px; vertical-align: top; }
        .inv-items-table tbody td:last-child, .inv-items-table tbody td:nth-last-child(2) { text-align: right; }
        .inv-summary { display: flex; justify-content: flex-end; margin-bottom: 16px; }
        .inv-summary-box { min-width: 240px; }
        .inv-sum-row { display: flex; justify-content: space-between; font-size: 12px; padding: 4px 0; border-bottom: 1px solid #f0f0f0; }
        .inv-sum-row:last-child { border-bottom: 2px solid #2563EB; padding-top: 8px; font-size: 15px; font-weight: 900; color: #1a3a8f; }
        .inv-payment { background: #f0f7ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 16px; margin: 12px 0; font-size: 11px; }
        .inv-payment-title { font-weight: 700; color: #1a3a8f; margin-bottom: 6px; font-size: 12px; }
        .inv-warranty { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 8px 12px; font-size: 11px; color: #15803d; margin-bottom: 12px; }
        .inv-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 28px; padding-top: 16px; border-top: 1px solid #e0e0e0; }
        .inv-sig-box { text-align: center; }
        .inv-sig-name { font-size: 13px; font-weight: 800; color: #333; margin-bottom: 40px; }
        .inv-sig-line { border-top: 1px solid #333; padding-top: 6px; font-size: 11px; color: #666; }
        .inv-footer { text-align: center; margin-top: 16px; padding-top: 12px; border-top: 1px dashed #e0e0e0; font-size: 10px; color: #999; }
        @media print {
            body { background: #fff; }
            .inv-wrapper { padding: 0; }
            .inv-toolbar { display: none !important; }
            .inv-paper { box-shadow: none; border-radius: 0; padding: 20px 24px; }
        }
    </style>
</head>
<body>
<div class="inv-wrapper">
    <div class="inv-toolbar">
        <div class="inv-toolbar-title">📄 Invoice {{ $order->order_number }}</div>
        <div class="inv-toolbar-btns">
            <button class="inv-tbtn inv-print" onclick="window.print()">🖨 Print</button>
            <button class="inv-tbtn inv-close-btn" onclick="window.close()">✕ Close</button>
        </div>
    </div>

    @php
        $invInfo    = \App\Models\Setting::get('store.info', []) ?: [];
        $invBrand   = \App\Models\Setting::get('site.branding', []) ?: [];
        $invName    = $invInfo['name']    ?? (($invBrand['logo_prefix'] ?? 'SR') . ' ' . ($invBrand['logo_text'] ?? 'MAC SHOP'));
        $invPhone   = $invInfo['phone']   ?? '+855 98 33 47 55';
        $invAddress = $invInfo['address'] ?? 'Sangkat Kambol, Khan Kambol, Phnom Penh';
        $invTagline = $invInfo['tagline'] ?? "Cambodia's #1 Apple Specialist";
        $invLogoUrl = \App\Models\Setting::logoUrl();
    @endphp
    <div class="inv-paper">
        {{-- Header --}}
        <div class="inv-header">
            <div class="inv-logo-wrap">
                <img src="{{ $invLogoUrl }}" alt="{{ $invName }}" class="inv-logo-icon">
                <div>
                    <div class="inv-shop-name">{{ $invName }}</div>
                    <div class="inv-shop-sub">{{ $invTagline }}</div>
                    <div class="inv-shop-addr">
                        {{ $invAddress }}<br>
                        Tel: {{ $invPhone }} · www.srmacshop.com
                    </div>
                </div>
            </div>
            <div class="inv-header-right">
                <div class="inv-doc-title">INVOICE</div>
                <table class="inv-meta-table">
                    <tr><td>Invoice #</td><td>{{ $order->order_number }}</td></tr>
                    <tr><td>Date</td><td>{{ $order->created_at->format('d M Y') }}</td></tr>
                    <tr><td>Time</td><td>{{ $order->created_at->format('H:i') }}</td></tr>
                    <tr><td>Payment</td><td style="text-transform:capitalize">{{ $order->payment_method }}</td></tr>
                    <tr><td>Status</td><td>{{ ucfirst($order->status->value ?? $order->status) }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Parties --}}
        <div class="inv-parties">
            <div>
                <div class="inv-party-label">From</div>
                <div class="inv-party-name">{{ $invName }}</div>
                <div class="inv-party-detail">
                    {{ $invAddress }}<br>
                    {{ $invPhone }}
                </div>
            </div>
            <div>
                <div class="inv-party-label">Bill To</div>
                <div class="inv-party-name">{{ $order->customer_name }}</div>
                <div class="inv-party-detail">
                    {{ $order->customer_phone }}<br>
                    {{ $order->customer_address }}
                </div>
            </div>
        </div>

        {{-- Items --}}
        <table class="inv-items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Specifications</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Unit Price</th>
                    <th style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="font-weight:700">{{ $item->product_name_snapshot }}</td>
                        <td style="color:#666">{{ $item->product_spec_snapshot }}</td>
                        <td style="text-align:right">{{ $item->quantity }}</td>
                        <td style="text-align:right">${{ number_format($item->unit_price / 100, 2) }}</td>
                        <td style="text-align:right;font-weight:700">${{ number_format($item->line_total / 100, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary --}}
        <div class="inv-summary">
            <div class="inv-summary-box">
                <div class="inv-sum-row"><span>Subtotal</span><span>${{ number_format($order->subtotal / 100, 2) }}</span></div>
                @if($order->discount > 0)
                    <div class="inv-sum-row" style="color:#16a34a"><span>Discount ({{ $order->coupon_code }})</span><span>-${{ number_format($order->discount / 100, 2) }}</span></div>
                @endif
                <div class="inv-sum-row"><span>Tax (10%)</span><span>${{ number_format($order->tax / 100, 2) }}</span></div>
                <div class="inv-sum-row"><span>TOTAL</span><span>${{ number_format($order->total / 100, 2) }}</span></div>
            </div>
        </div>

        {{-- Payment info --}}
        <div class="inv-payment">
            <div class="inv-payment-title">Payment Information</div>
            <p>Method: <strong style="text-transform:capitalize">{{ $order->payment_method }}</strong> &nbsp;|&nbsp;
            Amount Paid: <strong>${{ number_format($order->total / 100, 2) }}</strong></p>
        </div>

        {{-- Warranty --}}
        <div class="inv-warranty">
            ✓ All products sold by {{ $invName }} come with official Apple warranty. Keep this invoice for warranty claims.
        </div>

        {{-- Signatures --}}
        <div class="inv-signatures">
            <div class="inv-sig-box">
                <div class="inv-sig-name">{{ $invName }}</div>
                <div class="inv-sig-line">Authorized Signature</div>
            </div>
            <div class="inv-sig-box">
                <div class="inv-sig-name">{{ $order->customer_name }}</div>
                <div class="inv-sig-line">Customer Signature</div>
            </div>
        </div>

        <div class="inv-footer">
            Thank you for shopping with {{ $invName }} · www.srmacshop.com · {{ $invPhone }}<br>
            This is a computer-generated invoice. Valid without signature.
        </div>
    </div>
</div>
</body>
</html>
