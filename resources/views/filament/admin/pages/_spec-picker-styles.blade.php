{{--
  Styles for the shared spec picker (_spec-picker.blade.php).
  MUST be @include'd from each page's TOP-LEVEL @push('styles') so it loads on the
  initial page render — Livewire morphs (the step1→step2 transition) do NOT inject
  @push blocks into the already-loaded <head>.

  Design goal: the trigger row is visually identical to the form's own .pp-input /
  select.pp-input controls (same height, border, radius, thin SVG chevron) so the
  spec fields line up cleanly next to Title / Price / Province. The sheet is a tidy
  Khmer24-style list (hairline dividers, big tap targets, slide-up on mobile).
--}}
<style>
    /* ---- Trigger row : matches .pp-input metrics exactly ---- */
    .pp-picker{display:flex;align-items:center;justify-content:space-between;gap:8px;width:100%;
        min-height:38px;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;background:#fff;
        color:#111827;font-size:14px;font-weight:400;line-height:1.4;cursor:pointer;text-align:left;
        transition:border-color .15s,box-shadow .15s}
    .dark .pp-picker{background:#111827;border-color:#374151;color:#f9fafb}
    .pp-picker:hover{border-color:#9ca3af}
    .dark .pp-picker:hover{border-color:#4b5563}
    .pp-picker:focus-visible{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
    .pp-picker.is-empty{color:#9ca3af}
    .dark .pp-picker.is-empty{color:#6b7280}
    .pp-picker-val{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1}
    .pp-picker-caret{flex-shrink:0;width:18px;height:18px;color:#6b7280;transition:transform .2s ease}
    .dark .pp-picker-caret{color:#9ca3af}
    .pp-picker-caret.is-open{transform:rotate(180deg)}

    /* ---- Backdrop + sheet ---- */
    .pp-sheet-backdrop{position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.55);
        -webkit-backdrop-filter:blur(3px);backdrop-filter:blur(3px);
        display:flex;align-items:center;justify-content:center;padding:16px}
    .pp-sheet{background:#fff;border-radius:16px;width:100%;max-width:440px;max-height:80vh;
        display:flex;flex-direction:column;overflow:hidden;
        box-shadow:0 24px 60px rgba(0,0,0,.35);animation:pp-pop .18s ease-out}
    .dark .pp-sheet{background:#1f2937;box-shadow:0 24px 60px rgba(0,0,0,.6)}
    @keyframes pp-pop{from{opacity:0;transform:scale(.97) translateY(6px)}to{opacity:1;transform:none}}

    /* drag handle — mobile only */
    .pp-sheet-grip{display:none}

    .pp-sheet-head{position:relative;display:flex;align-items:center;justify-content:center;
        padding:15px 52px;font-size:15px;font-weight:600;color:#0f172a;border-bottom:1px solid #eef2f7}
    .dark .pp-sheet-head{color:#f9fafb;border-color:#374151}
    .pp-sheet-close{position:absolute;right:12px;top:50%;transform:translateY(-50%);
        width:30px;height:30px;border-radius:50%;border:none;background:#f1f5f9;color:#64748b;
        cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .12s,color .12s}
    .pp-sheet-close svg{width:15px;height:15px}
    .pp-sheet-close:hover{background:#e2e8f0;color:#0f172a}
    .dark .pp-sheet-close{background:#374151;color:#cbd5e1}
    .dark .pp-sheet-close:hover{background:#4b5563;color:#f9fafb}

    /* search */
    .pp-sheet-search-wrap{position:relative;padding:12px 16px 8px}
    .pp-sheet-search-ico{position:absolute;left:28px;top:50%;transform:translateY(-50%);
        width:16px;height:16px;color:#9ca3af;pointer-events:none}
    .pp-sheet-search{width:100%;padding:10px 12px 10px 38px;border:1px solid #e5e7eb;border-radius:10px;
        font-size:14px;background:#f8fafc;color:#111827;outline:none;transition:border-color .15s,background .15s,box-shadow .15s}
    .pp-sheet-search::placeholder{color:#9ca3af}
    .pp-sheet-search:focus{border-color:#3b82f6;background:#fff;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
    .dark .pp-sheet-search{background:#111827;border-color:#374151;color:#f9fafb}

    /* option list */
    .pp-sheet-list{overflow-y:auto;-webkit-overflow-scrolling:touch;padding:4px 0 8px}
    .pp-sheet-opt{display:flex;align-items:center;gap:10px;width:100%;
        padding:13px 18px;border:none;background:transparent;color:#0f172a;
        font-size:15px;font-weight:400;text-align:left;cursor:pointer;transition:background .12s}
    .pp-sheet-opt+.pp-sheet-opt{box-shadow:inset 0 1px 0 #f1f5f9}   /* hairline divider */
    .dark .pp-sheet-opt{color:#e5e7eb}
    .dark .pp-sheet-opt+.pp-sheet-opt{box-shadow:inset 0 1px 0 #374151}
    .pp-sheet-opt:hover{background:#f8fafc}
    .dark .pp-sheet-opt:hover{background:#374151}
    .pp-sheet-opt.on{color:#c2410c;font-weight:600;background:#fff7ed}
    .dark .pp-sheet-opt.on{color:#fb923c;background:#431407}
    .pp-opt-label{flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .pp-opt-check{flex-shrink:0;width:18px;height:18px;color:#f97316;opacity:0;transition:opacity .12s}
    .pp-sheet-opt.on .pp-opt-check{opacity:1}
    .pp-sheet-empty{padding:28px;text-align:center;color:#9ca3af;font-size:14px}

    @media(max-width:640px){
        .pp-sheet-backdrop{align-items:flex-end;padding:0}
        .pp-sheet{max-width:none;max-height:82vh;border-radius:20px 20px 0 0;
            animation:pp-sheetup .3s cubic-bezier(.32,.72,0,1)}
        .pp-sheet-grip{display:block;width:40px;height:5px;border-radius:3px;background:#d1d5db;margin:8px auto 0}
        .dark .pp-sheet-grip{background:#4b5563}
        .pp-sheet-head{padding:12px 52px}
        .pp-sheet-opt{padding:15px 18px;font-size:16px}
    }
    @keyframes pp-sheetup{from{transform:translateY(100%)}to{transform:translateY(0)}}
</style>
