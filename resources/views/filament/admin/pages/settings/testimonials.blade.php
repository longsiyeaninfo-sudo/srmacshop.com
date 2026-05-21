<x-filament-panels::page>
    @push('styles')
        @include('filament.admin.pages.settings._shared')
        <style>
            .tst-item{background:var(--card);border:1px solid var(--hairline);border-radius:12px;padding:18px;margin-bottom:12px;position:relative}
            .tst-item-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:8px}
            .tst-item-idx{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#86868b;background:#f2f2f7;padding:4px 10px;border-radius:980px}
            .tst-item-actions{display:flex;gap:6px}
            .tst-act{width:28px;height:28px;border-radius:50%;border:1px solid #d2d2d7;background:#fff;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;color:#1d1d1f;transition:all .15s}
            .tst-act:hover{background:#007aff;color:#fff;border-color:#007aff}
            .tst-act.danger:hover{background:#ff3b30;border-color:#ff3b30}
            .tst-row2{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
            .tst-rating{display:flex;gap:4px;margin-top:4px}
            .tst-star{cursor:pointer;font-size:22px;color:#d2d2d7;transition:color .1s;line-height:1}
            .tst-star.on{color:#ff9500}
            .tst-add{width:100%;padding:14px;background:transparent;border:2px dashed #d2d2d7;border-radius:12px;color:#86868b;font-weight:600;cursor:pointer;font-size:13px;transition:all .15s}
            .tst-add:hover{border-color:#007aff;color:#007aff;background:rgba(0,122,255,.04)}
        </style>
    @endpush

    <form wire:submit.prevent="save" class="st-wrap">
        <div class="st-card">
            <h2 class="st-h">💬 Customer Testimonials</h2>
            <p class="st-sub">Shown on the home page and About page. 3–6 is the sweet spot.</p>

            @foreach($items as $i => $item)
                <div class="tst-item" wire:key="t-{{ $i }}">
                    <div class="tst-item-head">
                        <span class="tst-item-idx">#{{ $i + 1 }}</span>
                        <div class="tst-item-actions">
                            <button type="button" class="tst-act" wire:click="moveUp({{ $i }})" title="Move up" {{ $i === 0 ? 'disabled' : '' }}>↑</button>
                            <button type="button" class="tst-act" wire:click="moveDown({{ $i }})" title="Move down" {{ $i === count($items) - 1 ? 'disabled' : '' }}>↓</button>
                            <button type="button" class="tst-act danger" wire:click="removeItem({{ $i }})" title="Remove">✕</button>
                        </div>
                    </div>
                    <div class="tst-row2">
                        <div class="st-f">
                            <label>Name</label>
                            <input class="st-input" type="text" wire:model="items.{{ $i }}.name" placeholder="Sophal K.">
                        </div>
                        <div class="st-f">
                            <label>Role / Location</label>
                            <input class="st-input" type="text" wire:model="items.{{ $i }}.role" placeholder="Designer · Phnom Penh">
                        </div>
                    </div>
                    <div class="st-f">
                        <label>Quote</label>
                        <textarea class="st-input" wire:model="items.{{ $i }}.quote" rows="3" placeholder="Loved the same-day delivery..."></textarea>
                    </div>
                    <div class="st-f" style="margin-bottom:0">
                        <label>Rating</label>
                        <div class="tst-rating">
                            @for($s = 1; $s <= 5; $s++)
                                <span class="tst-star {{ ($item['rating'] ?? 5) >= $s ? 'on' : '' }}"
                                    wire:click="$set('items.{{ $i }}.rating', {{ $s }})">★</span>
                            @endfor
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" class="tst-add" wire:click="addItem">+ Add testimonial</button>
        </div>

        <button type="submit" class="st-save">💾 Save testimonials</button>
    </form>
</x-filament-panels::page>
