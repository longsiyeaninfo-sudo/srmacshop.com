<div>
    {{-- TODO Phase 4 (post-prototype): port #cartOverlay markup --}}
    @if($isOpen)
    <div role="dialog" aria-modal="true" aria-label="Cart"
       style="position:fixed;inset:0;z-index:60;background:rgba(0,0,0,.4);display:flex;justify-content:flex-end"
         wire:click="close">
        <aside style="width:min(420px,100%);background:#fff;height:100%;overflow-y:auto;padding:24px"
            wire:click.stop>
          <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
              <h2 style="margin:0">{{ __('Your Cart') }}</h2>
              <button wire:click="close" style="border:none;background:transparent;font-size:24px;cursor:pointer">×</button>
            </header>

    @if($items->isEmpty())
            <p>{{ __('Your cart is empty.') }}</p>
          @else
              @foreach($items as $item)
          <div style="display:flex;gap:12px;align-items:center;padding:12px 0;border-bottom:1px solid #eee">
                  <div style="font-size:32px">{{ $item['product']->emoji ?: '💻' }}</div>
                    <div style="flex:1">
                  <div style="font-weight:600">{{ $item['product']->name }}</div>
                       <div style="color:#666;font-size:13px">{{ $item['product']->spec }}</div>
                      <div style="display:flex;gap:8px;align-items:center;margin-top:6px">
                             <button wire:click="changeQty({{ $item['product']->id }}, -1)" style="padding:2px 8px">−</button>
                         <span>{{ $item['quantity'] }}</span>
                           <button wire:click="changeQty({{ $item['product']->id }}, 1)" style="padding:2px 8px">+</button>
                           <button wire:click="removeItem({{ $item['product']->id }})" style="margin-left:auto;color:#FF3B30;border:none;background:transparent;cursor:pointer">{{ __('Remove') }}</button>
                </div>
                 </div>
                <div>${{ number_format($item['line_total'] / 100, 0) }}</div>
                </div>
                @endforeach

       <div style="margin-top:16px">
             <label style="display:flex;gap:8px">
              <input type="text" wire:model="couponCode" placeholder="{{ __('Coupon code') }}"
              style="flex:1;padding:8px;border:1px solid #ddd;border-radius:10px">
                <button wire:click="applyCoupon" style="padding:8px 12px">{{ __('Apply') }}</button>
                  </label>
                 @if($couponStatus)
                 <div style="margin-top:6px;font-size:13px;color:#666">{{ $couponStatus }}</div>
                @endif
              </div>

              <div style="margin-top:16px">
                    <strong>{{ __('Payment') }}:</strong>
            @foreach(['cash' => __('Cash'), 'card' => __('Card'), 'qr' => __('QR'), 'aba' => __('ABA')] as $value => $label)
          <label style="display:inline-flex;align-items:center;gap:6px;margin-right:12px">
                <input type="radio" name="pay" value="{{ $value }}"
                                wire:click="selectPayment('{{ $value }}')"
                         @checked($paymentMethod === $value)>
                      {{ $label }}
                        </label>
                @endforeach
                </div>

           <dl style="margin-top:20px">
                <div style="display:flex;justify-content:space-between"><dt>{{ __('Subtotal') }}</dt><dd>${{ number_format($subtotal/100, 2) }}</dd></div>
                 <div style="display:flex;justify-content:space-between;color:#34c759"><dt>{{ __('Discount') }}</dt><dd>-${{ number_format($discount/100, 2) }}</dd></div>
                    <div style="display:flex;justify-content:space-between"><dt>{{ __('Tax') }}</dt><dd>${{ number_format($tax/100, 2) }}</dd></div>
            <div style="display:flex;justify-content:space-between;font-weight:700;font-size:18px;margin-top:8px"><dt>{{ __('Total') }}</dt><dd>${{ number_format($total/100, 2) }}</dd></div>
                </dl>

         <form method="POST" action="{{ route('checkout.process') }}" style="margin-top:16px">
                @csrf
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
           <input type="text" name="customer_name" placeholder="{{ __('Full name') }}" required
                  style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;margin-bottom:8px">
                    <input type="text" name="customer_phone" placeholder="{{ __('Phone') }}" required
                 style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;margin-bottom:8px">
                    <textarea name="customer_address" placeholder="{{ __('Delivery address') }}" required rows="3"
                       style="width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;margin-bottom:8px"></textarea>
                    <button type="submit"
                      style="width:100%;padding:12px;background:#007AFF;color:#fff;border:none;border-radius:14px;font-weight:600;cursor:pointer">
                    {{ __('Place Order') }}
              </button>
                </form>
        @endif
        </aside>
    </div>
    @endif
</div>
