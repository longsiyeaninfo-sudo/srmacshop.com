<div>
    {{-- Cart Overlay --}}
    <div class="cart-overlay {{ $isOpen ? 'on' : '' }}"
        x-data
        @keydown.escape.window="$wire.close()">

        <div class="cart-backdrop" wire:click="close"></div>

        <div class="cart-drawer">
            {{-- Header --}}
            <div class="cart-hd">
                <div class="cart-hd-title" data-en="🛒 Your Cart" data-km="🛒 កន្ត្រករបស់អ្នក">🛒 Your Cart</div>
                <button class="cart-close" wire:click="close" type="button">✕</button>
            </div>

            {{-- Items --}}
            <div class="cart-body">
                @if($items->isEmpty())
                    <div class="cart-empty">
                        <span>🛒</span>
                        <p data-en="Your cart is empty" data-km="កន្ត្រករបស់អ្នកទទេ">Your cart is empty</p>
                    </div>
                @else
                    @foreach($items as $item)
                        @php $product = $item['product']; @endphp
                        <div class="citem">
                            <div class="citem-em">
                                @php $img = $product->getFirstMediaUrl('gallery'); @endphp
                                @if($img)
                                    <img src="{{ $img }}" style="width:36px;height:36px;object-fit:cover;border-radius:4px" alt="">
                                @else
                                    {{ $product->emoji ?: '💻' }}
                                @endif
                            </div>
                            <div class="citem-inf">
                                <div class="citem-name">{{ $product->name }}</div>
                                <div class="citem-pr">{{ $product->spec }}</div>
                                <div class="citem-ctrl">
                                    <button class="qbtn" wire:click="changeQty({{ $product->id }}, -1)" type="button">−</button>
                                    <span class="qnum">{{ $item['quantity'] }}</span>
                                    <button class="qbtn" wire:click="changeQty({{ $product->id }}, 1)" type="button">+</button>
                                    <button class="qbtn" wire:click="removeItem({{ $product->id }})" type="button"
                                        style="margin-left:4px;color:var(--red);border-color:var(--red)">🗑</button>
                                </div>
                            </div>
                            <div class="citem-tot">${{ number_format($item['line_total'] / 100, 2) }}</div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Coupon --}}
            <div class="coupon-row">
                <input class="coupon-inp" type="text" wire:model="couponCode"
                    placeholder="Coupon code..." data-en="Coupon code..." data-km="លេខកូដប្រូម៉ូសិន...">
                <button class="coupon-apply" wire:click="applyCoupon" wire:loading.attr="disabled" wire:target="applyCoupon" type="button">
                    <span wire:loading.remove wire:target="applyCoupon" data-en="Apply" data-km="អនុវត្ត">Apply</span>
                    <span wire:loading wire:target="applyCoupon" data-en="…" data-km="…">…</span>
                </button>
            </div>
            @if($couponStatus)
                <div class="coupon-status {{ str_contains($couponStatus, 'applied') ? 'cs-ok' : 'cs-err' }}">
                    {{ $couponStatus }}
                </div>
            @endif

            {{-- Footer --}}
            <div class="cart-ft">
                {{-- Delivery location toggle --}}
                @if(!$items->isEmpty())
                <div style="display:flex;gap:6px;margin-bottom:10px">
                    <button type="button"
                        wire:click="setLocation(false)"
                        style="flex:1;padding:7px 0;font-size:12px;font-weight:600;border-radius:8px;border:1.5px solid {{ !$isProvince ? 'var(--blue)' : 'var(--border2)' }};background:{{ !$isProvince ? 'var(--blue-l)' : 'var(--card)' }};color:{{ !$isProvince ? 'var(--blue)' : 'var(--text2)' }};cursor:pointer;transition:all .15s">
                        🏙 Phnom Penh
                    </button>
                    <button type="button"
                        wire:click="setLocation(true)"
                        style="flex:1;padding:7px 0;font-size:12px;font-weight:600;border-radius:8px;border:1.5px solid {{ $isProvince ? 'var(--blue)' : 'var(--border2)' }};background:{{ $isProvince ? 'var(--blue-l)' : 'var(--card)' }};color:{{ $isProvince ? 'var(--blue)' : 'var(--text2)' }};cursor:pointer;transition:all .15s">
                        🗺 Province
                    </button>
                </div>
                @endif

                <div class="cft-row">
                    <span data-en="Subtotal" data-km="សរុបរង">Subtotal</span>
                    <span>${{ number_format($subtotal / 100, 2) }}</span>
                </div>
                @if($discount > 0)
                    <div class="cft-row cft-disc">
                        <span data-en="Discount" data-km="បញ្ចុះតម្លៃ">Discount</span>
                        <span>-${{ number_format($discount / 100, 2) }}</span>
                    </div>
                @endif
                @if($taxEnabled && $tax > 0)
                    <div class="cft-row">
                        <span data-en="Tax ({{ $taxPercent }}%)" data-km="ពន្ធ ({{ $taxPercent }}%)">Tax ({{ $taxPercent }}%)</span>
                        <span>${{ number_format($tax / 100, 2) }}</span>
                    </div>
                @endif
                @if(!$items->isEmpty())
                    <div class="cft-row">
                        <span data-en="Delivery" data-km="ដឹកជញ្ជូន">Delivery</span>
                        @if($deliveryFee === 0)
                            <span style="color:var(--green);font-weight:700" data-en="FREE" data-km="ឥតគិតថ្លៃ">FREE</span>
                        @else
                            <span>${{ number_format($deliveryFee / 100, 2) }}</span>
                        @endif
                    </div>
                @endif
                <div class="cft-total">
                    <span data-en="Total" data-km="សរុប">Total</span>
                    <span>${{ number_format($total / 100, 2) }}</span>
                </div>

                {{-- Payment methods --}}
                <div class="pay-meths">
                    @if($cashEnabled)
                    <div class="pme {{ $paymentMethod === 'cash' ? 'sel' : '' }}" wire:click="selectPayment('cash')">
                        💵 <span data-en="Cash" data-km="សាច់ប្រាក់">Cash</span>
                    </div>
                    @endif
                    @if($abaEnabled)
                    <div class="pme {{ $paymentMethod === 'aba' ? 'sel' : '' }}" wire:click="selectPayment('aba')">
                        🏦 ABA
                    </div>
                    <div class="pme {{ $paymentMethod === 'qr' ? 'sel' : '' }}" wire:click="selectPayment('qr')">
                        📱 KHQR
                    </div>
                    @endif
                    @if($cardEnabled)
                    <div class="pme {{ $paymentMethod === 'card' ? 'sel' : '' }}" wire:click="selectPayment('card')">
                        💳 Card
                    </div>
                    @endif
                </div>

                @if($paymentMethod === 'qr' && $abaEnabled)
                    <div style="background:var(--blue-l);border:1px solid var(--border2);border-radius:var(--rs);padding:10px;margin-bottom:8px;text-align:center;font-size:11px;color:var(--text2)">
                        @if($abaQrUrl)
                            <img src="{{ $abaQrUrl }}" alt="KHQR" style="max-width:140px;margin:0 auto 6px;display:block;border-radius:6px">
                        @endif
                        📱 <strong style="color:var(--blue)">Scan KHQR to pay</strong><br>
                        ABA · WING · ACLEDA · Any Cambodian bank<br>
                        <span style="font-size:10px">Show payment screenshot when ordering</span>
                    </div>
                @endif
                @if($paymentMethod === 'aba' && $abaEnabled)
                    <div style="background:#E3F5E9;border:1px solid #bbf7d0;border-radius:var(--rs);padding:10px;margin-bottom:8px;font-size:11px;color:#15803d">
                        🏦 <strong>ABA Bank Transfer</strong><br>
                        Account: <strong>{{ $abaNumber }}</strong> · {{ $abaName }}<br>
                        <span style="font-size:10px">Show transfer receipt when ordering</span>
                    </div>
                @endif

                @if(!$items->isEmpty())
                    <button class="checkout-btn" type="button"
                        onclick="window.dispatchEvent(new CustomEvent('checkout-open', {detail: {method: '{{ $paymentMethod }}'}}))"
                        data-en="Place Order →" data-km="ដាក់ការបញ្ជាទិញ →">Place Order →</button>
                @else
                    <button class="checkout-btn" type="button" disabled
                        data-en="Place Order →" data-km="ដាក់ការបញ្ជាទិញ →">Place Order →</button>
                @endif
            </div>
        </div>
    </div>

    {{-- Checkout Modal --}}
    <div x-data="{ open: false, method: 'cash' }"
         x-on:checkout-open.window="open = true; method = $event.detail.method"
         x-on:keydown.escape.window="open = false"
         x-show="open" x-cloak
         class="overlay" style="z-index:600">
        <div class="modal" @click.stop style="max-width:500px">
            <div class="modal-head">
                <div class="modal-title" data-en="Complete Your Order" data-km="បញ្ចប់ការបញ្ជាទិញ">Complete Your Order</div>
                <button class="modal-x" type="button" @click="open = false">✕</button>
            </div>
            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf
                <input type="hidden" name="payment_method" :value="method">
                <div class="form-group">
                    <label class="form-label" data-en="Full Name" data-km="ឈ្មោះពេញ">Full Name</label>
                    <input class="form-inp" type="text" name="customer_name" required placeholder="Sophal Keo">
                </div>
                <div class="form-group">
                    <label class="form-label" data-en="Phone Number" data-km="លេខទូរស័ព្ទ">Phone Number</label>
                    <input class="form-inp" type="tel" name="customer_phone" required placeholder="+855 98 xxx xxx">
                </div>
                <div class="form-group">
                    <label class="form-label" data-en="Delivery Address" data-km="អាសយដ្ឋានដឹកជញ្ជូន">Delivery Address</label>
                    <textarea class="form-inp" name="customer_address" rows="2" required
                        placeholder="Street 271, Toul Kork, Phnom Penh"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" data-en="Notes (optional)" data-km="កំណត់ចំណាំ">Notes (optional)</label>
                    <textarea class="form-inp" name="notes" rows="2"
                        placeholder="Any special instructions..."></textarea>
                </div>
                <button type="submit" class="btn btn-blue" style="width:100%;justify-content:center;padding:14px;margin-top:4px"
                    data-en="Confirm Order →" data-km="បញ្ជាក់ការបញ្ជាទិញ →">Confirm Order →</button>
            </form>
        </div>
    </div>
</div>
