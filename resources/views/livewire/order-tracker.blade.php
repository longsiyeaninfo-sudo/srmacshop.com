<div>
<style>
.ot-wrap{max-width:580px;margin:0 auto;padding:2rem 1rem 4rem}
.ot-hero{text-align:center;margin-bottom:2.5rem}
.ot-hero h1{font-size:clamp(1.6rem,4vw,2.2rem);font-weight:800;margin-bottom:.5rem}
.ot-hero p{color:var(--text2);font-size:14px}
.ot-card{background:var(--card);border:1px solid var(--border2);border-radius:var(--r);padding:28px;box-shadow:var(--shadow)}
.ot-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px}
@media(max-width:480px){.ot-row{grid-template-columns:1fr}}
.ot-label{font-size:12px;font-weight:700;color:var(--text2);margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
.ot-inp{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:var(--rs);font-size:14px;background:var(--bg);color:var(--text);font-family:var(--font);transition:border-color .15s,box-shadow .15s;outline:none}
.ot-inp:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(0,122,255,.12)}
.ot-btn{width:100%;padding:13px;background:var(--blue);color:#fff;border:none;border-radius:var(--rs);font-size:15px;font-weight:700;cursor:pointer;font-family:var(--font);transition:all .15s;margin-top:4px}
.ot-btn:hover{background:var(--blue-h);transform:translateY(-1px)}
.ot-err{margin-top:16px;background:#FFF0F0;border:1px solid #FFD0D0;border-radius:var(--rs);padding:12px 16px;font-size:13px;color:var(--red);display:flex;align-items:center;gap:8px}
[data-theme="dark"] .ot-err{background:#2A0808;border-color:#5A1A1A}

/* Result card */
.ot-result{margin-top:24px}
.ot-num{font-size:13px;color:var(--text2);margin-bottom:4px}
.ot-order-id{font-size:20px;font-weight:800;letter-spacing:.5px;color:var(--blue)}
.ot-meta{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:16px 0}
@media(max-width:480px){.ot-meta{grid-template-columns:1fr}}
.ot-meta-item{background:var(--bg);border-radius:var(--rs);padding:12px 14px;border:1px solid var(--border2)}
.ot-meta-l{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:4px}
.ot-meta-v{font-size:13px;font-weight:600}

/* Timeline */
.ot-timeline{position:relative;padding-left:28px;margin:20px 0}
.ot-tl-line{position:absolute;left:9px;top:8px;bottom:8px;width:2px;background:var(--border2)}
.ot-step{position:relative;margin-bottom:18px;display:flex;align-items:flex-start;gap:12px}
.ot-step:last-child{margin-bottom:0}
.ot-dot{width:18px;height:18px;border-radius:50%;border:2px solid var(--border);background:var(--card);position:absolute;left:-28px;top:1px;display:flex;align-items:center;justify-content:center;font-size:9px;flex-shrink:0;z-index:1}
.ot-dot.done{background:var(--green);border-color:var(--green);color:#fff}
.ot-dot.active{background:var(--blue);border-color:var(--blue);color:#fff;box-shadow:0 0 0 4px rgba(0,122,255,.18)}
.ot-dot.cancelled{background:var(--red);border-color:var(--red);color:#fff}
.ot-step-info{}
.ot-step-title{font-size:13px;font-weight:700}
.ot-step-sub{font-size:11px;color:var(--text2);margin-top:2px}

/* Items */
.ot-items{border-top:1px solid var(--border2);margin-top:16px;padding-top:14px}
.ot-item{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid var(--border2);font-size:13px;gap:8px}
.ot-item:last-child{border-bottom:none}
.ot-item-name{font-weight:600;flex:1}
.ot-item-spec{color:var(--text2);font-size:11px}
.ot-totals{margin-top:12px;display:flex;flex-direction:column;gap:4px}
.ot-trow{display:flex;justify-content:space-between;font-size:13px;padding:3px 0}
.ot-trow-total{font-size:16px;font-weight:800;border-top:1px solid var(--border2);padding-top:10px;margin-top:4px}

/* WA CTA */
.ot-wa{display:flex;align-items:center;justify-content:center;gap:8px;background:#25D366;color:#fff;border-radius:var(--rs);padding:12px;font-size:13px;font-weight:700;text-decoration:none;margin-top:16px;transition:opacity .15s}
.ot-wa:hover{opacity:.88}
</style>

<div class="ot-wrap">
    <div class="ot-hero">
        <div style="font-size:36px;margin-bottom:8px">📦</div>
        <h1 data-en="Track Your Order" data-km="តាមដានការបញ្ជាទិញ">Track Your Order</h1>
        <p data-en="Enter your order number and phone number to check delivery status." data-km="បញ្ចូលលេខបញ្ជាទិញ និងលេខទូរស័ព្ទដើម្បីពិនិត្យស្ថានភាព">Enter your order number and phone number to check delivery status.</p>
    </div>

    <div class="ot-card">
        <div class="ot-row">
            <div>
                <div class="ot-label" data-en="Order Number" data-km="លេខបញ្ជាទិញ">Order Number</div>
                <input class="ot-inp" type="text" wire:model="orderNumber"
                    placeholder="SR-1001" style="text-transform:uppercase"
                    wire:keydown.enter="track">
            </div>
            <div>
                <div class="ot-label" data-en="Phone Number" data-km="លេខទូរស័ព្ទ">Phone Number</div>
                <input class="ot-inp" type="tel" wire:model="phone"
                    placeholder="+855 98 xxx xxx"
                    wire:keydown.enter="track">
            </div>
        </div>

        <button class="ot-btn" wire:click="track" wire:loading.attr="disabled" wire:target="track">
            <span wire:loading.remove wire:target="track">🔍 <span data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ">Track Order</span></span>
            <span wire:loading wire:target="track" style="display:inline-flex;align-items:center;gap:8px">
                <span class="ot-spinner"></span> <span data-en="Searching…" data-km="កំពុងស្វែងរក…">Searching…</span>
            </span>
        </button>

        <style>
            .ot-spinner{display:inline-block;width:14px;height:14px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:otSpin .7s linear infinite;vertical-align:-2px}
            @keyframes otSpin{to{transform:rotate(360deg)}}
        </style>

        @if($error)
            <div class="ot-err">⚠️ {{ $error }}</div>
        @endif
    </div>

    {{-- Result --}}
    @if($order)
    @php
        $statusSteps = [
            'pending'   => ['label' => 'Order Received',   'sub' => 'We got your order and are reviewing it.', 'emoji' => '📋'],
            'confirmed' => ['label' => 'Order Confirmed',  'sub' => 'Your order is confirmed and being prepared.', 'emoji' => '✅'],
            'delivered' => ['label' => 'Delivered',        'sub' => 'Your order has been delivered. Enjoy!', 'emoji' => '🎉'],
            'cancelled' => ['label' => 'Cancelled',        'sub' => 'This order was cancelled.', 'emoji' => '❌'],
        ];
        $currentStatus = $order->status->value ?? $order->status;
        $flow = ['pending', 'confirmed', 'delivered'];
        $isCancelled = $currentStatus === 'cancelled';
    @endphp

    <div class="ot-result">
        <div class="ot-card">
            <div class="ot-num" data-en="Order" data-km="ការបញ្ជាទិញ">Order</div>
            <div class="ot-order-id">{{ $order->order_number }}</div>

            <div class="ot-meta">
                <div class="ot-meta-item">
                    <div class="ot-meta-l" data-en="Customer" data-km="អតិថិជន">Customer</div>
                    <div class="ot-meta-v">{{ $order->customer_name }}</div>
                </div>
                <div class="ot-meta-item">
                    <div class="ot-meta-l" data-en="Payment" data-km="ការទូទាត់">Payment</div>
                    <div class="ot-meta-v" style="text-transform:capitalize">{{ $order->payment_method }}</div>
                </div>
                <div class="ot-meta-item" style="grid-column:1/-1">
                    <div class="ot-meta-l" data-en="Delivery Address" data-km="អាសយដ្ឋាន">Delivery Address</div>
                    <div class="ot-meta-v">{{ $order->customer_address }}</div>
                </div>
            </div>

            {{-- Timeline --}}
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:10px">
                Status Timeline
            </div>
            <div class="ot-timeline">
                <div class="ot-tl-line"></div>
                @if($isCancelled)
                    <div class="ot-step">
                        <div class="ot-dot done">✓</div>
                        <div class="ot-step-info">
                            <div class="ot-step-title">📋 Order Received</div>
                        </div>
                    </div>
                    <div class="ot-step">
                        <div class="ot-dot cancelled">✕</div>
                        <div class="ot-step-info">
                            <div class="ot-step-title" style="color:var(--red)">❌ Cancelled</div>
                            <div class="ot-step-sub">This order was cancelled. Contact us for help.</div>
                        </div>
                    </div>
                @else
                    @foreach($flow as $step)
                        @php
                            $stepOrder = array_search($step, $flow);
                            $currentOrder = array_search($currentStatus, $flow);
                            $isDone = $stepOrder < $currentOrder;
                            $isActive = $step === $currentStatus;
                            $dotClass = $isDone ? 'done' : ($isActive ? 'active' : '');
                            $info = $statusSteps[$step];
                        @endphp
                        <div class="ot-step">
                            <div class="ot-dot {{ $dotClass }}">
                                @if($isDone) ✓
                                @elseif($isActive) ●
                                @else &nbsp;
                                @endif
                            </div>
                            <div class="ot-step-info">
                                <div class="ot-step-title" style="{{ $isActive ? 'color:var(--blue)' : ($isDone ? '' : 'color:var(--text3)') }}">
                                    {{ $info['emoji'] }} {{ $info['label'] }}
                                    @if($isActive) <span style="background:var(--blue-l);color:var(--blue);font-size:10px;padding:2px 7px;border-radius:980px;margin-left:4px">Now</span>@endif
                                </div>
                                @if($isActive || $isDone)
                                    <div class="ot-step-sub">{{ $info['sub'] }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Items --}}
            <div class="ot-items">
                @foreach($order->items as $item)
                    <div class="ot-item">
                        <div>
                            <div class="ot-item-name">{{ $item->product_name_snapshot }}</div>
                            <div class="ot-item-spec">{{ $item->product_spec_snapshot }} × {{ $item->quantity }}</div>
                        </div>
                        <div style="font-weight:700;white-space:nowrap">${{ number_format($item->line_total / 100, 2) }}</div>
                    </div>
                @endforeach
            </div>

            <div class="ot-totals">
                <div class="ot-trow">
                    <span style="color:var(--text2)">Subtotal</span>
                    <span>${{ number_format($order->subtotal / 100, 2) }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="ot-trow" style="color:var(--green)">
                        <span>Discount</span>
                        <span>-${{ number_format($order->discount / 100, 2) }}</span>
                    </div>
                @endif
                @if($order->tax > 0)
                    <div class="ot-trow">
                        <span style="color:var(--text2)">Tax</span>
                        <span>${{ number_format($order->tax / 100, 2) }}</span>
                    </div>
                @endif
                @if(($order->delivery_fee ?? 0) > 0)
                    <div class="ot-trow">
                        <span style="color:var(--text2)">Delivery</span>
                        <span>${{ number_format($order->delivery_fee / 100, 2) }}</span>
                    </div>
                @endif
                <div class="ot-trow ot-trow-total">
                    <span>Total</span>
                    <span>${{ number_format($order->total / 100, 2) }}</span>
                </div>
            </div>

            <a href="https://wa.me/85598334755?text={{ urlencode('Hi SR MAC SHOP! I have a question about order ' . $order->order_number) }}"
               class="ot-wa" target="_blank">
                💬 <span data-en="Chat with us on WhatsApp" data-km="ជជែកជាមួយយើងនៅ WhatsApp">Chat with us on WhatsApp</span>
            </a>
        </div>
    </div>
    @endif
</div>
</div>
