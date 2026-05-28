<div class="aon-wrap"
     x-data="{
         open: @entangle('open'),
         lastSeen: parseInt(localStorage.getItem('aon_last_seen') || '0'),
         newCount: 0,
         init() {
             this.newCount = {{ $latestOrderId }} > this.lastSeen ? 1 : 0;
             this.$watch('open', v => {
                 if (v) {
                     this.lastSeen = {{ $latestOrderId }};
                     localStorage.setItem('aon_last_seen', {{ $latestOrderId }});
                     this.newCount = 0;
                 }
             });
         }
     }"
     @click.outside="open = false"
     @keydown.escape.window="open = false"
     wire:poll.30s>

<style>
/* ── Wrap ── */
.aon-wrap{position:relative;display:flex;align-items:center}

/* ── Bell button ── */
.aon-bell{position:relative;width:38px;height:38px;border-radius:10px;border:none;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:background .15s,color .15s,transform .15s}
.aon-bell:hover{background:rgba(99,102,241,.1);color:#6366f1;transform:scale(1.05)}
.dark .aon-bell:hover{background:rgba(99,102,241,.15);color:#818cf8}
.dark .aon-bell{color:#9ca3af}

/* ── Badge (red dot) ── */
.aon-badge{position:absolute;top:3px;right:3px;min-width:17px;height:17px;border-radius:980px;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 3.5px;line-height:1;border:2px solid white;box-shadow:0 1px 4px rgba(239,68,68,.45)}
.dark .aon-badge{border-color:#111827}
.aon-badge-pulse{animation:aonPulse 2s infinite}
@keyframes aonPulse{0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,.5)}70%{box-shadow:0 0 0 6px rgba(239,68,68,0)}}

/* ── Bell ring animation ── */
@keyframes aonRing{0%,100%{transform:rotate(0)}10%,30%,50%,70%{transform:rotate(-15deg)}20%,40%,60%{transform:rotate(15deg)}}
.aon-bell-icon-pending{animation:aonRing 1s ease .3s 2}

/* ── Dropdown ── */
.aon-dropdown{position:absolute;top:calc(100% + 10px);right:0;width:340px;background:#fff;border-radius:16px;box-shadow:0 12px 40px rgba(0,0,0,.16),0 2px 8px rgba(0,0,0,.08);border:1px solid rgba(0,0,0,.07);z-index:9999;overflow:hidden;transform-origin:top right}
.dark .aon-dropdown{background:#1e2432;border-color:rgba(255,255,255,.09);box-shadow:0 12px 40px rgba(0,0,0,.5)}
@keyframes aonIn{from{opacity:0;transform:scale(.93) translateY(-8px)}to{opacity:1;transform:scale(1) translateY(0)}}
@keyframes aonOut{to{opacity:0;transform:scale(.93) translateY(-8px)}}

/* ── Header ── */
.aon-head{padding:14px 16px 12px;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);display:flex;align-items:center;gap:8px}
.aon-head-icon{width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.aon-head-info{flex:1;min-width:0}
.aon-head-title{font-size:13px;font-weight:700;color:#fff;line-height:1.2}
.aon-head-sub{font-size:11px;color:rgba(255,255,255,.75);margin-top:1px}
.aon-head-link{font-size:11px;font-weight:600;color:rgba(255,255,255,.9);text-decoration:none;background:rgba(255,255,255,.18);padding:4px 10px;border-radius:980px;white-space:nowrap;transition:background .15s}
.aon-head-link:hover{background:rgba(255,255,255,.3)}

/* ── Stats bar ── */
.aon-stats{display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid rgba(0,0,0,.06)}
.dark .aon-stats{border-color:rgba(255,255,255,.07)}
.aon-stat{padding:10px 16px;display:flex;flex-direction:column;align-items:center;gap:2px}
.aon-stat:first-child{border-right:1px solid rgba(0,0,0,.06)}
.dark .aon-stat:first-child{border-color:rgba(255,255,255,.07)}
.aon-stat-num{font-size:20px;font-weight:900;color:#111827;line-height:1}
.dark .aon-stat-num{color:#f9fafb}
.aon-stat-num-warn{color:#d97706}
.aon-stat-label{font-size:10px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.05em}

/* ── Scroll area ── */
.aon-scroll{max-height:340px;overflow-y:auto;overscroll-behavior:contain}
.aon-scroll::-webkit-scrollbar{width:4px}
.aon-scroll::-webkit-scrollbar-track{background:transparent}
.aon-scroll::-webkit-scrollbar-thumb{background:rgba(0,0,0,.12);border-radius:4px}
.dark .aon-scroll::-webkit-scrollbar-thumb{background:rgba(255,255,255,.12)}

/* ── Section label ── */
.aon-section-label{padding:8px 16px 4px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#9ca3af;background:#fafafa}
.dark .aon-section-label{background:#1a2030;color:#6b7280}

/* ── Order item ── */
.aon-item{display:flex;align-items:flex-start;gap:10px;padding:10px 16px;text-decoration:none;transition:background .1s;border-bottom:1px solid rgba(0,0,0,.04);position:relative}
.dark .aon-item{border-color:rgba(255,255,255,.04)}
.aon-item:last-child{border-bottom:none}
.aon-item:hover{background:rgba(99,102,241,.04)}
.dark .aon-item:hover{background:rgba(99,102,241,.08)}
.aon-item-new{background:rgba(99,102,241,.05)}
.dark .aon-item-new{background:rgba(99,102,241,.1)}

/* ── Status dot ── */
.aon-dot-wrap{display:flex;flex-direction:column;align-items:center;padding-top:2px;gap:4px}
.aon-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0}

/* ── Body ── */
.aon-item-body{flex:1;min-width:0}
.aon-item-row1{display:flex;justify-content:space-between;align-items:center;margin-bottom:2px;gap:4px}
.aon-item-num{font-size:12px;font-weight:700;color:#111827;font-family:ui-monospace,'SF Mono',monospace;letter-spacing:.02em}
.dark .aon-item-num{color:#f9fafb}
.aon-item-amt{font-size:13px;font-weight:800;color:#111827;white-space:nowrap}
.dark .aon-item-amt{color:#f9fafb}
.aon-item-row2{display:flex;justify-content:space-between;align-items:center;margin-bottom:3px}
.aon-item-name{font-size:11.5px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px}
.aon-item-time{font-size:10px;color:#9ca3af;white-space:nowrap;flex-shrink:0}
.aon-item-row3{display:flex;align-items:center;gap:6px}
.aon-status-pill{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:2px 7px;border-radius:980px}
.aon-items-tag{font-size:10px;color:#9ca3af;display:flex;align-items:center;gap:3px}

/* ── NEW badge ── */
.aon-new-tag{font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;padding:1.5px 5px;border-radius:4px;flex-shrink:0}

/* ── Footer ── */
.aon-footer{padding:10px 16px;border-top:1px solid rgba(0,0,0,.06);background:#fafafa;text-align:center}
.dark .aon-footer{background:#1a2030;border-color:rgba(255,255,255,.07)}
.aon-footer-link{font-size:12px;font-weight:600;color:#6366f1;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
.aon-footer-link:hover{text-decoration:underline}

/* ── Empty state ── */
.aon-empty{padding:32px 16px;text-align:center}
.aon-empty-icon{font-size:32px;margin-bottom:8px;opacity:.5}
.aon-empty-text{font-size:13px;color:#9ca3af}

[x-cloak]{display:none!important}
</style>

    {{-- Bell button --}}
    <button type="button" class="aon-bell"
            @click="open = !open"
            :aria-expanded="open"
            aria-label="Order notifications">
        <svg class="{{ $pendingCount > 0 ? 'aon-bell-icon-pending' : '' }}"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.7" stroke="currentColor" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        @if($pendingCount > 0)
            <span class="aon-badge aon-badge-pulse">{{ $pendingCount > 99 ? '99+' : $pendingCount }}</span>
        @elseif($todayCount > 0)
            <span class="aon-badge" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">{{ $todayCount > 99 ? '99+' : $todayCount }}</span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div class="aon-dropdown" x-show="open" x-cloak
         x-transition:enter.duration.150ms
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave.duration.100ms
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="transform-origin:top right">

        {{-- Header --}}
        <div class="aon-head">
            <div class="aon-head-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="white" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </div>
            <div class="aon-head-info">
                <div class="aon-head-title">Order Notifications</div>
                <div class="aon-head-sub">
                    @if($pendingCount > 0)
                        {{ $pendingCount }} pending · {{ $todayCount }} today
                    @else
                        {{ $todayCount }} orders today
                    @endif
                </div>
            </div>
            <a href="{{ url('/admin/orders') }}" class="aon-head-link" @click="open=false">
                View all →
            </a>
        </div>

        {{-- Stats bar --}}
        <div class="aon-stats">
            <div class="aon-stat">
                <span class="aon-stat-num {{ $pendingCount > 0 ? 'aon-stat-num-warn' : '' }}">
                    {{ $pendingCount }}
                </span>
                <span class="aon-stat-label">Pending</span>
            </div>
            <div class="aon-stat">
                <span class="aon-stat-num">{{ $todayCount }}</span>
                <span class="aon-stat-label">Today</span>
            </div>
        </div>

        {{-- Order list --}}
        <div class="aon-scroll">
            @forelse($orders as $order)
                @php
                    $sv      = $order->status->value ?? $order->status;
                    $isPend  = $sv === 'pending';
                    $isNew   = $order->created_at->gt(now()->subMinutes(10));
                    $dot     = match($sv) {
                        'pending'   => '#f59e0b',
                        'confirmed' => '#3b82f6',
                        'delivered' => '#22c55e',
                        'cancelled' => '#ef4444',
                        default     => '#9ca3af',
                    };
                    $pillBg  = match($sv) {
                        'pending'   => 'rgba(245,158,11,.12)',
                        'confirmed' => 'rgba(59,130,246,.12)',
                        'delivered' => 'rgba(34,197,94,.12)',
                        'cancelled' => 'rgba(239,68,68,.12)',
                        default     => 'rgba(156,163,175,.12)',
                    };
                    $payIcon = match(strtolower($order->payment_method ?? '')) {
                        'stripe','card'  => '💳',
                        'aba','bakong'   => '🏦',
                        'cash'           => '💵',
                        default          => '💰',
                    };
                @endphp
                <a href="{{ \App\Filament\Admin\Pages\OrderDetail::getUrl(['record' => $order->id]) }}"
                   class="aon-item {{ $isNew ? 'aon-item-new' : '' }}"
                   @click="open=false">

                    <div class="aon-dot-wrap">
                        <span class="aon-dot" style="background:{{ $dot }}"></span>
                    </div>

                    <div class="aon-item-body">
                        <div class="aon-item-row1">
                            <span class="aon-item-num">{{ $order->order_number }}</span>
                            <span class="aon-item-amt">${{ number_format($order->total / 100, 0) }}</span>
                        </div>
                        <div class="aon-item-row2">
                            <span class="aon-item-name">{{ $order->customer_name }}</span>
                            <span class="aon-item-time">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="aon-item-row3">
                            <span class="aon-status-pill"
                                  style="background:{{ $pillBg }};color:{{ $dot }}">
                                {{ ucfirst($sv) }}
                            </span>
                            <span class="aon-items-tag">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="2" stroke="currentColor" width="10" height="10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m21 7.5-9-4.5-9 4.5m18 0-9 4.5m9-4.5v9l-9 4.5m0-9L3 7.5m9 4.5v9" />
                                </svg>
                                {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}
                            </span>
                            <span style="font-size:10px">{{ $payIcon }}</span>
                            @if($isNew)
                                <span class="aon-new-tag">New</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="aon-empty">
                    <div class="aon-empty-icon">📭</div>
                    <div class="aon-empty-text">No orders yet</div>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($orders->isNotEmpty())
            <div class="aon-footer">
                <a href="{{ url('/admin/orders') }}" class="aon-footer-link" @click="open=false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" width="13" height="13">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 12h16.5m0 0-6.75-6.75M20.25 12l-6.75 6.75" />
                    </svg>
                    View all orders
                </a>
            </div>
        @endif

    </div>
</div>
