import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

Alpine.plugin(persist);

// ── Theme store ──
Alpine.store('theme', {
    current: Alpine.$persist('light').as('srmac_theme'),
    init() {
        document.documentElement.setAttribute('data-theme', this.current);
    },
    toggle() {
        this.current = this.current === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', this.current);
    },
});

// ── Language store ──
Alpine.store('lang', {
    current: Alpine.$persist('en').as('srmac_lang'),
    init() {
        this.apply(this.current);
    },
    toggle() {
        this.current = this.current === 'en' ? 'km' : 'en';
        this.apply(this.current);
        document.documentElement.setAttribute('lang', this.current);
    },
    apply(lang) {
        document.querySelectorAll('[data-en]').forEach(el => {
            const val = el.getAttribute('data-' + lang);
            if (val !== null) el.textContent = val;
        });
        document.documentElement.setAttribute('lang', lang);
    },
});

window.Alpine = Alpine;
Alpine.start();

// Apply theme & lang on first load before Alpine hydrates
(function () {
    const theme = localStorage.getItem('srmac_theme')?.replace(/"/g, '') || 'light';
    document.documentElement.setAttribute('data-theme', theme);
    const lang = localStorage.getItem('srmac_lang')?.replace(/"/g, '') || 'en';
    document.documentElement.setAttribute('lang', lang);
})();

// Re-apply lang when Livewire morphs the DOM
document.addEventListener('livewire:update', () => {
    const lang = Alpine.store('lang')?.current || 'en';
    Alpine.store('lang').apply(lang);
});
