@props(['product'])

@php
    $img = $product->getFirstMediaUrl('gallery');
    $isOnSale = $product->original_price && $product->original_price > $product->price;
    $saveAmt = $isOnSale ? ($product->original_price - $product->price) : 0;
    $savePct = $isOnSale ? (int) round((1 - $product->price / $product->original_price) * 100) : 0;
    $lowStock = $product->stock > 0 && $product->stock <= 3;
    $endsAt = $product->sale_ends_at?->toIso8601String();
@endphp

<a href="{{ route('product', $product->slug) }}" class="fd-card">
    {{-- Image (1:1) with overlay badges --}}
    <div class="fd-card-img">
        @if($img)
            <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy">
        @else
            <div class="fd-card-emoji">{{ $product->emoji ?: '💻' }}</div>
        @endif
        @if($savePct > 0)
            <div class="fd-card-badge">−{{ $savePct }}%</div>
        @endif
        @if($lowStock)
            <div class="fd-card-low">Only {{ $product->stock }} left!</div>
        @endif
    </div>

    {{-- Body --}}
    <div class="fd-card-body">
        <div class="fd-card-cat">{{ $product->category?->name }}</div>
        <div class="fd-card-name">{{ $product->name }}</div>
        @if($product->spec)
            <div class="fd-card-spec">{{ $product->spec }}</div>
        @endif

        <div class="fd-card-price-row">
            <span class="fd-card-price">${{ number_format($product->price / 100, 0) }}</span>
            @if($isOnSale)
                <span class="fd-card-strike">${{ number_format($product->original_price / 100, 0) }}</span>
            @endif
        </div>

        @if($endsAt)
            <div class="fd-card-cd" data-countdown="{{ $endsAt }}">
                ⏰ <span class="cd-timer">…</span> <span data-en="left" data-km="នៅសល់" data-zh="剩余">left</span>
            </div>
        @endif

        <span class="fd-card-cta"
            data-en="🛒 Order Now" data-km="🛒 បញ្ជាទិញ" data-zh="🛒 立即订购">🛒 Order Now</span>
    </div>
</a>
