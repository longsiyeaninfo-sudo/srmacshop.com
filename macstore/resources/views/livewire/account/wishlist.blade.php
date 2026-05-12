<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('My Wishlist') }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <h1 class="text-4xl font-bold mb-8">{{ __('My Wishlist') }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                 <x-card class="p-6">
                        <div class="space-y-2">
                        <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
                   {{ __('Dashboard') }}
                 </a>
                <a href="{{ route('account.orders') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
          {{ __('Orders') }}
                       </a>
                        <a href="{{ route('account.addresses') }}" class="block px-4 py-2 rounded-button hover:bg-gray-100 dark:hover:bg-gray-800">
                        {{ __('Addresses') }}
                       </a>
                            <a href="{{ route('account.wishlist') }}" class="block px-4 py-2 rounded-button bg-accent text-white">
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
                        @if(session('success'))
                <div class="mb-6 p-4 bg-green/10 text-green rounded-button">
                             {{ session('success') }}
                          </div>
                      @endif

                        @if($wishlists->count() > 0)
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                      @foreach($wishlists as $wishlist)
                                    <div class="border border-border-light dark:border-border-dark rounded-button overflow-hidden">
                               @if($wishlist->product)
                                   <a href="{{ route('products.show', $wishlist->product->slug) }}">
                          @if($wishlist->product->getFirstMediaUrl('images'))
                                 <img src="{{ $wishlist->product->getFirstMediaUrl('images') }}"
                                     alt="{{ $wishlist->product->name }}"
                                  class="w-full h-48 object-cover">
                    @else
                               <div class="w-full h-48 bg-gray-200 dark:bg-gray-700"></div>
                                        @endif
                                 </a>

                                 <div class="p-4">
                                 <h3 class="font-bold text-lg mb-2">
                                           <a href="{{ route('products.show', $wishlist->product->slug) }}" class="hover:text-accent">
                         {{ $wishlist->product->name }}
                                   </a>
                     </h3>

                                           <div class="text-2xl font-bold text-accent mb-4">
                                ${{ number_format($wishlist->product->price, 2) }}
                               </div>

                             <div class="flex gap-2">
                                          <x-button
                                       variant="primary"
                        wire:click="addToCart({{ $wishlist->product->id }})"
                                 class="flex-1">
                        {{ __('Add to Cart') }}
                            </x-button>

                      <x-button
                                          variant="ghost"
                                         wire:click="removeFromWishlist({{ $wishlist->product->id }})"
                     class="px-4">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </x-button>
                             </div>
                        </div>
                                @endif
              </div>
                            @endforeach
                 </div>
                     @else
                            <div class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-text-secondary-light dark:text-text-secondary-dark mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
               <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">
                        {{ __('Your wishlist is empty') }}
                       </p>
                       <x-button variant="primary" href="{{ route('products.index') }}">
                            {{ __('Browse Products') }}
                          </x-button>
              </div>
                        @endif
               </x-card>
         </div>
            </div>
        </div>
    </x-layouts.storefront>
</div>
