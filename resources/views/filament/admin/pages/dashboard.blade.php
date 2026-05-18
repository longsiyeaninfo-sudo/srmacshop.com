<x-filament-panels::page>
    @push('styles')
        <style>
        .kd-wrap{display:flex;flex-direction:column;gap:18px}
        .kd-period{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:14px 16px}
        .dark .kd-period{background:#1f2937;border-color:#374151}
        .kd-period-title{font-size:13px;color:#6b7280;font-weight:600}
        .dark .kd-period-title{color:#9ca3af}
        .kd-chips{display:flex;gap:6px;flex-wrap:wrap}
        .kd-chip{padding:6px 14px;border-radius:980px;font-size:12px;font-weight:700;cursor:pointer;border:1.5px solid #e5e7eb;background:#fff;color:#6b7280;transition:all .15s}
        .dark .kd-chip{background:#111827;border-color:#374151;color:#9ca3af}
        .kd-chip:hover{border-color:#f97316;color:#f97316}
        .kd-chip.on{background:#f97316;border-color:#f97316;color:#fff}
        .kd-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px}
        .kd-row{display:grid;grid-template-columns:1.4fr 1fr;gap:14px}
        @media(max-width:900px){.kd-row{grid-template-columns:1fr}}
        .kd-card{background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px}
        .dark .kd-card{background:#1f2937;border-color:#374151}
        .kd-card-title{font-size:14px;font-weight:700;color:#111827;margin:0 0 12px}
        .dark .kd-card-title{color:#f9fafb}
        .kd-card .fi-wi,
        .kd-card .fi-section,
        .kd-card .fi-wi-stats-overview-stat,
        .kd-card .fi-wi-chart{background:transparent !important;border:0 !important;box-shadow:none !important;padding:0 !important}
        </style>
    @endpush

    <div class="kd-wrap">
        {{-- Period selector --}}
        <div class="kd-period">
            <div class="kd-period-title">Showing data for</div>
            <div class="kd-chips">
                @foreach($this->getPeriodOptions() as $key => $label)
                    <button type="button"
                        wire:click="setPeriod('{{ $key }}')"
                        class="kd-chip {{ $period === $key ? 'on' : '' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- KPI overview --}}
        <div class="kd-card">
            <h3 class="kd-card-title">📊 Key Metrics</h3>
            @livewire(\App\Filament\Admin\Widgets\KpiStatsOverview::class, ['period' => $period], key('kpi-'.$period))
        </div>

        {{-- Revenue chart + Category donut side by side --}}
        <div class="kd-row">
            <div class="kd-card">
                <h3 class="kd-card-title">💰 Revenue Trend</h3>
                @livewire(\App\Filament\Admin\Widgets\RevenueChartWidget::class, ['period' => $period], key('rev-'.$period))
            </div>
            <div class="kd-card">
                <h3 class="kd-card-title">🥧 Sales by Category</h3>
                @livewire(\App\Filament\Admin\Widgets\CategoryDonutWidget::class, [], key('cat'))
            </div>
        </div>

        {{-- Recent orders --}}
        <div class="kd-card">
            <h3 class="kd-card-title">🛒 Recent Orders</h3>
            @livewire(\App\Filament\Admin\Widgets\RecentOrdersTable::class, [], key('recent'))
        </div>
    </div>
</x-filament-panels::page>
