<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seo        = \App\Models\Setting::get('site.seo', []) ?: [];
        $seoTitle   = $seo['default_title']    ?? 'SR MAC SHOP — Think Different. Buy Smarter.';
        $seoDesc    = $seo['meta_description'] ?? 'Buy authentic MacBooks, iPhones & iPads in Cambodia with official Apple warranty. Same-day delivery in Phnom Penh.';
        $seoSuffix  = $seo['title_suffix']     ?? '';
        $seoOgImg   = isset($seo['og_image_path']) && $seo['og_image_path']
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($seo['og_image_path'])
            : asset('og-image.jpg');
        $seoGaId    = $seo['google_analytics_id'] ?? config('services.analytics.google_id', '');
        $seoFbPixel = $seo['facebook_pixel_id']   ?? config('services.analytics.facebook_pixel', '');
        $storeBrand = (\App\Models\Setting::get('site.branding', []) ?: []);
        $siteName   = ($storeBrand['logo_prefix'] ?? 'SR') . ' ' . ($storeBrand['logo_text'] ?? 'MAC SHOP');
    @endphp
    <title>@yield('title', $seoTitle)</title>
    <meta name="description" content="@yield('description', $seoDesc)">
    <meta name="keywords" content="MacBook Cambodia, MacBook Phnom Penh, Apple Cambodia, MacBook Air, MacBook Pro, M3, M4, ម៉ាក់ប៊ុក, ភ្នំពេញ">
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $siteName }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $seoTitle)">
    <meta property="og:description" content="@yield('description', $seoDesc)">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $seoOgImg }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seoTitle)">
    <meta name="twitter:description" content="@yield('description', $seoDesc)">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">
    <link rel="icon" href="{{ \App\Models\Setting::logoUrl() }}">

    {{-- iOS / Android browser chrome tinting --}}
    <meta name="theme-color" content="#0a0a0a" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">

    {{-- Prevent dark flash --}}
    <script>!function(){var t=localStorage.getItem('srmac_theme')||'light';document.documentElement.setAttribute('data-theme',t)}()</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Iconify icons (used for flag icons in language switcher) --}}
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js" defer></script>

    {{-- Theme accent color override (admin-controlled) --}}
    @php $themeAccent = (\App\Models\Setting::get('site.theme', []) ?: [])['accent_color'] ?? null; @endphp
    @if($themeAccent && strtoupper($themeAccent) !== '#007AFF')
    <style>:root{--blue:{{ $themeAccent }};}</style>
    @endif

    {{-- Google Analytics (set via Admin › Settings › SEO) --}}
    @if($seoGaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoGaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $seoGaId }}');
    </script>
    @endif

    {{-- Facebook Pixel (set via Admin › Settings › SEO) --}}
    @if($seoFbPixel)
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $seoFbPixel }}');
        fbq('track', 'PageView');
    </script>
    @endif

    {{-- Image copy deterrents (the baked watermark is the real protection; this just stops casual saving) --}}
    <style>
        img{-webkit-user-drag:none;-khtml-user-drag:none;-moz-user-drag:none;-o-user-drag:none;user-drag:none;-webkit-touch-callout:none}
        .pcard-img,.detail-hero,.detail-main-img,.detail-thumbs-grid,.dthumb-cell,.lb-img{-webkit-user-select:none;-moz-user-select:none;user-select:none}
    </style>

    @yield('head')
