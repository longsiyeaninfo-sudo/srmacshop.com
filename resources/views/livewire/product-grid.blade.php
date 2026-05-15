<div>
    {{-- TODO Phase 3 (post-prototype): port .shop-toolbar + .chip-bar + .pgrid markup --}}
    <section style="max-width:1200px;margin:0 auto;padding:32px 16px">
      <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px">
            <input type="search" wire:model.live.debounce.300ms="search"
                   placeholder="{{ __('Search MacBooks…') }}"
            style="flex:1;min-width:240px;padding:10px 14px;border:1px solid #ddd;border-radius:14px;font:inherit">
        </div>

     <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px">
         <button wire:click="$set('category', '')"
             style="padding:8px 14px;border:1px solid #ddd;border-radius:999px;background:{{ $category === '' ? '#007AFF' : '#fff' }};color:{{ $category === '' ? '#fff' : '#111' }};cursor:pointer">
                {{ __('All') }}
            </button>
          @foreach($categories as $cat)
              <button wire:click="$set('category', '{{ $cat->slug }}')"
                  style="padding:8px 14px;border:1px solid #ddd;border-radius:999px;background:{{ $category === $cat->slug ? '#007AFF' : '#fff' }};color:{{ $category === $cat->slug ? '#fff' : '#111' }};cursor:pointer">
                    {{ $cat->name }}
                </button>
        @endforeach
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px">
     @forelse($products as $product)
            <x-product-card :product="$product" />
            @empty
                <p>{{ __('No products found.') }}</p>
            @endforelse
        </div>

     <div style="margin-top:24px">{{ $products->links() }}</div>
    </section>
</div>
