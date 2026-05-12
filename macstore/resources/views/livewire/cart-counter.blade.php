<a href="{{ route('cart') }}" class="relative p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
    </svg>
    @if($count > 0)
        <span class="absolute -top-1 -right-1 bg-accent text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
            {{ $count }}
        </span>
    @endif
</a>
