<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('Products') }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-4xl font-bold mb-2">{{ __('Shop MacBooks') }}</h1>
                <p class="text-text-secondary-light dark:text-text-secondary-dark">
                    {{ __('Find your perfect MacBook') }}
                </p>
          </div>

            <div class="flex flex-col lg:flex-row gap-8">
        <aside class="lg:w-64 flex-shrink-0">
                <x-card class="p-6 sticky top-20">
                     <h2 class="font-semibold text-lg mb-4">{{ __('Filters') }}</h2>

            <div class="mb-6">
               <label class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                      <x-input
                        type="text"
                      wire:model.live.debounce.300ms="search"
                          placeholder="{{ __('Search products...') }}"
                     />
           </div>

                  <div class="mb-6">
                          <label class="block text-sm font-medium mb-2">{{ __('Category') }}</label>
                  <x-select wire:model.live="categoryFilter">
                          <option value="">{{ __('All Categories') }}</option>
                             @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                           @endforeach
                 </x-select>
                </div>

                      <div class="mb-6">
                         <label class="block text-sm font-medium mb-2">{{ __('Condition') }}</label>
                          <x-select wire:model.live="conditionFilter">
                         <option value="">{{ __('All Conditions') }}</option>
                       <option value="new">{{ __('New') }}</option>
                      <option value="refurbished">{{ __('Refurbished') }}</option>
                         <option value="used">{{ __('Used') }}</option>
                          </x-select>
                   </div>

                        <x-button variant="ghost" wire:click="clearFilters" class="w-full">
                 {{ __('Clear Filters') }}
                   </x-button>
                    </x-card>
                </aside>

              <div class="flex-1">
                    <div class="flex justify-between items-center mb-6">
                    <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                       {{ $products->total() }} {{ __('products found') }}
                    </p>
                     <x-select wire:model.live="sortBy" class="w-48">
                <option value="latest">{{ __('Latest') }}</option>
                <option value="price_low">{{ __('Price: Low to High') }}</option>
                     <option value="price_high">{{ __('Price: High to Low') }}</option>
                          <option value="name">{{ __('Name: A-Z') }}</option>
                      </x-select>
                </div>

             @if($products->count() > 0)
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              @foreach($products as $product)
                     <x-product-card :product="$product" />
                        @endforeach
               </div>
                     <div class="mt-8">
                      {{ $products->links() }}
                     </div>
               @else
              <x-card class="p-12 text-center">
                            <h3 class="text-lg font-semibold mb-2">{{ __('No products found') }}</h3>
                       <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">
                        {{ __('Try adjusting your filters') }}
                         </p>
                        <x-button variant="ghost" wire:click="clearFilters">
                           {{ __('Clear Filters') }}
                       </x-button>
                     </x-card>
               @endif
            </div>
            </div>
        </div>
    </x-layouts.storefront>
</div>
