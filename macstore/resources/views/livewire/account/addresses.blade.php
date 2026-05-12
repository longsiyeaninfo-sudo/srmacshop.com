<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('My Addresses') }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold mb-8">{{ __('My Addresses') }}</h1>

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
                          <a href="{{ route('account.addresses') }}" class="block px-4 py-2 rounded-button bg-accent text-white">
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
                    <div class="flex justify-between items-center mb-6">
                   <h2 class="text-2xl font-bold">{{ __('Saved Addresses') }}</h2>
                  <x-button variant="primary" wire:click="openModal">
                  {{ __('Add New Address') }}
                    </x-button>
                  </div>

                @if(session('success'))
                   <div class="mb-6 p-4 bg-green/10 text-green rounded-button">
                      {{ session('success') }}
               </div>
                    @endif

             <x-card class="p-6">
                     @if($addresses->count() > 0)
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($addresses as $address)
                               <div class="border border-border-light dark:border-border-dark rounded-button p-6">
                                 @if($address->is_default)
                               <span class="inline-block px-2 py-1 bg-accent/10 text-accent text-xs rounded-full mb-3">
                                        {{ __('Default') }}
                                     </span>
                            @endif

                                 <h3 class="font-bold text-lg mb-2">{{ $address->label }}</h3>
                         <p class="text-text-secondary-light dark:text-text-secondary-dark">
                                {{ $address->address_line1 }}<br>
                           @if($address->address_line2)
                              {{ $address->address_line2 }}<br>
                                @endif
                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                            {{ $address->country }}
                         </p>

                          @if($address->phone)
                                    <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-2">
                                 {{ __('Phone') }}: {{ $address->phone }}
                             </p>
                               @endif

                             <div class="flex gap-2 mt-4">
                                       <x-button variant="ghost" wire:click="editAddress({{ $address->id }})" class="flex-1">
                                 {{ __('Edit') }}
                                   </x-button>
                                    @if(!$address->is_default)
                                         <x-button variant="ghost" wire:click="setDefault({{ $address->id }})" class="flex-1">
                               {{ __('Set Default') }}
                                      </x-button>
                            @endif
                                     <x-button
                                        variant="ghost"
                                      wire:click="deleteAddress({{ $address->id }})"
                                  wire:confirm="{{ __('Are you sure?') }}"
                                 class="px-4 text-red">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                           </svg>
                             </x-button>
                             </div>
                      </div>
                        @endforeach
                     </div>
                   @else
                     <div class="text-center py-12">
                     <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">
              {{ __('No addresses saved yet') }}
                         </p>
                </div>
                     @endif
                </x-card>

             <!-- Address Modal -->
                    @if($showModal)
               <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click="closeModal">
                 <div class="bg-white dark:bg-gray-800 rounded-button p-8 max-w-2xl w-full mx-4" wire:click.stop>
                   <h3 class="text-2xl font-bold mb-6">
                      {{ $editingId ? __('Edit Address') : __('Add New Address') }}
                           </h3>

                     <form wire:submit="saveAddress" class="space-y-4">
                         <div>
                              <x-input
                                          wire:model="label"
                                          label="{{ __('Label') }}"
                                      placeholder="{{ __('Home') }}"
                     required
                        />
                       @error('label') <span class="text-red text-sm">{{ $message }}</span> @enderror
                     </div>

                               <div>
                           <x-input
                   wire:model="address_line1"
                                label="{{ __('Address Line 1') }}"
                                      required
                            />
                           @error('address_line1') <span class="text-red text-sm">{{ $message }}</span> @enderror
                                 </div>

                          <div>
                         <x-input
                                         wire:model="address_line2"
                      label="{{ __('Address Line 2') }}"
                       />
                            </div>

                              <div class="grid grid-cols-2 gap-4">
                             <div>
                           <x-input wire:model="city" label="{{ __('City') }}" required />
                           @error('city') <span class="text-red text-sm">{{ $message }}</span> @enderror
                              </div>
                       <div>
                                 <x-input wire:model="state" label="{{ __('State') }}" required />
                                    @error('state') <span class="text-red text-sm">{{ $message }}</span> @enderror
                                 </div>
                                 </div>

                           <div class="grid grid-cols-2 gap-4">
                             <div>
                         <x-input wire:model="postal_code" label="{{ __('Postal Code') }}" required />
                           @error('postal_code') <span class="text-red text-sm">{{ $message }}</span> @enderror
                          </div>
                              <div>
                              <x-input wire:model="country" label="{{ __('Country') }}" required />
                      @error('country') <span class="text-red text-sm">{{ $message }}</span> @enderror
                                    </div>
                     </div>

                          <div>
                    <x-input wire:model="phone" label="{{ __('Phone') }}" type="tel" />
                               </div>

                                    <div class="flex items-center gap-2">
                              <input type="checkbox" wire:model="is_default" id="is_default" class="rounded">
                               <label for="is_default">{{ __('Set as default') }}</label>
                              </div>

                           <div class="flex gap-4 pt-4">
                         <x-button type="submit" variant="primary" class="flex-1">
                                   {{ $editingId ? __('Update') : __('Add') }}
                          </x-button>
                    <x-button type="button" variant="ghost" wire:click="closeModal" class="flex-1">
                       {{ __('Cancel') }}
                                  </x-button>
                            </div>
                                </form>
                        </div>
                </div>
                  @endif
                </div>
            </div>
        </div>
    </x-layouts.storefront>
</div>
