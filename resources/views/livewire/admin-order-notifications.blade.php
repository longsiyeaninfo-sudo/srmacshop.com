<div class="aon-wrap"
     x-data="{
         open: false,
         lastSeen: parseInt(localStorage.getItem('aon_last_seen') || '0'),
         init() {
             this.$watch('open', v => {
                 if (v) {
                     this.lastSeen = {{ $latestOrderId }};
                     localStorage.setItem('aon_last_seen', {{ $latestOrderId }});
                 }
             });
         },
         toggle() { this.open = !this.open },
         close()  { this.open = false }
     }"
     @keydown.escape.window="close()"
     wire:poll.30s>

<style>
/* Wrap */
.aon-wrap{position:relative;display:flex;align-items:center}

/* Bell button */
.aon-bell{position:relative;width:42px;height:42px;border-radius:10px;border:none;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:background .15s,color .15s;-webkit-tap-highlight-color:transparent;touch-action:manipulation}
.aon-bell:hover,.aon-bell:focus-visible{background:rgba(99,102,241,.1);color:#6366f1;outline:none}
.dark .aon-bell{color:#9ca3af}
.dark .aon-bell:hover{background:rgba(99,102,241,.15);color:#818cf8}

/* Badge */
.aon-badge{position:absolute;top:4px;right:4px;min-width:17px;height:17px;border-radius:980px;color:#fff;font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 3.5px;line-height:1;border:2px solid white;pointer-events:none}
.dark .aon-badge{border-color:#111827}
.aon-badge-red{background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 1px 6px rgba(239,68,68,.5)}
.aon-badge-indigo{background:linear-gradient(135deg,#6366f1,#8b5cf6)}
@keyframes aonPulse{0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,.5)}65%{box-shadow:0 0 0 6px rgba(239,68,68,0)}}
.aon-badge-pulse{animation:aonPulse 2s infinite}
@keyframes aonRing{0%,100%{transform:rotate(0)}15%,45%{transform:rotate(-14deg)}30%,60%{transform:rotate(14deg)}}
.aon-bell-ring{animation:aonRing 1s ease .4s 2}

/* Backdrop (mobile close layer) */
.aon-backdrop{position:fixed;inset:0;z-index:9998;background:transparent;-webkit-tap-highlight-color:transparent}

/* Dropdown */
.aon-dropdown{position:absolute;top:calc(100% + 10px);right:0;width:340px;background:#fff;border-radius:16px;box-shadow:0 16px 48px rgba(0,0,0,.18),0 2px 8px rgba(0,0,0,.08);border:1px solid rgba(0,0,0,.07);z-index:9999;overflow:hidden}
.dark .aon-dropdown{background:#1e2432;border-color:rgba(255,255,255,.09);box-shadow:0 16px 48px rgba(0,0,0,.55)}
@media(max-width:639px){
  .aon-dropdown{position:fixed;top:68px;left:8px;right:8px;width:auto;border-radius:14px;max-height:calc(100dvh - 88px);overflow-y:auto}
  .aon-scroll{max-height:calc(100dvh - 260px)}
}

/* CSS-only transitions (no Tailwind) */
@keyframes aonIn{from{opacity:0;transform:scale(.93) translateY(-8px)}to{opacity:1;transform:scale(1) translateY(0)}}
@keyframes aonOut{from{opacity:1;transform:scale(1) translateY(0)}to{opacity:0;transform:scale(.93) translateY(-8px)}}
.aon-dropdown[x-show]{transform-origin:top right}
.aon-enter{animation:aonIn .15s cubic-bezier(.16,1,.3,1) forwards}
.aon-leave{animation:aonOut .1s ease forwards}

/* Header */
.aon-head{padding:13px 15px 12px;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);display:flex;align-items:center;gap:9px}
.aon-head-icon{width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.aon-head-info{flex:1;min-width:0}
.aon-head-title{font-size:13px;font-weight:700;color:#fff}
.aon-head-sub{font-size:11px;color:rgba(255,255,255,.75);margin-top:1px}
.aon-head-actions{display:flex;align-items:center;gap:6px}
.aon-head-link{font-size:11px;font-weight:600;color:rgba(255,255,255,.9);text-decoration:none;background:rgba(255,255,255,.18);padding:5px 10px;border-radius:980px;white-space:nowrap;transition:background .15s;-webkit-tap-highlight-color:transparent;touch-action:manipulation}
.aon-head-link:hover{background:rgba(255,255,255,.3)}
.aon-head-close{width:28px;height:28px;border-radius:50%;border:none;background:rgba(255,255,255,.18);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;line-height:1;flex-shrink:0;-webkit-tap-highlight-color:transparent;touch-action:manipulation}
.aon-head-close:hover{background:rgba(255,255,255,.3)}

/* Stats */
.aon-stats{display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid rgba(0,0,0,.06)}
.dark .aon-stats{border-color:rgba(255,255,255,.07)}
.aon-stat{padding:10px 16px;display:flex;flex-direction:column;align-items:center;gap:2px}
.aon-stat:first-child{border-right:1px solid rgba(0,0,0,.06)}
.dark .aon-stat:first-child{border-color:rgba(255,255,255,.07)}
.aon-stat-num{font-size:22px;font-weight:900;color:#111827;line-height:1}
.dark .aon-stat-num{color:#f9fafb}
.aon-stat-warn{color:#d97706}
.aon-stat-label{font-size:10px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:.05em}

/* Scroll area */
.aon-scroll{max-height:336px;overflow-y:auto;-webkit-overflow-scrolling:touch;overscroll-behavior:contain}
.aon-scroll::-webkit-scrollbar{width:3px}
.aon-scroll::-webkit-scrollbar-thumb{background:rgba(0,0,0,.12);border-radius:3px}
.dark .aon-scroll::-webkit-scrollbar-thumb{background:rgba(255,255,255,.12)}

/* Order item */
.aon-item{display:flex;align-items:flex-start;gap:10px;padding:11px 15px;text-decoration:none;transition:background .1s;border-bottom:1px solid rgba(0,0,0,.04);-webkit-tap-highlight-color:transparent;touch-action:manipulation}
.dark .aon-item{border-color:rgba(255,255,255,.04)}
.aon-item:last-child{border-bottom:none}
.aon-item:hover,.aon-item:active{background:rgba(99,102,241,.05)}
.dark .aon-item:hover,.dark .aon-item:active{background:rgba(99,102,241,.1)}
.aon-item-new{background:rgba(99,102,241,.04)}

/* Dot */
.aon-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;margin-top:3px}

/* Body */
.aon-item-body{flex:1;min-width:0}
.aon-item-r1{display:flex;justify-content:space-between;align-items:center;gap:4px;margin-bottom:2px}
.aon-item-num{font-size:12px;font-weight:700;color:#111827;font-family:ui-monospace,'SF Mono',monospace}
.dark .aon-item-num{color:#f9fafb}
.aon-item-amt{font-size:13px;font-weight:800;color:#111827;white-space:nowrap}
.dark .aon-item-amt{color:#f9fafb}
.aon-item-r2{display:flex;justify-content:space-between;align-items:center;margin-bottom:4px}
.aon-item-name{font-size:11.5px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:145px}
.aon-item-time{font-size:10px;color:#9ca3af;white-space:nowrap;flex-shrink:0}
.aon-item-r3{display:flex;align-items:center;gap:5px;flex-wrap:wrap}
.aon-pill{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:2px 7px;border-radius:980px}
.aon-items-tag{font-size:10px;color:#9ca3af;display:flex;align-items:center;gap:2px}
.aon-new-tag{font-size:8.5px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;padding:2px 6px;border-radius:4px}

/* Footer */
.aon-footer{padding:10px 16px;border-top:1px solid rgba(0,0,0,.06);background:#fafafa;text-align:center}
.dark .aon-footer{background:#181f2e;border-color:rgba(255,255,255,.07)}
.aon-footer-link{font-size:12px;font-weight:600;color:#6366f1;text-decoration:none;display:inline-flex;align-items:center;gap:5px;padding:4px 8px;border-radius:6px;-webkit-tap-highlight-color:transparent;touch-action:manipulation}
.aon-footer-link:hover,.aon-footer-link:active{text-decoration:underline}

/* Empty */
.aon-empty{padding:32px 16px;text-align:center}
.aon-empty-icon{font-size:36px;margin-bottom:8px}
.aon-empty-text{font-size:13px;color:#9ca3af}

[x-cloak]{display:none!important}
</style>

    {{-- Backdrop (closes dropdown on tap-outside on mobile) --}}
    <div class="aon-backdrop" x-show="open" x-cloak @click="close()" @touchend.prevent="close()"></div>

    {{-- Bell --}}
    <button type="button" class="aon-bell"
            @click.stop="toggle()"
            @touchend.prevent.stop="toggle()"
            :aria-expanded="open.toString()"
            aria-label="Order notifications">
        <svg class="{{ $pendingCount > 0 ? 'aon-bell-ring' : '' }}"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.7" stroke="currentColor" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        @if($pendingCount > 0)
            <span class="aon-badge aon-badge-red aon-badge-pulse">{{ $pendingCount > 99 ? '99+' : $pendingCount }}</span>
        @elseif($todayCount > 0)
            <span class="aon-badge aon-badge-indigo">{{ $todayCount > 99 ? '99+' : $todayCount }}</span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div class="aon-dropdown"
         x-show="open"
         x-cloak
         x-transition:enter="aon-enter"
         x-transition:leave="aon-leave"
         @click.stop
         @touchstart.stop
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
                        {{ $pendingCount }} pending &nbsp;·&nbsp; {{ $todayCount }} today
                    @else
                        {{ $todayCount }} {{ Str::plural('order', $todayCount) }} today
                    @endif
                </div>
            </div>
            <div class="aon-head-actions">
                <a href="{{ url('/admin/orders') }}" class="aon-head-link" @click="close()">All →</a>
                <button type="button" class="aon-head-close" @click="close()" @touchend.prevent="close()" aria-label="Close">✕</button>
            </div>
        </div>

        {{-- Stats --}}
        <div class="aon-stats">
            <div class="aon-stat">
                <span class="aon-stat-num {{ $pendingCount > 0 ? 'aon-stat-warn' : '' }}">{{ $pendingCount }}</span>
                <span class="aon-stat-label">Pending</span>
            </div>
            <div class="aon-stat">
                <span class="aon-stat-num">{{ $todayCount }}</span>
                <span class="aon-stat-label">Today</span>
            </div>
        </div>

        {{-- Order list --}}
        <div class="aon-scroll" @touchstart.stop @touchmove.stop @touchend.stop>
            @forelse($orders as $order)
                @php
                    $sv     = $order->status->value ?? $order->status;
                    $isNew  = $order->created_at->gt(now()->subMinutes(10));
                    $dot    = match($sv) {
                        'pending'   => '#f59e0b',
                        'confirmed' => '#3b82f6',
                        'delivered' => '#22c55e',
                        'cancelled' => '#ef4444',
                        default     => '#9ca3af',
                    };
                    $pillBg = match($sv) {
                        'pending'   => 'rgba(245,158,11,.13)',
                        'confirmed' => 'rgba(59,130,246,.13)',
                        'delivered' => 'rgba(34,197,94,.13)',
                        'cancelled' => 'rgba(239,68,68,.13)',
                        default     => 'rgba(156,163,175,.13)',
                    };
                    $payIcon = match(strtolower($order->payment_method ?? '')) {
                        'stripe','card' => '💳',
                        'aba','bakong'  => '🏦',
                        'cash'          => '💵',
                        default         => '💰',
                    };
                @endphp
                <a href="{{ \App\Filament\Admin\Pages\OrderDetail::getUrl(['record' => $order->id]) }}"
                   class="aon-item {{ $isNew ? 'aon-item-new' : '' }}"
                   @click="close()">

                    <span class="aon-dot" style="background:{{ $dot }}"></span>

                    <div class="aon-item-body">
                        <div class="aon-item-r1">
                            <span class="aon-item-num">{{ $order->order_number }}</span>
                            <span class="aon-item-amt">${{ number_format($order->total / 100, 0) }}</span>
                        </div>
                        <div class="aon-item-r2">
                            <span class="aon-item-name">{{ $order->customer_name }}</span>
                            <span class="aon-item-time">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="aon-item-r3">
                            <span class="aon-pill" style="background:{{ $pillBg }};color:{{ $dot }}">{{ ucfirst($sv) }}</span>
                            <span class="aon-items-tag">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="2.2" stroke="currentColor" width="10" height="10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m21 7.5-9-4.5-9 4.5m18 0-9 4.5m9-4.5v9l-9 4.5m0-9L3 7.5m9 4.5v9" />
                                </svg>
                                {{ $order->items_count }}
                            </span>
                            <span style="font-size:11px;line-height:1">{{ $payIcon }}</span>
                            @if($isNew)<span class="aon-new-tag">New</span>@endif
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

        @if($orders->isNotEmpty())
            <div class="aon-footer">
                <a href="{{ url('/admin/orders') }}" class="aon-footer-link" @click="close()">
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
