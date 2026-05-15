<div>
    {{-- TODO Phase 3 (post-prototype): port .loan-card markup --}}
    <section class="loan-card" style="margin-top:24px;padding:20px;border:1px solid #eee;border-radius:14px;background:#fff">
        <h3 style="margin:0 0 12px">{{ __('Loan Calculator') }}</h3>

        <label style="display:block;margin-bottom:12px">
      <span>{{ __('Down Payment') }} ($)</span>
            <input type="number" min="0" step="50" wire:model.live="downPayment"
                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:10px">
        </label>

        <label style="display:block;margin-bottom:12px">
            <span>{{ __('Term') }} ({{ __('months') }})</span>
            <input type="number" min="1" max="60" wire:model.live="termMonths"
                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:10px">
        </label>

        <label style="display:block;margin-bottom:12px">
            <span>{{ __('Interest Rate') }} (%)</span>
            <input type="number" min="0" step="0.01" wire:model.live="interestRate"
              style="width:100%;padding:8px;border:1px solid #ddd;border-radius:10px">
      </label>

        <div style="display:flex;justify-content:space-between;font-weight:600;font-size:18px">
            <span>{{ __('Monthly') }}</span>
            <span>${{ number_format($this->monthlyPayment, 2) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;color:#666;font-size:13px;margin-top:4px">
            <span>{{ __('Total interest') }}</span>
            <span>${{ number_format($this->totalInterest, 2) }}</span>
      </div>
    </section>
</div>
