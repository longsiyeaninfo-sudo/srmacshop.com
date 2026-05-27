@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Smartphones, iPads & Apple Devices in Cambodia')
@section('description', "Cambodia's most trusted Apple specialist. Smartphones, iPads, MacBooks with official warranty. Same-day delivery in Phnom Penh. Best prices guaranteed.")

@section('content')
    {{-- ─────────────────────────────────────────────────────── ①  HERO  ─── --}}
    <div class="hero hero-mobile">
        <div class="hero-mesh"></div>
        <div class="hero-orb orb1"></div>
        <div class="hero-orb orb2"></div>
        <div class="hero-content">
            <div class="hero-pill"
                 data-en="📱 New: iPhone &amp; iPad Now Available"
                 data-km="📱 ថ្មី៖ iPhone និង iPad មានហើយ"
                 data-zh="📱 新品：iPhone 和 iPad 现已上市">
                📱 New: iPhone &amp; iPad Now Available
            </div>

            <h1>
                <span class="grad"
                      data-en="The Future of Mobile."
                      data-km="អនាគតនៃទូរស័ព្ទ។"
                      data-zh="移动的未来。">The Future of Mobile.</span><br>
                <span data-en="In Your Hand."
                      data-km="នៅក្នុងដៃរបស់អ្នក។"
                      data-zh="尽在掌中。">In Your Hand.</span>
            </h1>

            <p class="hero-sub"
               data-en="Latest iPhones, iPads, and tablets from Apple — with official warranty, same-day delivery in Phnom Penh, and Cambodia's best after-sales support."
               data-km="iPhone, iPad និង tablet ថ្មីបំផុតពី Apple — ជាមួយការធានាផ្លូវការ ដឹកជញ្ជូនក្នុងថ្ងៃនៅភ្នំពេញ និងការគាំទ្រក្រោយការលក់ដ៏ល្អបំផុតនៅកម្ពុជា។"
               data-zh="最新的 iPhone、iPad 和平板电脑 — 享有官方保修、金边当日送达，以及柬埔寨最佳售后服务。">
                Latest iPhones, iPads, and tablets from Apple — with official warranty, same-day delivery in Phnom Penh, and Cambodia's best after-sales support.
            </p>

            <div class="hero-btns">
                <a href="{{ route('shop') }}?category=smartphones" class="btn btn-blue"
                   data-en="Shop Smartphones →"
                   data-km="ទិញទូរស័ព្ទ →"
                   data-zh="选购智能手机 →">Shop Smartphones →</a>
                <a href="{{ route('shop') }}?category=tablets-ipad" class="btn"
                   style="background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.2)"
                   data-en="Shop iPads →"
                   data-km="ទិញ iPad →"
                   data-zh="选购 iPad →">Shop iPads →</a>
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

            {{-- Spotlight pills --}}
            <div class="hero-spotlight-row">
                <a href="{{ route('shop') }}?category=smartphones" class="hero-spot-pill">
                    <span class="hero-spot-icon" aria-hidden="true">📱</span>
                    <div>
                        <div class="hero-spot-t" data-en="iPhone" data-km="iPhone" data-zh="iPhone">iPhone</div>
                        <div class="hero-spot-s" data-en="Latest models" data-km="ម៉ូដែលថ្មីបំផុត" data-zh="最新型号">Latest models</div>
                    </div>
                </a>
                <a href="{{ route('shop') }}?category=tablets-ipad" class="hero-spot-pill">
                    <span class="hero-spot-icon" aria-hidden="true">📲</span>
                    <div>
                        <div class="hero-spot-t" data-en="iPad" data-km="iPad" data-zh="iPad">iPad</div>
                        <div class="hero-spot-s" data-en="Pro · Air · Mini" data-km="Pro · Air · Mini" data-zh="Pro · Air · Mini">Pro · Air · Mini</div>
                    </div>
                </a>
                <a href="{{ route('shop') }}?category=macbook-pro" class="hero-spot-pill">
                    <span class="hero-spot-icon" aria-hidden="true">💻</span>
                    <div>
                        <div class="hero-spot-t" data-en="MacBook" data-km="MacBook" data-zh="MacBook">MacBook</div>
                        <div class="hero-spot-s" data-en="Air &amp; Pro" data-km="Air និង Pro" data-zh="Air 和 Pro">Air &amp; Pro</div>
                    </div>
                </a>
                <a href="{{ route('contact') }}" class="hero-spot-pill">
                    <span class="hero-spot-icon" aria-hidden="true">💬</span>
                    <div>
                        <div class="hero-spot-t" data-en="WhatsApp" data-km="WhatsApp" data-zh="WhatsApp">WhatsApp</div>
                        <div class="hero-spot-s">+855 98 33 47 55</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- ─────────────────────────────  ④  COMPUTER SALES (FB / TikTok)  ─── --}}
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
                    <x-product-card :product="$product" />
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
