<x-layouts.storefront>
    <x-slot name="title">{{ __('Server Error') }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <x-traffic-lights class="justify-center mb-8" />

            <h1 class="text-9xl font-bold text-red mb-4">500</h1>

            <h2 class="text-3xl font-bold mb-4">{{ __('Server Error') }}</h2>

            <p class="text-xl text-text-secondary-light dark:text-text-secondary-dark mb-8 max-w-2xl mx-auto">
                {{ __('Something went wrong on our end. Please try again later.') }}
       </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <x-button variant="primary" href="/">
              {{ __('Go Home') }}
            </x-button>
                <x-button variant="ghost" onclick="window.location.reload()">
                    {{ __('Refresh Page') }}
                </x-button>
        </div>
        </div>
    </div>
</x-layouts.storefront>
