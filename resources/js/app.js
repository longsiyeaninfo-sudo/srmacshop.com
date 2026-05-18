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

// Apply theme & lang immediately on first load (before Alpine hydrates everything)
(function () {
    const theme = (localStorage.getItem('srmac_theme') || 'light').replace(/"/g, '');
    document.documentElement.setAttribute('data-theme', theme);
    const lang = (localStorage.getItem('srmac_lang') || 'en').replace(/"/g, '');
    document.documentElement.setAttribute('lang', lang);
})();

// Re-apply lang after Livewire morphs the DOM
document.addEventListener('livewire:initialized', () => {
    if (window.Livewire && typeof window.Livewire.hook === 'function') {
        window.Livewire.hook('morph.updated', () => {
            const lang = Alpine.store('lang')?.current || 'en';
            Alpine.store('lang').apply(lang);
        });
    }
});

// Also re-apply after any DOM update (e.g. modals opening)
document.addEventListener('livewire:navigated', () => {
    const lang = Alpine.store('lang')?.current || 'en';
    Alpine.store('lang').apply(lang);
});
