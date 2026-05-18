<div>
    <nav id="cust-nav">
        <div class="cn-inner">
            <a href="{{ route('home') }}" class="cn-logo">
                🍎 <span>SR</span> MAC SHOP
            </a>

            <ul class="cn-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}" data-en="Home" data-km="ដើម">Home</a></li>
                <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'on' : '' }}" data-en="Shop" data-km="ហាង">Shop</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}" data-en="About" data-km="អំពីយើង">About</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}" data-en="Contact" data-km="ទំនាក់ទំនង">Contact</a></li>
            </ul>

            <div class="cn-right">
                {{-- Language Toggle --}}
                <div class="lang-tog" x-data>
                    <button class="lang-b" :class="$store.lang.current === 'en' ? 'on' : ''"
                        @click="$store.lang.current !== 'en' && $store.lang.toggle()" type="button">EN</button>
                    <button class="lang-b" :class="$store.lang.current === 'km' ? 'on' : ''"
                        @click="$store.lang.current !== 'km' && $store.lang.toggle()" type="button">KM</button>
                </div>

                {{-- Dark Mode Toggle --}}
                <button class="dark-tog" type="button" x-data @click="$store.theme.toggle()"
                    :title="$store.theme.current === 'light' ? 'Dark mode' : 'Light mode'">
                    <span x-text="$store.theme.current === 'light' ? '🌙' : '☀️'">🌙</span>
                </button>

                {{-- Cart FAB --}}
                <button class="cart-fab" type="button" x-data @click="$dispatch('cart.open')"
                    data-en="🛒 Cart" data-km="🛒 កន្ត្រក">
                    🛒 Cart
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </button>

                {{-- Admin link --}}
                <a href="/admin" style="font-size:12px;font-weight:600;color:var(--blue)" data-en="Admin" data-km="អ្នកគ្រប់គ្រង">Admin</a>
            </div>
        </div>
    </nav>
</div>
