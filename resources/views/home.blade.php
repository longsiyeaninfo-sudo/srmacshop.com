@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Smartphones, iPads & Apple Devices in Cambodia')
@section('description', "Cambodia's most trusted Apple specialist. Smartphones, iPads, MacBooks with official warranty. Same-day delivery in Phnom Penh. Best prices guaranteed.")

@section('content')
    {{-- ─────────────────────────────────────────────  ①  PHOTO SLIDESHOW  ─── --}}
    @php
        // Admin-controlled slideshow display config.
        $ss           = $slideshowConfig ?? [];
        $ssEnabled    = (bool) ($ss['enabled'] ?? true);
        $ssAutoplay   = (bool) ($ss['autoplay'] ?? true);
        $ssIntervalMs = (int) round(((float) ($ss['interval'] ?? 4.5)) * 1000);
        $ssThumbs     = (bool) ($ss['show_thumbnails'] ?? true);
        $ssEyebrowEn  = trim($ss['eyebrow_en'] ?? '');
        $ssEyebrowKm  = trim($ss['eyebrow_km'] ?? '');
        $ssEyebrowZh  = trim($ss['eyebrow_zh'] ?? '');
        $ssHeadingEn  = trim($ss['heading_en'] ?? '');
        $ssHeadingKm  = trim($ss['heading_km'] ?? '');
        $ssHeadingZh  = trim($ss['heading_zh'] ?? '');

        $formatPrice = fn ($cents) => $cents ? '$' . number_format($cents / 100, 0) : null;
        if ($homeSlides->isNotEmpty()) {
            $slideData = $homeSlides->map(function ($s) use ($formatPrice) {
                $title = $s->resolvedTitle();
                return [
                    'name'    => $title ?: 'Slide',
                    'titleEn' => $title,
                    'titleKm' => $s->title_km ?: $title,
                    'titleZh' => $s->title_zh ?: $title,
                    'img'     => $s->imageUrl(),
                    'url'     => $s->resolvedUrl(),
                    'price'   => $formatPrice($s->resolvedPriceCents()),
                    'orig'    => $formatPrice($s->resolvedOriginalPriceCents()),
                    'discountPct' => $s->resolvedDiscountPercent(),
                    'savings'     => $formatPrice($s->resolvedSavingsCents()),
                    'category'    => $s->resolvedCategoryName(),
                ];
            })->values();
        } else {
            $slideData = $slideshowProducts->map(fn ($p) => [
                'name'    => $p->name,
                'titleEn' => $p->name,
                'titleKm' => $p->name,
                'titleZh' => $p->name,
                'img'     => $p->getFirstMediaUrl('gallery'),
                'url'     => route('product', $p->slug),
                'price'   => $formatPrice($p->price ?? null),
                'orig'    => ($p->original_price && $p->price && $p->original_price > $p->price)
                    ? $formatPrice($p->original_price) : null,
                'discountPct' => $p->isOnSale() ? $p->discountPercent() : null,
                'savings'     => $p->isOnSale() ? $formatPrice($p->discountAmount()) : null,
                'category'    => $p->category?->name,
            ])->values();
        }
    @endphp
    @if($ssEnabled && $slideData->isNotEmpty())
        <section class="shop-section hp-slideshow-section" style="background:var(--bg)"
                 x-data='{
                    slides: @json($slideData),
                    active: 0,
                    _t: null,
                    zoom: { open: false, img: "", alt: "" },
                    next(){ this.active = (this.active + 1) % this.slides.length; this.scrollThumb() },
                    prev(){ this.active = (this.active - 1 + this.slides.length) % this.slides.length; this.scrollThumb() },
                    go(n){ this.active = n; this.scrollThumb() },
                    _start(){ if({{ $ssAutoplay ? 'true' : 'false' }} && this.slides.length > 1 && !this._t) this._t = setInterval(() => this.next(), {{ $ssIntervalMs }}) },
                    pause(){ clearInterval(this._t); this._t = null },
                    resume(){ if(!this.zoom.open) this._start() },
                    _tx: 0,
                    onStart(e){ this._tx = e.changedTouches[0].clientX },
                    onEnd(e){ const dx = e.changedTouches[0].clientX - this._tx; if(Math.abs(dx) > 50){ dx < 0 ? this.next() : this.prev() } },
                    openZoom(){ const s = this.slides[this.active]; this.zoom = { open: true, img: s.img, alt: s.name }; this.pause(); document.body.style.overflow = "hidden" },
                    closeZoom(){ this.zoom.open = false; document.body.style.overflow = ""; this.resume() },
                    scrollThumb(){ this.$nextTick(() => { const el = this.$refs.thumbs && this.$refs.thumbs.querySelector(".hp-ss-thumb.is-on"); if(el && el.scrollIntoView) el.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" }) }) }
                 }'
                 x-init="_start()"
                 @keydown.escape.window="if(zoom.open) closeZoom()">
            <div class="inner">
                @if($ssEyebrowEn || $ssHeadingEn)
                    <div style="margin-bottom:16px;text-align:center">
                        @if($ssEyebrowEn)
                            <div class="sec-eyebrow"
                                 data-en="{{ $ssEyebrowEn }}"
                                 data-km="{{ $ssEyebrowKm ?: $ssEyebrowEn }}"
                                 data-zh="{{ $ssEyebrowZh ?: $ssEyebrowEn }}">{{ $ssEyebrowEn }}</div>
                        @endif
                        @if($ssHeadingEn)
                            <h2 class="sec-h"
                                data-en="{{ $ssHeadingEn }}"
                                data-km="{{ $ssHeadingKm ?: $ssHeadingEn }}"
                                data-zh="{{ $ssHeadingZh ?: $ssHeadingEn }}">{{ $ssHeadingEn }}</h2>
                        @endif
                    </div>
                @endif
                <div class="hp-ss-main"
                     @mouseenter="pause()" @mouseleave="resume()"
                     @touchstart="onStart($event)" @touchend="onEnd($event)">
                    <template x-for="(s, i) in slides" :key="i">
                        <div class="hp-ss-slide" :class="{ 'is-on': active === i }">
                            <button type="button" class="hp-ss-img-btn"
                                    @click="openZoom()" :aria-label="`Zoom slide ${i+1}`" tabindex="-1">
                                <img :src="s.img" alt="" aria-hidden="true" class="hp-ss-img-bg">
                                <img :src="s.img" :alt="s.name" class="hp-ss-img">
                            </button>
                            <template x-if="s.discountPct">
                                <div class="hp-ss-badge"><span x-text="`−${s.discountPct}%`"></span></div>
                            </template>
                            <template x-if="s.titleEn || s.price">
                                <div class="hp-ss-caption">
                                    <div class="hp-ss-info">
                                        <template x-if="s.category">
                                            <div class="hp-ss-eyebrow" x-text="s.category"></div>
                                        </template>
                                        <template x-if="s.titleEn">
                                            <div class="hp-ss-title"
                                                 :data-en="s.titleEn"
                                                 :data-km="s.titleKm"
                                                 :data-zh="s.titleZh"
                                                 x-text="s.titleEn"></div>
                                        </template>
                                        <template x-if="s.price">
                                            <div class="hp-ss-price-row">
                                                <span class="hp-ss-price" x-text="s.price"></span>
                                                <template x-if="s.orig">
                                                    <span class="hp-ss-orig" x-text="s.orig"></span>
                                                </template>
                                                <template x-if="s.savings">
                                                    <span class="hp-ss-save"><span data-en="Save" data-km="សន្សំ" data-zh="省">Save</span> <span x-text="s.savings"></span></span>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                    <template x-if="s.url">
                                        <a :href="s.url" class="hp-ss-btn"
                                           data-en="Shop →" data-km="ទិញ →" data-zh="选购 →"
                                           @click.stop>Shop →</a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="slides.length > 1">
                        <button type="button" class="hp-ss-arrow hp-ss-prev" @click.stop="prev()" aria-label="Previous">‹</button>
                    </template>
                    <template x-if="slides.length > 1">
                        <button type="button" class="hp-ss-arrow hp-ss-next" @click.stop="next()" aria-label="Next">›</button>
                    </template>
                </div>

                @if($ssThumbs)
                <template x-if="slides.length > 1">
                    <div class="hp-ss-thumbs" x-ref="thumbs">
                        <template x-for="(s, i) in slides" :key="i">
                            <button type="button" class="hp-ss-thumb" :class="{ 'is-on': active === i }"
                                    @click="go(i)" :aria-label="`Slide ${i+1}`">
                                <img :src="s.img" :alt="s.name">
                            </button>
                        </template>
                    </div>
                </template>
                @endif
            </div>

            {{-- Zoom lightbox --}}
            <div class="hp-lightbox" x-show="zoom.open" x-cloak
                 @click.self="closeZoom()"
                 x-transition.opacity>
                <button type="button" class="hp-lightbox-close" @click="closeZoom()" aria-label="Close">×</button>
                <img :src="zoom.img" :alt="zoom.alt" class="hp-lightbox-img">
            </div>
        </section>
    @endif

    {{-- ─────────────────────────────────────────────  ②  SMARTPHONES  ─── --}}
    @if($smartphones->isNotEmpty())
    <section class="shop-section" style="background:var(--bg2)">
        <div class="inner">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:8px">
                <div>
                    <div class="sec-eyebrow"
                         data-en="📱 Smartphones"
                         data-km="📱 ទូរស័ព្ទស្មាតហ្វូន"
                         data-zh="📱 智能手机">📱 Smartphones</div>
                    <h2 class="sec-h"
                        data-en="iPhone — Power in your pocket"
                        data-km="iPhone — ថាមពលនៅក្នុងហោប៉ៅ"
                        data-zh="iPhone — 口袋中的强大力量">iPhone — Power in your pocket</h2>
                </div>
                <a href="{{ route('shop') }}?category=smartphones" class="btn btn-blue"
                   data-en="View All iPhones →"
                   data-km="មើល iPhone ទាំងអស់ →"
                   data-zh="查看所有 iPhone →">View All iPhones →</a>
            </div>
            <div class="pgrid" style="margin-top:20px">
                @foreach($smartphones as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─────────────────────────────────────────  ④  TABLETS / iPad  ─── --}}
    @if($tablets->isNotEmpty())
    <section class="shop-section" style="background:var(--bg)">
        <div class="inner">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:8px">
                <div>
                    <div class="sec-eyebrow"
                         data-en="📲 Tablets &amp; iPad"
                         data-km="📲 Tablet និង iPad"
                         data-zh="📲 平板电脑和 iPad">📲 Tablets &amp; iPad</div>
                    <h2 class="sec-h"
                        data-en="iPad — Your canvas, your stage"
                        data-km="iPad — ផ្ទាំងគំនូរ និងឆាករបស់អ្នក"
                        data-zh="iPad — 您的画布，您的舞台">iPad — Your canvas, your stage</h2>
                </div>
                <a href="{{ route('shop') }}?category=tablets-ipad" class="btn btn-blue"
                   data-en="View All iPads →"
                   data-km="មើល iPad ទាំងអស់ →"
                   data-zh="查看所有 iPad →">View All iPads →</a>
            </div>
            <div class="pgrid" style="margin-top:20px">
                @foreach($tablets as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─────────────────────────────  ⑤  COMPUTER SALES (FB / TikTok)  ─── --}}
    @if($promoCards->isNotEmpty())
        <section class="shop-section promo-feed" style="background:var(--bg2)">
            <div class="inner">
                <div class="sec-eyebrow"
                     data-en="🖥️ Computer Sales · Social Feed"
                     data-km="🖥️ ការលក់កុំព្យូទ័រ · ផ្សាយសង្គម"
                     data-zh="🖥️ 电脑促销 · 社交动态">
                    🖥️ Computer Sales · Social Feed
                </div>
                <h2 class="sec-h"
                    data-en="See what's trending on Facebook &amp; TikTok"
                    data-km="មើលអ្វីដែលកំពុងពេញនិយមនៅលើ Facebook និង TikTok"
                    data-zh="看看 Facebook 和 TikTok 上的热门内容">
                    See what's trending on Facebook &amp; TikTok
                </h2>
                <p class="cat-spot-tagline"
                   data-en="Latest computer deals and announcements from our social channels — tap any card to see the full post."
                   data-km="ការផ្តល់ជូននិងការប្រកាសកុំព្យូទ័រថ្មីបំផុតពីបណ្តាញសង្គមរបស់យើង — ចុចលើកាតណាមួយដើម្បីមើលប្រកាសពេញលេញ។"
                   data-zh="来自我们社交频道的最新电脑优惠和公告 — 点击任何卡片查看完整帖子。">
                    Latest computer deals and announcements from our social channels — tap any card to see the full post.
                </p>

                <div class="promo-feed-grid">
                    @foreach($promoCards as $card)
                        <x-social-promo-card :card="$card" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ────────────────────────────────────────  ⑥  MACBOOK HIGHLIGHTS  ─── --}}
    @php $macbookList = $macbooks->isNotEmpty() ? $macbooks : $featured; @endphp
    @if($macbookList->isNotEmpty())
    <style>
        .top-mac-pick{position:relative}
        .top-mac-ribbon{position:absolute;top:10px;left:50%;transform:translateX(-50%);z-index:3;
            background:linear-gradient(135deg,#B8860B,#E0A722);color:#fff;font-size:11px;font-weight:800;
            letter-spacing:.2px;padding:4px 12px;border-radius:980px;white-space:nowrap;
            box-shadow:0 2px 6px rgba(0,0,0,.2)}
    </style>
    <section class="shop-section" style="background:var(--bg)">
        <div class="inner">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:8px">
                <div>
                    <div class="sec-eyebrow"
                         data-en="💻 MacBook Highlights"
                         data-km="💻 MacBook ល្អៗ"
                         data-zh="💻 MacBook 精选">
                        💻 MacBook Highlights
                    </div>
                    <h2 class="sec-h"
                        data-en="Top MacBooks in Cambodia"
                        data-km="MacBook ល្អបំផុតនៅកម្ពុជា"
                        data-zh="柬埔寨顶级 MacBook">
                        Top MacBooks in Cambodia
                    </h2>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <span style="background:#E3F5E9;color:var(--green);font-size:11px;font-weight:700;padding:4px 12px;border-radius:980px">✓ Official Warranty</span>
                    <span style="background:var(--blue-l);color:var(--blue);font-size:11px;font-weight:700;padding:4px 12px;border-radius:980px">🚀 Same-Day Delivery</span>
                </div>
            </div>
            <div class="pgrid" style="margin-top:20px">
                @foreach($macbookList as $product)
                    @if($product->top_label_en ?? null)
                        <div class="top-mac-pick">
                            <div class="top-mac-ribbon"
                                 data-en="🏆 {{ $product->top_label_en }}"
                                 data-km="🏆 {{ $product->top_label_km ?: $product->top_label_en }}"
                                 data-zh="🏆 {{ $product->top_label_zh ?: $product->top_label_en }}">
                                🏆 {{ $product->top_label_en }}
                            </div>
                            <x-product-card :product="$product" />
                        </div>
                    @else
                        <x-product-card :product="$product" />
                    @endif
                @endforeach
            </div>
            <div style="text-align:center;margin-top:1.5rem">
                <a href="{{ route('shop') }}?category=macbook-pro" class="btn btn-blue"
                   data-en="View All MacBooks →"
                   data-km="មើល MacBook ទាំងអស់ →"
                   data-zh="查看所有 MacBook →">
                    View All MacBooks →
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ───────────────────────────────────────────────────────  ⑦  WHY US  ─── --}}
    <section class="shop-section" style="background:var(--bg2)">
        <div class="inner">
            <div class="sec-eyebrow"
                 data-en="Why SR MAC SHOP"
                 data-km="ហេតុអ្វីជ្រើស SR MAC SHOP"
                 data-zh="为何选择 SR MAC SHOP">
                Why SR MAC SHOP
            </div>
            <h2 class="sec-h"
                data-en="Shop With Confidence"
                data-km="ទិញដោយទំនុកចិត្ត"
                data-zh="放心购物">
                Shop With Confidence
            </h2>
            <div class="why-grid">
                <div class="wcard">
                    <div class="wcard-icon">✅</div>
                    <div class="wcard-t"
                         data-en="100% Authentic"
                         data-km="ពិតប្រាកដ ១០០%"
                         data-zh="100% 正品">100% Authentic</div>
                    <div class="wcard-s"
                         data-en="Official Apple warranty with every device — iPhones, iPads, and MacBooks."
                         data-km="ការធានា Apple ផ្លូវការជាមួយឧបករណ៍គ្រប់គ្រឿង — iPhone, iPad និង MacBook។"
                         data-zh="每台设备均享 Apple 官方保修 — iPhone、iPad 和 MacBook。">
                        Official Apple warranty with every device — iPhones, iPads, and MacBooks.
                    </div>
                </div>
                <div class="wcard">
                    <div class="wcard-icon">🚀</div>
                    <div class="wcard-t"
                         data-en="Same-Day Delivery"
                         data-km="ដឹកជញ្ជូនក្នុងថ្ងៃ"
                         data-zh="当日送达">Same-Day Delivery</div>
                    <div class="wcard-s"
                         data-en="Order before 2PM, delivered same day in Phnom Penh."
                         data-km="បញ្ជាទិញមុនម៉ោង ២ ទទួលបានថ្ងៃនេះ។"
                         data-zh="下午 2 点前下单，金边当日送达。">
                        Order before 2PM, delivered same day in Phnom Penh.
                    </div>
                </div>
                <div class="wcard">
                    <div class="wcard-icon">💰</div>
                    <div class="wcard-t"
                         data-en="Best Price Guarantee"
                         data-km="ធានាតម្លៃល្អបំផុត"
                         data-zh="最优价格保证">Best Price Guarantee</div>
                    <div class="wcard-s"
                         data-en="We beat any lower price — guaranteed."
                         data-km="យើងប្រកួតតម្លៃ — ធានា។"
                         data-zh="保证最优价格，发现更低价我们再让利。">
                        We beat any lower price — guaranteed.
                    </div>
                </div>
                <div class="wcard">
                    <div class="wcard-icon">🔧</div>
                    <div class="wcard-t"
                         data-en="After-Sales Support"
                         data-km="គាំទ្រក្រោយការលក់"
                         data-zh="售后支持">After-Sales Support</div>
                    <div class="wcard-s"
                         data-en="Free setup, data transfer &amp; 24/7 WhatsApp support."
                         data-km="ដំឡើងឥតគិតថ្លៃ ផ្ទេរទិន្នន័យ &amp; WhatsApp ២៤/៧។"
                         data-zh="免费设置、数据迁移和 24/7 WhatsApp 支持。">
                        Free setup, data transfer &amp; 24/7 WhatsApp support.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
