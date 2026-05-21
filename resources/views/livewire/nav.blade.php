<div x-data="{ mobileOpen: false }">
    <nav id="cust-nav">
        <div class="cn-inner">
            <a href="{{ route('home') }}" class="cn-logo">
                <img src="{{ asset('img/srmac-logo.svg') }}" alt="" class="cn-logo-img">
                <span class="cn-logo-text"><span>SR</span> MAC SHOP</span>
            </a>

            {{-- Desktop links --}}
            <ul class="cn-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}" data-en="Home" data-km="ដើម" data-zh="首页">Home</a></li>
                <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') || request()->routeIs('product') ? 'on' : '' }}" data-en="Shop" data-km="ហាង" data-zh="商店">Shop</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}" data-en="About" data-km="អំពីយើង" data-zh="关于">About</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}" data-en="Contact" data-km="ទំនាក់ទំនង" data-zh="联系">Contact</a></li>
                <li><a href="{{ route('track-order') }}" class="{{ request()->routeIs('track-order') ? 'on' : '' }}" data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ" data-zh="追踪订单">Track Order</a></li>
            </ul>

            <div class="cn-right">
                {{-- Language switcher (3 flags) --}}
                <div class="lang-tog" role="group" aria-label="Language">
                    <button class="lang-flag" type="button" @click="$store.lang.set('en')"
                        :class="$store.lang.current === 'en' ? 'on' : ''"
                        :aria-pressed="$store.lang.current === 'en'" aria-label="English" title="English">
                        <iconify-icon icon="circle-flags:gb" width="22" height="22" aria-hidden="true"></iconify-icon>
                    </button>
                    <button class="lang-flag" type="button" @click="$store.lang.set('km')"
                        :class="$store.lang.current === 'km' ? 'on' : ''"
                        :aria-pressed="$store.lang.current === 'km'" aria-label="Khmer" title="ភាសាខ្មែរ">
                        <iconify-icon icon="circle-flags:kh" width="22" height="22" aria-hidden="true"></iconify-icon>
                    </button>
                    <button class="lang-flag" type="button" @click="$store.lang.set('zh')"
                        :class="$store.lang.current === 'zh' ? 'on' : ''"
                        :aria-pressed="$store.lang.current === 'zh'" aria-label="Chinese" title="中文">
                        <iconify-icon icon="circle-flags:cn" width="22" height="22" aria-hidden="true"></iconify-icon>
                    </button>
                </div>

                {{-- Dark Mode Toggle --}}
                <button class="dark-tog" type="button" @click="$store.theme.toggle()"
                    :title="$store.theme.current === 'light' ? 'Dark mode' : 'Light mode'">
                    <span x-text="$store.theme.current === 'light' ? '🌙' : '☀️'">🌙</span>
                </button>

                {{-- Cart FAB --}}
                <button class="cart-fab" type="button"
                    onclick="Livewire.dispatch('cart.open')"
                    data-en="🛒 Cart" data-km="🛒 កន្ត្រក" data-zh="🛒 购物车">
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

        {{-- Mobile dropdown (legacy — will be replaced by slide-in panel in Phase 4) --}}
        <div class="mob-menu" x-show="mobileOpen" x-transition @click.outside="mobileOpen = false">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}" data-en="Home" data-km="ដើម" data-zh="首页">Home</a>
            <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') || request()->routeIs('product') ? 'on' : '' }}" data-en="Shop" data-km="ហាង" data-zh="商店">Shop</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}" data-en="About" data-km="អំពីយើង" data-zh="关于">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}" data-en="Contact" data-km="ទំនាក់ទំនង" data-zh="联系">Contact</a>
            <a href="{{ route('track-order') }}" class="{{ request()->routeIs('track-order') ? 'on' : '' }}" data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ" data-zh="追踪订单">Track Order</a>
            <a href="https://wa.me/85598334755" target="_blank" rel="noopener" style="color:#25D366;font-weight:700">💬 WhatsApp Us</a>
        </div>
    </nav>

    {{-- ═════ Mobile bottom tab bar (≤ 768px) — Phase 3 ═════ --}}
    <nav class="cn-tabbar" aria-label="Primary mobile">
        <a href="{{ route('home') }}" class="cn-tab {{ request()->routeIs('home') ? 'on' : '' }}">
            <span class="cn-tab-ico">🏠</span>
            <span class="cn-tab-lbl" data-en="Home" data-km="ដើម" data-zh="首页">Home</span>
        </a>
        <a href="{{ route('shop') }}" class="cn-tab {{ request()->routeIs('shop') || request()->routeIs('product') || request()->routeIs('compare') ? 'on' : '' }}">
            <span class="cn-tab-ico">🛍</span>
            <span class="cn-tab-lbl" data-en="Shop" data-km="ហាង" data-zh="商店">Shop</span>
        </a>
        <button type="button" class="cn-tab cn-tab-cart" onclick="Livewire.dispatch('cart.open')" aria-label="Cart">
            <span class="cn-tab-ico">🛒</span>
            <span class="cn-tab-lbl" data-en="Cart" data-km="កន្ត្រក" data-zh="购物车">Cart</span>
            @if($cartCount > 0)
                <span class="cn-tab-badge">{{ $cartCount }}</span>
            @endif
        </button>
        <a href="https://wa.me/85598334755" target="_blank" rel="noopener" class="cn-tab">
            <span class="cn-tab-ico">💬</span>
            <span class="cn-tab-lbl">WhatsApp</span>
        </a>
        <button type="button" class="cn-tab" @click="mobileOpen = true" aria-label="Menu">
            <span class="cn-tab-ico">☰</span>
            <span class="cn-tab-lbl" data-en="Menu" data-km="ម៉ឺនុយ" data-zh="菜单">Menu</span>
        </button>
    </nav>
</div>
