@props(['product'])

@php
    $firstImg = $product->getFirstMediaUrl('gallery');
    $stockClass = $product->stock > 5 ? 'tok' : ($product->stock > 0 ? 'tlow' : 'tout');
    $stockText = $product->stock > 5 ? 'In Stock' : ($product->stock > 0 ? "Only {$product->stock} left" : 'Out of Stock');
@endphp

<a href="{{ route('product', $product->slug) }}" class="pcard" style="display:block;text-decoration:none;color:inherit">
    @if($product->badge)
        <div class="pcard-badge b-{{ $product->badge }}">{{ strtoupper($product->badge) }}</div>
    @endif

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

    <div class="pcard-body">
        <div class="pcard-cat">{{ $product->category?->name }}</div>
        <div class="pcard-name">{{ $product->name }}</div>
        <div class="pcard-spec">{{ $product->spec }}</div>
        <div class="pcard-foot">
            <div>
                <div class="pcard-price">${{ number_format($product->price / 100, 0) }}</div>
                <div class="stock-tag {{ $stockClass }}">
                    <div class="dot"></div>
                    <span>{{ $stockText }}</span>
                </div>
            </div>
            <span style="font-size:11px;font-weight:600;color:var(--blue);white-space:nowrap"
                data-en="View →" data-km="មើល →">View →</span>
        </div>
    </div>
</a>
