<div>
    <div class="loan-card">
        <div class="loan-title">🧮 <span data-en="Loan Calculator" data-km="គណនាប្រាក់កម្ចី">Loan Calculator</span></div>

        <div class="loan-inp-row">
            <div class="loan-inp-lbl">Down Payment ($)</div>
            <input class="loan-inp" type="number" wire:model.live="downPayment" value="0" min="0">
        </div>
        <div class="loan-inp-row">
            <div class="loan-inp-lbl">Term (months)</div>
            <input class="loan-inp" type="number" wire:model.live="termMonths" value="12" min="1" max="60">
        </div>
        <div class="loan-inp-row">
            <div class="loan-inp-lbl">Interest Rate (%/month)</div>
            <input class="loan-inp" type="number" wire:model.live="interestRate" value="1.99" min="0" step="0.01">
        </div>

        <div class="loan-result">
            <div class="loan-monthly">${{ number_format($this->monthlyPayment, 2) }}</div>
            <div class="loan-monthly-lbl" data-en="per month" data-km="ក្នុងមួយខែ">per month</div>
            <hr class="loan-divider">
            <div class="loan-row">
                <span class="loan-lbl" data-en="Loan Amount" data-km="ចំនួនប្រាក់កម្ចី">Loan Amount</span>
                <span class="loan-val">${{ number_format(max(0, $productPrice - $downPayment), 2) }}</span>
            </div>
            <div class="loan-row">
                <span class="loan-lbl" data-en="Total Interest" data-km="ការប្រាក់សរុប">Total Interest</span>
                <span class="loan-val" style="color:var(--orange)">${{ number_format($this->totalInterest, 2) }}</span>
            </div>
            <div class="loan-row" style="border-top:1px solid var(--border2);padding-top:8px;margin-top:4px">
                <span style="font-weight:700" data-en="Total Payment" data-km="ការទូទាត់សរុប">Total Payment</span>
                <span class="loan-val" style="color:var(--blue);font-size:15px">${{ number_format($this->totalPayment, 2) }}</span>
            </div>
        </div>
    </div>
</div>
