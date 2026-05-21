<x-filament-panels::page>
    @push('styles')
        <style>
        .cp-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px}
        .cp-sub{font-size:13px;color:#6e6e73;font-weight:600}
        .cp-cta{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:0;border-radius:8px;background:linear-gradient(180deg,#0a84ff,#006fe6);color:#fff;font-weight:700;font-size:13px;cursor:pointer;box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 1px 2px rgba(0,122,255,.25);font-family:inherit}
        .cp-cta:hover{box-shadow:inset 0 1px 0 rgba(255,255,255,.2),0 4px 10px rgba(0,122,255,.35)}

        .cp-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px}
        .cp-card{position:relative;background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:14px;padding:18px 18px 16px;box-shadow:0 1px 3px rgba(0,0,0,.04);transition:all .15s cubic-bezier(.4,0,.2,1)}
        .dark .cp-card{background:#2c2c2e;border-color:rgba(255,255,255,.08)}
        .cp-card:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.08)}

        .cp-row1{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:8px}
        .cp-code{font-family:ui-monospace,'SF Mono',Consolas,monospace;font-size:17px;font-weight:800;color:#1d1d1f;letter-spacing:.04em}
        .dark .cp-code{color:#f5f5f7}

        .cp-pill{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:980px;font-size:10.5px;font-weight:700;letter-spacing:-.005em;white-space:nowrap}
        .cp-pill-dot{width:5px;height:5px;border-radius:50%}
        .cp-pill.green{background:#dcfce7;color:#15803d}
        .cp-pill.green .cp-pill-dot{background:#34c759}
        .cp-pill.orange{background:#fff7ed;color:#c2410c}
        .cp-pill.orange .cp-pill-dot{background:#f97316}
        .cp-pill.gray{background:#f5f5f7;color:#3f3f46}
        .cp-pill.gray .cp-pill-dot{background:#8e8e93}
        .dark .cp-pill.gray{background:rgba(255,255,255,.08);color:#a1a1a6}

        .cp-discount{font-size:20px;font-weight:800;color:#f97316;margin:6px 0;letter-spacing:-.014em}

        .cp-meta{display:grid;grid-template-columns:1fr 1fr;gap:8px 12px;margin-top:10px;font-size:11.5px;color:#6e6e73}
        .cp-meta-l{font-weight:500;color:#a1a1a6;text-transform:uppercase;letter-spacing:.04em;font-size:10px}
        .cp-meta-v{font-weight:600;color:#1d1d1f;font-size:12.5px}
        .dark .cp-meta-v{color:#f5f5f7}

        .cp-usage-bar{height:4px;border-radius:980px;background:rgba(0,0,0,.06);overflow:hidden;margin-top:10px}
        .dark .cp-usage-bar{background:rgba(255,255,255,.08)}
        .cp-usage-fill{height:100%;background:linear-gradient(90deg,#34c759,#22c55e);border-radius:980px;transition:width .25s cubic-bezier(.4,0,.2,1)}
        .cp-usage-fill.warn{background:linear-gradient(90deg,#f97316,#ea580c)}
        .cp-usage-fill.full{background:linear-gradient(90deg,#ff3b30,#d70015)}

        .cp-actions{position:absolute;top:10px;right:10px;display:flex;gap:4px;opacity:0;transition:opacity .12s cubic-bezier(.4,0,.2,1)}
        .cp-card:hover .cp-actions{opacity:1}
        .cp-act{width:26px;height:26px;border:0;border-radius:6px;background:rgba(0,0,0,.05);color:#1d1d1f;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px}
        .dark .cp-act{background:rgba(255,255,255,.08);color:#f5f5f7}
        .cp-act:hover{background:rgba(0,122,255,.15);color:#007aff}
        .cp-act-del:hover{background:rgba(255,59,48,.15);color:#ff3b30}

        /* Empty state */
        .cp-empty{padding:60px 20px;text-align:center;color:#6e6e73;border:2px dashed rgba(0,0,0,.08);border-radius:14px}

        /* Modal */
        .cp-modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.4);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;z-index:50;padding:20px;overflow-y:auto}
        .cp-modal{background:#fff;border-radius:14px;padding:24px;max-width:520px;width:100%;box-shadow:0 20px 40px rgba(0,0,0,.18);margin:auto}
        .dark .cp-modal{background:#2c2c2e}
        .cp-modal h3{font-size:17px;font-weight:700;margin:0 0 4px;color:#1d1d1f}
        .dark .cp-modal h3{color:#f5f5f7}
        .cp-modal p{font-size:13px;color:#6e6e73;margin:0 0 16px}

        .cp-f{margin-bottom:13px}
        .cp-f label{display:block;font-size:12.5px;font-weight:600;color:#1d1d1f;margin-bottom:5px}
        .dark .cp-f label{color:#f5f5f7}
        .cp-input{width:100%;padding:8px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;background:#fff;color:#1d1d1f;outline:none;font-family:inherit;transition:all .15s}
        .dark .cp-input{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
        .cp-input:focus{border-color:#007aff;box-shadow:0 0 0 4px rgba(0,122,255,.18)}
        .cp-code-input{font-family:ui-monospace,'SF Mono',Consolas,monospace;font-weight:700;letter-spacing:.04em;text-transform:uppercase}

        .cp-code-row{display:flex;gap:6px}
        .cp-code-row .cp-input{flex:1}
        .cp-gen-btn{padding:0 12px;border:1px solid #d2d2d7;border-radius:8px;background:#fff;color:#1d1d1f;cursor:pointer;font-size:12px;font-weight:700;font-family:inherit}
        .dark .cp-gen-btn{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
        .cp-gen-btn:hover{background:rgba(0,122,255,.06);border-color:#007aff;color:#007aff}

        .cp-tabs{display:flex;background:rgba(0,0,0,.05);border-radius:8px;padding:3px;gap:2px}
        .dark .cp-tabs{background:rgba(255,255,255,.06)}
        .cp-tab{flex:1;padding:7px;border:0;border-radius:6px;background:transparent;color:#6e6e73;font-weight:700;font-size:12.5px;cursor:pointer;font-family:inherit;transition:all .12s}
        .cp-tab.on{background:#fff;color:#1d1d1f;box-shadow:0 1px 2px rgba(0,0,0,.06)}
        .dark .cp-tab.on{background:#3a3a3c;color:#f5f5f7}

        .cp-row2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .cp-switch-row{display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;background:#fff;cursor:pointer;font-size:13.5px;font-weight:600;color:#1d1d1f}
        .dark .cp-switch-row{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
        .cp-sw{width:34px;height:20px;background:#d2d2d7;border-radius:980px;position:relative;transition:background .15s}
        .cp-sw.on{background:#34c759}
        .cp-sw-dot{position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .15s;box-shadow:0 1px 2px rgba(0,0,0,.18)}
        .cp-sw.on .cp-sw-dot{transform:translateX(14px)}

        .cp-preview{background:linear-gradient(135deg,#fff7ed,#fef3c7);border:1px solid #fed7aa;border-radius:10px;padding:12px 14px;margin:14px 0 4px}
        .dark .cp-preview{background:linear-gradient(135deg,rgba(249,115,22,.15),rgba(245,158,11,.12));border-color:rgba(249,115,22,.3)}
        .cp-pv-l{font-size:11px;color:#92400e;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px}
        .cp-pv-text{font-size:13px;color:#1d1d1f;line-height:1.5}
        .dark .cp-pv-text{color:#f5f5f7}
        .cp-pv-text strong{color:#f97316;font-weight:800}

        .cp-modal-actions{display:flex;gap:8px;margin-top:18px}
        .cp-modal-actions button{flex:1;padding:10px;border:0;border-radius:8px;font-weight:700;font-size:13.5px;cursor:pointer;font-family:inherit}
        .cp-cancel{background:rgba(0,0,0,.06);color:#1d1d1f}
        .dark .cp-cancel{background:rgba(255,255,255,.1);color:#f5f5f7}
        .cp-save{background:linear-gradient(180deg,#0a84ff,#006fe6);color:#fff;box-shadow:inset 0 1px 0 rgba(255,255,255,.18)}
        .cp-err{font-size:12px;color:#ff3b30;margin-top:4px}
        </style>
    @endpush

    <div class="cp-head">
        <div class="cp-sub">
            <strong style="color:#1d1d1f">{{ $this->coupons->count() }}</strong> coupons configured
        </div>
        <button type="button" wire:click="openCreate" class="cp-cta">+ New Coupon</button>
    </div>

    @if($this->coupons->isEmpty())
        <div class="cp-empty">
            <div style="font-size:48px;margin-bottom:10px">🎟️</div>
            <p style="margin:0;font-weight:600">No coupons yet</p>
            <p style="font-size:12.5px;margin:4px 0 0">Create your first discount code to start running promos.</p>
        </div>
    @else
        <div class="cp-grid">
            @foreach($this->coupons as $c)
                @php
                    [$statusLabel, $statusColor] = $this->statusOf($c);
                    $usagePct = $c->max_uses > 0 ? min(100, ($c->used_count / $c->max_uses) * 100) : 0;
                    $usageCls = $usagePct >= 100 ? 'full' : ($usagePct >= 80 ? 'warn' : '');
                    $discountText = $c->type === 'percent'
                        ? $c->value . '% off'
                        : '$' . number_format($c->value / 100, 2) . ' off';
                @endphp
                <div class="cp-card" wire:key="cp-{{ $c->id }}">
                    <div class="cp-actions">
                        <button type="button" wire:click="openEdit({{ $c->id }})" class="cp-act" title="Edit">✎</button>
                        <button type="button" wire:click="delete({{ $c->id }})" wire:confirm="Delete coupon {{ $c->code }}?" class="cp-act cp-act-del" title="Delete">✕</button>
                    </div>

                    <div class="cp-row1">
                        <span class="cp-code">{{ $c->code }}</span>
                        <span class="cp-pill {{ $statusColor }}"><span class="cp-pill-dot"></span>{{ $statusLabel }}</span>
                    </div>

                    <div class="cp-discount">{{ $discountText }}</div>

                    <div class="cp-meta">
                        <div>
                            <div class="cp-meta-l">Min order</div>
                            <div class="cp-meta-v">${{ number_format($c->min_subtotal / 100, 2) }}</div>
                        </div>
                        <div>
                            <div class="cp-meta-l">Used</div>
                            <div class="cp-meta-v">{{ $c->used_count }}{{ $c->max_uses > 0 ? ' / ' . $c->max_uses : '' }}</div>
                        </div>
                        <div>
                            <div class="cp-meta-l">Expires</div>
                            <div class="cp-meta-v">{{ $c->expires_at ? $c->expires_at->format('d M Y') : 'Never' }}</div>
                        </div>
                        <div>
                            <div class="cp-meta-l">Active</div>
                            <div class="cp-meta-v">{{ $c->is_active ? 'Yes' : 'No' }}</div>
                        </div>
                    </div>

                    @if($c->max_uses > 0)
                        <div class="cp-usage-bar">
                            <div class="cp-usage-fill {{ $usageCls }}" style="width:{{ $usagePct }}%"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Create / Edit modal --}}
    @if($showModal)
        <div class="cp-modal-bg" wire:click.self="close">
            <form wire:submit.prevent="save" class="cp-modal"
                x-data="{
                    get preview() {
                        const v = parseFloat($wire.value) || 0;
                        const min = parseFloat($wire.min_subtotal) || 0;
                        const t = $wire.type;
                        const order = Math.max(750, min || 500);
                        if (!v) return null;
                        const saved = t === 'percent' ? order * v / 100 : Math.min(v, order);
                        return { order, saved, final: order - saved, min };
                    }
                }">
                <h3>{{ $editingId ? 'Edit Coupon' : 'New Coupon' }}</h3>
                <p>Customers redeem this at checkout.</p>

                <div class="cp-f">
                    <label>Code</label>
                    <div class="cp-code-row">
                        <input type="text" class="cp-input cp-code-input" wire:model="code" maxlength="32">
                        <button type="button" wire:click="regenerateCode" class="cp-gen-btn">Generate</button>
                    </div>
                    @error('code') <div class="cp-err">{{ $message }}</div> @enderror
                </div>

                <div class="cp-f">
                    <label>Discount type</label>
                    <div class="cp-tabs">
                        <button type="button" wire:click="$set('type', 'percent')" class="cp-tab {{ $type === 'percent' ? 'on' : '' }}">% Percent</button>
                        <button type="button" wire:click="$set('type', 'fixed')" class="cp-tab {{ $type === 'fixed' ? 'on' : '' }}">$ Fixed amount</button>
                    </div>
                </div>

                <div class="cp-row2">
                    <div class="cp-f">
                        <label>{{ $type === 'percent' ? 'Percent (%)' : 'Amount ($)' }}</label>
                        <input type="number" min="0" step="{{ $type === 'percent' ? '1' : '0.01' }}" class="cp-input" wire:model="value" placeholder="{{ $type === 'percent' ? '10' : '5.00' }}">
                        @error('value') <div class="cp-err">{{ $message }}</div> @enderror
                    </div>
                    <div class="cp-f">
                        <label>Min order ($)</label>
                        <input type="number" min="0" step="0.01" class="cp-input" wire:model="min_subtotal" placeholder="0.00">
                    </div>
                </div>

                <div class="cp-row2">
                    <div class="cp-f">
                        <label>Max uses (0 = ∞)</label>
                        <input type="number" min="0" class="cp-input" wire:model="max_uses" placeholder="0">
                    </div>
                    <div class="cp-f">
                        <label>Expires</label>
                        <input type="datetime-local" class="cp-input" wire:model="expires_at">
                    </div>
                </div>

                <div class="cp-f">
                    <button type="button" wire:click="$toggle('is_active')" class="cp-switch-row">
                        <span>Active</span>
                        <span class="cp-sw {{ $is_active ? 'on' : '' }}"><span class="cp-sw-dot"></span></span>
                    </button>
                </div>

                <div class="cp-preview" x-show="preview" x-cloak>
                    <div class="cp-pv-l">Live preview</div>
                    <div class="cp-pv-text">
                        On a $<span x-text="preview?.order?.toFixed(2)"></span> order
                        <template x-if="preview && preview.min > 0">
                            <span> (min $<span x-text="preview.min.toFixed(2)"></span>)</span>
                        </template>:
                        customer saves <strong>$<span x-text="preview?.saved?.toFixed(2)"></span></strong>
                        → pays <strong>$<span x-text="preview?.final?.toFixed(2)"></span></strong>
                    </div>
                </div>

                <div class="cp-modal-actions">
                    <button type="button" wire:click="close" class="cp-cancel">Cancel</button>
                    <button type="submit" class="cp-save">{{ $editingId ? 'Save changes' : 'Create coupon' }}</button>
                </div>
            </form>
        </div>
    @endif
</x-filament-panels::page>
