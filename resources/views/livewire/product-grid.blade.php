<div>
    <section class="shop-section" style="background:var(--bg);padding-top:2.5rem">
        <div class="inner">
            <div class="sec-eyebrow" data-en="Our Catalog" data-km="បញ្ជីផលិតផល">Our Catalog</div>
            <h2 class="sec-h" data-en="All MacBooks" data-km="MacBook ទាំងអស់">All MacBooks</h2>

            {{-- Search + Sort row --}}
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
                @if($products->total() > 0)
                    <div class="shop-count" wire:loading.class="opacity-50">
                        <span data-en="Showing" data-km="បង្ហាញ">Showing</span>
                        <strong>{{ $products->count() }}</strong>
                        <span data-en="of" data-km="នៃ">of</span>
                        <strong>{{ $products->total() }}</strong>
                    </div>
                @endif
            </div>

            {{-- Category filter chips (underline-active) --}}
            <div class="chip-bar">
                <button type="button" class="chip {{ $category === '' ? 'on' : '' }}"
                    wire:click="$set('category', '')" data-en="All" data-km="ទាំងអស់">All</button>
                @foreach($categories as $cat)
                    <button type="button" class="chip {{ $category === $cat->slug ? 'on' : '' }}"
                        wire:click="$set('category', '{{ $cat->slug }}')">{{ $cat->name }}</button>
                @endforeach
            </div>

            {{-- Loading skeleton (shows while Livewire is filtering) --}}
            <div class="pgrid-skeleton" wire:loading.delay.long wire:target="search,category,sort">
                @for($i = 0; $i < 8; $i++)
                    <div class="skcard">
                        <div class="skcard-img"></div>
                        <div class="skcard-body">
                            <div class="skcard-line short"></div>
                            <div class="skcard-line long"></div>
                            <div class="skcard-line short"></div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Real grid --}}
            <div wire:loading.delay.long.remove wire:target="search,category,sort">
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
        </div>
    </section>

    {{-- Floating compare pill (shows when 1+ items selected) --}}
    @if(count($compareIds) > 0)
        <div class="cmp-pill">
            <span data-en="Compare" data-km="ប្រៀបធៀប">Compare</span>
            <span class="cmp-pill-count">{{ count($compareIds) }}</span>
            @if(count($compareIds) >= 2)
                <a href="{{ route('compare', ['ids' => implode(',', $compareIds)]) }}" class="cmp-pill-go">
                    <span data-en="View →" data-km="មើល →">View →</span>
                </a>
            @else
                <span style="font-size:12px;opacity:.6" data-en="Pick one more" data-km="ជ្រើសរើសមួយទៀត">Pick one more</span>
            @endif
            <button type="button" class="cmp-pill-x" wire:click="clearCompare" aria-label="Clear">✕</button>
        </div>
    @endif
</div>
