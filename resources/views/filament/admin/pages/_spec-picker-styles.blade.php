{{--
  Styles for the shared spec picker (_spec-picker.blade.php).
  MUST be @include'd from each page's TOP-LEVEL @push('styles') so it loads on the
  initial page render — Livewire morphs (the step1→step2 transition) do NOT inject
  @push blocks into the already-loaded <head>.
--}}
<style>
    /* Trigger row — looks like .pp-input so it sits naturally next to Title/Price */
    .pp-picker{display:flex;align-items:center;justify-content:space-between;gap:10px;width:100%;
        padding:9px 12px;border:1px solid #d1d5db;border-radius:8px;background:#fff;color:#111827;
        font-size:14px;font-weight:500;cursor:pointer;text-align:left;transition:border-color .15s}
    .dark .pp-picker{background:#111827;border-color:#374151;color:#f9fafb}
    .pp-picker:hover{border-color:#3b82f6}
    .pp-picker:focus-visible{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
    .pp-picker.is-empty{color:#9ca3af;font-weight:400}
    .dark .pp-picker.is-empty{color:#6b7280}
    .pp-picker-val{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .pp-picker-caret{color:#9ca3af;font-size:11px;flex-shrink:0}

    /* Backdrop + sheet (centered modal on desktop, slide-up sheet on mobile) */
    .pp-sheet-backdrop{position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.6);
        -webkit-backdrop-filter:blur(2px);backdrop-filter:blur(2px);
        display:flex;align-items:center;justify-content:center;padding:16px}
    .pp-sheet{background:#fff;border-radius:16px;width:100%;max-width:460px;max-height:80vh;
        display:flex;flex-direction:column;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.4)}
    .dark .pp-sheet{background:#1f2937}
    .pp-sheet-head{display:flex;align-items:center;justify-content:space-between;
        padding:14px 16px;border-bottom:1px solid #eef2f7;font-size:16px;font-weight:700;color:#0f172a}
    .dark .pp-sheet-head{border-color:#374151;color:#f9fafb}
    .pp-sheet-close{width:32px;height:32px;border-radius:50%;border:none;background:#f1f5f9;color:#334155;
        font-size:15px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center}
    .pp-sheet-close:hover{background:#e2e8f0}
    .dark .pp-sheet-close{background:#374151;color:#e5e7eb}
    .pp-sheet-search{margin:12px 16px 4px;padding:10px 12px;border:1px solid #d1d5db;border-radius:10px;
        font-size:14px;background:#f8fafc;color:#111827;outline:none}
    .pp-sheet-search:focus{border-color:#3b82f6;background:#fff;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
    .dark .pp-sheet-search{background:#111827;border-color:#374151;color:#f9fafb}
    .pp-sheet-list{overflow-y:auto;padding:6px 10px 12px;display:flex;flex-direction:column;gap:2px}
    .pp-sheet-opt{display:flex;align-items:center;justify-content:space-between;gap:10px;width:100%;
        padding:13px 14px;border:none;border-radius:10px;background:transparent;color:#0f172a;
        font-size:15px;font-weight:500;text-align:left;cursor:pointer;transition:background .12s}
    .pp-sheet-opt:hover{background:#f1f5f9}
    .dark .pp-sheet-opt{color:#f3f4f6}
    .dark .pp-sheet-opt:hover{background:#374151}
    .pp-sheet-opt.on{background:#fff7ed;color:#c2410c;font-weight:700}
    .dark .pp-sheet-opt.on{background:#431407;color:#fb923c}
    .pp-sheet-opt.on::after{content:'✓';color:#f97316;font-weight:800;flex-shrink:0}
    .pp-sheet-empty{padding:24px;text-align:center;color:#9ca3af;font-size:14px}

    @media(max-width:640px){
        .pp-sheet-backdrop{align-items:flex-end;padding:0}
        .pp-sheet{max-width:none;max-height:78vh;border-radius:18px 18px 0 0}
        .pp-sheet-opt{padding:15px 14px}
    }
</style>
