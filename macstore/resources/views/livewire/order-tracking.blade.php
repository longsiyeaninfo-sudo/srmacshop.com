<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('Track Order') }} #{{ $order->order_number }}</x-slot>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold mb-8">{{ __('Order Tracking') }}</h1>

            <!-- Order Info -->
            <x-card class="p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-text-secondary-light dark:text-text-secondary-dark mb-1">
                      {{ __('Order Number') }}
                </h3>
                      <p class="text-lg font-bold">{{ $order->order_number }}</p>
                    </div>

              <div>
                        <h3 class="text-sm font-medium text-text-secondary-light dark:text-text-secondary-dark mb-1">
                    {{ __('Order Date') }}
                  </h3>
                  <p class="text-lg">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>

                    @if($trackingInfo['tracking_number'])
                        <div>
                            <h3 class="text-sm font-medium text-text-secondary-light dark:text-text-secondary-dark mb-1">
                     {{ __('Tracking Number') }}
                            </h3>
               <p class="text-lg font-mono">{{ $trackingInfo['tracking_number'] }}</p>
                     </div>

                   <div>
                            <h3 class="text-sm font-medium text-text-secondary-light dark:text-text-secondary-dark mb-1">
                         {{ __('Carrier') }}
                    </h3>
                         <p class="text-lg uppercase">{{ $trackingInfo['carrier'] }}</p>
                        </div>
           @endif
             </div>

             @if($trackingInfo['tracking_url'])
                    <div class="mt-6">
                <x-button variant="primary" href="{{ $trackingInfo['tracking_url'] }}" target="_blank">
                    {{ __('Track on Carrier Website') }}
             </x-button>
                    </div>
                @endif
            </x-card>

            <!-- Status Timeline -->
            <x-card class="p-6 mb-8">
                <h2 class="text-xl font-bold mb-6">{{ __('Order Status') }}</h2>

                <div class="relative">
                    @foreach($statusHistory as $index => $history)
           <div class="flex gap-4 mb-6 last:mb-0">
                            <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                     {{ $index === count($statusHistory) - 1 ? 'bg-accent text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                           @if($history['status'] === 'delivered')
                                   <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                         </svg>
                         @else
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                               </svg>
                        @endif
                      </div>
                            @if($index < count($statusHistory) - 1)
                                  <div class="w-0.5 h-full bg-gray-200 dark:bg-gray-700 mt-2"></div>
                         @endif
                  </div>

                       <div class="flex-1 pb-6">
                    <h3 class="font-bold text-lg capitalize">{{ str_replace('_', ' ', $history['status']) }}</h3>
                <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                               {{ \Carbon\Carbon::parse($history['timestamp'])->format('M d, Y \a\t h:i A') }}
                          </p>
                     @if($history['note'])
                               <p class="text-sm mt-2">{{ $history['note'] }}</p>
                       @endif
                            </div>
                </div>
          @endforeach
                </div>
            </x-card>

            <!-- Order Items -->
       <x-card class="p-6">
           <h2 class="text-xl font-bold mb-6">{{ __('Order Items') }}</h2>

          <div class="space-y-4">
          @foreach($order->items as $item)
                      <div class="flex items-center gap-4 pb-4 border-b border-border-light dark:border-border-dark last:border-0">
                    @if($item->productVariant && $item->productVariant->product)
                             <img src="{{ $item->productVariant->product->getFirstMediaUrl('images') }}"
                           alt="{{ $item->product_name }}"
                                 class="w-20 h-20 object-cover rounded-button">
                         @else
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-button"></div>
                @endif

                  <div class="flex-1">
                           <h3 class="font-semibold">{{ $item->product_name }}</h3>
                 <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                    {{ __('Quantity') }}: {{ $item->quantity }}
                         </p>
              </div>

                        <div class="text-right">
                <p class="font-bold">${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                  </div>
                  @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-border-light dark:border-border-dark">
               <div class="flex justify-between text-lg font-bold">
                        <span>{{ __('Total') }}</span>
                     <span class="text-accent">${{ number_format($order->grand_total, 2) }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </x-layouts.storefront>
</div>
