@props(['type' => 'success'])

@php
$icons = [
    'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
    'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
];

$colors = [
    'success' => 'text-green',
    'error' => 'text-red',
    'warning' => 'text-yellow',
    'info' => 'text-accent',
];
@endphp

<div
    x-data="{ show: false, message: '' }"
    x-on:toast.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
    class="fixed bottom-4 right-4 z-50 glass rounded-card shadow-hover border border-border-light dark:border-border-dark p-4 max-w-sm"
  style="display: none;"
>
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 {{ $colors[$type] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icons[$type] !!}
            </svg>
        </div>
        <div class="ml-3 w-0 flex-1">
            <p class="text-sm font-medium" x-text="message"></p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
          <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
         <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
         </svg>
          </button>
        </div>
    </div>
</div>
