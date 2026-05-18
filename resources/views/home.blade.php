@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Think Different. Buy Smarter.')
@section('description', 'Buy authentic MacBooks in Cambodia with official Apple warranty. MacBook Air, MacBook Pro with M3/M4 chips. Same-day delivery in Phnom Penh. Best prices guaranteed.')

@section('content')
    {{-- HERO --}}
    <div class="hero">
        <div class="hero-mesh"></div>
        <div class="hero-orb orb1"></div>
        <div class="hero-orb orb2"></div>
        <div class="hero-content">
            <div class="hero-pill" data-en="🍎 SR MAC SHOP — Apple Hardware &amp; Care" data-km="អ្នកជំនាញ MacBook លេខ១ នៅកម្ពុជា">🍎 SR MAC SHOP — Apple Hardware &amp; Care</div>
            <h1>
                <span class="grad" data-en="Think Different." data-km="គិតខុសគេ។">Think Different.</span><br>
                <span data-en="Buy Smarter." data-km="ទិញឆ្លាតជាង។">Buy Smarter.</span>
            </h1>
            <p class="hero-sub" data-en="Authentic Apple MacBooks with official warranty. Best prices in Phnom Penh. Same-day delivery available." data-km="MacBook Apple ពិតប្រាកដ មានការធានា Apple ផ្លូវការ។ តម្លៃល្អបំផុត នៅភ្នំពេញ។ ដឹកជញ្ជូនបានក្នុងថ្ងៃ។">
                Authentic Apple MacBooks with official warranty. Best prices in Phnom Penh. Same-day delivery available.
            </p>
            <div class="hero-btns">
                <a href="{{ route('shop') }}" class="btn btn-blue" data-en="Shop Now →" data-km="ទិញឥឡូវ →">Shop Now →</a>
                <a href="{{ route('contact') }}" class="btn" style="background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.2)"
                    data-en="Contact Us" data-km="ទំនាក់ទំនង">Contact Us</a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hstat-n">500+</div>
                    <div class="hstat-l" data-en="Happy Customers" data-km="អតិថិជន">Happy Customers</div>
                </div>
                <div>
                    <div class="hstat-n">100%</div>
                    <div class="hstat-l" data-en="Authentic" data-km="ពិតប្រាកដ">Authentic</div>
                </div>
                <div>
                    <div class="hstat-n">2yr</div>
                    <div class="hstat-l" data-en="Warranty" data-km="ការធានា">Warranty</div>
                </div>
                <div>
                    <div class="hstat-n">24/7</div>
                    <div class="hstat-l" data-en="Support" data-km="គាំទ្រ">Support</div>
                </div>
            </div>
            {{-- Product Spotlight --}}
            <div style="display:flex;gap:10px;justify-content:center;margin-top:2.5rem;flex-wrap:wrap">
                <a href="{{ route('shop') }}" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:10px 18px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all .2s;backdrop-filter:blur(8px);text-decoration:none"
                    onmouseover="this.style.background='rgba(255,255,255,.15)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                    <span style="font-size:22px">💻</span>
                    <div style="text-align:left"><div style="color:#fff;font-size:12px;font-weight:700">MacBook Air M4</div><div style="color:rgba(255,255,255,.5);font-size:11px">From $1,099</div></div>
                </a>
                <a href="{{ route('shop') }}" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:10px 18px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all .2s;backdrop-filter:blur(8px);text-decoration:none"
                    onmouseover="this.style.background='rgba(255,255,255,.15)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                    <span style="font-size:22px">🖥️</span>
                    <div style="text-align:left"><div style="color:#fff;font-size:12px;font-weight:700">MacBook Pro M4</div><div style="color:rgba(255,255,255,.5);font-size:11px">From $1,555</div></div>
                </a>
                <a href="{{ route('shop') }}" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:10px 18px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all .2s;backdrop-filter:blur(8px);text-decoration:none"
                    onmouseover="this.style.background='rgba(255,255,255,.15)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                    <span style="font-size:22px">🛡️</span>
                    <div style="text-align:left"><div style="color:#fff;font-size:12px;font-weight:700">AppleCare+</div><div style="color:rgba(255,255,255,.5);font-size:11px">3-Year Coverage</div></div>
                </a>
                <a href="{{ route('contact') }}" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:10px 18px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all .2s;backdrop-filter:blur(8px);text-decoration:none"
                    onmouseover="this.style.background='rgba(255,255,255,.15)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
                    <span style="font-size:22px">💬</span>
                    <div style="text-align:left"><div style="color:#fff;font-size:12px;font-weight:700">WhatsApp Us</div><div style="color:rgba(255,255,255,.5);font-size:11px">+855 98 33 47 55</div></div>
                </a>
            </div>
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
