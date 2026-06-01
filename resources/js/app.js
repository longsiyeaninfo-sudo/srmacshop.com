import './bootstrap';

// NOTE: Do NOT import Alpine here — Livewire 3 includes Alpine and exposes it
// as window.Alpine. Importing again causes "Multiple instances of Alpine" and
// breaks $wire bindings.

// Wait for Alpine (from Livewire) to be ready before registering stores
document.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine;

    Alpine.store('theme', {
        current: Alpine.$persist
            ? Alpine.$persist('light').as('srmac_theme')
            : (localStorage.getItem('srmac_theme') || 'light').replace(/"/g, ''),
        init() {
            document.documentElement.setAttribute('data-theme', this.current);
        },
        toggle() {
            this.current = this.current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', this.current);
            localStorage.setItem('srmac_theme', JSON.stringify(this.current));
        },
    });

    Alpine.store('lang', {
        current: (localStorage.getItem('srmac_lang') || 'en').replace(/"/g, ''),
        supported: ['en', 'km', 'zh'],
        init() {
            if (!this.supported.includes(this.current)) this.current = 'en';
            this.apply(this.current);
        },
        set(lang) {
            if (!this.supported.includes(lang) || lang === this.current) return;
            this.current = lang;
            this.apply(lang);
            localStorage.setItem('srmac_lang', JSON.stringify(lang));
        },
        toggle() {
            // Cycle EN → KM → ZH → EN (kept for backwards compat with any old callers)
            const i = this.supported.indexOf(this.current);
            this.set(this.supported[(i + 1) % this.supported.length]);
        },
        apply(lang) {
            document.querySelectorAll('[data-en]').forEach(el => {
                // Fall back to English when the chosen lang isn't translated on this element
                const val = el.getAttribute('data-' + lang) ?? el.getAttribute('data-en');
                if (val !== null) el.textContent = val;
            });
            document.documentElement.setAttribute('lang', lang);
        },
    });
});

// Pre-paint theme & lang before Alpine boots to prevent FOUC
(function () {
    const theme = (localStorage.getItem('srmac_theme') || 'light').replace(/"/g, '');
    document.documentElement.setAttribute('data-theme', theme);
    const lang = (localStorage.getItem('srmac_lang') || 'en').replace(/"/g, '');
    document.documentElement.setAttribute('lang', lang);
})();

// Re-apply translations after every Livewire morph
document.addEventListener('livewire:initialized', () => {
    if (window.Livewire && typeof window.Livewire.hook === 'function') {
        window.Livewire.hook('morph.updated', () => {
            const store = window.Alpine?.store('lang');
            if (store) store.apply(store.current);
        });
    }
});

// Live countdown timer: any element with [data-countdown="ISO8601"] gets a
// child .hp-hero-cdtimer (or .cd-timer) updated every second.
(function () {
    const fmt = (ms) => {
        if (ms <= 0) return 'Ended';
        const s = Math.floor(ms / 1000);
        const d = Math.floor(s / 86400);
        const h = Math.floor((s % 86400) / 3600);
        const m = Math.floor((s % 3600) / 60);
        const sec = s % 60;
        if (d > 0) return `${d}d ${h}h ${m}m`;
        if (h > 0) return `${h}h ${m}m ${sec}s`;
        if (m > 0) return `${m}m ${sec}s`;
        return `${sec}s`;
    };
    const tick = () => {
        document.querySelectorAll('[data-countdown]').forEach((el) => {
            const target = new Date(el.getAttribute('data-countdown')).getTime();
            const out = el.querySelector('.hp-hero-cdtimer, .cd-timer');
            if (!out || isNaN(target)) return;
            out.textContent = fmt(target - Date.now());
        });
    };
    const start = () => {
        tick();
        setInterval(tick, 1000);
    };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();

// Mobile bottom tab bar: hides on scroll-down past 100px, shows on scroll-up.
// Twitter / Instagram pattern. Pure CSS class toggle — no animation flicker.
(function () {
    let lastY = 0;
    let ticking = false;
    const update = () => {
        const bar = document.querySelector('.cn-tabbar');
        if (!bar) { ticking = false; return; }
        const y = window.scrollY;
        const delta = y - lastY;
        if (y < 100) {
            bar.classList.remove('is-hidden');
        } else if (delta > 4) {
            bar.classList.add('is-hidden');
        } else if (delta < -4) {
            bar.classList.remove('is-hidden');
        }
        // When the tab bar slides away, let the sticky deal bar drop into its place.
        document.body.classList.toggle('tabbar-hidden', bar.classList.contains('is-hidden'));
        lastY = y;
        ticking = false;
    };
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(update);
            ticking = true;
        }
    }, { passive: true });
})();

// Scroll-aware nav: adds .is-scrolled when user scrolls past the top
(function () {
    const apply = () => {
        const nav = document.getElementById('cust-nav');
        if (!nav) return;
        if (window.scrollY > 20) nav.classList.add('is-scrolled');
        else nav.classList.remove('is-scrolled');
    };
    document.addEventListener('DOMContentLoaded', apply);
    window.addEventListener('scroll', apply, { passive: true });
})();

// Scroll reveal: opt-in via .reveal class.
(function () {
    if (!('IntersectionObserver' in window)) {
        // No IO support — show everything immediately so content isn't hidden.
        document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });

    const observe = () => document.querySelectorAll('.reveal:not(.is-visible)').forEach((el) => io.observe(el));

    // Run immediately (script is loaded at end of body via Vite), and also on
    // DOMContentLoaded for safety + after Livewire morphs new content in.
    observe();
    document.addEventListener('DOMContentLoaded', observe);
    document.addEventListener('livewire:initialized', () => {
        if (window.Livewire?.hook) {
            window.Livewire.hook('morph.updated', observe);
        }
    });
})();