</head>
<body x-data>
    {{-- ── Announcement bar (admin-controlled, top of every page) ── --}}
    @php
        $ann     = \App\Models\Setting::get('site.announcement', []) ?: [];
        $annOn   = (bool)($ann['enabled'] ?? false);
        $annText = $ann['text'] ?? '';
    @endphp
    @if($annOn && $annText)
    @php $annId = substr(md5($annText), 0, 8); @endphp
    <div class="site-announce"
         style="background:{{ $ann['bg_color'] ?? '#FF2D55' }}"
         x-data="{ show: !localStorage.getItem('ann_{{ $annId }}') }"
         x-show="show" x-cloak>
        <span class="site-announce-text">{{ $annText }}</span>
        @if(!empty($ann['link_url']) && !empty($ann['link_text']))
            <a href="{{ $ann['link_url'] }}" class="site-announce-cta"
               target="_blank" rel="noopener">{{ $ann['link_text'] }}</a>
        @endif
        @if($ann['dismissible'] ?? true)
            <button type="button" class="site-announce-close" aria-label="Dismiss"
                    @click="show=false; localStorage.setItem('ann_{{ $annId }}', '1')">×</button>
        @endif
    </div>
    @endif

    <livewire:nav />

    <main id="main-content">
        @yield('content')
    </main>

    @php
        // ── Store info (phone, email, social) ────────────────────────────────
        $footStoreInfo = \App\Models\Setting::get('store.info', []) ?: [];
        $footFacebook  = $footStoreInfo['facebook']  ?? null;
        $footInstagram = $footStoreInfo['instagram'] ?? null;
        $footTikTok    = $footStoreInfo['tiktok']    ?? null;
        $footTelegram  = $footStoreInfo['telegram_url']
            ?? ('https://t.me/' . ltrim($footStoreInfo['telegram_channel'] ?? '@srmacshop', '@'));
        $footPhone     = $footStoreInfo['phone'] ?? '+855 98 33 47 55';
        $footPhoneWa   = preg_replace('/\D/', '', $footPhone) ?: '85598334755'; // digits only for wa.me
        $footEmail     = $footStoreInfo['email'] ?? 'hello@srmacshop.com';

        // ── Branding (logo) ──────────────────────────────────────────────────
        $footBranding   = \App\Models\Setting::get('site.branding', []) ?: [];
        $footLogoPath   = $footBranding['logo_path'] ?? null;
        $footLogoUrl    = $footLogoPath
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($footLogoPath)
            : asset('img/srmac-logo.svg');
        $footLogoPrefix = $footBranding['logo_prefix'] ?? 'SR';
        $footLogoText   = $footBranding['logo_text']   ?? 'MAC SHOP';

        // ── Footer-specific settings ─────────────────────────────────────────
        $footCfg        = \App\Models\Setting::get('site.footer', []) ?: [];
        $footDescEn     = $footCfg['description_en'] ?? "Cambodia's most trusted Apple specialist — iPhones, iPads &amp; MacBooks since 2018.";
        $footCopyright  = ($footCfg['copyright_text'] ?? '') ?: ('© ' . date('Y') . ' ' . $footLogoPrefix . ' ' . $footLogoText . ' · ' . $footPhone . ' · www.srmacshop.com');
        $footMadeWith   = $footCfg['made_with']   ?? 'Made with ❤️ in Phnom Penh';
        $footShowWa     = (bool) ($footCfg['show_float_wa'] ?? true);
        $footShowTg     = (bool) ($footCfg['show_float_tg'] ?? true);
        $footWaMsg      = rawurlencode($footCfg['wa_message'] ?? "Hi SR MAC SHOP! I'd like to enquire about a product.");
    @endphp
    <footer class="footer">
        <div class="foot-inner">
            <div>
                <div class="foot-logo">
                    <img src="{{ $footLogoUrl }}" alt="{{ $footLogoPrefix }} {{ $footLogoText }}" class="foot-logo-img">
                    <span><span class="foot-logo-sr">{{ $footLogoPrefix }}</span> {{ $footLogoText }}</span>
                </div>
                <div style="font-size:11px;color:var(--text3)">www.srmacshop.com</div>
                <div class="foot-desc"
                     data-en="{{ $footDescEn }}"
                     data-km="អ្នកជំនាញ Apple ដែលគួរទុកចិត្តបំផុតនៅកម្ពុជា — iPhone, iPad និង MacBook ចាប់ពី ២០១៨។"
                     data-zh="柬埔寨最值得信赖的 Apple 专家 — iPhone、iPad 和 MacBook，自 2018 年起。">
                    {{ $footDescEn }}
                </div>
                <div class="foot-social">
                    <a href="https://wa.me/{{ $footPhoneWa }}" target="_blank" rel="noopener" aria-label="WhatsApp" title="WhatsApp">💬</a>
                    <a href="{{ $footTelegram }}" target="_blank" rel="noopener" aria-label="Telegram" title="Telegram"><x-icon-telegram :size="15" /></a>
                    @if($footFacebook)
                        <a href="{{ $footFacebook }}" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook">📘</a>
                    @endif
                    @if($footTikTok)
                        <a href="{{ $footTikTok }}" target="_blank" rel="noopener" aria-label="TikTok" title="TikTok">🎵</a>
                    @endif
                    @if($footInstagram)
                        <a href="{{ $footInstagram }}" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram">📸</a>
                    @endif
                    @if($footEmail)
                        <a href="mailto:{{ $footEmail }}" aria-label="Email" title="Email">✉️</a>
                    @endif
                    @if($footPhone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $footPhone) }}" aria-label="Phone" title="Call us">📞</a>
                    @endif
                </div>
            </div>
            <div class="foot-col">
                <h4 data-en="Shop" data-km="ទិញ" data-zh="商店">Shop</h4>
                <ul>
                    <li><a href="{{ route('shop') }}?category=smartphones" data-en="Smartphones" data-km="ទូរស័ព្ទស្មាតហ្វូន" data-zh="智能手机">Smartphones</a></li>
                    <li><a href="{{ route('shop') }}?category=tablets-ipad" data-en="Tablets / iPad" data-km="Tablet / iPad" data-zh="平板电脑 / iPad">Tablets / iPad</a></li>
                    <li><a href="{{ route('shop') }}?category=computers" data-en="Computers" data-km="កុំព្យូទ័រ" data-zh="电脑">Computers</a></li>
                    <li><a href="{{ route('shop') }}?category=macbook-air">MacBook Air</a></li>
                    <li><a href="{{ route('shop') }}?category=macbook-pro">MacBook Pro</a></li>
                    <li><a href="{{ route('shop') }}?category=accessories" data-en="Accessories" data-km="គ្រឿងបន្ថែម" data-zh="配件">Accessories</a></li>
                    <li><a href="{{ route('shop') }}?category=protection" data-en="Protection" data-km="ការពារ" data-zh="保护">Protection</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4 data-en="Company" data-km="ក្រុមហ៊ុន" data-zh="公司">Company</h4>
                <ul>
                    <li><a href="{{ route('about') }}" data-en="About Us" data-km="អំពីយើង" data-zh="关于我们">About Us</a></li>
                    <li><a href="{{ route('contact') }}" data-en="Contact" data-km="ទំនាក់ទំនង" data-zh="联系">Contact</a></li>
                    <li><a href="/admin" data-en="Admin" data-km="អ្នកគ្រប់គ្រង" data-zh="管理">Admin</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4 data-en="Support" data-km="ជំនួយ" data-zh="支持">Support</h4>
                <ul>
                    <li><a href="{{ route('track-order') }}" data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ" data-zh="追踪订单">Track Order</a></li>
                    <li><a href="https://wa.me/85598334755" target="_blank" rel="noopener" data-en="WhatsApp Help" data-km="ជំនួយ WhatsApp" data-zh="WhatsApp 帮助">WhatsApp Help</a></li>
                    <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
        </div>
        <div class="foot-bottom">
            <span>{{ $footCopyright }}</span>
            <span>{{ $footMadeWith }}</span>
        </div>
    </footer>

    {{-- Floating contact pills (stacked: Telegram on top, WhatsApp below) --}}
    @if($footShowTg || $footShowWa)
    <div class="float-stack">
        @if($footShowTg)
        <a href="{{ $footTelegram }}"
            class="float-pill float-tg" target="_blank" rel="noopener" aria-label="Telegram">
            <span class="float-icon" style="background:#229ED9"><x-icon-telegram :size="13" color="#fff" /></span>
            <span class="float-label" data-en="Telegram" data-km="តេឡេក្រាម" data-zh="Telegram">Telegram</span>
        </a>
        @endif
        @if($footShowWa)
        <a href="https://wa.me/{{ $footPhoneWa }}?text={{ $footWaMsg }}"
            class="float-pill float-wa" target="_blank" rel="noopener" aria-label="WhatsApp">
            <span class="float-icon" style="background:#25D366">💬</span>
            <span class="float-label" data-en="WhatsApp Us" data-km="ទំនាក់ទំនង" data-zh="联系我们">WhatsApp Us</span>
        </a>
        @endif
    </div>
    @endif

    {{-- Mobile sticky "Today's Deal" CTA bar (home page only, phones only) --}}
    @if(request()->routeIs('home') && (\App\Models\Setting::get('home_promo.sticky_cta_enabled', true) ?? true))
        @php
            $stickyPromo = \App\Models\Setting::get('home_promo', []);
            $stickyHp = null;
            if (! empty($stickyPromo['headline_product_id'])) {
                $stickyHp = \App\Models\Product::with('media')->find($stickyPromo['headline_product_id']);
            }
            if (! $stickyHp) {
                $stickyHp = \App\Models\Product::with('media')
                    ->where('is_active', true)
                    ->where('stock', '>', 0)
                    ->whereNotNull('original_price')
                    ->whereColumn('original_price', '>', 'price')
                    ->orderByRaw('(original_price - price) DESC')
                    ->first();
            }
            if (! $stickyHp) {
                $stickyHp = \App\Models\Product::with('media')->where('is_active', true)->where('stock', '>', 0)->first();
            }
            $stickyPriceCents = ($stickyPromo['headline_price'] ?? null) ?: ($stickyHp->price ?? 0);
            $stickyImg = $stickyHp?->getFirstMediaUrl('gallery') ?? '';
        @endphp
        @if($stickyHp)
        <a href="{{ route('product', $stickyHp->slug) }}" class="hp-sticky-cta">
            <div class="hp-sticky-thumb">
                @if($stickyImg)
                    <img src="{{ $stickyImg }}" alt="" loading="lazy">
                @else
                    <span>{{ $stickyHp->emoji ?: '💻' }}</span>
                @endif
            </div>
            <div class="hp-sticky-info">
                <div class="hp-sticky-eyebrow" data-en="🔥 Today's Deal" data-km="🔥 ការផ្តល់ជូនថ្ងៃនេះ" data-zh="🔥 今日特惠">🔥 Today's Deal</div>
                <div class="hp-sticky-price">${{ number_format($stickyPriceCents / 100, 0) }}</div>
            </div>
            <span class="hp-sticky-btn" data-en="Order →" data-km="បញ្ជាទិញ →" data-zh="订购 →">Order →</span>
        </a>
        @endif
    @endif

    <livewire:cart-drawer />
    <livewire:toast />

    @livewireScripts

    @yield('scripts')

    {{-- Block right-click + drag on images only (page stays fully usable elsewhere) --}}
    <script>
        (function(){
            var block = function(e){ if(e.target && e.target.tagName === 'IMG'){ e.preventDefault(); } };
            document.addEventListener('contextmenu', block);
            document.addEventListener('dragstart', block);
        })();
    </script>
</body>
</html>
