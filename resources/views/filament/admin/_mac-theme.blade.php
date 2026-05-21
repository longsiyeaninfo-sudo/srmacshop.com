{{-- macOS Premium Theme: global chrome overrides for Filament 3. --}}
{{-- Injected via PanelsRenderHook::HEAD_END so it loads after Filament's CSS. --}}
<style>
:root {
  --mac-font: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
  --mac-blue: #007aff;
  --mac-blue-hover: #006fe6;
  --mac-blue-soft: rgba(0,122,255,.18);
  --mac-orange: #f97316;
  --mac-orange-hover: #ea580c;
  --mac-gray-50: #f5f5f7;
  --mac-gray-100: #e5e5ea;
  --mac-gray-200: #d2d2d7;
  --mac-gray-300: #a1a1a6;
  --mac-text: #1d1d1f;
  --mac-text-soft: #6e6e73;
  --mac-glass-light: rgba(246,246,246,.78);
  --mac-glass-dark: rgba(28,28,30,.78);
  --mac-shadow-sm: 0 1px 2px rgba(0,0,0,.04), 0 1px 3px rgba(0,0,0,.06);
  --mac-shadow-md: 0 4px 12px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04);
  --mac-shadow-lg: 0 20px 40px rgba(0,0,0,.12), 0 8px 16px rgba(0,0,0,.06);
  --mac-radius-sm: 8px;
  --mac-radius: 10px;
  --mac-radius-lg: 14px;
  --mac-radius-pill: 980px;
  --mac-ease: cubic-bezier(.4, 0, .2, 1);
}
.dark {
  --mac-text: #f5f5f7;
  --mac-text-soft: #a1a1a6;
  --mac-gray-50: #1c1c1e;
  --mac-gray-100: #2c2c2e;
  --mac-gray-200: rgba(255,255,255,.14);
}

/* ──────────────── Typography ──────────────── */
html, body, .fi-body, .fi-layout {
  font-family: var(--mac-font) !important;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  letter-spacing: -0.011em;
}

/* ──────────────── Page background ──────────────── */
.fi-body, .fi-main-ctn, .fi-main {
  background: var(--mac-gray-50) !important;
}
.dark .fi-body, .dark .fi-main-ctn, .dark .fi-main {
  background: #1c1c1e !important;
}

/* ──────────────── Sidebar: frosted glass ──────────────── */
.fi-sidebar {
  background: var(--mac-glass-light) !important;
  backdrop-filter: blur(24px) saturate(180%);
  -webkit-backdrop-filter: blur(24px) saturate(180%);
  border-right: 1px solid rgba(0,0,0,.06) !important;
  box-shadow: none !important;
}
.dark .fi-sidebar {
  background: var(--mac-glass-dark) !important;
  border-right-color: rgba(255,255,255,.08) !important;
}

.fi-sidebar-header {
  background: transparent !important;
  border-bottom: 1px solid rgba(0,0,0,.06) !important;
}
.dark .fi-sidebar-header { border-bottom-color: rgba(255,255,255,.08) !important; }

.fi-sidebar-nav-groups { padding: 8px !important; }
.fi-sidebar-group-label {
  font-size: 11px !important;
  font-weight: 700 !important;
  text-transform: uppercase;
  letter-spacing: .06em;
  color: var(--mac-text-soft) !important;
  padding: 12px 12px 6px !important;
}

.fi-sidebar-item-button, a.fi-sidebar-item-button {
  border-radius: var(--mac-radius-sm) !important;
  padding: 7px 12px !important;
  font-weight: 500 !important;
  font-size: 13.5px !important;
  color: var(--mac-text) !important;
  transition: background .12s var(--mac-ease), color .12s var(--mac-ease) !important;
}
.fi-sidebar-item-button:hover {
  background: rgba(0,0,0,.05) !important;
}
.dark .fi-sidebar-item-button:hover {
  background: rgba(255,255,255,.06) !important;
}
.fi-sidebar-item-active > .fi-sidebar-item-button,
.fi-sidebar-item-button[aria-current="page"] {
  background: var(--mac-blue) !important;
  color: #fff !important;
  box-shadow: 0 1px 2px rgba(0,122,255,.25);
}
.fi-sidebar-item-active > .fi-sidebar-item-button .fi-icon,
.fi-sidebar-item-active > .fi-sidebar-item-button svg {
  color: #fff !important;
}

/* ──────────────── Topbar: frosted glass ──────────────── */
.fi-topbar {
  background: var(--mac-glass-light) !important;
  backdrop-filter: blur(24px) saturate(180%);
  -webkit-backdrop-filter: blur(24px) saturate(180%);
  border-bottom: 1px solid rgba(0,0,0,.06) !important;
  box-shadow: none !important;
}
.dark .fi-topbar {
  background: var(--mac-glass-dark) !important;
  border-bottom-color: rgba(255,255,255,.08) !important;
}

/* ──────────────── Visit Shop topbar pill polish ──────────────── */
.fi-topbar a[href][target="_blank"][style*="background:#f97316"],
.fi-topbar a[href][target="_blank"][style*="background: #f97316"] {
  background: linear-gradient(180deg, #ff9522, #f97316) !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.25), 0 1px 2px rgba(0,0,0,.1) !important;
  transition: transform .15s var(--mac-ease), box-shadow .15s var(--mac-ease) !important;
}
.fi-topbar a[href][target="_blank"][style*="background:#f97316"]:hover,
.fi-topbar a[href][target="_blank"][style*="background: #f97316"]:hover {
  transform: translateY(-1px);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.25), 0 4px 8px rgba(249,115,22,.3) !important;
}

/* ──────────────── Sections / cards ──────────────── */
.fi-section {
  background: #fff !important;
  border: 1px solid rgba(0,0,0,.06) !important;
  border-radius: var(--mac-radius-lg) !important;
  box-shadow: var(--mac-shadow-sm) !important;
}
.dark .fi-section {
  background: #2c2c2e !important;
  border-color: rgba(255,255,255,.08) !important;
}
.fi-section-header { border-bottom: 1px solid rgba(0,0,0,.05) !important; }
.dark .fi-section-header { border-bottom-color: rgba(255,255,255,.06) !important; }
.fi-section-header-heading { font-weight: 700 !important; letter-spacing: -0.012em; }

/* ──────────────── Buttons (Apple Blue primary, Orange warning) ──────────────── */
.fi-btn {
  font-family: var(--mac-font) !important;
  font-weight: 600 !important;
  border-radius: var(--mac-radius-sm) !important;
  transition: transform .12s var(--mac-ease), box-shadow .12s var(--mac-ease), background .12s var(--mac-ease) !important;
  letter-spacing: -0.011em;
}
.fi-btn:active:not(:disabled) { transform: scale(.97); }

.fi-btn-color-primary {
  background: linear-gradient(180deg, #0a84ff, #006fe6) !important;
  color: #fff !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.18), 0 1px 2px rgba(0,122,255,.25) !important;
  border: 0 !important;
}
.fi-btn-color-primary:hover:not(:disabled) {
  background: linear-gradient(180deg, #0a84ff, #005ed1) !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 4px 10px rgba(0,122,255,.35) !important;
}

.fi-btn-color-warning {
  background: linear-gradient(180deg, #ff9522, #f97316) !important;
  color: #fff !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.18), 0 1px 2px rgba(249,115,22,.25) !important;
  border: 0 !important;
}
.fi-btn-color-warning:hover:not(:disabled) {
  background: linear-gradient(180deg, #ff9522, #ea580c) !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 4px 10px rgba(249,115,22,.35) !important;
}

.fi-btn-color-success {
  background: linear-gradient(180deg, #32d74b, #28a745) !important;
  color: #fff !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.18), 0 1px 2px rgba(40,167,69,.22) !important;
  border: 0 !important;
}

.fi-btn-color-danger {
  background: linear-gradient(180deg, #ff453a, #d70015) !important;
  color: #fff !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.18), 0 1px 2px rgba(215,0,21,.25) !important;
  border: 0 !important;
}

.fi-btn-color-gray {
  background: rgba(0,0,0,.05) !important;
  color: var(--mac-text) !important;
  border: 1px solid rgba(0,0,0,.08) !important;
  box-shadow: none !important;
}
.dark .fi-btn-color-gray {
  background: rgba(255,255,255,.08) !important;
  color: var(--mac-text) !important;
  border-color: rgba(255,255,255,.12) !important;
}

/* ──────────────── Inputs ──────────────── */
.fi-input, .fi-select-input, textarea.fi-input {
  font-family: var(--mac-font) !important;
  border: 1px solid var(--mac-gray-200) !important;
  border-radius: var(--mac-radius-sm) !important;
  background: #fff !important;
  transition: border-color .12s var(--mac-ease), box-shadow .12s var(--mac-ease) !important;
}
.dark .fi-input, .dark .fi-select-input, .dark textarea.fi-input {
  background: rgba(255,255,255,.04) !important;
  border-color: rgba(255,255,255,.12) !important;
}
.fi-input:focus, .fi-select-input:focus, textarea.fi-input:focus,
.fi-input-wrp:focus-within {
  border-color: var(--mac-blue) !important;
  box-shadow: 0 0 0 4px var(--mac-blue-soft) !important;
  outline: 0 !important;
}

.fi-fo-field-wrp-label { font-size: 13px !important; font-weight: 600 !important; }

/* ──────────────── Tables ──────────────── */
.fi-ta {
  border-radius: var(--mac-radius-lg) !important;
  overflow: hidden;
  box-shadow: var(--mac-shadow-sm) !important;
  border: 1px solid rgba(0,0,0,.06) !important;
}
.dark .fi-ta { border-color: rgba(255,255,255,.08) !important; }

.fi-ta-header {
  background: rgba(0,0,0,.02) !important;
  border-bottom: 1px solid rgba(0,0,0,.06) !important;
}
.dark .fi-ta-header {
  background: rgba(255,255,255,.03) !important;
  border-bottom-color: rgba(255,255,255,.08) !important;
}

.fi-ta-table thead {
  position: sticky;
  top: 0;
  z-index: 5;
  background: rgba(245,245,247,.95) !important;
  backdrop-filter: blur(12px);
}
.dark .fi-ta-table thead { background: rgba(28,28,30,.95) !important; }

.fi-ta-header-cell {
  font-size: 11.5px !important;
  font-weight: 700 !important;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: var(--mac-text-soft) !important;
  padding: 12px 16px !important;
}

.fi-ta-row {
  transition: background .12s var(--mac-ease) !important;
  border-bottom: 1px solid rgba(0,0,0,.04) !important;
}
.dark .fi-ta-row { border-bottom-color: rgba(255,255,255,.05) !important; }
.fi-ta-row:nth-child(even) { background: rgba(0,0,0,.015) !important; }
.dark .fi-ta-row:nth-child(even) { background: rgba(255,255,255,.02) !important; }
.fi-ta-row:hover { background: rgba(0,122,255,.05) !important; }
.dark .fi-ta-row:hover { background: rgba(0,122,255,.08) !important; }

.fi-ta-cell { padding: 13px 16px !important; font-size: 13.5px !important; }

/* ──────────────── Badges ──────────────── */
.fi-badge {
  border-radius: var(--mac-radius-pill) !important;
  font-weight: 600 !important;
  letter-spacing: -0.005em;
  padding: 3px 10px !important;
}

/* ──────────────── Modals / dropdowns ──────────────── */
.fi-modal-window {
  border-radius: var(--mac-radius-lg) !important;
  box-shadow: var(--mac-shadow-lg) !important;
  border: 1px solid rgba(0,0,0,.06) !important;
}
.fi-dropdown-panel {
  border-radius: var(--mac-radius) !important;
  box-shadow: var(--mac-shadow-md) !important;
  border: 1px solid rgba(0,0,0,.08) !important;
  background: rgba(255,255,255,.96) !important;
  backdrop-filter: blur(16px);
}
.dark .fi-dropdown-panel {
  background: rgba(44,44,46,.96) !important;
  border-color: rgba(255,255,255,.1) !important;
}

/* ──────────────── Tabs ──────────────── */
.fi-tabs {
  background: rgba(0,0,0,.04) !important;
  border-radius: var(--mac-radius-sm) !important;
  padding: 3px !important;
  border: 0 !important;
}
.dark .fi-tabs { background: rgba(255,255,255,.06) !important; }
.fi-tabs-item {
  border-radius: 6px !important;
  border: 0 !important;
  background: transparent !important;
  transition: background .12s var(--mac-ease) !important;
}
.fi-tabs-item-active {
  background: #fff !important;
  box-shadow: var(--mac-shadow-sm) !important;
}
.dark .fi-tabs-item-active { background: #3a3a3c !important; }

/* ──────────────── Pagination ──────────────── */
.fi-pagination {
  background: transparent !important;
  border: 0 !important;
  padding: 12px 4px !important;
}

/* ──────────────── Headings ──────────────── */
.fi-header-heading {
  font-weight: 800 !important;
  letter-spacing: -0.022em;
  font-size: 26px !important;
}

/* ──────────────── Custom-page compat: don't break .pp-* / .kd-* ──────────────── */
.pp-input, .kd-chip { font-family: var(--mac-font); }
.pp-card, .kd-card {
  box-shadow: var(--mac-shadow-sm);
  border-radius: var(--mac-radius-lg) !important;
}

/* ──────────────── Login page: gradient backdrop + glass card ──────────────── */
.fi-simple-layout {
  background:
    radial-gradient(at 20% 20%, rgba(0,122,255,.15) 0%, transparent 50%),
    radial-gradient(at 80% 70%, rgba(249,115,22,.12) 0%, transparent 50%),
    radial-gradient(at 50% 90%, rgba(175,82,222,.10) 0%, transparent 50%),
    linear-gradient(135deg, #f5f5f7 0%, #e5e5ea 100%) !important;
  min-height: 100vh;
}
.dark .fi-simple-layout {
  background:
    radial-gradient(at 20% 20%, rgba(0,122,255,.18) 0%, transparent 50%),
    radial-gradient(at 80% 70%, rgba(249,115,22,.15) 0%, transparent 50%),
    radial-gradient(at 50% 90%, rgba(175,82,222,.12) 0%, transparent 50%),
    linear-gradient(135deg, #1c1c1e 0%, #0a0a0a 100%) !important;
}

.fi-simple-main {
  background: rgba(255,255,255,.78) !important;
  backdrop-filter: blur(28px) saturate(180%);
  -webkit-backdrop-filter: blur(28px) saturate(180%);
  border: 1px solid rgba(255,255,255,.6) !important;
  border-radius: 18px !important;
  box-shadow:
    0 24px 60px rgba(0,0,0,.12),
    0 8px 16px rgba(0,0,0,.06),
    inset 0 1px 0 rgba(255,255,255,.5) !important;
}
.dark .fi-simple-main {
  background: rgba(44,44,46,.78) !important;
  border-color: rgba(255,255,255,.12) !important;
}

/* macOS traffic-light dots in the top-left of the login card */
.fi-simple-main::before {
  content: "";
  position: absolute;
  top: 14px;
  left: 14px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #ff5f57;
  box-shadow:
    20px 0 0 #ffbd2e,
    40px 0 0 #28c940;
}
.fi-simple-main {
  position: relative;
}

.fi-simple-main-ctn .fi-logo,
.fi-simple-main-ctn img[alt*="logo" i] {
  margin: 0 auto 4px;
}

.fi-simple-header-heading {
  font-weight: 800 !important;
  letter-spacing: -0.024em;
}
</style>
