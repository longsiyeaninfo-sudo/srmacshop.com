<div>
<style>
.loan-card{background:var(--card);border:1px solid var(--hairline);border-radius:var(--radius-lg);padding:var(--space-5);box-shadow:var(--shadow-sm)}
.loan-title{font-size:13px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.5px;margin-bottom:var(--space-5);display:flex;align-items:center;gap:6px}
.loan-slider-row{margin-bottom:var(--space-4)}
.loan-slider-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:8px}
.loan-slider-lbl{font-size:13px;color:var(--text2)}
.loan-slider-val{font-size:14px;font-weight:600;color:var(--text);font-variant-numeric:tabular-nums;letter-spacing:-.005em}

/* Apple-style range slider */
.loan-range{-webkit-appearance:none;appearance:none;width:100%;height:6px;border-radius:3px;background:linear-gradient(to right, var(--blue) 0%, var(--blue) var(--p, 50%), var(--bg3) var(--p, 50%), var(--bg3) 100%);outline:none;cursor:pointer;margin:0}
.loan-range::-webkit-slider-thumb{-webkit-appearance:none;appearance:none;width:22px;height:22px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.15),0 2px 6px rgba(0,0,0,.12);cursor:grab;border:none;transition:transform .15s var(--ease)}
.loan-range::-webkit-slider-thumb:hover{transform:scale(1.08)}
.loan-range::-webkit-slider-thumb:active{cursor:grabbing;transform:scale(1.12)}
.loan-range::-moz-range-thumb{width:22px;height:22px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.15),0 2px 6px rgba(0,0,0,.12);cursor:grab;border:none}
[data-theme="dark"] .loan-range::-webkit-slider-thumb{background:#f5f5f7}

.loan-result{margin-top:var(--space-5);padding-top:var(--space-5);border-top:1px solid var(--hairline);text-align:center}
.loan-monthly{font-size:44px;font-weight:700;letter-spacing:-.04em;color:var(--text);line-height:1;font-variant-numeric:tabular-nums}
.loan-monthly-lbl{font-size:13px;color:var(--text2);margin-top:4px;margin-bottom:var(--space-4)}
.loan-summary{display:grid;grid-template-columns:1fr 1fr;gap:var(--space-3);text-align:left;padding-top:var(--space-3);border-top:1px solid var(--hairline)}
.loan-sum-l{font-size:11px;color:var(--text2);text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
.loan-sum-v{font-size:14px;font-weight:600;font-variant-numeric:tabular-nums}
</style>

@php
    $downPct = $productPrice > 0 ? min(100, round(($downPayment / $productPrice) * 100)) : 0;
    $termPct = round((($termMonths - 6) / (60 - 6)) * 100);
    $ratePct = round((($interestRate - 0) / 5) * 100);
@endphp

<div class="loan-card">
    <div class="loan-title">🧮 <span data-en="Loan Calculator" data-km="គណនាប្រាក់កម្ចី">Loan Calculator</span></div>

    {{-- Down payment slider --}}
    <div class="loan-slider-row">
        <div class="loan-slider-head">
            <span class="loan-slider-lbl" data-en="Down payment" data-km="ប្រាក់កក់">Down payment</span>
            <span class="loan-slider-val">${{ number_format($downPayment, 0) }} <span style="color:var(--text3);font-weight:400">({{ $downPct }}%)</span></span>
        </div>
        <input type="range" class="loan-range" min="0" max="{{ (int) $productPrice }}" step="50"
            wire:model.live="downPayment"
            style="--p: {{ $downPct }}%">
    </div>

    {{-- Term slider --}}
    <div class="loan-slider-row">
        <div class="loan-slider-head">
            <span class="loan-slider-lbl" data-en="Term" data-km="រយៈពេល">Term</span>
            <span class="loan-slider-val">{{ $termMonths }} <span style="color:var(--text3);font-weight:400" data-en="months" data-km="ខែ">months</span></span>
        </div>
        <input type="range" class="loan-range" min="6" max="60" step="1"
            wire:model.live="termMonths"
            style="--p: {{ $termPct }}%">
    </div>

    {{-- Interest rate slider --}}
    <div class="loan-slider-row">
        <div class="loan-slider-head">
            <span class="loan-slider-lbl" data-en="Interest rate" data-km="អត្រាការប្រាក់">Interest rate</span>
            <span class="loan-slider-val">{{ number_format($interestRate, 2) }}%<span style="color:var(--text3);font-weight:400">/mo</span></span>
        </div>
        <input type="range" class="loan-range" min="0" max="5" step="0.05"
            wire:model.live="interestRate"
            style="--p: {{ $ratePct }}%">
    </div>

    {{-- Big monthly display --}}
    <div class="loan-result">
        <div class="loan-monthly">${{ number_format($this->monthlyPayment, 2) }}</div>
        <div class="loan-monthly-lbl" data-en="per month" data-km="ក្នុងមួយខែ">per month</div>

        <div class="loan-summary">
            <div>
                <div class="loan-sum-l" data-en="Loan amount" data-km="ប្រាក់កម្ចី">Loan amount</div>
                <div class="loan-sum-v">${{ number_format(max(0, $productPrice - $downPayment), 0) }}</div>
            </div>
            <div>
                <div class="loan-sum-l" data-en="Total paid" data-km="សរុបបាន">Total paid</div>
                <div class="loan-sum-v" style="color:var(--blue)">${{ number_format($this->totalPayment, 0) }}</div>
            </div>
        </div>
    </div>
</div>
</div>
