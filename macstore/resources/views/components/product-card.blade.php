@props(['product'])

<x-card class="p-6 group cursor-pointer">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="aspect-square mb-4 flex items-center justify-center bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden">
          @if($product->hasMedia('images'))
            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
           <svg class="w-24 h-24 text-gray-300 dark:text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
          </svg>
        @endif
        </div>

        <div class="space-y-2">
        <h3 class="font-semibold text-lg group-hover:text-accent transition-colors">
                {{ $product->name }}
            </h3>

            <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark line-clamp-2">
                {{ $product->short_description }}
            </p>

            <div class="flex items-baseline justify-between pt-2">
                <div>
              @if($product->sale_price && $product->sale_price < $product->base_price)
                        <span class="text-xl font-semibold text-accent">${{ number_format($product->sale_price) }}</span>
                   <span class="text-sm text-text-secondary-light dark:text-text-secondary-dark line-through ml-2">${{ number_format($product->base_price) }}</span>
                    @else
                        <span class="text-xl font-semibold">${{ number_format($product->base_price) }}</span>
                    @endif
                </div>

                @if($product->condition === 'refurbished')
               <span class="text-xs px-2 py-1 bg-green/10 text-green rounded-full">Refurbished</span>
            @endif
            </div>
        </div>
    </a>
</x-card>
