<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('My Account') }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold mb-8">{{ __('My Account') }}</h1>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-card class="p-6">
                      <div class="space-y-2">
                   <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 rounded-button bg-accent text-white">
                           {{ __('Dashboard') }}
                         </a>
                 <a href="{{ route('account.orders') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
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
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <x-card class="p-6">
                          <div class="text-3xl font-bold text-accent mb-2">{{ $totalOrders }}</div>
                      <div class="text-sm text-text-secondary-light dark:text-text-secondary-dark">{{ __('Total Orders') }}</div>
                    </x-card>
                        <x-card class="p-6">
                   <div class="text-3xl font-bold text-accent mb-2">${{ number_format($totalSpent, 2) }}</div>
                     <div class="text-sm text-text-secondary-light dark:text-text-secondary-dark">{{ __('Total Spent') }}</div>
                     </x-card>
                        <x-card class="p-6">
                     <div class="text-3xl font-bold text-accent mb-2">{{ $user->wishlists->count() }}</div>
                      <div class="text-sm text-text-secondary-light dark:text-text-secondary-dark">{{ __('Wishlist Items') }}</div>
              </x-card>
                </div>

                    <!-- Recent Orders -->
                  <x-card class="p-6">
               <h2 class="text-2xl font-bold mb-6">{{ __('Recent Orders') }}</h2>

                @if($recentOrders->count() > 0)
                      <div class="space-y-4">
                     @foreach($recentOrders as $order)
                             <div class="flex justify-between items-center p-4 border border-border-light dark:border-border-dark rounded-button">
                                  <div>
                                         <div class="font-semibold">{{ $order->order_number }}</div>
                                  <div class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                                     {{ $order->created_at->format('M d, Y') }}
                                         </div>
                                   </div>
                          <div class="text-right">
                                <div class="font-semibold">${{ number_format($order->grand_total, 2) }}</div>
                            <div class="text-sm">
                                 <span class="px-2 py-1 rounded-full text-xs
                                  @if($order->status === 'delivered') bg-green/10 text-green
                                     @elseif($order->status === 'cancelled') bg-red/10 text-red
                                    @else bg-accent/10 text-accent
                                       @endif">
                                  {{ ucfirst($order->status) }}
                                         </span>
                               </div>
                       </div>
                    </div>
                     @endforeach
                   </div>

                 <div class="mt-6">
                    <x-button variant="ghost" href="{{ route('account.orders') }}" class="w-full">
                    {{ __('View All Orders') }}
                 </x-button>
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
