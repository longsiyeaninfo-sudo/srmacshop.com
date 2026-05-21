@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Think Different. Buy Smarter.')
@section('description', 'Buy authentic MacBooks in Cambodia with official Apple warranty. MacBook Air, MacBook Pro with M3/M4 chips. Same-day delivery in Phnom Penh. Best prices guaranteed.')

@section('content')
    {{-- HERO — macOS Sonoma Window (frosted glass + aurora wallpaper) --}}
    @php
        $hp = $headline ?? null;
        $hpPriceCents  = ($promo['headline_price'] ?? null) ?: ($hp->price ?? 0);
        $hpOrigCents   = $hp->original_price ?? null;
        $hpEndsAt      = $promo['headline_ends_at'] ?? optional($hp?->sale_ends_at)->toIso8601String();

        // Pre-compute slide data for Alpine JSON
        $heroSlideData = [];
        foreach ($heroSlides ?? [] as $i => $s) {
            $isHead    = ($i === 0);
            $pCents    = $isHead ? $hpPriceCents : $s->price;
            $oCents    = $isHead ? $hpOrigCents  : ($s->original_price ?? null);
            $endsAt    = $isHead ? ($hpEndsAt ?? '') : (optional($s->sale_ends_at)->toIso8601String() ?? '');
            $savingCts = ($oCents && $oCents > $pCents) ? $oCents - $pCents : 0;
            $heroSlideData[] = [
                'name'      => $s->name,
                'spec'      => $s->spec ?? '',
                'price'     => '$' . number_format($pCents / 100, 0),
                'orig'      => ($oCents && $oCents > $pCents) ? '$' . number_format($oCents / 100, 0) : '',
                'saving'    => $savingCts > 0 ? 'SAVE $' . number_format($savingCts / 100, 0) : '',
                'endsAt'    => $endsAt,
                'url'       => route('product', $s->slug),
                'pretextEn' => $isHead ? ($promo['headline_text']    ?? "🔥 Today's Deal")          : '⚡ Flash Deal',
                'pretextKm' => $isHead ? ($promo['headline_text_km'] ?? "🔥 ការផ្តល់ជូនថ្ងៃនេះ") : '⚡ ការផ្តល់ជូនរហ័ស',
                'pretextZh' => $isHead ? ($promo['headline_text_zh'] ?? "🔥 今日特惠")               : '⚡ 限时特惠',
            ];
        }
        $heroSlidesJson = json_encode($heroSlideData, JSON_HEX_TAG | JSON_HEX_APOS);
        $slide0 = $heroSlideData[0] ?? null;
    @endphp

    <div class="hero hp-hero"
        x-data='{
            slides: {{ $heroSlidesJson }},
            active: 0,
            _t: null,
            paused: false,
            _ts: 0,
            get cur() { return this.slides[this.active] || {} },
            next() { this.active = (this.active + 1) % this.slides.length; this._reset(); },
            prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length; this._reset(); },
            go(n) { this.active = n; this._reset(); },
            pause() { this.paused = true; },
            resume() { this.paused = false; },
            _reset() { clearInterval(this._t); this._start(); },
            _start() { if (this.slides.length > 1) this._t = setInterval(() => { if (!this.paused) this.next(); }, 4500); },
            init() {
                this._start();
                this.$nextTick(() => { const ls = window.Alpine?.store("lang"); if (ls) ls.apply(ls.current); });
                this.$watch("active", () => {
                    this.$nextTick(() => { const ls = window.Alpine?.store("lang"); if (ls) ls.apply(ls.current); });
                });
            }
        }'
        @mouseenter="pause()" @mouseleave="resume()">
        <div class="hero-mesh"></div>

        {{-- Aurora wallpaper background (animated) --}}
        <div class="hp-aurora" aria-hidden="true"></div>
        <div class="hp-aurora-grain" aria-hidden="true"></div>

        {{-- macOS-style frosted glass window --}}
        <div class="hp-window">

            {{-- Title bar with traffic lights --}}
            <div class="hp-window-bar">
                <div class="hp-window-dots" aria-hidden="true">
                    <span class="hp-dot hp-dot-r"></span>
                    <span class="hp-dot hp-dot-y"></span>
                    <span class="hp-dot hp-dot-g"></span>
                </div>
                <div class="hp-window-title">SR MAC SHOP — <span data-en="Featured" data-km="ផ្ដល់ជូនពិសេស" data-zh="精选">Featured</span></div>
            </div>

            {{-- Window body: copy LEFT, media RIGHT --}}
            <div class="hp-window-body">

                {{-- ── Copy side ── --}}
                <div class="hp-hero-copy">
                    @if(!empty($heroSlideData))
                        {{-- Pretext badge (multilingual) --}}
                        <div class="hp-hero-pretext"
                            :data-en="cur.pretextEn" :data-km="cur.pretextKm" :data-zh="cur.pretextZh"
                            data-en="{{ $slide0['pretextEn'] ?? "🔥 Today's Deal" }}"
                            data-km="{{ $slide0['pretextKm'] ?? "🔥 ការផ្តល់ជូនថ្ងៃនេះ" }}"
                            data-zh="{{ $slide0['pretextZh'] ?? "🔥 今日特惠" }}">{{ $slide0['pretextEn'] ?? "🔥 Today's Deal" }}</div>

                        {{-- Product name + spec --}}
                        <h1 class="hp-hero-h" x-text="cur.name">{{ $slide0['name'] ?? '' }}</h1>
                        <p class="hp-hero-spec" x-show="cur.spec" x-text="cur.spec"
                           style="{{ $slide0 && $slide0['spec'] ? '' : 'display:none' }}">{{ $slide0['spec'] ?? '' }}</p>

                        {{-- Prices --}}
                        <div class="hp-hero-prices">
                            <span class="hp-hero-price" x-text="cur.price">{{ $slide0['price'] ?? '' }}</span>
                            <span class="hp-hero-strike" x-show="cur.orig" x-text="cur.orig"
                                  style="{{ $slide0 && $slide0['orig'] ? '' : 'display:none' }}">{{ $slide0['orig'] ?? '' }}</span>
                        </div>

                        {{-- Countdown --}}
                        <div class="hp-hero-countdown" :data-countdown="cur.endsAt" x-show="cur.endsAt"
                             style="{{ $slide0 && $slide0['endsAt'] ? '' : 'display:none' }}"
                             data-countdown="{{ $slide0['endsAt'] ?? '' }}">
                            <span data-en="Ends in" data-km="បញ្ចប់ក្នុង" data-zh="结束于">Ends in</span>
                            <span class="hp-hero-cdtimer">…</span>
                        </div>

                        {{-- CTA buttons --}}
                        <div class="hp-hero-cta">
                            <a :href="cur.url" href="{{ $slide0['url'] ?? route('shop') }}" class="hp-hero-btn-buy"
                               data-en="🛒 Order Now →" data-km="🛒 បញ្ជាទិញឥឡូវ →" data-zh="🛒 立即订购 →">
                                🛒 Order Now →
                            </a>
                            <a href="{{ route('shop') }}" class="hp-hero-btn-ghost"
                               data-en="See all MacBooks" data-km="មើល MacBook ទាំងអស់" data-zh="查看所有 MacBook">
                                See all MacBooks
                            </a>
                        </div>

                    @else
                        {{-- Fallback: no products configured --}}
                        <div class="hp-hero-pretext"
                            data-en="🍎 Premium MacBooks" data-km="🍎 MacBook ពិតប្រាកដ" data-zh="🍎 优质 MacBook">
                            🍎 Premium MacBooks</div>
                        <h1 class="hp-hero-h"
                            data-en="Think Different. Buy Smarter."
                            data-km="គិតខុសគេ ទិញឆ្លាតជាង។"
                            data-zh="非同凡想。智慧购物。">Think Different. Buy Smarter.</h1>
                        <p class="hp-hero-spec"
                            data-en="Authentic Apple MacBooks. Same-day delivery in Phnom Penh."
                            data-km="MacBook Apple ពិតប្រាកដ ដឹកជញ្ជូនបានក្នុងថ្ងៃ នៅភ្នំពេញ។"
                            data-zh="正品 Apple MacBook。金边当日送达。">Authentic Apple MacBooks. Same-day delivery in Phnom Penh.</p>
                        <div class="hp-hero-cta">
                            <a href="{{ route('shop') }}" class="hp-hero-btn-buy"
                               data-en="🛒 Shop Now →" data-km="🛒 ទិញឥឡូវ →" data-zh="🛒 立即选购 →">🛒 Shop Now →</a>
                        </div>
                    @endif
                </div>

                {{-- ── Media / Slideshow side ── --}}
                @if(!empty($heroSlideData))
                <div class="hp-hero-media"
                     @touchstart.passive="_ts = $event.touches[0].clientX"
                     @touchend.passive="const d = $event.changedTouches[0].clientX - _ts; if (Math.abs(d) > 50) { d < 0 ? next() : prev(); }">

                    @foreach($heroSlides as $i => $s)
                    @php $sImg = $s->getFirstMediaUrl('gallery'); @endphp
                    <div class="hs-slide {{ $i === 0 ? 'hs-active' : '' }}"
                         :class="{ 'hs-active': active === {{ $i }} }">
                        @if($sImg)
                            <img src="{{ $sImg }}" alt="{{ $s->name }}" class="hp-hero-img"
                                 {{ $i === 0 ? 'loading="eager"' : 'loading="lazy"' }}>
                        @else
                            <div class="hp-hero-emoji">{{ $s->emoji ?: '💻' }}</div>
                        @endif
                    </div>
                    @endforeach

                    {{-- SAVE badge --}}
                    <div class="hp-hero-saving-badge" x-show="cur.saving" x-text="cur.saving"
                         style="{{ $slide0 && $slide0['saving'] ? '' : 'display:none' }}"></div>

                    {{-- Dots + arrows (only when >1 slide) --}}
                    @if(count($heroSlideData) > 1)
                    <div class="hs-dots">
                        @foreach($heroSlideData as $i => $s)
                        <button class="hs-dot {{ $i === 0 ? 'hs-dot-on' : '' }}"
                                :class="{ 'hs-dot-on': active === {{ $i }} }"
                                @click.stop="go({{ $i }})" aria-label="Slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>
                    <button class="hs-arrow hs-prev" @click.stop="prev()" aria-label="Previous">‹</button>
                    <button class="hs-arrow hs-next" @click.stop="next()" aria-label="Next">›</button>
                    @endif
                </div>
                @endif

            </div> {{-- /.hp-window-body --}}
        </div> {{-- /.hp-window --}}

        {{-- Dock-style trust stats (frosted pill below window) --}}
        <div class="hp-dock">
            <div class="hp-dock-item"><b>500+</b> <span data-en="Customers" data-km="អតិថិជន" data-zh="客户">Customers</span></div>
            <div class="hp-dock-item"><b>100%</b> <span data-en="Authentic" data-km="ពិតប្រាកដ" data-zh="正品">Authentic</span></div>
            <div class="hp-dock-item"><b>2yr</b> <span data-en="Warranty" data-km="ការធានា" data-zh="保修">Warranty</span></div>
            <div class="hp-dock-item"><b>24/7</b> <span data-en="Support" data-km="គាំទ្រ" data-zh="支持">Support</span></div>
        </div>

    </div>

    {{-- FEATURED PRODUCTS --}}
    <section class="shop-section" style="background:var(--bg2)">
        <div class="inner">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:8px">
                <div>
                    <div class="sec-eyebrow" data-en="🔥 Best Sellers" data-km="🔥 លក់ដាច់បំផុត">🔥 Best Sellers</div>
                    <h2 class="sec-h" data-en="Top MacBooks in Cambodia 2025" data-km="MacBook ល្អបំផុត នៅកម្ពុជា ២០២៥">Top MacBooks in Cambodia 2025</h2>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <span style="background:#E3F5E9;color:var(--green);font-size:11px;font-weight:700;padding:4px 12px;border-radius:980px">✓ Official Warranty</span>
                    <span style="background:var(--blue-l);color:var(--blue);font-size:11px;font-weight:700;padding:4px 12px;border-radius:980px">🚀 Same-Day Delivery</span>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:18px;margin-top:20px">
                @foreach($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div style="text-align:center;margin-top:1.5rem">
                <a href="{{ route('shop') }}" class="btn btn-blue" data-en="View All Products →" data-km="មើលទាំងអស់ →">View All Products →</a>
            </div>
        </div>
    </section>

    {{-- WHY US --}}
    <section class="shop-section" style="background:var(--bg)">
        <div class="inner">
            <div class="sec-eyebrow" data-en="Why SR MAC SHOP" data-km="ហេតុអ្វីជ្រើស SR MAC SHOP">Why SR MAC SHOP</div>
            <h2 class="sec-h" data-en="Shop With Confidence" data-km="ទិញដោយទំនុកចិត្ត">Shop With Confidence</h2>
            <div class="why-grid">
                <div class="wcard">
                    <div class="wcard-icon">✅</div>
                    <div class="wcard-t" data-en="100% Authentic" data-km="ពិតប្រាកដ ១០០%">100% Authentic</div>
                    <div class="wcard-s" data-en="Official Apple warranty with every MacBook." data-km="ការធានា Apple ផ្លូវការជាមួយ MacBook គ្រប់គ្រឿង។">Official Apple warranty with every MacBook.</div>
                </div>
                <div class="wcard">
                    <div class="wcard-icon">🚀</div>
                    <div class="wcard-t" data-en="Same-Day Delivery" data-km="ដឹកជញ្ជូនក្នុងថ្ងៃ">Same-Day Delivery</div>
                    <div class="wcard-s" data-en="Order before 2PM, delivered same day in Phnom Penh." data-km="បញ្ជាទិញមុន ម៉ោង ២ ទទួលបានថ្ងៃនេះ។">Order before 2PM, delivered same day in Phnom Penh.</div>
                </div>
                <div class="wcard">
                    <div class="wcard-icon">💰</div>
                    <div class="wcard-t" data-en="Best Price Guarantee" data-km="ធានាតម្លៃល្អបំផុត">Best Price Guarantee</div>
                    <div class="wcard-s" data-en="We beat any lower price — guaranteed." data-km="យើងប្រកួតតម្លៃ — ធានា។">We beat any lower price — guaranteed.</div>
                </div>
                <div class="wcard">
                    <div class="wcard-icon">🔧</div>
                    <div class="wcard-t" data-en="After-Sales Support" data-km="គាំទ្រក្រោយការលក់">After-Sales Support</div>
                    <div class="wcard-s" data-en="Free setup, data transfer &amp; 24/7 WhatsApp support." data-km="ដំឡើងឥតគិតថ្លៃ ផ្ទេរទិន្នន័យ &amp; WhatsApp ២៤/៧។">Free setup, data transfer &amp; 24/7 WhatsApp support.</div>
                </div>
            </div>
        </div>
    </section>
@endsection
