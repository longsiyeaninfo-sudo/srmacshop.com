@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Think Different. Buy Smarter.')
@section('description', 'Buy authentic MacBooks in Cambodia with official Apple warranty. MacBook Air, MacBook Pro with M3/M4 chips. Same-day delivery in Phnom Penh. Best prices guaranteed.')

@section('content')
    {{-- HERO --}}
    <div class="hero">
        <div class="hero-mesh"></div>
        <div class="hero-content">
            <div class="hero-pill" data-en="🍎 SR MAC SHOP — Apple Hardware &amp; Care" data-km="អ្នកជំនាញ MacBook លេខ១ នៅកម្ពុជា" data-zh="🍎 SR MAC SHOP — Apple 硬件与售后">🍎 SR MAC SHOP — Apple Hardware &amp; Care</div>
            <h1>
                <span class="grad" data-en="Think Different." data-km="គិតខុសគេ។" data-zh="非同凡想。">Think Different.</span><br>
                <span data-en="Buy Smarter." data-km="ទិញឆ្លាតជាង។" data-zh="智慧购物。">Buy Smarter.</span>
            </h1>
            <p class="hero-sub" data-en="Authentic Apple MacBooks with official warranty. Best prices in Phnom Penh. Same-day delivery available." data-km="MacBook Apple ពិតប្រាកដ មានការធានា Apple ផ្លូវការ។ តម្លៃល្អបំផុត នៅភ្នំពេញ។ ដឹកជញ្ជូនបានក្នុងថ្ងៃ។" data-zh="正品 Apple MacBook，官方保修。金边最优价格。当日送达。">
                Authentic Apple MacBooks with official warranty. Best prices in Phnom Penh. Same-day delivery available.
            </p>
            <div class="hero-btns">
                <a href="{{ route('shop') }}" class="btn btn-blue" data-en="Shop Now →" data-km="ទិញឥឡូវ →" data-zh="立即选购 →">Shop Now →</a>
                <a href="{{ route('contact') }}" class="btn" style="background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.14);backdrop-filter:blur(10px)"
                    data-en="Contact Us" data-km="ទំនាក់ទំនង" data-zh="联系我们">Contact Us</a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hstat-n">500+</div>
                    <div class="hstat-l" data-en="Happy Customers" data-km="អតិថិជន" data-zh="满意客户">Happy Customers</div>
                </div>
                <div>
                    <div class="hstat-n">100%</div>
                    <div class="hstat-l" data-en="Authentic" data-km="ពិតប្រាកដ" data-zh="正品">Authentic</div>
                </div>
                <div>
                    <div class="hstat-n">2yr</div>
                    <div class="hstat-l" data-en="Warranty" data-km="ការធានា" data-zh="保修">Warranty</div>
                </div>
                <div>
                    <div class="hstat-n">24/7</div>
                    <div class="hstat-l" data-en="Support" data-km="គាំទ្រ" data-zh="支持">Support</div>
                </div>
            </div>
            {{-- Product spotlight pills --}}
            <div class="spot-row">
                <a href="{{ route('shop') }}?category=macbook-air" class="spot-card">
                    <span class="spot-card-emoji">💻</span>
                    <div style="text-align:left">
                        <div class="spot-card-title">MacBook Air M4</div>
                        <div class="spot-card-meta">From $1,099</div>
                    </div>
                </a>
                <a href="{{ route('shop') }}?category=macbook-pro" class="spot-card">
                    <span class="spot-card-emoji">🖥️</span>
                    <div style="text-align:left">
                        <div class="spot-card-title">MacBook Pro M4</div>
                        <div class="spot-card-meta">From $1,555</div>
                    </div>
                </a>
                <a href="{{ route('shop') }}?category=protection" class="spot-card">
                    <span class="spot-card-emoji">🛡️</span>
                    <div style="text-align:left">
                        <div class="spot-card-title">AppleCare+</div>
                        <div class="spot-card-meta">3-Year Coverage</div>
                    </div>
                </a>
                <a href="https://wa.me/85598334755" class="spot-card" target="_blank" rel="noopener">
                    <span class="spot-card-emoji">💬</span>
                    <div style="text-align:left">
                        <div class="spot-card-title">WhatsApp Us</div>
                        <div class="spot-card-meta">+855 98 33 47 55</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

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
