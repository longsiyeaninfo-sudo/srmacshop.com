<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ $product->name }}</x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <a href="/" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
         <a href="/products" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('Products') }}</a>
              <span class="mx-2">/</span>
            <span>{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
              <!-- Product Images -->
              <div>
              @if($product->getFirstMediaUrl('images'))
                     <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full rounded-card shadow-hover">
                  @else
                   <div class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-card flex items-center justify-center">
        <svg class="w-32 h-32 text-gray-300 dark:text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
                      </svg>
                      </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                 <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>

                    @if($product->condition === 'refurbished')
                     <span class="inline-block px-3 py-1 bg-green/10 text-green rounded-full text-sm mb-4">
                         {{ __('Refurbished') }}
           </span>
                    @endif

                 <p class="text-text-secondary-light dark:text-text-secondary-dark mb-6">
                        {{ $product->short_description }}
                    </p>

                  <!-- Price -->
             <div class="mb-8">
               <div class="flex items-baseline gap-3">
                     <span class="text-4xl font-bold text-accent">${{ number_format($this->finalPrice, 2) }}</span>
             @if($product->sale_price && $product->sale_price < $product->base_price)
                          <span class="text-xl text-text-secondary-light dark:text-text-secondary-dark line-through">
                          ${{ number_format($product->base_price, 2) }}
            </span>
                       @endif
                   </div>
                  </div>

             <!-- Variants -->
                    @if($product->variants->count() > 0)
                     <div class="mb-8">
                  <h3 class="font-semibold mb-4">{{ __('Configuration') }}</h3>
                 <div class="grid grid-cols-2 gap-3">
                       @foreach($product->variants as $variant)
                           <button
                wire:click="$set('selectedVariantId', {{ $variant->id }})"
                                 class="p-4 rounded-button border-2 transition-all
                                    {{ $selectedVariantId == $variant->id
                           ? 'border-accent bg-accent/5'
                      : 'border-border-light dark:border-border-dark hover:border-accent/50'
                                }}"
                             >
                              <div class="font-medium">{{ $variant->ram }} / {{ $variant->storage }}</div>
                                 @if($variant->color)
                        <div class="text-sm text-text-secondary-light dark:text-text-secondary-dark">{{ $variant->color }}</div>
                           @endif
                 @if($variant->price_modifier != 0)
                              <div class="text-sm text-accent">+${{ number_format($variant->price_modifier, 2) }}</div>
                       @endif
                               </button>
                      @endforeach
                          </div>
                        </div>
               @endif

               <!-- Add to Cart -->
                    <div class="flex gap-4 mb-8">
                  <x-button variant="primary" size="lg" wire:click="addToCart" class="flex-1">
                         {{ __('Add to Cart') }}
                        </x-button>
                </div>

              @if(session()->has('success'))
                        <div class="p-4 bg-green/10 text-green rounded-card mb-4">
                         {{ session('success') }}
                      </div>
            @endif

                    <!-- Description -->
               <div class="prose dark:prose-invert max-w-none">
                        <p>{{ $product->description }}</p>
                  </div>
            </div>
            </div>

            <!-- Specifications -->
            @if($product->specs->count() > 0)
              <x-card class="p-8 mb-16">
                 <h2 class="text-2xl font-bold mb-6">{{ __('Technical Specifications') }}</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($product->specs->sortBy('sort_order') as $spec)
                          <div class="flex justify-between py-3 border-b border-border-light dark:border-border-dark">
               <dt class="font-medium">{{ ucfirst($spec->key) }}</dt>
                             <dd class="text-text-secondary-light dark:text-text-secondary-dark">{{ $spec->value }}</dd>
                      </div>
            @endforeach
                    </dl>
             </x-card>
            @endif

            <!-- Reviews -->
            @livewire('product-reviews', ['product' => $product])

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div>
                    <h2 class="text-2xl font-bold mb-6">{{ __('You might also like') }}</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                         <x-product-card :product="$related" />
                   @endforeach
              </div>
                </div>
            @endif
      </div>

        <x-toast type="success" />
    </x-layouts.storefront>
</div>
