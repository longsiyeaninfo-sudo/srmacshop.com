<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('Shopping Cart') }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold mb-8">{{ __('Shopping Cart') }}</h1>

            @if(session()->has('success'))
              <div class="p-4 bg-green/10 text-green rounded-card mb-6">
                {{ session('success') }}
                </div>
            @endif

        @if(session()->has('error'))
                <div class="p-4 bg-red/10 text-red rounded-card mb-6">
                  {{ session('error') }}
             </div>
         @endif

            @if($cart->items->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                 <div class="lg:col-span-2 space-y-4">
              @foreach($cart->items as $item)
           <x-card class="p-6">
                     <div class="flex gap-6">
                               <!-- Product Image -->
                             <div class="w-24 h-24 flex-shrink-0 bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                                @if($item->productVariant->product->hasMedia('images'))
                                    <img src="{{ $item->productVariant->product->getFirstMediaUrl('images') }}"
                                 alt="{{ $item->productVariant->product->name }}"
                                               class="w-full h-full object-cover">
                             @else
                     <svg class="w-full h-full text-gray-300 dark:text-gray-700 p-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
                                        </svg>
                           @endif
                          </div>

                      <!-- Product Info -->
                      <div class="flex-1">
                               <h3 class="font-semibold text-lg mb-1">
                                    <a href="{{ route('products.show', $item->productVariant->product->slug) }}" class="hover:text-accent">
                           {{ $item->productVariant->product->name }}
                               </a>
                                  </h3>
                           <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mb-2">
                             {{ $item->productVariant->ram }} / {{ $item->productVariant->storage }}
                                    @if($item->productVariant->color)
                           / {{ $item->productVariant->color }}
                           @endif
                             </p>
                         <p class="font-semibold text-accent">
                                   ${{ number_format($item->price_at_add, 2) }}
                            </p>
                    </div>

                       <!-- Quantity & Remove -->
                               <div class="flex flex-col items-end justify-between">
                          <button
                          wire:click="removeItem({{ $item->id }})"
                               class="text-text-secondary-light dark:text-text-secondary-dark hover:text-red transition-colors"
                              >
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                             </svg>
                                  </button>

                                   <div class="flex items-center gap-2">
                               <button
                       wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                      class="w-8 h-8 flex items-center justify-center rounded-button border border-border-light dark:border-border-dark hover:border-accent transition-colors"
                                    >
                                  -
                                     </button>
                                   <span class="w-12 text-center font-medium">{{ $item->quantity }}</span>
                            <button
                                        wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                 class="w-8 h-8 flex items-center justify-center rounded-button border border-border-light dark:border-border-dark hover:border-accent transition-colors"
                                  >
                                      +
                       </button>
                             </div>

                                     <p class="font-semibold">
                                  ${{ number_format($item->lineTotal, 2) }}
                               </p>
                                 </div>
                        </div>
                </x-card>
                     @endforeach
                    </div>

              <!-- Order Summary -->
            <div class="lg:col-span-1">
                    <x-card class="p-6 sticky top-20">
                       <h2 class="font-semibold text-lg mb-6">{{ __('Order Summary') }}</h2>

                       <div class="space-y-3 mb-6">
                         <div class="flex justify-between">
                                    <span class="text-text-secondary-light dark:text-text-secondary-dark">{{ __('Subtotal') }}</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                         </div>
                       <div class="flex justify-between">
                          <span class="text-text-secondary-light dark:text-text-secondary-dark">{{ __('Shipping') }}</span>
                              <span class="font-medium">{{ __('Calculated at checkout') }}</span>
                           </div>
                          <div class="flex justify-between">
                      <span class="text-text-secondary-light dark:text-text-secondary-dark">{{ __('Tax') }}</span>
                             <span class="font-medium">{{ __('Calculated at checkout') }}</span>
                     </div>
                        <div class="pt-3 border-t border-border-light dark:border-border-dark">
               <div class="flex justify-between text-lg font-semibold">
                     <span>{{ __('Total') }}</span>
                                  <span class="text-accent">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                   </div>

                     <x-button variant="primary" href="/checkout" class="w-full mb-3">
                            {{ __('Proceed to Checkout') }}
                      </x-button>

                     <x-button variant="ghost" href="{{ route('products.index') }}" class="w-full">
                            {{ __('Continue Shopping') }}
                       </x-button>
                        </x-card>
                    </div>
              </div>
            @else
                <x-card class="p-12 text-center">
                    <svg class="w-24 h-24 mx-auto mb-6 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
            <h2 class="text-2xl font-bold mb-2">{{ __('Your cart is empty') }}</h2>
                    <p class="text-text-secondary-light dark:text-text-secondary-dark mb-6">
                      {{ __('Add some MacBooks to get started!') }}
                  </p>
                <x-button variant="primary" href="{{ route('products.index') }}">
                        {{ __('Shop MacBooks') }}
             </x-button>
             </x-card>
            @endif
     </div>
    </x-layouts.storefront>
</div>
