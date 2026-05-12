@props(['disabled' => false, 'rows' => 4])

<textarea {{ $disabled ? 'disabled' : '' }} rows="{{ $rows }}" {!! $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-button bg-white dark:bg-gray-800 border border-border-light dark:border-border-dark text-text-primary-light dark:text-text-primary-dark placeholder-text-secondary-light dark:placeholder-text-secondary-dark focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed resize-none']) !!}>{{ $slot }}</textarea>
