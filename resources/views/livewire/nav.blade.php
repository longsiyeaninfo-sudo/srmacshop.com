<div x-data="{ mobileOpen: false, searchOpen: false }">
    <nav id="cust-nav">
        <div class="cn-inner">
            <a href="{{ route('home') }}" class="cn-logo">
                <img src="{{ $logoUrl }}" alt="{{ $logoPrefix }} {{ $logoText }}" class="cn-logo-img">
                @if($showLogoText)
                <span class="cn-logo-text"><span>{{ $logoPrefix }}</span> {{ $logoText }}</span>
                @endif
            </a>

            {{-- Inline search (desktop) --}}
            <form action="{{ route('shop') }}" method="GET" class="cn-search">
                <span class="cn-search-icon">🔍</span>
                <input type="text" name="q" autocomplete="off"
                    placeholder="Search MacBooks..."
                    data-en="Search MacBooks..." data-km="ស្វែងរក MacBook..." data-zh="搜索 MacBook...">
            </form>

            {{-- Desktop links --}}
            <ul class="cn-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}" data-en="Home" data-km="ដើម" data-zh="首页">Home</a></li>
                {{-- Shop link with category mega-menu (desktop hover) --}}
                <li x-data="{ megaOpen: false, megaTimer: null }" class="cn-mega-wrap"
                    @mouseenter="clearTimeout(megaTimer); megaOpen = true"
                    @mouseleave="megaTimer = setTimeout(() => megaOpen = false, 150)">
                    <a href="{{ route('shop') }}"
                       class="{{ request()->routeIs('shop') || request()->routeIs('product') ? 'on' : '' }}"
                       data-en="Shop" data-km="ហាង" data-zh="商店">Shop</a>

                    @if($navCategories->count())
                    @php
                        $megaEmoji = fn(string $slug): string => match(true) {
                            str_contains($slug, 'air')     => '🌬️',
                            str_contains($slug, 'pro')     => '⚡',
                            str_contains($slug, 'access')  => '🎒',
                            str_contains($slug, 'protect') => '🛡️',
                            str_contains($slug, 'refurb')  => '♻️',
                            str_contains($slug, 'ipad')    => '📱',
                            str_contains($slug, 'airpod')  => '🎧',
                            str_contains($slug, 'cable')   => '🔌',
                            default                        => '💻',
                        };
                    @endphp
                    <div class="cn-mega" x-show="megaOpen" x-cloak
                         @mouseenter="clearTimeout(megaTimer)"
                         @mouseleave="megaTimer = setTimeout(() => megaOpen = false, 150)">
                        <div class="cn-mega-grid">
                            @foreach($navCategories as $cat)
                            <a href="{{ route('shop') }}?category={{ $cat->slug }}"
                               class="cn-mega-card" @click="megaOpen = false">
                                <span class="cn-mega-ico">{{ $megaEmoji($cat->slug) }}</span>
                                <span class="cn-mega-body">
                                    <span class="cn-mega-name">{{ $cat->name }}</span>
                                    <span class="cn-mega-count">{{ $cat->products_count }} {{ $cat->products_count === 1 ? 'product' : 'products' }}</span>
                                </span>
                                <span class="cn-mega-arr">→</span>
                            </a>
                            @endforeach
                        </div>
                        <div class="cn-mega-foot">
                            <a href="{{ route('shop') }}" @click="megaOpen = false"
                               data-en="Browse all products →" data-km="មើលទំនិញទាំងអស់ →" data-zh="浏览所有商品 →">Browse all products →</a>
                        </div>
                    </div>
                    @endif
                </li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}" data-en="About" data-km="អំពីយើង" data-zh="关于">About</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}" data-en="Contact" data-km="ទំនាក់ទំនង" data-zh="联系">Contact</a></li>
                <li><a href="{{ route('track-order') }}" class="{{ request()->routeIs('track-order') ? 'on' : '' }}" data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ" data-zh="追踪订单">Track Order</a></li>
            </ul>

            <div class="cn-right">
                {{-- Mobile search icon (opens full-screen overlay) --}}
                <button type="button" class="cn-search-btn" @click="searchOpen = true; $nextTick(() => $refs.searchInp.focus())" aria-label="Search">🔍</button>

                {{-- Language switcher — click dropdown --}}
                <div class="lang-tog" x-data="{ open: false }"
                     @click.outside="open = false" @keydown.escape.window="open = false">
                    <button type="button" class="lang-tog-btn" @click="open = !open"
                            :aria-expanded="open" aria-label="Language" aria-haspopup="listbox">
                        <iconify-icon
                            :icon="$store.lang.current === 'en' ? 'circle-flags:gb' : ($store.lang.current === 'km' ? 'circle-flags:kh' : 'circle-flags:cn')"
                            width="22" height="22" aria-hidden="true"></iconify-icon>
                        <svg class="lang-tog-caret" :class="{ 'is-open': open }" width="10" height="10" viewBox="0 0 10 10" aria-hidden="true">
                            <path d="M2 4 L5 7 L8 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="lang-tog-menu" x-show="open" x-cloak
                         x-transition:enter="lang-tog-trans-enter"
                         x-transition:enter-start="lang-tog-trans-enter-start"
                         x-transition:enter-end="lang-tog-trans-enter-end"
                         role="listbox">
                        <button type="button" class="lang-tog-item"
                                :class="{ 'is-on': $store.lang.current === 'en' }"
                                @click="$store.lang.set('en'); open = false" role="option">
                            <iconify-icon icon="circle-flags:gb" width="20" height="20" aria-hidden="true"></iconify-icon>
                            <span>English</span>
                            <span class="lang-tog-check" aria-hidden="true">✓</span>
                        </button>
                        <button type="button" class="lang-tog-item"
                                :class="{ 'is-on': $store.lang.current === 'km' }"
                                @click="$store.lang.set('km'); open = false" role="option">
                            <iconify-icon icon="circle-flags:kh" width="20" height="20" aria-hidden="true"></iconify-icon>
                            <span>ភាសាខ្មែរ</span>
                            <span class="lang-tog-check" aria-hidden="true">✓</span>
                        </button>
                        <button type="button" class="lang-tog-item"
                                :class="{ 'is-on': $store.lang.current === 'zh' }"
                                @click="$store.lang.set('zh'); open = false" role="option">
                            <iconify-icon icon="circle-flags:cn" width="20" height="20" aria-hidden="true"></iconify-icon>
                            <span>中文</span>
                            <span class="lang-tog-check" aria-hidden="true">✓</span>
                        </button>
                    </div>
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

    </nav>

    {{-- ═════ Mobile slide-in side panel (Phase 4) ═════ --}}
    <div class="cn-panel-overlay" x-show="mobileOpen" x-transition.opacity @click="mobileOpen = false" x-cloak></div>
    <aside class="cn-panel" :class="{ open: mobileOpen }" x-cloak @keydown.escape.window="mobileOpen = false">
        <header class="cn-panel-header">
            <a href="{{ route('home') }}" class="cn-panel-logo" @click="mobileOpen = false">
                <img src="{{ $logoUrl }}" alt="{{ $logoPrefix }} {{ $logoText }}" class="cn-logo-img">
                <span>{{ $logoPrefix }} {{ $logoText }}</span>
            </a>
            <button type="button" class="cn-panel-close" @click="mobileOpen = false" aria-label="Close">✕</button>
        </header>

        <div class="cn-panel-body">
            {{-- Search shortcut --}}
            <form action="{{ route('shop') }}" method="GET" class="cn-panel-search" @click="mobileOpen = false">
                <span class="cn-panel-search-icon">🔍</span>
                <input type="text" name="q" placeholder="Search MacBooks..."
                    data-en="Search MacBooks..." data-km="ស្វែងរក MacBook..." data-zh="搜索 MacBook...">
            </form>

            {{-- Categories --}}
            @if($navCategories->count())
                <div class="cn-panel-section">
                    <h4 class="cn-panel-title" data-en="Browse by category" data-km="មើលតាមប្រភេទ" data-zh="按类别浏览">Browse by category</h4>
                    <div class="cn-panel-cats">
                        @foreach($navCategories as $cat)
                            <a href="{{ route('shop') }}?category={{ $cat->slug }}" class="cn-panel-cat" @click="mobileOpen = false">
                                <span class="cn-panel-cat-name">{{ $cat->name }}</span>
                                <span class="cn-panel-cat-count">{{ $cat->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quick links --}}
            <div class="cn-panel-section">
                <h4 class="cn-panel-title" data-en="Quick links" data-km="តំណភ្ជាប់រហ័ស" data-zh="快速链接">Quick links</h4>
                <a href="{{ route('home') }}" class="cn-panel-link {{ request()->routeIs('home') ? 'on' : '' }}" @click="mobileOpen = false">
                    🏠 <span data-en="Home" data-km="ដើម" data-zh="首页">Home</span>
                </a>
                <a href="{{ route('shop') }}" class="cn-panel-link {{ request()->routeIs('shop') || request()->routeIs('product') ? 'on' : '' }}" @click="mobileOpen = false">
                    🛍 <span data-en="Shop" data-km="ហាង" data-zh="商店">Shop</span>
                </a>
                <a href="{{ route('about') }}" class="cn-panel-link {{ request()->routeIs('about') ? 'on' : '' }}" @click="mobileOpen = false">
                    🍎 <span data-en="About" data-km="អំពីយើង" data-zh="关于">About</span>
                </a>
                <a href="{{ route('contact') }}" class="cn-panel-link {{ request()->routeIs('contact') ? 'on' : '' }}" @click="mobileOpen = false">
                    📞 <span data-en="Contact" data-km="ទំនាក់ទំនង" data-zh="联系">Contact</span>
                </a>
                <a href="{{ route('track-order') }}" class="cn-panel-link {{ request()->routeIs('track-order') ? 'on' : '' }}" @click="mobileOpen = false">
                    📦 <span data-en="Track Order" data-km="តាមដានការបញ្ជាទិញ" data-zh="追踪订单">Track Order</span>
                </a>
            </div>

            {{-- Language --}}
            <div class="cn-panel-section">
                <h4 class="cn-panel-title" data-en="Language" data-km="ភាសា" data-zh="语言">Language</h4>
                <div class="lang-tog" x-data="{ open: false }"
                     @click.outside="open = false" @keydown.escape.window="open = false">
                    <button type="button" class="lang-tog-btn" @click="open = !open"
                            :aria-expanded="open" aria-label="Language" aria-haspopup="listbox">
                        <iconify-icon
                            :icon="$store.lang.current === 'en' ? 'circle-flags:gb' : ($store.lang.current === 'km' ? 'circle-flags:kh' : 'circle-flags:cn')"
                            width="22" height="22" aria-hidden="true"></iconify-icon>
                        <span class="lang-tog-label"
                              x-text="$store.lang.current === 'en' ? 'English' : ($store.lang.current === 'km' ? 'ភាសាខ្មែរ' : '中文')"></span>
                        <svg class="lang-tog-caret" :class="{ 'is-open': open }" width="10" height="10" viewBox="0 0 10 10" aria-hidden="true">
                            <path d="M2 4 L5 7 L8 4" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="lang-tog-menu" x-show="open" x-cloak role="listbox">
                        <button type="button" class="lang-tog-item"
                                :class="{ 'is-on': $store.lang.current === 'en' }"
                                @click="$store.lang.set('en'); open = false" role="option">
                            <iconify-icon icon="circle-flags:gb" width="20" height="20" aria-hidden="true"></iconify-icon>
                            <span>English</span>
                            <span class="lang-tog-check" aria-hidden="true">✓</span>
                        </button>
                        <button type="button" class="lang-tog-item"
                                :class="{ 'is-on': $store.lang.current === 'km' }"
                                @click="$store.lang.set('km'); open = false" role="option">
                            <iconify-icon icon="circle-flags:kh" width="20" height="20" aria-hidden="true"></iconify-icon>
                            <span>ភាសាខ្មែរ</span>
                            <span class="lang-tog-check" aria-hidden="true">✓</span>
                        </button>
                        <button type="button" class="lang-tog-item"
                                :class="{ 'is-on': $store.lang.current === 'zh' }"
                                @click="$store.lang.set('zh'); open = false" role="option">
                            <iconify-icon icon="circle-flags:cn" width="20" height="20" aria-hidden="true"></iconify-icon>
                            <span>中文</span>
                            <span class="lang-tog-check" aria-hidden="true">✓</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Theme --}}
            <div class="cn-panel-section">
                <button type="button" class="cn-panel-link" @click="$store.theme.toggle()">
                    <span x-text="$store.theme.current === 'light' ? '🌙' : '☀️'">🌙</span>
                    <span x-text="$store.theme.current === 'light' ? 'Dark mode' : 'Light mode'">Dark mode</span>
                </button>
            </div>

            {{-- Connect --}}
            <div class="cn-panel-section">
                <h4 class="cn-panel-title" data-en="Connect" data-km="ភ្ជាប់" data-zh="联系">Connect</h4>
                <a href="https://t.me/srmacshop" target="_blank" rel="noopener" class="cn-panel-link" @click="mobileOpen = false">
                    <x-icon-telegram :size="16" /> <span>Telegram</span>
                </a>
                <a href="https://wa.me/85598334755" target="_blank" rel="noopener" class="cn-panel-link" @click="mobileOpen = false">
                    💬 <span>WhatsApp</span>
                </a>
                <a href="mailto:hello@srmacshop.com" class="cn-panel-link" @click="mobileOpen = false">
                    ✉️ <span>Email</span>
                </a>
            </div>
        </div>
    </aside>

    {{-- ═════ Mobile search overlay (Phase 1) ═════ --}}
    <div class="cn-search-overlay" x-show="searchOpen" x-cloak x-transition.opacity @keydown.escape.window="searchOpen = false">
        <form action="{{ route('shop') }}" method="GET" class="cn-search-overlay-form">
            <div class="cn-search-overlay-head">
                <div class="cn-search-overlay-input-wrap">
                    <span class="cn-search-icon">🔍</span>
                    <input type="text" name="q" x-ref="searchInp" autocomplete="off"
                        placeholder="Search MacBooks..."
                        data-en="Search MacBooks..." data-km="ស្វែងរក MacBook..." data-zh="搜索 MacBook...">
                </div>
                <button type="button" class="cn-search-overlay-close" @click="searchOpen = false"
                    data-en="Cancel" data-km="បោះបង់" data-zh="取消">Cancel</button>
            </div>

            @if($navCategories->count())
                <div class="cn-search-overlay-section">
                    <div class="cn-search-overlay-title" data-en="Browse by category" data-km="មើលតាមប្រភេទ" data-zh="按类别浏览">Browse by category</div>
                    <div class="cn-search-overlay-cats">
                        @foreach($navCategories as $cat)
                            <a href="{{ route('shop') }}?category={{ $cat->slug }}" class="cn-search-overlay-chip" @click="searchOpen = false">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="cn-search-overlay-section">
                <div class="cn-search-overlay-title" data-en="Popular searches" data-km="ការស្វែងរកពេញនិយម" data-zh="热门搜索">Popular searches</div>
                <div class="cn-search-overlay-cats">
                    <a href="{{ route('shop') }}?q=MacBook+Air" class="cn-search-overlay-chip" @click="searchOpen = false">MacBook Air</a>
                    <a href="{{ route('shop') }}?q=MacBook+Pro" class="cn-search-overlay-chip" @click="searchOpen = false">MacBook Pro</a>
                    <a href="{{ route('shop') }}?q=M4" class="cn-search-overlay-chip" @click="searchOpen = false">M4 chip</a>
                    <a href="{{ route('shop') }}?q=AppleCare" class="cn-search-overlay-chip" @click="searchOpen = false">AppleCare</a>
                </div>
            </div>
        </form>
    </div>

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
