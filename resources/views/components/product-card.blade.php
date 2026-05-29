@props(['product', 'compareIds' => null])

@php
    $firstImg = $product->getFirstMediaUrl('gallery');
    $stockClass = $product->stock > 5 ? 'tok' : ($product->stock > 0 ? 'tlow' : 'tout');
    $stockText = $product->stock > 5 ? 'In Stock' : ($product->stock > 0 ? "Only {$product->stock} left" : 'Out of Stock');
    $hasDiscount = $product->original_price && $product->original_price > $product->price;
    $discountPct = $hasDiscount ? round((1 - $product->price / $product->original_price) * 100) : 0;
    $compareEnabled = is_array($compareIds);
    $inCompare = $compareEnabled && in_array($product->id, $compareIds);
    $gradeColor = match($product->condition_grade) {
        'A+' => 'g-aplus', 'A' => 'g-a', 'B' => 'g-b', 'C' => 'g-c', default => null,
    };
@endphp

<div class="pcard {{ $inCompare ? 'is-comparing' : '' }}">
    {{-- Badges --}}
    @if($product->badge)
        <div class="pcard-badge b-{{ $product->badge }}">{{ strtoupper($product->badge) }}</div>
    @elseif($hasDiscount)
        <div class="pcard-badge b-sale">-{{ $discountPct }}%</div>
    @endif

    {{-- Compare checkbox (top-right) — only shown when used inside ProductGrid --}}
    @if($compareEnabled)
        <button
            type="button"
            class="pcard-cmp"
            wire:click.prevent.stop="toggleCompare({{ $product->id }})"
            aria-label="Add to compare"
            title="Compare">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3.5 8.5 6.5 11.5 12.5 5"/>
            </svg>
        </button>
    @endif

    {{-- Image --}}
    <a href="{{ route('product', $product->slug) }}" class="pcard-img-wrap">
        <div class="pcard-img">
            @if($firstImg)
                <img src="{{ $firstImg }}" alt="{{ $product->name }}"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="pcard-img-fallback">{{ $product->emoji ?: '💻' }}</div>
            @else
                <div class="pcard-img-fallback" style="display:flex">{{ $product->emoji ?: '💻' }}</div>
            @endif
        </div>
        @if($product->stock <= 0)
            <div class="sold-stamp">SOLD</div>
        @endif
    </a>

    {{-- Body --}}
    <div class="pcard-body">
        <div class="pcard-cat">{{ $product->category?->name }}</div>
        @if($product->condition_grade || $product->battery_health)
            <div class="pcard-meta">
                @if($product->condition_grade)
                    <span class="pcard-grade {{ $gradeColor }}">Grade {{ $product->condition_grade }}</span>
                @endif
                @if($product->battery_health)
                    <span class="pcard-batt">🔋 {{ $product->battery_health }}%</span>
                @endif
            </div>
        @endif
        <a href="{{ route('product', $product->slug) }}" class="pcard-link">
            <div class="pcard-name">{{ $product->name }}</div>
            <div class="pcard-spec">{{ $product->spec }}</div>
        </a>
        <div class="pcard-foot">
            <div>
                <div class="pcard-price">
                    ${{ number_format($product->price / 100, 0) }}
                    @if($hasDiscount)
                        <span class="pcard-strike">${{ number_format($product->original_price / 100, 0) }}</span>
                    @endif
                </div>
                <div class="stock-tag {{ $stockClass }}">{{ $stockText }}</div>
            </div>
            @if($product->stock > 0)
                <button
                    type="button"
                    class="pcard-add-btn"
                    wire:click.prevent="$dispatch('cart.add', {productId: {{ $product->id }}, qty: 1})"
                    data-en="Add" data-km="បន្ថែម">
                    Add
                </button>
            @else
                <span class="pcard-sold">Sold out</span>
            @endif
        </div>
    </div>
</div>
