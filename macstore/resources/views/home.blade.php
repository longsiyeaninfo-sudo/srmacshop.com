<x-layouts.storefront>
    <x-slot name="title">Home</x-slot>

    <!-- Hero Section -->
    <section class="relative min-h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-accent/10 to-transparent"></div>
      
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <x-traffic-lights class="justify-center mb-8" />
            
            <h1 class="text-5xl md:text-7xl font-bold tracking-display mb-6">
           The power of <span class="text-accent">Mac</span>.<br>
             Now in Cambodia.
            </h1>
            
        <p class="text-xl md:text-2xl text-text-secondary-light dark:text-text-secondary-dark mb-8 max-w-3xl mx-auto">
           Premium MacBooks for professionals and creators. New and refurbished models with warranty.
          </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
           <x-button variant="primary" size="lg" href="/products">
               Shop MacBooks
          </x-button>
                <x-button variant="ghost" size="lg" href="/products?condition=refurbished">
                    View Refurbished
              </x-button>
          </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex justify-between items-end mb-12">
            <div>
           <h2 class="text-3xl md:text-4xl font-bold mb-2">Featured MacBooks</h2>
                <p class="text-text-secondary-light dark:text-text-secondary-dark">Handpicked for you</p>
            </div>
            <x-button variant="ghost" href="/products">View All</x-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($i = 0; $i < 3; $i++)
      <x-product-card :product="(object)[
              'name' => 'MacBook Pro 14&quot;',
             'short_description' => 'M4 Pro chip, 16GB RAM, 512GB SSD',
                'base_price' => 1999,
          'slug' => 'macbook-pro-14-m4'
            ]" />
            @endfor
        </div>
    </section>

    <!-- Categories -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
     <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center">Shop by Model</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card class="p-8 text-center">
              <div class="w-16 h-16 mx-auto mb-4 bg-accent/10 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-accent" fill="currentColor" viewBox="0 0 24 24">
             <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
                 </svg>
             </div>
             <h3 class="text-xl font-semibold mb-2">MacBook Air</h3>
           <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">Lightweight and powerful</p>
                <x-button variant="ghost" href="/products?category=macbook-air">Browse</x-button>
            </x-card>

      <x-card class="p-8 text-center">
              <div class="w-16 h-16 mx-auto mb-4 bg-accent/10 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-accent" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
               </svg>
      </div>
                <h3 class="text-xl font-semibold mb-2">MacBook Pro 14"</h3>
                <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">Pro performance</p>
                <x-button variant="ghost" href="/products?category=macbook-pro-14">Browse</x-button>
            </x-card>

            <x-card class="p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-accent/10 rounded-full flex items-center justify-center">
               <svg class="w-8 h-8 text-accent" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
                    </svg>
                </div>
           <h3 class="text-xl font-semibold mb-2">MacBook Pro 16"</h3>
        <p class="text-text-secondary-light dark:text-text-secondary-dark mb-4">Maximum power</p>
                <x-button variant="ghost" href="/products?category=macbook-pro-16">Browse</x-button>
        </x-card>
        </div>
    </section>

    <!-- Toast Notification -->
  <x-toast type="success" />
</x-layouts.storefront>
