@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Think Different. Buy Smarter.')
@section('description', 'Buy authentic MacBooks in Cambodia with official Apple warranty. MacBook Air, MacBook Pro with M3/M4 chips. Same-day delivery in Phnom Penh. Best prices guaranteed.')

@section('content')
    {{-- HERO — sales-focused, mobile-first --}}
    @php
        $hp = $headline ?? null;
        $hpImg = $hp ? $hp->getFirstMediaUrl('gallery') : '';
        // Resolve the displayed price: admin override (cents in $promo['headline_price']) > product price
        $hpPriceCents  = ($promo['headline_price'] ?? null) ?: ($hp->price ?? 0);
        $hpOrigCents   = $hp->original_price ?? null;
        $hpEndsAt      = $promo['headline_ends_at'] ?? optional($hp?->sale_ends_at)->toIso8601String();
        $hpSavingCents = ($hpOrigCents && $hpOrigCents > $hpPriceCents) ? ($hpOrigCents - $hpPriceCents) : 0;
        $hpPretextEn   = $promo['headline_text']    ?? "🔥 Today's Deal";
        $hpPretextKm   = $promo['headline_text_km'] ?? "🔥 ការផ្តល់ជូនថ្ងៃនេះ";
        $hpPretextZh   = $promo['headline_text_zh'] ?? "🔥 今日特惠";
    @endphp

    <div class="hero hp-hero">
        <div class="hero-mesh"></div>
        <div class="hp-hero-inner">
            {{-- Media side --}}
            @if($hp)
            <div class="hp-hero-media">
                @if($hpImg)
                    <img src="{{ $hpImg }}" alt="{{ $hp->name }}" class="hp-hero-img" loading="eager">
                @else
                    <div class="hp-hero-emoji">{{ $hp->emoji ?: '💻' }}</div>
                @endif
                @if($hpSavingCents > 0)
                    <div class="hp-hero-saving-badge">SAVE&nbsp;${{ number_format($hpSavingCents / 100, 0) }}</div>
                @endif
            </div>
            @endif

            {{-- Copy side --}}
            <div class="hp-hero-copy">
                <div class="hp-hero-pretext"
                    data-en="{{ $hpPretextEn }}"
                    data-km="{{ $hpPretextKm }}"
                    data-zh="{{ $hpPretextZh }}">{{ $hpPretextEn }}</div>

                @if($hp)
                    <h1 class="hp-hero-h">{{ $hp->name }}</h1>
                    @if($hp->spec)
                        <p class="hp-hero-spec">{{ $hp->spec }}</p>
                    @endif
                    <div class="hp-hero-prices">
                        <span class="hp-hero-price">${{ number_format($hpPriceCents / 100, 0) }}</span>
                        @if($hpOrigCents && $hpOrigCents > $hpPriceCents)
                            <span class="hp-hero-strike">${{ number_format($hpOrigCents / 100, 0) }}</span>
                        @endif
                    </div>

                    {{-- Countdown timer --}}
                    @if($hpEndsAt)
                        <div class="hp-hero-countdown" data-countdown="{{ $hpEndsAt }}">
                            <span data-en="Ends in" data-km="បញ្ចប់ក្នុង" data-zh="结束于">Ends in</span>
                            <span class="hp-hero-cdtimer">…</span>
                        </div>
                    @endif

                    <div class="hp-hero-cta">
                        <a href="{{ route('product', $hp->slug) }}" class="hp-hero-btn-buy"
                            data-en="🛒 Order Now →" data-km="🛒 បញ្ជាទិញឥឡូវ →" data-zh="🛒 立即订购 →">
                            🛒 Order Now →
                        </a>
                        <a href="{{ route('shop') }}" class="hp-hero-btn-ghost"
                            data-en="See all MacBooks" data-km="មើល MacBook ទាំងអស់" data-zh="查看所有 MacBook">See all MacBooks</a>
                    </div>
                @else
                    {{-- Fallback if there's no product to feature --}}
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

                {{-- Trust stats (compact on mobile) --}}
                <div class="hp-hero-stats">
                    <div><b>500+</b> <span data-en="Customers" data-km="អតិថិជន" data-zh="客户">Customers</span></div>
                    <div><b>100%</b> <span data-en="Authentic" data-km="ពិតប្រាកដ" data-zh="正品">Authentic</span></div>
                    <div><b>2yr</b> <span data-en="Warranty" data-km="ការធានា" data-zh="保修">Warranty</span></div>
                    <div><b>24/7</b> <span data-en="Support" data-km="គាំទ្រ" data-zh="支持">Support</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ⚡ FLASH DEALS — swipeable reel (FB/TikTok style) --}}
    @if(($promo['flash_deals_enabled'] ?? true) && $flashDeals->count() > 0)
    <section class="fd-section reveal">
        <div class="fd-head">
            <div>
                <div class="fd-eyebrow" data-en="⚡ Flash Deals" data-km="⚡ ការផ្តល់ជូនរហ័ស" data-zh="⚡ 限时特惠">⚡ Flash Deals</div>
                <h2 class="fd-h" data-en="Limited time. Limited stock." data-km="មានកំណត់ពេលវេលា មានកំណត់ស្តុក។" data-zh="限时限量。">Limited time. Limited stock.</h2>
            </div>
            <a href="{{ route('shop') }}" class="fd-see-all"
                data-en="See all →" data-km="មើលទាំងអស់ →" data-zh="查看全部 →">See all →</a>
        </div>

        <div class="fd-row">
            @foreach($flashDeals as $deal)
                <x-flash-deal-card :product="$deal" />
            @endforeach
        </div>
    </section>
    @endif

    {{-- FEATURED PRODUCTS --}}
    <section class="shop-section reveal" style="background:var(--bg2)">
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
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:24px;margin-top:20px">
                @foreach($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div style="text-align:center;margin-top:1.5rem">
                <a href="{{ route('shop') }}" class="btn btn-blue" data-en="View All Products →" data-km="មើលទាំងអស់ →">View All Products →</a>
            </div>
        </div>
    </section>

    {{-- FEATURED SPOTLIGHT BAND (apple.com signature) --}}
    <section class="spotlight-band reveal">
        <div class="spotlight-band-inner">
            <div class="spotlight-eyebrow" data-en="New" data-km="ថ្មី">New</div>
            <h2 class="spotlight-h" data-en="MacBook Air M4." data-km="MacBook Air M4។">MacBook Air M4.</h2>
            <p class="spotlight-sub" data-en="The everyday laptop, supercharged by Apple silicon. Now starting at $1,099." data-km="កុំព្យូទ័រយួរដៃប្រចាំថ្ងៃ ដែលបានពង្រឹងដោយ Apple silicon។ ចាប់ផ្ដើមពី $1,099។">The everyday laptop, supercharged by Apple silicon. Now starting at $1,099.</p>
            <div class="spotlight-img">💻</div>
            <div class="spotlight-actions">
                <a href="{{ route('shop') }}?category=macbook-air" data-en="Buy →" data-km="ទិញ →">Buy →</a>
                <a href="{{ route('contact') }}" data-en="Learn more →" data-km="ស្វែងយល់បន្ថែម →">Learn more →</a>
            </div>
        </div>
    </section>

    {{-- HOW TO ORDER --}}
    <section class="shop-section reveal" style="background:var(--bg2)">
        <div class="inner">
            <div style="text-align:center;margin-bottom:0">
                <div class="sec-eyebrow" data-en="How It Works" data-km="វិធីដំណើរការ">How It Works</div>
                <h2 class="sec-h" data-en="Order in 4 simple steps" data-km="ការបញ្ជាទិញក្នុង ៤ ជំហានសាមញ្ញ">Order in 4 simple steps</h2>
            </div>
            <div class="how-grid">
                <div class="how-step">
                    <div class="how-step-content">
                        <div class="how-emoji">🔍</div>
                        <div class="how-title" data-en="Browse the catalog" data-km="មើលបញ្ជី">Browse the catalog</div>
                        <div class="how-desc" data-en="Filter by MacBook Air or Pro. Compare specs side by side." data-km="ច្រោះតាម MacBook Air ឬ Pro។ ប្រៀបធៀបលក្ខណៈពិសេស។">Filter by MacBook Air or Pro. Compare specs side by side.</div>
                    </div>
                </div>
                <div class="how-step">
                    <div class="how-step-content">
                        <div class="how-emoji">🛒</div>
                        <div class="how-title" data-en="Add to cart" data-km="បន្ថែមទៅកន្ត្រក">Add to cart</div>
                        <div class="how-desc" data-en="Pick your model. Apply a coupon. See the total instantly." data-km="ជ្រើសរើសម៉ូដែលរបស់អ្នក។ អនុវត្តកូដបញ្ចុះតម្លៃ។">Pick your model. Apply a coupon. See the total instantly.</div>
                    </div>
                </div>
                <div class="how-step">
                    <div class="how-step-content">
                        <div class="how-emoji">✅</div>
                        <div class="how-title" data-en="Confirm your order" data-km="បញ្ជាក់ការបញ្ជាទិញ">Confirm your order</div>
                        <div class="how-desc" data-en="Cash, ABA, or KHQR. Pay your way. We'll call to confirm." data-km="សាច់ប្រាក់ ABA ឬ KHQR។ ទូទាត់តាមរបៀបរបស់អ្នក។">Cash, ABA, or KHQR. Pay your way. We'll call to confirm.</div>
                    </div>
                </div>
                <div class="how-step">
                    <div class="how-step-content">
                        <div class="how-emoji">🚀</div>
                        <div class="how-title" data-en="Same-day delivery" data-km="ដឹកជញ្ជូនថ្ងៃនេះ">Same-day delivery</div>
                        <div class="how-desc" data-en="Order before 2 PM in Phnom Penh and we'll deliver today." data-km="បញ្ជាទិញមុនម៉ោង ២ រសៀលនៅភ្នំពេញ យើងដឹកថ្ងៃនេះ។">Order before 2 PM in Phnom Penh and we'll deliver today.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ✈️ TELEGRAM CHANNEL — banner + embed --}}
    @if($promo['telegram_section_enabled'] ?? true)
    @php
        $tgChannel = ltrim($promo['telegram_channel'] ?? '@srmacshop', '@');
        $tgSubs    = (int) ($promo['telegram_subscribers'] ?? 1200);
        $tgSubsFmt = $tgSubs >= 1000 ? number_format($tgSubs) : $tgSubs;
    @endphp
    <section class="tg-section reveal">
        <div class="tg-inner">
            <div class="tg-banner">
                <div class="tg-banner-left">
                    <svg class="tg-banner-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19l-9.5 6.01-4.1-1.31c-.88-.27-.89-.86.19-1.28L19.27 4.7c.73-.27 1.43.18 1.15 1.28l-3 14.13c-.19.89-.73 1.11-1.48.69L12.46 17l-1.96 1.91c-.23.23-.42.42-.85.42z"/>
                    </svg>
                    <div>
                        <div class="tg-banner-eyebrow" data-en="Telegram" data-km="តេឡេក្រាម" data-zh="Telegram">Telegram</div>
                        <h2 class="tg-banner-h"
                            data-en="Join {{ $tgSubsFmt }}+ MacBook fans on Telegram"
                            data-km="ចូលរួមជាមួយអ្នកគាំទ្រ MacBook {{ $tgSubsFmt }}+ នៅ Telegram"
                            data-zh="加入 {{ $tgSubsFmt }}+ 位 MacBook 粉丝的 Telegram 频道">Join {{ $tgSubsFmt }}+ MacBook fans on Telegram</h2>
                        <p class="tg-banner-sub"
                            data-en="Daily deals, new arrivals, and direct chat with us."
                            data-km="ការផ្តល់ជូនប្រចាំថ្ងៃ និងជជែកដោយផ្ទាល់ជាមួយយើង។"
                            data-zh="每日特惠、新品上架、直接与我们聊天。">Daily deals, new arrivals, and direct chat with us.</p>
                    </div>
                </div>
                <a href="https://t.me/{{ $tgChannel }}" target="_blank" rel="noopener" class="tg-banner-cta">
                    <span data-en="Subscribe →" data-km="តាមដាន →" data-zh="订阅 →">Subscribe →</span>
                </a>
            </div>

            {{-- Embed: Telegram channel preview --}}
            <div class="tg-embed" x-data="{ failed: false }">
                <iframe
                    src="https://t.me/s/{{ $tgChannel }}?embed=1"
                    loading="lazy"
                    title="SR MAC SHOP Telegram channel"
                    x-on:load="failed = false"
                    x-on:error="failed = true"></iframe>
                <div class="tg-embed-fallback" x-show="failed" x-cloak>
                    <p data-en="Open in Telegram to see our latest posts." data-km="បើកនៅ Telegram ដើម្បីមើលការប្រកាសថ្មីៗ។" data-zh="在 Telegram 中打开查看最新动态。">Open in Telegram to see our latest posts.</p>
                    <a href="https://t.me/{{ $tgChannel }}" target="_blank" rel="noopener" class="btn btn-blue"
                        data-en="Open Telegram →" data-km="បើក Telegram →" data-zh="打开 Telegram →">Open Telegram →</a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- TESTIMONIALS --}}
    <x-testimonials-section variant="light" />

    {{-- WHY US --}}
    <section class="shop-section reveal" style="background:var(--bg)">
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
