<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('My Orders') }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold mb-8">{{ __('My Orders') }}</h1>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                 <x-card class="p-6">
                  <div class="space-y-2">
                   <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
                      {{ __('Dashboard') }}
                      </a>
                 <a href="{{ route('account.orders') }}" class="block px-4 py-2 rounded-button bg-accent text-white">
                     {{ __('Orders') }}
                      </a>
                       <a href="{{ route('account.addresses') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
                  {{ __('Addresses') }}
                        </a>
                            <a href="{{ route('account.wishlist') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
               {{ __('Wishlist') }}
                      </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
                   {{ __('Profile') }}
                     </a>
                      <form method="POST" action="{{ route('logout') }}">
                  @csrf
                     <button type="submit" class="w-full text-left px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800 text-red">
                               {{ __('Logout') }}
                       </button>
                            </form>
                 </div>
            </x-card>
                </div>

                 <!-- Main Content -->
                <div class="lg:col-span-3">
                  <x-card class="p-6">
                  @if($orders->count() > 0)
                        <div class="space-y-6">
                       @foreach($orders as $order)
                                  <div class="border border-border-light dark:border-border-dark rounded-button p-6">
                                      <div class="flex justify-between items-start mb-4">
                            <div>
                                    <h3 class="text-xl font-bold">{{ $order->order_number }}</h3>
                                <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                                         {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                                    </p>
                   </div>
                                          <div class="text-right">
                                   <div class="text-2xl font-bold text-accent">${{ number_format($order->grand_total, 2) }}</div>
                       <span class="inline-block px-3 py-1 rounded-full text-sm mt-2
                                         @if($order->status === 'delivered') bg-green/10 text-green
                   @elseif($order->status === 'cancelled') bg-red/10 text-red
                                             @else bg-accent/10 text-accent
                                       @endif">
                                     {{ ucfirst($order->status) }}
                                           </span>
                          </div>
                       </div>

                         <div class="space-y-3">
                                    @foreach($order->items as $item)
                                       <div class="flex items-center gap-4">
                                  @if($item->product && $item->product->getFirstMediaUrl('images'))
                               <img src="{{ $item->product->getFirstMediaUrl('images') }}"
                                                   alt="{{ $item->product_name }}"
                                         class="w-16 h-16 object-cover rounded-button">
                                @else
                                              <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-button"></div>
                                   @endif
                            <div class="flex-1">
                                      <h4 class="font-semibold">{{ $item->product_name }}</h4>
                                               <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                                               {{ __('Quantity') }}: {{ $item->quantity }}
                           </p>
                                 </div>
                                              <div class="text-right">
                                             <div class="font-semibold">${{ number_format($item->unit_price, 2) }}</div>
                                         </div>
                           </div>
                                  @endforeach
                         </div>

                            <div class="mt-4 pt-4 border-t border-border-light dark:border-border-dark">
                                   <div class="flex justify-between text-sm">
                                      <span>{{ __('Subtotal') }}</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                           </div>
                                   @if($order->discount > 0)
                          <div class="flex justify-between text-sm text-green">
                                    <span>{{ __('Discount') }}</span>
                                 <span>-${{ number_format($order->discount, 2) }}</span>
                                             </div>
                   @endif
                            <div class="flex justify-between text-sm">
                                          <span>{{ __('Tax') }}</span>
                               <span>${{ number_format($order->tax, 2) }}</span>
                            </div>
                              <div class="flex justify-between text-sm">
                      <span>{{ __('Shipping') }}</span>
                                 <span>${{ number_format($order->shipping_cost, 2) }}</span>
                                  </div>
                            </div>
                           </div>
                             @endforeach
                          </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                 </div>
                 @else
                 <div class="text-center py-12">
                            <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">
                           {{ __('No orders yet') }}
                           </p>
                         <x-button variant="primary" href="{{ route('products.index') }}">
                           {{ __('Start Shopping') }}
                      </x-button>
                      </div>
                 @endif
               </x-card>
                </div>
            </div>
     </div>
    </x-layouts.storefront>
</div>
