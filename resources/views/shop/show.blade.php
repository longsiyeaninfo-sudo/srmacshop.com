@extends('layouts.storefront')

@section('title', $product->name . ' ' . $product->spec . ' — SR MAC SHOP')
@section('description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? 'Premium MacBook at SR MAC SHOP Cambodia'), 160))

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "description": "{{ \Illuminate\Support\Str::limit($product->description ?? '', 200) }}",
  "brand": {"@type": "Brand", "name": "Apple"},
  "offers": {
    "@type": "Offer",
    "price": "{{ $product->price / 100 }}",
    "priceCurrency": "USD",
    "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
  }
}
</script>
@endsection

@section('content')
@php
    $media = $product->getMedia('gallery');
    $firstImg = $product->getFirstMediaUrl('gallery');
    $specs = [];
    if ($product->spec) $specs['Specs'] = $product->spec;
    if ($product->warranty) $specs['Warranty'] = $product->warranty;
    if ($product->color) $specs['Color'] = $product->color;
    if ($product->weight) $specs['Weight'] = $product->weight;
    if ($product->category) $specs['Category'] = $product->category->name;
    $priceFormatted = '$' . number_format($product->price / 100, 0);
    $waMsg = urlencode("Hi SR MAC SHOP! I'm interested in: {$product->name} {$product->spec} ({$priceFormatted}). Please send me more info.");
    $stockClass = $product->stock > 5 ? 'tok' : ($product->stock > 0 ? 'tlow' : 'tout');
    $stockText = $product->stock > 5 ? 'In Stock' : ($product->stock > 0 ? "Only {$product->stock} left" : 'Out of Stock');
@endphp

