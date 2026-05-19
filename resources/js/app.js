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
        init() {
            this.apply(this.current);
        },
        toggle() {
            this.current = this.current === 'en' ? 'km' : 'en';
            this.apply(this.current);
            localStorage.setItem('srmac_lang', JSON.stringify(this.current));
        },
        apply(lang) {
            document.querySelectorAll('[data-en]').forEach(el => {
                const val = el.getAttribute('data-' + lang);
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

// Scroll reveal: opt-in via .reveal class. Used by Phase 9; safe to ship now.
(function () {
    if (!('IntersectionObserver' in window)) return;
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.05 });

    const observe = () => document.querySelectorAll('.reveal:not(.is-visible)').forEach((el) => io.observe(el));
    document.addEventListener('DOMContentLoaded', observe);
    document.addEventListener('livewire:initialized', () => {
        if (window.Livewire?.hook) {
            window.Livewire.hook('morph.updated', observe);
        }
    });
})();
