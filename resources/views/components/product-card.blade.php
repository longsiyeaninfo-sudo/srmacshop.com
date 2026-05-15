@props(['product'])

{{-- TODO Phase 3: port the prototype's .pcard markup verbatim --}}
<a href="{{ route('product', $product->slug) }}" class="pcard"
   style="display:block;background:#fff;border-radius:14px;padding:16px;text-decoration:none;color:inherit;border:1px solid #eee">
    @if($product->getFirstMediaUrl('gallery'))
        <img src="{{ $product->getFirstMediaUrl('gallery') }}" alt="{{ $product->name }}"
             style="width:100%;aspect-ratio:1;object-fit:contain;background:#fafafa;border-radius:10px">
    @else
        <div style="width:100%;aspect-ratio:1;background:#fafafa;border-radius:10px;display:grid;place-items:center;font-size:48px">
          {{ $product->emoji ?: '💻' }}
        </div>
    @endif
    <div style="margin-top:12px;font-weight:600">{{ $product->name }}</div>
    <div style="font-size:13px;color:#666">{{ $product->spec }}</div>
    <div style="margin-top:8px;font-weight:600">${{ number_format($product->price_dollars, 0) }}</div>
    @if($product->badge)
        <span style="display:inline-block;margin-top:6px;padding:2px 8px;background:#007AFF;color:#fff;border-radius:999px;font-size:11px;text-transform:uppercase">
            {{ $product->badge }}
        </span>
    @endif
</a>
