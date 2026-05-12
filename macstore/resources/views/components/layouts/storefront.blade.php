<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MacStore') }} - {{ $title ?? 'Premium MacBooks' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-border-light dark:border-border-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
          <div class="flex-shrink-0">
               <a href="/" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-accent" fill="currentColor" viewBox="0 0 24 24">
                     <path d="M18.71 19.5C17.88 20.74 17 21.95 15.66 21.97C14.32 22 13.89 21.18 12.37 21.18C10.84 21.18 10.37 21.95 9.09997 22C7.78997 22.05 6.79997 20.68 5.95997 19.47C4.24997 17 2.93997 12.45 4.69997 9.39C5.56997 7.87 7.12997 6.91 8.81997 6.88C10.1 6.86 11.32 7.75 12.11 7.75C12.89 7.75 14.37 6.68 15.92 6.84C16.57 6.87 18.39 7.1 19.56 8.82C19.47 8.88 17.39 10.1 17.41 12.63C17.44 15.65 20.06 16.66 20.09 16.67C20.06 16.74 19.67 18.11 18.71 19.5ZM13 3.5C13.73 2.67 14.94 2.04 15.94 2C16.07 3.17 15.6 4.35 14.9 5.19C14.21 6.04 13.07 6.7 11.95 6.61C11.8 5.46 12.36 4.26 13 3.5Z"/>
                    </svg>
               <span class="text-xl font-semibold tracking-display">MacStore</span>
                    </a>
                </div>

           <!-- Desktop Navigation -->
              <div class="hidden md:flex items-center space-x-8">
              <a href="/products" class="text-sm font-medium hover:text-accent transition-colors">{{ __('Products') }}</a>
                 <a href="/products?category=macbook-air" class="text-sm font-medium hover:text-accent transition-colors">MacBook Air</a>
                    <a href="/products?category=macbook-pro" class="text-sm font-medium hover:text-accent transition-colors">MacBook Pro</a>
                  <a href="/products?condition=refurbished" class="text-sm font-medium hover:text-accent transition-colors">{{ __('Refurbished') }}</a>
                </div>

            <!-- Right Side -->
                <div class="flex items-center space-x-4">
                 <!-- Search -->
                    <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
           </svg>
                    </button>

                <!-- Language Switcher -->
             <div x-data="{ open: false }" class="relative">
                  <button @click="open = !open" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                  </svg>
                  </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-32 glass rounded-card shadow-hover border border-border-light dark:border-border-dark">
                    <a href="?lang=en" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 rounded-t-card">English</a>
                            <a href="?lang=km" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 rounded-b-card font-khmer">ខ្មែរ</a>
            </div>
           </div>

               <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                      <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
               </button>

                    <!-- Cart -->
                  <a href="/cart" class="relative p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
             <span class="absolute -top-1 -right-1 bg-accent text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
               </a>

                  <!-- Account -->
                  @auth
               <a href="/account" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </a>
                    @else
                    <a href="/login" class="text-sm font-medium hover:text-accent transition-colors">{{ __('Sign In') }}</a>
                    @endauth
          </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16 min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="glass border-t border-border-light dark:border-border-dark mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
              <!-- About -->
                <div>
            <h3 class="font-semibold mb-4">{{ __('About MacStore') }}</h3>
             <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                        {{ __('Premium MacBooks for professionals and creators in Cambodia.') }}
                    </p>
              </div>

              <!-- Shop -->
             <div>
                  <h3 class="font-semibold mb-4">{{ __('Shop') }}</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/products" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('All Products') }}</a></li>
                <li><a href="/products?category=macbook-air" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">MacBook Air</a></li>
                        <li><a href="/products?category=macbook-pro" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">MacBook Pro</a></li>
                   <li><a href="/products?condition=refurbished" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('Refurbished') }}</a></li>
                 </ul>
            </div>

                <!-- Support -->
                <div>
                 <h3 class="font-semibold mb-4">{{ __('Support') }}</h3>
              <ul class="space-y-2 text-sm">
                     <li><a href="/contact" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('Contact Us') }}</a></li>
                   <li><a href="/shipping" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('Shipping') }}</a></li>
              <li><a href="/warranty" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('Warranty') }}</a></li>
                    <li><a href="/faq" class="text-text-secondary-light dark:text-text-secondary-dark hover:text-accent">{{ __('FAQ') }}</a></li>
              </ul>
                </div>

              <!-- Newsletter -->
                <div>
              <h3 class="font-semibold mb-4">{{ __('Newsletter') }}</h3>
                  <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mb-4">
            {{ __('Get updates on new products and offers.') }}
                    </p>
                    <form class="flex gap-2">
              <input type="email" placeholder="{{ __('Email') }}" class="flex-1 px-3 py-2 text-sm rounded-button bg-white dark:bg-gray-800 border border-border-light dark:border-border-dark focus:ring-2 focus:ring-accent focus:border-transparent">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-accent hover:bg-accent-hover rounded-button transition-colors">
                   {{ __('Subscribe') }}
                    </button>
                    </form>
            </div>
            </div>

            <div class="mt-8 pt-8 border-t border-border-light dark:border-border-dark flex flex-col md:flex-row justify-between items-center text-sm text-text-secondary-light dark:text-text-secondary-dark">
                <p>&copy; {{ date('Y') }} MacStore. {{ __('All rights reserved.') }}</p>
              <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="/privacy" class="hover:text-accent">{{ __('Privacy') }}</a>
                <a href="/terms" class="hover:text-accent">{{ __('Terms') }}</a>
         </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
