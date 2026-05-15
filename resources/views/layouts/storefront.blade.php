<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', 'SR MAC SHOP — Premium MacBooks in Phnom Penh, Cambodia.')">

    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', 'SR MAC SHOP — Premium MacBooks in Phnom Penh, Cambodia.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    {{-- TODO: replace with the prototype's #cust-nav markup once srmacshop-full_13.html is in the repo --}}
    <livewire:nav />

    <main>
        @yield('content')
    </main>

    {{-- TODO: replace with the prototype's <footer class="footer"> markup --}}
    <footer class="footer">
        <div style="max-width:1200px;margin:0 auto;padding:32px 16px;font-size:14px;color:#666">
            &copy; {{ date('Y') }} SR MAC SHOP. {{ __('All rights reserved.') }}
        </div>
    </footer>

    <livewire:cart-drawer />
    <livewire:toast />

    @livewireScripts
</body>
</html>
