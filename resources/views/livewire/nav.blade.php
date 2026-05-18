<div x-data="{ mobileOpen: false }">
    <nav id="cust-nav">
        <div class="cn-inner">
            <a href="{{ route('home') }}" class="cn-logo">
                🍎 <span>SR</span> MAC SHOP
            </a>

            {{-- Desktop links --}}
            <ul class="cn-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}" data-en="Home" data-km="ដើម">Home</a></li>
                <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') || request()->routeIs('product') ? 'on' : '' }}" data-en="Shop" data-km="ហាង">Shop</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}" data-en="About" data-km="អំពីយើង">About</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}" data-en="Contact" data-km="ទំនាក់ទំនង">Contact</a></li>
            </ul>

            <div class="cn-right">
                {{-- Language Toggle --}}
                <div class="lang-tog">
                    <button class="lang-b" :class="$store.lang.current === 'en' ? 'on' : ''"
                        @click="$store.lang.current !== 'en' && $store.lang.toggle()" type="button">EN</button>
                    <button class="lang-b" :class="$store.lang.current === 'km' ? 'on' : ''"
                        @click="$store.lang.current !== 'km' && $store.lang.toggle()" type="button">KM</button>
                </div>

                {{-- Dark Mode Toggle --}}
                <button class="dark-tog" type="button" @click="$store.theme.toggle()"
                    :title="$store.theme.current === 'light' ? 'Dark mode' : 'Light mode'">
                    <span x-text="$store.theme.current === 'light' ? '🌙' : '☀️'">🌙</span>
                </button>

                {{-- Cart FAB --}}
                <button class="cart-fab" type="button"
                    onclick="Livewire.dispatch('cart.open')"
                    data-en="🛒 Cart" data-km="🛒 កន្ត្រក">
                    🛒 Cart
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </button>

                {{-- Mobile hamburger --}}
                <button class="mob-menu-btn" type="button" @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen" aria-label="Menu">
                    <span x-show="!mobileOpen">☰</span>
                    <span x-show="mobileOpen">✕</span>
                </button>
            </div>
        </div>

        {{-- Mobile dropdown --}}
        <div class="mob-menu" x-show="mobileOpen" x-transition @click.outside="mobileOpen = false">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}" data-en="Home" data-km="ដើម">Home</a>
            <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') || request()->routeIs('product') ? 'on' : '' }}" data-en="Shop" data-km="ហាង">Shop</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}" data-en="About" data-km="អំពីយើង">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}" data-en="Contact" data-km="ទំនាក់ទំនង">Contact</a>
            <a href="https://wa.me/85598334755" target="_blank" rel="noopener" style="color:#25D366;font-weight:700">💬 WhatsApp Us</a>
        </div>
    </nav>
</div>
