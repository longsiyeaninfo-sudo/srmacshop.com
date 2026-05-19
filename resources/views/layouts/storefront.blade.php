<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SR MAC SHOP — Think Different. Buy Smarter.')</title>
    <meta name="description" content="@yield('description', 'Buy authentic MacBooks in Cambodia with official Apple warranty. MacBook Air, MacBook Pro with M3/M4 chips. Same-day delivery in Phnom Penh.')">
    <meta name="keywords" content="MacBook Cambodia, MacBook Phnom Penh, Apple Cambodia, MacBook Air, MacBook Pro, M3, M4, ម៉ាក់ប៊ុក, ភ្នំពេញ">
    <meta name="robots" content="index, follow">
    <meta name="author" content="SR MAC SHOP">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SR MAC SHOP — Premium MacBooks in Cambodia')">
    <meta property="og:description" content="@yield('description', 'Authentic MacBooks with official Apple warranty. Same-day delivery in Phnom Penh.')">
    <meta property="og:site_name" content="SR MAC SHOP">
    <meta property="og:image" content="{{ asset('og-image.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SR MAC SHOP — Premium MacBooks in Cambodia')">
    <meta name="twitter:description" content="@yield('description', 'Authentic MacBooks with official Apple warranty.')">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">

    {{-- Prevent dark flash --}}
    <script>!function(){var t=localStorage.getItem('srmac_theme')||'light';document.documentElement.setAttribute('data-theme',t)}()</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Google Analytics --}}
    @if(config('services.analytics.google_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics.google_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.analytics.google_id') }}');
    </script>
    @endif

    {{-- Facebook Pixel --}}
    @if(config('services.analytics.facebook_pixel'))
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ config('services.analytics.facebook_pixel') }}');
        fbq('track', 'PageView');
    </script>
    @endif

    @yield('head')
</head>
<body x-data>
    <livewire:nav />

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="foot-inner">
            <div>
                <div class="foot-logo">🍎 <span>SR</span> MAC SHOP</div>
                <div style="font-size:11px;color:var(--text3)">www.srmacshop.com</div>
                <div class="foot-desc" data-en="Cambodia's most trusted MacBook specialist since 2018." data-km="អ្នកជំនាញ MacBook ដែលគួរទុកចិត្ត នៅកម្ពុជា ចាប់ពី ២០១៨។">Cambodia's most trusted MacBook specialist since 2018.</div>
                <div class="foot-social">
                    <a href="https://wa.me/85598334755" target="_blank" rel="noopener" aria-label="WhatsApp" title="WhatsApp">💬</a>
                    <a href="https://t.me/srmacshop" target="_blank" rel="noopener" aria-label="Telegram" title="Telegram">✈️</a>
                    <a href="mailto:hello@srmacshop.com" aria-label="Email" title="Email">✉️</a>
                    <a href="tel:+85598334755" aria-label="Phone" title="Call us">📞</a>
                </div>
            </div>
            <div class="foot-col">
                <h4 data-en="Shop" data-km="ទិញ">Shop</h4>
                <ul>
                    <li><a href="{{ route('shop') }}?category=macbook-air">MacBook Air</a></li>
                    <li><a href="{{ route('shop') }}?category=macbook-pro">MacBook Pro</a></li>
                    <li><a href="{{ route('shop') }}?category=accessories" data-en="Accessories" data-km="គ្រឿងបន្ថែម">Accessories</a></li>
                    <li><a href="{{ route('shop') }}?category=protection" data-en="Protection" data-km="ការពារ">Protection</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4 data-en="Company" data-km="ក្រុមហ៊ុន">Company</h4>
                <ul>
                    <li><a href="{{ route('about') }}" data-en="About Us" data-km="អំពីយើង">About Us</a></li>
                    <li><a href="{{ route('contact') }}" data-en="Contact" data-km="ទំនាក់ទំនង">Contact</a></li>
                    <li><a href="/admin" data-en="Admin" data-km="អ្នកគ្រប់គ្រង">Admin</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4 data-en="Support" data-km="ជំនួយ">Support</h4>
                <ul>
                    <li><a href="{{ route('track-order') }}" data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ">Track Order</a></li>
                    <li><a href="https://wa.me/85598334755" target="_blank" rel="noopener" data-en="WhatsApp Help" data-km="ជំនួយ WhatsApp">WhatsApp Help</a></li>
                    <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
        </div>
        <div class="foot-bottom">
            <span>© {{ date('Y') }} SR MAC SHOP · +855 98 33 47 55 · www.srmacshop.com</span>
            <span data-en="Made with ❤️ in Phnom Penh" data-km="បង្កើតដោយ ❤️ នៅភ្នំពេញ">Made with ❤️ in Phnom Penh</span>
        </div>
    </footer>

    {{-- WhatsApp floating button --}}
    <a href="https://wa.me/85598334755?text=Hi%20SR%20MAC%20SHOP!%20I%27d%20like%20to%20enquire%20about%20a%20MacBook."
        class="wa-float" target="_blank" rel="noopener" aria-label="WhatsApp">
        <span class="wa-icon">💬</span>
        <span data-en="WhatsApp Us" data-km="ទំនាក់ទំនង">WhatsApp Us</span>
    </a>

    <livewire:cart-drawer />
    <livewire:toast />

    @livewireScripts

    @yield('scripts')
</body>
</html>
