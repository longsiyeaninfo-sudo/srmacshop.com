<style>
.st-wrap{max-width:720px;margin:0 auto;display:flex;flex-direction:column;gap:18px}
.st-card{background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:14px;padding:22px;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.dark .st-card{background:#2c2c2e;border-color:rgba(255,255,255,.08)}
.st-h{font-size:17px;font-weight:700;margin:0 0 4px;color:#1d1d1f;letter-spacing:-.012em}
.dark .st-h{color:#f5f5f7}
.st-sub{font-size:13px;color:#6e6e73;margin:0 0 16px}
.st-section{padding-bottom:14px;border-bottom:1px solid rgba(0,0,0,.05);margin-bottom:14px}
.dark .st-section{border-color:rgba(255,255,255,.06)}
.st-section:last-of-type{border:0;margin-bottom:0;padding-bottom:0}

.st-f{margin-bottom:13px}
.st-f label{display:block;font-size:12.5px;font-weight:600;color:#1d1d1f;margin-bottom:5px}
.dark .st-f label{color:#f5f5f7}
.st-hint{font-size:11.5px;color:#6e6e73;margin-top:4px;line-height:1.4}
.st-input{width:100%;padding:9px 13px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;background:#fff;color:#1d1d1f;outline:none;transition:all .15s cubic-bezier(.4,0,.2,1);font-family:inherit}
.dark .st-input{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
.st-input:focus{border-color:#007aff;box-shadow:0 0 0 4px rgba(0,122,255,.18)}
.st-input.st-mono{font-family:ui-monospace,'SF Mono',Consolas,monospace;font-size:13px}
textarea.st-input{min-height:80px;resize:vertical;line-height:1.5}

.st-row2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.st-row3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
@media(max-width:640px){.st-row2,.st-row3{grid-template-columns:1fr}}

.st-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:rgba(0,0,0,.02);border-radius:10px;margin-bottom:8px;cursor:pointer;transition:background .12s cubic-bezier(.4,0,.2,1)}
.dark .st-toggle-row{background:rgba(255,255,255,.03)}
.st-toggle-row:hover{background:rgba(0,0,0,.04)}
.dark .st-toggle-row:hover{background:rgba(255,255,255,.05)}
.st-tg-l{font-weight:600;font-size:13.5px;color:#1d1d1f}
.dark .st-tg-l{color:#f5f5f7}
.st-tg-d{font-size:11.5px;color:#6e6e73;margin-top:2px}
.st-sw{width:38px;height:22px;background:#d2d2d7;border-radius:980px;position:relative;transition:background .15s;flex-shrink:0;margin-left:14px}
.st-sw.on{background:#34c759}
.st-sw-dot{position:absolute;top:2px;left:2px;width:18px;height:18px;background:#fff;border-radius:50%;transition:transform .15s;box-shadow:0 1px 2px rgba(0,0,0,.18)}
.st-sw.on .st-sw-dot{transform:translateX(16px)}

.st-save{width:100%;padding:11px;border:0;border-radius:9px;font-size:14px;font-weight:700;cursor:pointer;color:#fff;background:linear-gradient(180deg,#ff9522,#f97316);box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 1px 2px rgba(249,115,22,.25);font-family:inherit;transition:all .12s cubic-bezier(.4,0,.2,1);margin-top:8px}
.st-save:hover{box-shadow:inset 0 1px 0 rgba(255,255,255,.2),0 4px 10px rgba(249,115,22,.35)}

.st-err{font-size:12px;color:#ff3b30;margin-top:4px}
.st-bdg{display:inline-block;font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:980px;background:rgba(0,122,255,.12);color:#007aff;margin-left:6px;text-transform:uppercase;letter-spacing:.05em}
</style>
