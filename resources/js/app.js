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
