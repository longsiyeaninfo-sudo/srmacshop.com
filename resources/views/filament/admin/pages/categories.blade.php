<x-filament-panels::page>
    @push('styles')
        <style>
        .cat-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px}
        .cat-h-title{font-size:13px;color:#6e6e73;font-weight:600}
        .cat-h-count{color:#1d1d1f;font-weight:700}
        .dark .cat-h-count{color:#f5f5f7}
        .cat-add-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:0;border-radius:8px;background:linear-gradient(180deg,#0a84ff,#006fe6);color:#fff;font-weight:700;font-size:13px;cursor:pointer;box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 1px 2px rgba(0,122,255,.25);transition:all .12s cubic-bezier(.4,0,.2,1)}
        .cat-add-btn:hover{box-shadow:inset 0 1px 0 rgba(255,255,255,.2),0 4px 10px rgba(0,122,255,.35)}

        .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:14px}

        .cat-tile{position:relative;background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:14px;padding:18px 16px;cursor:grab;transition:all .15s cubic-bezier(.4,0,.2,1);box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .dark .cat-tile{background:#2c2c2e;border-color:rgba(255,255,255,.08)}
        .cat-tile:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.08),0 2px 6px rgba(0,0,0,.04)}
        .cat-tile.sortable-ghost{opacity:.35}
        .cat-tile.sortable-drag{cursor:grabbing}

        .cat-emoji{font-size:36px;line-height:1;margin-bottom:10px;filter:drop-shadow(0 1px 2px rgba(0,0,0,.06))}

        .cat-name{font-weight:700;color:#1d1d1f;font-size:15px;letter-spacing:-.01em;line-height:1.25;cursor:text;margin:0 0 6px;word-break:break-word}
        .dark .cat-name{color:#f5f5f7}
        .cat-name-input{width:100%;padding:6px 10px;border:1.5px solid #007aff;border-radius:7px;background:#fff;font-size:14px;font-weight:700;color:#1d1d1f;outline:none;box-shadow:0 0 0 4px rgba(0,122,255,.18);font-family:inherit;margin:0 0 6px}
        .dark .cat-name-input{background:#1c1c1e;color:#f5f5f7}

        .cat-meta{display:flex;justify-content:space-between;align-items:center;margin-top:8px}
        .cat-count{font-size:11.5px;font-weight:600;color:#6e6e73;background:rgba(0,0,0,.04);padding:3px 9px;border-radius:980px}
        .dark .cat-count{background:rgba(255,255,255,.08);color:#a1a1a6}
        .cat-slug{font-size:10.5px;color:#a1a1a6;font-family:ui-monospace,'SF Mono',Consolas,monospace}

        .cat-actions{position:absolute;top:10px;right:10px;display:flex;gap:4px;opacity:0;transition:opacity .12s cubic-bezier(.4,0,.2,1)}
        .cat-tile:hover .cat-actions{opacity:1}
        .cat-action{width:28px;height:28px;border:0;border-radius:7px;background:rgba(0,0,0,.05);color:#1d1d1f;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .12s cubic-bezier(.4,0,.2,1);font-size:13px}
        .dark .cat-action{background:rgba(255,255,255,.08);color:#f5f5f7}
        .cat-action:hover{background:rgba(0,122,255,.15);color:#007aff}
        .cat-action-del:hover{background:rgba(255,59,48,.15);color:#ff3b30}

        .cat-empty{padding:60px 20px;text-align:center;color:#6e6e73;border:2px dashed rgba(0,0,0,.08);border-radius:14px}
        .cat-empty-ico{font-size:48px;margin-bottom:10px}

        /* Modal */
        .cat-modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.4);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;z-index:50;padding:20px}
        .cat-modal{background:#fff;border-radius:14px;padding:24px;max-width:420px;width:100%;box-shadow:0 20px 40px rgba(0,0,0,.18),0 8px 16px rgba(0,0,0,.08)}
        .dark .cat-modal{background:#2c2c2e}
        .cat-modal h3{font-size:17px;font-weight:700;margin:0 0 4px;color:#1d1d1f}
        .dark .cat-modal h3{color:#f5f5f7}
        .cat-modal p{font-size:13px;color:#6e6e73;margin:0 0 16px}
        .cat-modal-actions{display:flex;gap:8px;margin-top:14px}
        .cat-modal-actions button{flex:1;padding:10px;border:0;border-radius:8px;font-weight:700;font-size:13.5px;cursor:pointer;font-family:inherit}
        .cat-modal-cancel{background:rgba(0,0,0,.06);color:#1d1d1f}
        .cat-modal-confirm{background:linear-gradient(180deg,#0a84ff,#006fe6);color:#fff;box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 1px 2px rgba(0,122,255,.25)}

        .cat-input{width:100%;padding:10px 13px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;background:#fff;color:#1d1d1f;outline:none;transition:all .15s;font-family:inherit}
        .dark .cat-input{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
        .cat-input:focus{border-color:#007aff;box-shadow:0 0 0 4px rgba(0,122,255,.18)}
        .cat-err{font-size:12px;color:#ff3b30;margin-top:6px}
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    @endpush

    @php
    $catEmoji = fn(string $n) => match(true) {
        str_contains($n, 'MacBook') => '💻',
        str_contains($n, 'iPhone') => '📱',
        str_contains($n, 'iPad') => '📱',
        str_contains($n, 'Watch') => '⌚',
        str_contains($n, 'AirPod') => '🎧',
        str_contains($n, 'TV') || str_contains($n, 'Monitor') => '🖥️',
        str_contains($n, 'Accessory') || str_contains($n, 'Accessories') => '🔌',
        str_contains($n, 'Case') || str_contains($n, 'Cover') => '📦',
        str_contains($n, 'Charger') || str_contains($n, 'Cable') => '🔋',
        str_contains($n, 'Bag') || str_contains($n, 'Backpack') => '🎒',
        str_contains($n, 'Protect') => '🛡️',
        default => '🏷️',
    };
    @endphp

    <div class="cat-head">
        <div class="cat-h-title">
            <span class="cat-h-count">{{ $this->categories->count() }}</span> categories
            · drag to reorder
        </div>
        <button type="button" wire:click="openCreate" class="cat-add-btn">+ New Category</button>
    </div>

    @if($this->categories->isEmpty())
        <div class="cat-empty">
            <div class="cat-empty-ico">🏷️</div>
            <p style="margin:0;font-weight:600">No categories yet</p>
            <p style="font-size:12.5px;margin:4px 0 0">Add your first category to start organizing products.</p>
        </div>
    @else
        <div class="cat-grid"
            x-data="catSort()"
            x-init="init($el)"
            wire:ignore.self>
            @foreach($this->categories as $cat)
                <div class="cat-tile" data-id="{{ $cat->id }}" wire:key="cat-{{ $cat->id }}">
                    <div class="cat-actions">
                        <button type="button" wire:click="startEdit({{ $cat->id }})" class="cat-action" aria-label="Rename" title="Rename">✎</button>
                        <button type="button" wire:click="delete({{ $cat->id }})" wire:confirm="Delete this category? Products must be moved first." class="cat-action cat-action-del" aria-label="Delete" title="Delete">✕</button>
                    </div>
                    <div class="cat-emoji">{{ $catEmoji($cat->name) }}</div>

                    @if($editingId === $cat->id)
                        <input type="text" class="cat-name-input"
                            wire:model="editingName"
                            wire:keydown.enter="saveEdit"
                            wire:keydown.escape="cancelEdit"
                            x-init="$el.focus(); $el.select()"
                            wire:blur="saveEdit">
                    @else
                        <h3 class="cat-name" wire:click="startEdit({{ $cat->id }})">{{ $cat->name }}</h3>
                    @endif

                    <div class="cat-meta">
                        <span class="cat-count">{{ $cat->products_count }} {{ $cat->products_count === 1 ? 'product' : 'products' }}</span>
                        <span class="cat-slug">{{ $cat->slug }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Create modal --}}
    @if($showCreateModal)
        <div class="cat-modal-bg" wire:click.self="closeCreate">
            <div class="cat-modal" x-data x-init="$el.querySelector('input').focus()">
                <h3>New Category</h3>
                <p>Give it a clear name — slug is auto-generated.</p>
                <input type="text" class="cat-input"
                    wire:model.blur="newName"
                    wire:keydown.enter="create"
                    wire:keydown.escape="closeCreate"
                    placeholder="e.g. MacBook Pro">
                @error('newName') <div class="cat-err">{{ $message }}</div> @enderror
                <div class="cat-modal-actions">
                    <button type="button" wire:click="closeCreate" class="cat-modal-cancel">Cancel</button>
                    <button type="button" wire:click="create" class="cat-modal-confirm">Create</button>
                </div>
            </div>
        </div>
    @endif

    <script>
    window.catSort = () => ({
        sortable: null,
        init(el) {
            if (this.sortable) return;
            const tryInit = () => {
                if (!window.Sortable) return setTimeout(tryInit, 100);
                this.sortable = window.Sortable.create(el, {
                    animation: 180,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onEnd: () => {
                        const ids = Array.from(el.querySelectorAll('[data-id]')).map(t => parseInt(t.dataset.id, 10));
                        const wireRoot = el.closest('[wire\\:id]')?.getAttribute('wire:id');
                        if (wireRoot) window.Livewire.find(wireRoot)?.call('reorder', ids);
                    }
                });
            };
            tryInit();
        }
    });
    </script>
</x-filament-panels::page>
