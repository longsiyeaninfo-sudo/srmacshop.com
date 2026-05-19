<div>
    <section class="shop-section" style="background:var(--bg);padding-top:2.5rem">
        <div class="inner">
            <div class="sec-eyebrow" data-en="Our Catalog" data-km="បញ្ជីផលិតផល">Our Catalog</div>
            <h2 class="sec-h" data-en="All Products" data-km="ផលិតផលទាំងអស់">All Products</h2>

            <div class="shop-toolbar">
                <div class="srch">
                    <span>🔍</span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search MacBooks..."
                        data-en="Search MacBooks..." data-km="ស្វែងរក MacBook...">
                </div>
                <div class="shop-sort">
                    <select wire:model.live="sort" class="sort-sel">
                        <option value="featured" data-en="Featured" data-km="ពិសេស">Featured</option>
                        <option value="newest" data-en="Newest" data-km="ថ្មីបំផុត">Newest</option>
                        <option value="price_asc" data-en="Price: Low → High" data-km="តម្លៃ: ទាប → ខ្ពស់">Price: Low → High</option>
                        <option value="price_desc" data-en="Price: High → Low" data-km="តម្លៃ: ខ្ពស់ → ទាប">Price: High → Low</option>
                    </select>
                </div>
                <div class="shop-count" wire:loading.class="opacity-50">
                    <span>{{ $products->total() }}</span> <span data-en="products" data-km="ផលិតផល">products</span>
                </div>
            </div>

            <div class="chip-bar">
                <div class="chip {{ $category === '' ? 'on' : '' }}"
                    wire:click="$set('category', '')" data-en="All" data-km="ទាំងអស់">All</div>
                @foreach($categories as $cat)
                    <div class="chip {{ $category === $cat->slug ? 'on' : '' }}"
                        wire:click="$set('category', '{{ $cat->slug }}')">{{ $cat->name }}</div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div style="text-align:center;padding:4rem 1rem;color:var(--text3)">
                    <div style="font-size:42px;margin-bottom:8px">🔍</div>
                    <p data-en="No products found." data-km="រកមិនឃើញផលិតផល។">No products found.</p>
                </div>
            @else
                <div class="pgrid">
                    @foreach($products as $product)
                        <x-product-card :product="$product" :compare-ids="$compareIds" />
                    @endforeach
                </div>
            @endif

            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                <div style="margin-top:24px;display:flex;justify-content:center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
