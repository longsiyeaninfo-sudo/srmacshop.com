@props(['hover' => true])

@php
$classes = 'glass rounded-card border border-border-light dark:border-border-dark shadow-resting transition-all duration-200';
if ($hover) {
    $classes .= ' hover:shadow-hover hover:scale-[1.02]';
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
