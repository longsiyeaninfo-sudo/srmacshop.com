<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SR MAC SHOP — Think Different. Buy Smarter.')</title>
    <meta name="description" content="@yield('description', 'Buy authentic MacBooks in Cambodia with official Apple warranty. MacBook Air, MacBook Pro with M3/M4 chips. Same-day delivery in Phnom Penh.')">
    <meta name="keywords" content="MacBook Cambodia, MacBook Phnom Penh, Apple Cambodia, MacBook Air, MacBook Pro, M3, M4">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SR MAC SHOP — Premium MacBooks in Cambodia')">
    <meta property="og:description" content="@yield('description', 'Authentic MacBooks with official Apple warranty. Same-day delivery in Phnom Penh.')">
    <meta property="og:site_name" content="SR MAC SHOP">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SR MAC SHOP — Premium MacBooks in Cambodia')">

    <link rel="canonical" href="{{ url()->current() }}">
    <script>!function(){var t=localStorage.getItem('srmac_theme')||'light';document.documentElement.setAttribute('data-theme',t)}()</script>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

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
            </div>
            <div class="foot-col">
                <h4 data-en="Shop" data-km="ទិញ">Shop</h4>
                <ul>
                    <li><a href="{{ route('shop') }}">MacBook Air</a></li>
                    <li><a href="{{ route('shop') }}">MacBook Pro</a></li>
                    <li><a href="{{ route('shop') }}" data-en="Accessories" data-km="គ្រឿងបន្ថែម">Accessories</a></li>
                    <li><a href="{{ route('shop') }}" data-en="Protection" data-km="ការពារ">Protection</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4 data-en="Company" data-km="ក្រុមហ៊ុន">Company</h4>
                <ul>
                    <li><a href="{{ route('about') }}" data-en="About Us" data-km="អំពីយើង">About Us</a></li>
                    <li><a href="{{ route('contact') }}" data-en="Contact" data-km="ទំនាក់ទំនង">Contact</a></li>
                    <li><a href="/admin">⚙️ Admin</a></li>
                </ul>
            </div>
        </div>
        <div class="foot-bottom">
            <span>© {{ date('Y') }} SR MAC SHOP — www.srmacshop.com</span>
            <span data-en="Made with ❤️ in Phnom Penh" data-km="បង្កើតដោយ ❤️ នៅភ្នំពេញ">Made with ❤️ in Phnom Penh</span>
        </div>
    </footer>

    <livewire:cart-drawer />
    <livewire:toast />

    @livewireScripts

    @yield('scripts')
</body>
</html>
