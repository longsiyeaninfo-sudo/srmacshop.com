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
                <div class="detail-gallery" x-data="{ activeImg: '{{ $firstImg }}' }">
                    <div>
                        @if($firstImg)
                            <img class="detail-main-img" :src="activeImg" alt="{{ $product->name }}">
                        @else
                            <div class="detail-main-emoji">{{ $product->emoji ?: '💻' }}</div>
                        @endif
                    </div>
                    @if($media->count() > 1)
                        <div class="detail-thumbs">
                            @foreach($media as $i => $m)
                                <div class="dthumb {{ $i === 0 ? 'on' : '' }}"
                                    @click="activeImg = '{{ $m->getUrl() }}'; document.querySelectorAll('.dthumb').forEach(t => t.classList.remove('on')); $el.classList.add('on')">
                                    <img src="{{ $m->getUrl() }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    @elseif(!$firstImg)
                        <div class="detail-thumbs">
                            <div class="dthumb on">{{ $product->emoji ?: '💻' }}</div>
                        </div>
                    @endif
                </div>

                {{-- Info Card --}}
                <div class="detail-info-card">
                    <div class="detail-meta">
                        @if($product->category)
                            <span>📦 {{ $product->category->name }}</span>
                        @endif
                        <span class="stock-tag {{ $stockClass }}" style="display:flex;align-items:center;gap:3px">
                            <div class="dot"></div>{{ $stockText }}
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
                <div style="background:var(--card);border-left:4px solid var(--orange);border-radius:var(--rs);padding:14px 16px;margin-bottom:14px;border:1px solid var(--border2)">
                    <p style="font-size:12px;color:var(--orange);font-weight:700;margin-bottom:6px">⚠️ Disclaimer</p>
                    <p style="font-size:12px;color:var(--text2);line-height:1.7"
                        data-en="All products come with official warranty. Prices may vary. Contact us for the latest pricing and availability."
                        data-km="ផលិតផលទាំងអស់មានការធានា។ តម្លៃអាចផ្លាស់ប្តូរ។ ទំនាក់ទំនងយើងសម្រាប់តម្លៃ និងភាពអាចរកបាន។">
                        All products come with official warranty. Prices may vary. Contact us for the latest pricing and availability.
                    </p>
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="detail-right">
                <div class="detail-contact-card">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
                        <div style="width:42px;height:42px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;font-weight:800">S</div>
                        <div>
                            <div class="detail-shop-name">🍎 SR MAC SHOP</div>
                            <div class="detail-shop-sub">www.srmacshop.com · Phnom Penh</div>
                        </div>
                    </div>

                    @if($product->stock > 0)
                        <button class="detail-add-btn" type="button"
                            x-data
                            @click="$dispatch('cart.add', { productId: {{ $product->id }}, qty: 1 })"
                            data-en="🛒 Add to Cart" data-km="🛒 បន្ថែមទៅកន្ត្រក">🛒 Add to Cart</button>
                    @else
                        <button class="detail-add-btn" type="button" disabled
                            data-en="Out of Stock" data-km="អស់ស្តុក">Out of Stock</button>
                    @endif

                    <a class="detail-wa-btn"
                        href="https://wa.me/85598334755?text={{ $waMsg }}"
                        target="_blank" rel="noopener">💬 WhatsApp</a>

                    <a class="detail-tg-btn"
                        href="https://t.me/srmacshop"
                        target="_blank" rel="noopener">✈️ Telegram</a>

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
            <div class="related-section">
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

{{-- Listen for add to cart events --}}
<script>
    document.addEventListener('cart.add', function(e) {
        Livewire.dispatch('cart.add', e.detail);
    });
</script>
@endsection
