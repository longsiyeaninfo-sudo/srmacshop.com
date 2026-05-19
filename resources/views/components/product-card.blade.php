@props(['product'])

@php
    $firstImg = $product->getFirstMediaUrl('gallery');
    $stockClass = $product->stock > 5 ? 'tok' : ($product->stock > 0 ? 'tlow' : 'tout');
    $stockText = $product->stock > 5 ? 'In Stock' : ($product->stock > 0 ? "Only {$product->stock} left" : 'Out of Stock');
    $hasDiscount = $product->original_price && $product->original_price > $product->price;
    $discountPct = $hasDiscount ? round((1 - $product->price / $product->original_price) * 100) : 0;
@endphp

<div class="pcard" style="position:relative">
    {{-- Badges --}}
    @if($product->badge)
        <div class="pcard-badge b-{{ $product->badge }}">{{ strtoupper($product->badge) }}</div>
    @elseif($hasDiscount)
        <div class="pcard-badge" style="background:var(--red);color:#fff">-{{ $discountPct }}%</div>
    @endif

    {{-- Image --}}
    <a href="{{ route('product', $product->slug) }}" class="pcard-img-wrap" style="display:block;text-decoration:none">
        <div class="pcard-img">
            @if($firstImg)
                <img src="{{ $firstImg }}" alt="{{ $product->name }}"
                    style="width:100%;height:100%;object-fit:cover;font-size:0"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:72px">{{ $product->emoji ?: '💻' }}</div>
            @else
                <div>{{ $product->emoji ?: '💻' }}</div>
            @endif
        </div>
        {{-- Hover overlay --}}
        <div class="pcard-overlay">
            <span style="font-size:13px;font-weight:700;color:#fff" data-en="View Details" data-km="មើលលម្អិត">View Details →</span>
        </div>
    </a>

    {{-- Body --}}
    <div class="pcard-body">
        <div class="pcard-cat">{{ $product->category?->name }}</div>
        <a href="{{ route('product', $product->slug) }}" style="text-decoration:none;color:inherit">
            <div class="pcard-name">{{ $product->name }}</div>
            <div class="pcard-spec">{{ $product->spec }}</div>
        </a>
        <div class="pcard-foot">
            <div>
                <div class="pcard-price">
                    ${{ number_format($product->price / 100, 0) }}
                    @if($hasDiscount)
                        <span style="font-size:11px;color:var(--text3);text-decoration:line-through;font-weight:400;margin-left:4px">
                            ${{ number_format($product->original_price / 100, 0) }}
                        </span>
                    @endif
                </div>
                <div class="stock-tag {{ $stockClass }}">
                    <div class="dot"></div>
                    <span>{{ $stockText }}</span>
                </div>
            </div>
            @if($product->stock > 0)
                <button
                    type="button"
                    class="pcard-add-btn"
                    wire:click.prevent="$dispatch('cart.add', {productId: {{ $product->id }}, qty: 1})"
                    data-en="+ Add" data-km="+ បន្ថែម">
                    + Add
                </button>
            @else
                <span style="font-size:11px;color:var(--text3)">Sold out</span>
            @endif
        </div>
    </div>
</div>
