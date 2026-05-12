@props(['variant' => 'primary', 'size' => 'md', 'href' => null])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-accent hover:bg-accent-hover active:bg-accent-pressed text-white focus:ring-accent',
    'secondary' => 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 focus:ring-gray-400',
    'ghost' => 'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-gray-400',
    'danger' => 'bg-red hover:bg-red/90 text-white focus:ring-red',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm rounded-button',
    'md' => 'px-4 py-2 text-sm rounded-button',
    'lg' => 'px-6 py-3 text-base rounded-button',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif
