<div class="aon-wrap" x-data="{ open: @entangle('open') }" @click.outside="open = false" @keydown.escape.window="open = false" wire:poll.30s>
<style>
.aon-wrap{position:relative;display:flex;align-items:center}
.aon-bell{position:relative;width:36px;height:36px;border-radius:8px;border:none;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:background .15s,color .15s}
.aon-bell:hover{background:rgba(0,0,0,.06);color:#111827}
.dark .aon-bell:hover{background:rgba(255,255,255,.08);color:#f9fafb}
.dark .aon-bell{color:#9ca3af}
.aon-badge{position:absolute;top:4px;right:4px;min-width:16px;height:16px;border-radius:980px;background:#ef4444;color:#fff;font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 3px;line-height:1;border:2px solid white}
.dark .aon-badge{border-color:#1f2937}
.aon-dropdown{position:absolute;top:calc(100% + 8px);right:0;width:320px;background:#fff;border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,.14),0 1px 4px rgba(0,0,0,.08);border:1px solid rgba(0,0,0,.08);z-index:9999;overflow:hidden}
.dark .aon-dropdown{background:#1f2937;border-color:rgba(255,255,255,.1);box-shadow:0 8px 32px rgba(0,0,0,.4)}
.aon-trans-in{animation:aonIn .15s ease}
.aon-trans-out{animation:aonIn .1s ease reverse}
@keyframes aonIn{from{opacity:0;transform:translateY(-6px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.aon-head{display:flex;align-items:center;gap:8px;padding:12px 14px 10px;border-bottom:1px solid rgba(0,0,0,.06)}
.dark .aon-head{border-color:rgba(255,255,255,.08)}
.aon-head-title{font-size:13px;font-weight:700;color:#111827;flex:1}
.dark .aon-head-title{color:#f9fafb}
.aon-head-badge{font-size:10px;font-weight:700;padding:2px 7px;border-radius:980px;background:rgba(245,158,11,.15);color:#d97706}
.aon-head-link{font-size:11.5px;font-weight:600;color:#6366f1;text-decoration:none;white-space:nowrap}
.aon-head-link:hover{text-decoration:underline}
.aon-item{display:flex;align-items:flex-start;gap:10px;padding:10px 14px;text-decoration:none;transition:background .1s;border-bottom:1px solid rgba(0,0,0,.04)}
.dark .aon-item{border-color:rgba(255,255,255,.05)}
.aon-item:last-child{border-bottom:none}
.aon-item:hover{background:rgba(0,0,0,.03)}
.dark .aon-item:hover{background:rgba(255,255,255,.04)}
.aon-item-pending{background:rgba(245,158,11,.06)}
.dark .aon-item-pending{background:rgba(245,158,11,.08)}
.aon-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px}
.aon-item-body{flex:1;min-width:0}
.aon-item-top{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:2px}
.aon-item-num{font-size:12.5px;font-weight:700;color:#111827;font-family:ui-monospace,'SF Mono',monospace}
.dark .aon-item-num{color:#f9fafb}
.aon-item-amt{font-size:13px;font-weight:800;color:#111827}
.dark .aon-item-amt{color:#f9fafb}
.aon-item-bot{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:2px}
.aon-item-name{font-size:12px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:150px}
.aon-item-time{font-size:10.5px;color:#9ca3af;white-space:nowrap;flex-shrink:0}
.aon-item-status{font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em}
.aon-empty{padding:24px;text-align:center;font-size:13px;color:#9ca3af}
[x-cloak]{display:none!important}
</style>

    {{-- Bell button --}}
    <button type="button" class="aon-bell" @click="open = !open" :aria-expanded="open" aria-label="Order notifications">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        @if($pendingCount > 0)
            <span class="aon-badge">{{ $pendingCount > 99 ? '99+' : $pendingCount }}</span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div class="aon-dropdown" x-show="open" x-cloak
         x-transition:enter="aon-trans-in" x-transition:leave="aon-trans-out">

        <div class="aon-head">
            <span class="aon-head-title">Orders</span>
            @if($pendingCount > 0)
                <span class="aon-head-badge">{{ $pendingCount }} pending</span>
            @endif
            <a href="{{ url('/admin/orders') }}" class="aon-head-link" @click="open=false">View all →</a>
        </div>

        @forelse($orders as $order)
            @php
                $statusVal = $order->status->value ?? $order->status;
                $isPending = $statusVal === 'pending';
                $isCancel  = $statusVal === 'cancelled';
                $dot = match($statusVal) {
                    'pending'   => '#f59e0b',
                    'confirmed' => '#3b82f6',
                    'delivered' => '#22c55e',
                    'cancelled' => '#ef4444',
                    default     => '#9ca3af',
                };
            @endphp
            <a href="{{ \App\Filament\Admin\Pages\OrderDetail::getUrl(['record' => $order->id]) }}"
               class="aon-item {{ $isPending ? 'aon-item-pending' : '' }}"
               @click="open=false">
                <span class="aon-dot" style="background:{{ $dot }}"></span>
                <div class="aon-item-body">
                    <div class="aon-item-top">
                        <span class="aon-item-num">{{ $order->order_number }}</span>
                        <span class="aon-item-amt">${{ number_format($order->total / 100, 0) }}</span>
                    </div>
                    <div class="aon-item-bot">
                        <span class="aon-item-name">{{ $order->customer_name }}</span>
                        <span class="aon-item-time">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="aon-item-status" style="color:{{ $dot }}">{{ ucfirst($statusVal) }}</span>
                </div>
            </a>
        @empty
            <div class="aon-empty">No orders yet</div>
        @endforelse
    </div>
</div>
