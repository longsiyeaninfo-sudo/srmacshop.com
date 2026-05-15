<div>
    {{-- TODO Phase 1 (post-prototype): replace with the prototype's #cust-nav markup --}}
    <nav id="cust-nav" style="position:sticky;top:0;z-index:50;backdrop-filter:saturate(180%) blur(20px);
       -webkit-backdrop-filter:saturate(180%) blur(20px);background:rgba(255,255,255,.72);
        border-bottom:1px solid rgba(0,0,0,.06)">
        <div style="max-width:1200px;margin:0 auto;padding:14px 16px;display:flex;align-items:center;gap:24px">
            <a href="{{ route('home') }}" style="font-weight:700;text-decoration:none;color:inherit">SR MAC SHOP</a>
          <div style="display:flex;gap:16px;flex:1">
                <a href="{{ route('home') }}" data-en="Home" data-km="ដើម">{{ __('Home') }}</a>
            <a href="{{ route('shop') }}" data-en="Shop" data-km="ហាង">{{ __('Shop') }}</a>
              <a href="{{ route('about') }}" data-en="About" data-km="អំពីយើង">{{ __('About') }}</a>
                <a href="{{ route('contact') }}" data-en="Contact" data-km="ទំនាក់ទំនង">{{ __('Contact') }}</a>
            </div>
            <button type="button" x-data x-on:click="$store.lang.toggle()" aria-label="Toggle language"
              style="border:none;background:transparent;cursor:pointer;font-weight:600">
          <span x-text="$store.lang.current === 'en' ? 'KM' : 'EN'">EN</span>
            </button>
          <button type="button" x-data x-on:click="$store.theme.toggle()" aria-label="Toggle theme"
                    style="border:none;background:transparent;cursor:pointer">
                <span x-text="$store.theme.current === 'light' ? '🌙' : '☀️'">🌙</span>
            </button>
            <button type="button"
                x-data
                 x-on:click="$dispatch('cart.open')"
          aria-label="Cart"
             style="position:relative;border:1px solid #ddd;background:#fff;border-radius:999px;padding:8px 14px;cursor:pointer">
            🛒
                @if($cartCount > 0)
        <span style="position:absolute;top:-6px;right:-6px;background:#FF3B30;color:#fff;border-radius:999px;padding:2px 6px;font-size:11px">
                 {{ $cartCount }}
                    </span>
          @endif
        </button>
            <a href="/admin" style="text-decoration:none;color:#007AFF" data-en="Admin" data-km="អ្នកគ្រប់គ្រង">
        {{ __('Admin') }}
          </a>
      </div>
    </nav>
</div>
