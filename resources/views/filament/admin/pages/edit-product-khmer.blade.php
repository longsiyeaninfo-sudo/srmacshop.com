<x-filament-panels::page>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css" crossorigin="" />
        <style>
        {{-- Reuse the exact same .pp-* classes from the Add Product page --}}
        .pp-wrap{max-width:880px;margin:0 auto;display:flex;flex-direction:column;gap:18px}
        .pp-card{background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px}
        .dark .pp-card{background:#1f2937;border-color:#374151}
        .pp-h2{font-size:18px;font-weight:700;color:#111827;margin:0}
        .dark .pp-h2{color:#f9fafb}
        .pp-sub{font-size:13px;color:#6b7280;margin:6px 0 16px}
        .dark .pp-sub{color:#9ca3af}
        .pp-section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid #e5e7eb}
        .dark .pp-section-head{border-color:#374151}
        .pp-section-head .pp-sub{margin:0;font-size:13px}
        .pp-field{margin-bottom:14px}
        .pp-field label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:4px}
        .dark .pp-field label{color:#d1d5db}
        .pp-req{color:#ef4444;margin-left:2px}
        .pp-input{width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff;color:#111827;outline:none;transition:border-color .15s}
        .dark .pp-input{background:#111827;border-color:#374151;color:#f9fafb}
        .pp-input:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
        select.pp-input{cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;background-size:18px;padding-right:36px}
        .pp-textarea{resize:vertical;min-height:88px;font-family:inherit;line-height:1.5}
        .pp-cat-chip{display:inline-flex;align-items:center;gap:14px;padding:8px 8px 8px 14px;border:1.5px dashed #d1d5db;border-radius:8px;background:#fff;font-size:14px;color:#111827}
        .dark .pp-cat-chip{background:#1f2937;border-color:#374151;color:#f9fafb}
        .pp-cat-sep{color:#9ca3af;margin:0 4px}
        .pp-toggle-row{display:flex;gap:8px}
        .pp-toggle{flex:1;padding:10px;border:1.5px solid #d1d5db;border-radius:8px;background:#fff;color:#374151;font-size:14px;font-weight:600;cursor:pointer;transition:all .15s}
        .dark .pp-toggle{background:#1f2937;border-color:#374151;color:#d1d5db}
        .pp-toggle:hover{border-color:#3b82f6}
        .pp-toggle.on{border-color:#3b82f6;background:#eff6ff;color:#3b82f6}
        .dark .pp-toggle.on{background:#1e3a8a;color:#93c5fd}
        .pp-input-row{display:flex;gap:8px}
        .pp-input-row .pp-input{flex:1}
        .pp-dtype{display:inline-flex;border:1px solid #d1d5db;border-radius:8px;padding:3px;gap:2px}
        .dark .pp-dtype{border-color:#374151}
        .pp-dtype-b{padding:6px 12px;border-radius:6px;border:none;background:transparent;color:#6b7280;font-size:14px;font-weight:600;cursor:pointer;min-width:38px}
        .pp-dtype-b.on{background:#e5e7eb;color:#111827}
        .dark .pp-dtype-b.on{background:#374151;color:#f9fafb}
        .pp-price-wrap{position:relative}
        .pp-price-prefix{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:16px;font-weight:600;color:#111827;pointer-events:none}
        .dark .pp-price-prefix{color:#f9fafb}
        .pp-price-input{padding-left:30px}
        .pp-toggle-row-btn{display:flex;align-items:center;justify-content:space-between;width:100%;padding:10px 14px;border:1.5px solid #d1d5db;border-radius:8px;background:#fff;color:#111827;font-size:14px;font-weight:600;cursor:pointer}
        .dark .pp-toggle-row-btn{background:#1f2937;border-color:#374151;color:#f9fafb}
        .pp-switch{display:inline-block;width:38px;height:22px;background:#d1d5db;border-radius:980px;position:relative;transition:background .15s}
        .pp-switch.on{background:#3b82f6}
        .pp-switch-dot{position:absolute;top:2px;left:2px;width:18px;height:18px;background:#fff;border-radius:50%;transition:transform .15s}
        .pp-switch.on .pp-switch-dot{transform:translateX(16px)}
        .pp-photos-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px}
        .pp-photo{position:relative;aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb}
        .dark .pp-photo{border-color:#374151}
        .pp-photo img{width:100%;height:100%;object-fit:cover;display:block}
        .pp-photo-x{position:absolute;top:6px;right:6px;width:24px;height:24px;border-radius:50%;background:rgba(0,0,0,.6);color:#fff;border:none;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center}
        .pp-photo-x:hover{background:rgba(239,68,68,.9)}
        .pp-photo-add{grid-column:1/-1;display:flex;align-items:center;justify-content:center;min-height:160px;border:2px dashed #d1d5db;border-radius:10px;background:#f9fafb;cursor:pointer;transition:all .15s;padding:20px;text-align:center}
        .dark .pp-photo-add{background:#111827;border-color:#374151}
        .pp-photo-add:hover{border-color:#3b82f6;background:#eff6ff}
        .pp-photo-add-inner{display:flex;flex-direction:column;align-items:center;gap:6px;color:#6b7280;font-size:13px}
        .pp-photo-ico{font-size:42px;color:#3b82f6}
        .pp-photo-hint{font-size:12px;color:#9ca3af}
        .pp-link{color:#3b82f6;font-weight:600;text-decoration:underline}
        .pp-uploading{font-size:13px;color:#3b82f6;font-weight:600;padding:6px 12px;background:#eff6ff;border-radius:6px;margin-top:6px}
        .pp-err{color:#ef4444;font-size:12px;margin-top:4px}
        .pp-terms{font-size:13px;color:#6b7280;margin:0 0 14px}
        .pp-link-inline{color:#3b82f6;font-weight:600;text-decoration:none}
        .pp-link-inline:hover{text-decoration:underline}
        .pp-actions-stack{display:flex;flex-direction:column;gap:10px;margin-top:8px}
        .pp-btn{padding:10px 22px;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;transition:all .15s}
        .pp-btn-submit{width:100%;background:#f97316;color:#fff;padding:14px;font-size:16px;font-weight:700;border-radius:8px}
        .pp-btn-submit:hover:not(:disabled){background:#ea580c}
        .pp-btn-submit:disabled{opacity:.6;cursor:not-allowed}
        .pp-btn-ghost{background:transparent;border:1px solid #d1d5db;color:#374151}
        .dark .pp-btn-ghost{border-color:#374151;color:#d1d5db}
        .pp-phone-row{display:flex;gap:8px;align-items:flex-start;margin-bottom:6px}
        .pp-phone-row .pp-input{flex:1}
        .pp-phone-add,.pp-phone-rm{width:36px;height:36px;flex-shrink:0;border:none;border-radius:50%;color:#fff;font-size:18px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center}
        .pp-phone-add{background:#3b82f6}.pp-phone-add:hover{background:#2563eb}
        .pp-phone-rm{background:#ef4444;font-size:13px}.pp-phone-rm:hover{background:#dc2626}
        .pp-edit-head{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
        .pp-edit-back{color:#3b82f6;font-size:13px;font-weight:600;text-decoration:none}
        .pp-edit-back:hover{text-decoration:underline}
        .pp-map-wrap{position:relative;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-top:14px}
        .pp-map{width:100%;height:200px}
        .pp-map-hint{position:absolute;bottom:0;left:0;right:0;background:rgba(255,255,255,.9);font-size:12px;text-align:center;padding:6px;margin:0;color:#374151}

        /* Spec chips */
        .pp-chips{display:flex;flex-wrap:wrap;gap:6px;margin-top:6px}
        .pp-chip{padding:5px 13px;border:1.5px solid #e5e7eb;border-radius:980px;background:#fff;font-size:13px;font-weight:500;color:#374151;cursor:pointer;transition:all .12s}
        .dark .pp-chip{background:#1f2937;border-color:#374151;color:#d1d5db}
        .pp-chip:hover{border-color:#3b82f6;background:#eff6ff;color:#1d4ed8}
        .dark .pp-chip:hover{background:#1e3a8a;border-color:#60a5fa;color:#93c5fd}
        .pp-chip.on{border-color:#f97316;background:#fff7ed;color:#c2410c;font-weight:700}
        .dark .pp-chip.on{background:#431407;border-color:#ea580c;color:#fb923c}

        /* Price preview */
        .pp-price-preview{display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin-top:8px;padding:10px 14px;background:#fff7ed;border:1px solid #fed7aa;border-radius:8px}
        .dark .pp-price-preview{background:#431407;border-color:#9a3412}
        .pp-price-orig{font-size:12px;color:#9ca3af;text-decoration:line-through}
        .pp-price-final{font-size:18px;font-weight:800;color:#f97316}
        .pp-price-save{font-size:11px;font-weight:700;color:#16a34a;background:#dcfce7;padding:2px 8px;border-radius:980px}

        /* Spec summary */
        .pp-spec-sum{font-size:12px;color:#6b7280;margin-top:4px;min-height:16px}
        .dark .pp-spec-sum{color:#9ca3af}
        </style>
        @include('filament.admin.pages._spec-picker-styles')
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js" crossorigin=""></script>
        <script src="https://unpkg.com/sortablejs@1.15.2/Sortable.min.js" crossorigin=""></script>
        @include('filament.admin.pages._photo-uploader-script')
    @endpush

    <div class="pp-wrap">
        <div class="pp-card">
            <div class="pp-edit-head">
                <div>
                    <h2 class="pp-h2">Editing: {{ $record->name }}</h2>
                    <p class="pp-sub">Saved as <code>{{ $record->slug }}</code> · Created {{ $record->created_at?->diffForHumans() }}</p>
                </div>
                <a href="{{ \App\Filament\Admin\Resources\ProductResource::getUrl('index') }}" class="pp-edit-back">← Back to Products</a>
            </div>
        </div>

        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            {{-- Photos (shared uploader: drag-drop + crop + reorder) --}}
            @include('filament.admin.pages._photo-uploader', ['mode' => 'edit'])

            {{-- Post Details --}}
            <div class="pp-card">
                <div class="pp-section-head">
                    <div>
                        <h2 class="pp-h2">📋 Product Details</h2>
                        @php $specPreview = implode(' · ', array_filter([$cpu, $ram ? $ram.' RAM' : '', $storage, $screen_size])); @endphp
                        @if($specPreview)
                            <div class="pp-spec-sum">{{ $specPreview }}</div>
                        @endif
                    </div>
                </div>

                <div class="pp-field">
                    <label>Title <span class="pp-req">*</span></label>
                    <input type="text" wire:model.blur="name" class="pp-input">
                    @error('name') <div class="pp-err">{{ $message }}</div> @enderror
                </div>

                <div class="pp-field">
                    <label>Category <span class="pp-req">*</span></label>
                    <select wire:model="category_id" class="pp-input">
                        @foreach($this->categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                @include('filament.admin.pages._spec-picker', ['field' => 'brand', 'label' => 'Brand', 'options' => $this->brands, 'required' => true])

                <div class="pp-field">
                    <label>Condition <span class="pp-req">*</span></label>
                    <div class="pp-toggle-row">
                        <button type="button" wire:click="$set('condition', 'used')" class="pp-toggle {{ $condition === 'used' ? 'on' : '' }}">Used</button>
                        <button type="button" wire:click="$set('condition', 'new')" class="pp-toggle {{ $condition === 'new' ? 'on' : '' }}">New</button>
                    </div>
                </div>

                @include('filament.admin.pages._spec-picker', ['field' => 'screen_size', 'label' => 'Screen Size', 'options' => $this->screenSizes, 'required' => true])

                @include('filament.admin.pages._spec-picker', ['field' => 'storage', 'label' => 'Storage', 'options' => $this->storageOptions, 'required' => true])

                @include('filament.admin.pages._spec-picker', ['field' => 'ram', 'label' => 'RAM', 'options' => $this->ramOptions, 'required' => true])

                @include('filament.admin.pages._spec-picker', ['field' => 'cpu', 'label' => 'CPU', 'options' => $this->cpuOptions, 'required' => true])

                @include('filament.admin.pages._spec-picker', ['field' => 'vga', 'label' => 'VGA / GPU', 'options' => $this->vgaOptions])

                <div class="pp-field">
                    <label>Stock</label>
                    <input type="number" min="0" wire:model="stock" class="pp-input">
                </div>

                <div class="pp-field">
                    <label>Badge</label>
                    <select wire:model="badge" class="pp-input">
                        <option value="">None</option>
                        <option value="new">🆕 New</option>
                        <option value="hot">🔥 Hot</option>
                        <option value="sale">💰 Sale</option>
                    </select>
                </div>

                <div class="pp-field">
                    <label>Warranty</label>
                    <input type="text" wire:model="warranty" class="pp-input">
                </div>

                <div class="pp-field">
                    <label>Discount</label>
                    <div class="pp-input-row">
                        <input type="number" min="0" step="0.01" wire:model="discount" class="pp-input" placeholder="0">
                        <div class="pp-dtype">
                            <button type="button" wire:click="$set('discount_type', '%')" class="pp-dtype-b {{ $discount_type === '%' ? 'on' : '' }}">%</button>
                            <button type="button" wire:click="$set('discount_type', '$')" class="pp-dtype-b {{ $discount_type === '$' ? 'on' : '' }}">$</button>
                        </div>
                    </div>
                </div>

                {{-- Sale fields (Phase 1) --}}
                <div class="pp-field">
                    <label>Original price ($) <span style="color:#86868b;font-weight:400">— optional, shows strike-through</span></label>
                    <input type="number" min="0" step="0.01" wire:model="original_price" class="pp-input" placeholder="e.g. 1299">
                </div>

                <div class="pp-field">
                    <label>Sale ends at <span style="color:#86868b;font-weight:400">— optional, drives countdown</span></label>
                    <input type="datetime-local" wire:model="sale_ends_at" class="pp-input">
                </div>

                <div class="pp-field">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" wire:model="is_flash_deal" style="width:18px;height:18px;cursor:pointer">
                        <span>🔥 Feature in home Flash Deals reel</span>
                    </label>
                </div>

                @if($this->is_macbook)
                <div class="pp-field" style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;padding:12px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" wire:model.live="is_top_pick" style="width:18px;height:18px;cursor:pointer">
                        <span>🏆 Feature in “Top MacBooks in Cambodia” (homepage)</span>
                    </label>
                    @if($is_top_pick)
                    <div style="margin-top:10px;display:grid;gap:8px">
                        <input type="text" wire:model="top_label_en" class="pp-input" placeholder="Rank label — English (e.g. Best Overall)">
                        <input type="text" wire:model="top_label_km" class="pp-input" placeholder="ស្លាក — ខ្មែរ (ឧ. ល្អបំផុតរួម)">
                        <input type="text" wire:model="top_label_zh" class="pp-input" placeholder="排名标签 — 中文 (如 综合最佳)">
                    </div>
                    <p style="margin:8px 0 0;font-size:12px;color:#92400e">Optional gold ribbon shown on the card. Leave blank for no ribbon.</p>
                    @endif
                </div>
                @endif

                <div class="pp-field"
                    x-data="{
                        get preview() {
                            const p = parseFloat($wire.price) || 0;
                            const d = parseFloat($wire.discount) || 0;
                            const dt = $wire.discount_type;
                            if (!p) return null;
                            const fp = d > 0 ? (dt === '%' ? p * (1 - d / 100) : Math.max(0, p - d)) : p;
                            return { list: p, final: fp, saved: p - fp, pct: Math.round((1 - fp / p) * 100) };
                        }
                    }">
                    <label>Price <span class="pp-req">*</span></label>
                    <div class="pp-price-wrap">
                        <span class="pp-price-prefix">$</span>
                        <input type="number" min="0" step="0.01" wire:model="price" class="pp-input pp-price-input">
                    </div>
                    @error('price') <div class="pp-err">{{ $message }}</div> @enderror
                    <div class="pp-price-preview" x-show="preview && preview.saved > 0" x-cloak>
                        <span class="pp-price-orig">$<span x-text="preview?.list?.toFixed(2)"></span></span>
                        <span class="pp-price-final">$<span x-text="preview?.final?.toFixed(2)"></span></span>
                        <span class="pp-price-save">Save $<span x-text="preview?.saved?.toFixed(2)"></span> (<span x-text="preview?.pct"></span>% off)</span>
                    </div>
                    <div class="pp-price-preview" x-show="preview && preview.saved === 0" x-cloak>
                        <span class="pp-price-final">$<span x-text="preview?.final?.toFixed(2)"></span></span>
                        <span style="font-size:12px;color:#6b7280">No discount applied</span>
                    </div>
                </div>

                <div class="pp-field">
                    <label>Free Delivery</label>
                    <button type="button" wire:click="$toggle('free_delivery')" class="pp-toggle-row-btn">
                        <span>{{ $free_delivery ? 'Yes' : 'No' }}</span>
                        <span class="pp-switch {{ $free_delivery ? 'on' : '' }}"><span class="pp-switch-dot"></span></span>
                    </button>
                </div>

                <div class="pp-field">
                    <label>Description <span class="pp-req">*</span></label>
                    <textarea wire:model.blur="description" rows="7" class="pp-input pp-textarea"></textarea>
                    @error('description') <div class="pp-err">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="pp-card">
                <p class="pp-terms">
                    Updating this product immediately changes how it appears on the public storefront.
                </p>
                <div class="pp-actions-stack">
                    <button type="submit" class="pp-btn pp-btn-submit"
                        wire:loading.attr="disabled" wire:target="submit,photos">
                        <span wire:loading.remove wire:target="submit">💾 Save Changes</span>
                        <span wire:loading wire:target="submit">Saving…</span>
                    </button>
                    <a href="{{ \App\Filament\Admin\Resources\ProductResource::getUrl('index') }}" class="pp-btn pp-btn-ghost" style="text-align:center;text-decoration:none;">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-filament-panels::page>