<div id="cp-detail">
    <section style="background:var(--bg);padding-top:1rem">
        <div class="detail-wrap">
            {{-- LEFT --}}
            <div class="detail-left">
                <a href="{{ route('shop') }}" class="detail-back">← <span data-en="Back to Shop" data-km="ត្រឡប់ទៅហាង">Back to Shop</span></a>

                {{-- Gallery --}}
                @php
                    $allImages = $media->map(fn($m) => $m->getUrl())->toArray();
                    $imgCount = count($allImages);
                    $visibleThumbs = 8;
                @endphp
                <div class="detail-gallery"
                     x-data="{
                        activeIdx: 0,
                        images: @js($allImages),
                        lightbox: false,
                        get activeImg() { return this.images[this.activeIdx] || '' },
                        open(i) { this.activeIdx = i; this.lightbox = true; document.body.style.overflow = 'hidden'; },
                        close() { this.lightbox = false; document.body.style.overflow = ''; },
                        next() { this.activeIdx = (this.activeIdx + 1) % this.images.length },
                        prev() { this.activeIdx = (this.activeIdx - 1 + this.images.length) % this.images.length },
                     }"
                     x-on:keydown.escape.window="lightbox && close()"
                     x-on:keydown.arrow-right.window="lightbox && next()"
                     x-on:keydown.arrow-left.window="lightbox && prev()">

                    {{-- Hero image --}}
                    <div class="detail-hero" @click="images.length && open(activeIdx)">
                        @if($firstImg)
                            <img class="detail-main-img" :src="activeImg" alt="{{ $product->name }}"
                                style="font-size:0;cursor:zoom-in"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="detail-main-emoji" style="display:none">{{ $product->emoji ?: '💻' }}</div>
                        @else
                            <div class="detail-main-emoji">{{ $product->emoji ?: '💻' }}</div>
                        @endif
                        @if($imgCount > 0)
                            <div class="detail-zoom-hint">🔍 <span data-en="Click to zoom" data-km="ចុចដើម្បីពង្រីក">Click to zoom</span></div>
                        @endif
                    </div>

                    {{-- 8 thumbnails strip (Khmer24 style) --}}
                    @if($imgCount > 0)
                        <div class="detail-thumbs-grid">
                            @foreach($media->take($visibleThumbs) as $i => $m)
                                <div class="dthumb-cell"
                                    :class="activeIdx === {{ $i }} && 'on'"
                                    @click.stop="activeIdx = {{ $i }}">
                                    <img src="{{ $m->getUrl() }}" alt="" @click="open({{ $i }})">
                                    @if($i === $visibleThumbs - 1 && $imgCount > $visibleThumbs)
                                        <div class="dthumb-more" @click="open({{ $i }})">+{{ $imgCount - $visibleThumbs + 1 }}</div>
                                    @endif
                                </div>
                            @endforeach
                            @if(!$firstImg)
                                <div class="dthumb-cell on">{{ $product->emoji ?: '💻' }}</div>
                            @endif
                        </div>
                    @endif

                    {{-- Lightbox (teleported to body so it escapes parent overflow) --}}
                    <template x-teleport="body">
                        <div x-show="lightbox" x-cloak
                             class="lb-overlay"
                             @click.self="close()">
                            <button class="lb-btn lb-close" @click="close()" aria-label="Close">✕</button>
                            @if($imgCount > 1)
                                <button class="lb-btn lb-prev" @click="prev()" aria-label="Previous">‹</button>
                                <button class="lb-btn lb-next" @click="next()" aria-label="Next">›</button>
                                <div class="lb-counter"><span x-text="activeIdx + 1"></span> / {{ $imgCount }}</div>
                            @endif
                            <img class="lb-img" :src="activeImg" alt="{{ $product->name }}">
                        </div>
                    </template>
                </div>

                {{-- Info Card --}}
                <div class="detail-info-card">
                    <div class="detail-meta">
                        @if($product->category)
                            <span>📦 {{ $product->category->name }}</span>
                        @endif
                        <span class="stock-tag {{ $stockClass }}" style="display:inline-flex;align-items:center;gap:5px">
                            <span style="width:6px;height:6px;border-radius:50%;background:currentColor;flex-shrink:0"></span>
                            {{ $stockText }}
                        </span>
                    </div>
                    <h1 class="detail-title">{{ $product->name }}</h1>
                    <div class="detail-price-row">
                        <div class="detail-price">{{ $priceFormatted }}</div>
                        @if($product->warranty)
                            <div class="detail-warranty-badge">✓ {{ $product->warranty }}</div>
                        @endif
                    </div>
                    <div class="detail-tags">
                        @foreach(array_filter(explode('·', $product->spec)) as $tag)
                            <span class="dtag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Specs --}}
                <div class="detail-info-card">
                    <div style="font-size:14px;font-weight:700;margin-bottom:12px">📋 <span data-en="Specifications" data-km="លក្ខណៈបច្ចេកទេស">Specifications</span></div>
                    <table class="spec-table">
                        @foreach($specs as $label => $value)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                {{-- Description --}}
                @if($product->description)
                    <div class="detail-info-card">
                        <div style="font-size:14px;font-weight:700;margin-bottom:12px">📝 <span data-en="Description" data-km="ការពិពណ៌នា">Description</span></div>
                        <div class="detail-desc">{{ $product->description }}</div>
                    </div>
                @endif

                {{-- Disclaimer --}}
                <div style="background:var(--bg);border-radius:var(--radius);padding:14px 18px;margin-bottom:14px;border:1px solid var(--hairline)">
                    <p style="font-size:11px;color:var(--text2);font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:6px">Note</p>
                    <p style="font-size:12px;color:var(--text2);line-height:1.6"
                        data-en="All products come with official warranty. Prices may vary. Contact us for the latest pricing and availability."
                        data-km="ផលិតផលទាំងអស់មានការធានា។ តម្លៃអាចផ្លាស់ប្តូរ។ ទំនាក់ទំនងយើងសម្រាប់តម្លៃ និងភាពអាចរកបាន។">
                        All products come with official warranty. Prices may vary. Contact us for the latest pricing and availability.
                    </p>
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="detail-right">
                <div class="detail-contact-card">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                        <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ config('app.name') }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;flex-shrink:0">
                        <div>
                            <div class="detail-shop-name">SR MAC SHOP</div>
                            <div class="detail-shop-sub">www.srmacshop.com · Phnom Penh</div>
                        </div>
                    </div>

                    @if($product->stock > 0)
                        <button class="detail-add-btn" type="button"
                            onclick="Livewire.dispatch('cart.add', {productId: {{ $product->id }}, qty: 1})"
                            data-en="🛒 Add to Cart" data-km="🛒 បន្ថែមទៅកន្ត្រក">🛒 Add to Cart</button>
                    @else
                        <button class="detail-add-btn" type="button" disabled
                            data-en="Out of Stock" data-km="អស់ស្តុក">Out of Stock</button>
                    @endif

                    <div class="detail-secondary-links">
                        <a class="detail-sec-link"
                            href="https://wa.me/85598334755?text={{ $waMsg }}"
                            target="_blank" rel="noopener">💬 <span data-en="WhatsApp" data-km="WhatsApp">WhatsApp</span></a>
                        <a class="detail-sec-link"
                            href="https://t.me/srmacshop"
                            target="_blank" rel="noopener">✈️ <span data-en="Telegram" data-km="Telegram">Telegram</span></a>
                    </div>

                    <div class="detail-contact-row">
                        <div class="detail-contact-ico">📍</div>
                        <div>
                            <div class="detail-contact-lbl">Location</div>
                            <div class="detail-contact-val" data-en="Sangkat Kambol, Khan Kambol, Phnom Penh" data-km="សង្កាត់កំបូល ខណ្ឌកំបូល ភ្នំពេញ">Sangkat Kambol, Khan Kambol, Phnom Penh</div>
                        </div>
                    </div>
                    <div class="detail-contact-row">
                        <div class="detail-contact-ico">📞</div>
                        <div>
                            <div class="detail-contact-lbl">Phone</div>
                            <div class="detail-contact-val">+855 98 33 47 55</div>
                        </div>
                    </div>
                    <div class="detail-contact-row">
                        <div class="detail-contact-ico">🕐</div>
                        <div>
                            <div class="detail-contact-lbl">Hours</div>
                            <div class="detail-contact-val" data-en="Mon–Sun: 8AM–8PM" data-km="ច័ន្ទ–អាទិត្យ: ៨–២០ម៉ោង">Mon–Sun: 8AM–8PM</div>
                        </div>
                    </div>
                </div>

                {{-- Loan Calculator --}}
                <livewire:loan-calculator :product-price="$product->price / 100" />
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->count())
            <div class="related-section reveal">
                <div class="related-title" data-en="🛍️ Related Products" data-km="🛍️ ផលិតផលពាក់ព័ន្ធ">🛍️ Related Products</div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px">
                    @foreach($related as $rel)
                        <x-product-card :product="$rel" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>

@endsection
