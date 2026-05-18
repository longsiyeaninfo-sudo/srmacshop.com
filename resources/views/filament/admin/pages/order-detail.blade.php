<x-filament-panels::page>
    @push('styles')
        <style>
        .od-wrap{display:grid;grid-template-columns:1.7fr 1fr;gap:18px;align-items:start}
        @media(max-width:900px){.od-wrap{grid-template-columns:1fr}}
        .od-col{display:flex;flex-direction:column;gap:14px}
        .od-card{background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px}
        .dark .od-card{background:#1f2937;border-color:#374151}
        .od-card-title{font-size:14px;font-weight:700;color:#111827;margin:0 0 12px;display:flex;align-items:center;gap:6px}
        .dark .od-card-title{color:#f9fafb}
        .od-row{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;padding:8px 0;border-bottom:1px solid #f3f4f6;font-size:14px}
        .dark .od-row{border-color:#374151}
        .od-row:last-child{border:0}
        .od-row-label{font-size:12px;color:#6b7280;font-weight:500;text-transform:uppercase;letter-spacing:.04em}
        .dark .od-row-label{color:#9ca3af}
        .od-row-val{color:#111827;font-weight:600;text-align:right}
        .dark .od-row-val{color:#f9fafb}

        .od-head{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
        .od-h{font-size:22px;font-weight:800;color:#111827;margin:0}
        .dark .od-h{color:#f9fafb}
        .od-sub{font-size:13px;color:#6b7280}

        .od-badge{display:inline-block;padding:4px 12px;border-radius:980px;font-size:12px;font-weight:700}
        .od-badge.pending{background:#fef3c7;color:#92400e}
        .od-badge.confirmed{background:#dbeafe;color:#1e40af}
        .od-badge.delivered{background:#dcfce7;color:#166534}
        .od-badge.cancelled{background:#fee2e2;color:#991b1b}

        .od-items{display:flex;flex-direction:column;gap:10px}
        .od-item{display:grid;grid-template-columns:64px 1fr auto;gap:12px;align-items:center;padding:10px;border:1px solid #f3f4f6;border-radius:8px}
        .dark .od-item{border-color:#374151}
        .od-item-img{width:64px;height:64px;border-radius:8px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-size:28px;overflow:hidden}
        .dark .od-item-img{background:#111827}
        .od-item-img img{width:100%;height:100%;object-fit:cover;display:block}
        .od-item-name{font-size:14px;font-weight:700;color:#111827;margin:0 0 2px}
        .dark .od-item-name{color:#f9fafb}
        .od-item-meta{font-size:12px;color:#6b7280;margin:0}
        .od-item-price{font-size:14px;font-weight:700;color:#111827;text-align:right;white-space:nowrap}
        .dark .od-item-price{color:#f9fafb}
        .od-item-qty{font-size:11px;color:#6b7280;text-align:right;display:block;margin-top:2px}

        {{-- Sticky right column --}}
        .od-sticky{position:sticky;top:80px}

        .od-timeline{display:flex;flex-direction:column;gap:0;margin:0;padding:0;list-style:none}
        .od-tl-step{display:flex;align-items:flex-start;gap:12px;padding:8px 0;position:relative}
        .od-tl-step::before{content:'';position:absolute;left:14px;top:30px;bottom:-8px;width:2px;background:#e5e7eb}
        .od-tl-step:last-child::before{display:none}
        .od-tl-icon{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;z-index:1;border:2px solid #fff}
        .od-tl-step.done .od-tl-icon{background:#22c55e;color:#fff}
        .od-tl-step.current .od-tl-icon{background:#f97316;color:#fff;box-shadow:0 0 0 4px rgba(249,115,22,.2)}
        .od-tl-step.future .od-tl-icon{background:#e5e7eb;color:#9ca3af}
        .od-tl-step.cancelled .od-tl-icon,.od-tl-step.cancelled-final .od-tl-icon{background:#ef4444;color:#fff}
        .od-tl-label{font-size:13px;font-weight:600;color:#111827;padding-top:4px}
        .dark .od-tl-label{color:#f9fafb}
        .od-tl-step.future .od-tl-label{color:#9ca3af}

        .od-totals .od-row-val{font-size:14px}
        .od-totals .od-total .od-row-label{color:#111827;font-weight:700;font-size:14px;text-transform:none;letter-spacing:0}
        .dark .od-totals .od-total .od-row-label{color:#f9fafb}
        .od-totals .od-total .od-row-val{color:#f97316;font-size:18px;font-weight:800}

        .od-actions{display:flex;flex-direction:column;gap:8px}
        .od-btn{width:100%;padding:11px 14px;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:all .15s;text-decoration:none}
        .od-btn:disabled{opacity:.5;cursor:not-allowed}
        .od-btn-confirm{background:#22c55e;color:#fff}.od-btn-confirm:hover:not(:disabled){background:#16a34a}
        .od-btn-deliver{background:#3b82f6;color:#fff}.od-btn-deliver:hover:not(:disabled){background:#2563eb}
        .od-btn-cancel{background:#ef4444;color:#fff}.od-btn-cancel:hover:not(:disabled){background:#dc2626}
        .od-btn-invoice{background:#f97316;color:#fff}.od-btn-invoice:hover{background:#ea580c}
        .od-btn-back{background:transparent;border:1px solid #d1d5db;color:#374151}
        .dark .od-btn-back{border-color:#374151;color:#d1d5db}
        </style>
    @endpush

    @php
        $order = $this->record;
        $status = $order->status;
    @endphp

    <div style="margin-bottom:18px">
        <div class="od-head">
            <div>
                <h1 class="od-h">Order #{{ $order->order_number }}</h1>
                <div class="od-sub">Placed {{ $order->created_at?->format('M j, Y · g:i A') }}</div>
            </div>
            <span class="od-badge {{ $status->value }}">{{ $status->label() }}</span>
        </div>
    </div>

    <div class="od-wrap">
        {{-- LEFT: customer, items, notes --}}
        <div class="od-col">
            <div class="od-card">
                <h3 class="od-card-title">👤 Customer</h3>
                <div class="od-row">
                    <div class="od-row-label">Name</div>
                    <div class="od-row-val">{{ $order->customer_name }}</div>
                </div>
                <div class="od-row">
                    <div class="od-row-label">Phone</div>
                    <div class="od-row-val">
                        <a href="tel:{{ $order->customer_phone }}" style="color:#f97316;text-decoration:none">{{ $order->customer_phone }}</a>
                    </div>
                </div>
                <div class="od-row">
                    <div class="od-row-label">Address</div>
                    <div class="od-row-val" style="text-align:right;max-width:60%">{{ $order->customer_address }}</div>
                </div>
                @if($order->coupon_code)
                    <div class="od-row">
                        <div class="od-row-label">Coupon</div>
                        <div class="od-row-val">{{ $order->coupon_code }}</div>
                    </div>
                @endif
            </div>

            <div class="od-card">
                <h3 class="od-card-title">📦 Items ({{ $order->items->count() }})</h3>
                <div class="od-items">
                    @foreach($order->items as $item)
                        <div class="od-item">
                            <div class="od-item-img">
                                @php $img = $item->product?->getFirstMediaUrl('gallery'); @endphp
                                @if($img)
                                    <img src="{{ $img }}" alt="">
                                @else
                                    <span>{{ $item->product?->emoji ?? '💻' }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="od-item-name">{{ $item->product_name_snapshot }}</p>
                                @if($item->product_spec_snapshot)
                                    <p class="od-item-meta">{{ $item->product_spec_snapshot }}</p>
                                @endif
                            </div>
                            <div>
                                <div class="od-item-price">${{ number_format($item->line_total / 100, 2) }}</div>
                                <span class="od-item-qty">${{ number_format($item->unit_price / 100, 2) }} × {{ $item->quantity }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($order->notes)
                <div class="od-card">
                    <h3 class="od-card-title">📝 Notes</h3>
                    <p style="font-size:14px;color:#374151;line-height:1.6;margin:0;white-space:pre-wrap">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        {{-- RIGHT: timeline, totals, actions --}}
        <div class="od-col">
            <div class="od-sticky" style="display:flex;flex-direction:column;gap:14px">
                <div class="od-card">
                    <h3 class="od-card-title">📍 Status Timeline</h3>
                    <ul class="od-timeline">
                        @foreach($this->timeline as $step)
                            <li class="od-tl-step {{ $step['state'] }}">
                                <div class="od-tl-icon">{{ $step['icon'] }}</div>
                                <div class="od-tl-label">{{ $step['label'] }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="od-card od-totals">
                    <h3 class="od-card-title">💵 Payment</h3>
                    <div class="od-row">
                        <div class="od-row-label">Method</div>
                        <div class="od-row-val">{{ strtoupper($order->payment_method) }}</div>
                    </div>
                    <div class="od-row">
                        <div class="od-row-label">Subtotal</div>
                        <div class="od-row-val">${{ number_format($order->subtotal / 100, 2) }}</div>
                    </div>
                    @if($order->discount > 0)
                        <div class="od-row">
                            <div class="od-row-label">Discount</div>
                            <div class="od-row-val" style="color:#22c55e">−${{ number_format($order->discount / 100, 2) }}</div>
                        </div>
                    @endif
                    @if($order->tax > 0)
                        <div class="od-row">
                            <div class="od-row-label">Tax</div>
                            <div class="od-row-val">${{ number_format($order->tax / 100, 2) }}</div>
                        </div>
                    @endif
                    <div class="od-row od-total">
                        <div class="od-row-label">Total</div>
                        <div class="od-row-val">${{ number_format($order->total / 100, 2) }}</div>
                    </div>
                </div>

                <div class="od-card">
                    <h3 class="od-card-title">⚡ Actions</h3>
                    <div class="od-actions">
                        @if($status === \App\Enums\OrderStatus::Pending)
                            <button type="button" wire:click="confirm" class="od-btn od-btn-confirm">✓ Confirm Order</button>
                        @endif

                        @if($status === \App\Enums\OrderStatus::Confirmed)
                            <button type="button" wire:click="deliver" class="od-btn od-btn-deliver">🚚 Mark Delivered</button>
                        @endif

                        @if(in_array($status, [\App\Enums\OrderStatus::Pending, \App\Enums\OrderStatus::Confirmed], true))
                            <button type="button" wire:click="cancelOrder" wire:confirm="Cancel this order? This cannot be undone." class="od-btn od-btn-cancel">✕ Cancel Order</button>
                        @endif

                        <a href="{{ route('invoice', $order) }}" target="_blank" class="od-btn od-btn-invoice">🖨️ Print Invoice</a>

                        <a href="{{ \App\Filament\Admin\Resources\OrderResource::getUrl('index') }}" class="od-btn od-btn-back">← Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
