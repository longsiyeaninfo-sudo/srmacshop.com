<?php

namespace App\Livewire;

use Livewire\Component;

class LoanCalculator extends Component
{
    public float $productPrice = 0;
    public float $downPayment = 0;
    public int $termMonths = 12;
    public float $interestRate = 1.99;

    public function mount(float $productPrice = 0): void
    {
        $this->productPrice = max(0, $productPrice);
    }

    public function getMonthlyPaymentProperty(): float
    {
        $principal = max(0, $this->productPrice - $this->downPayment);
        if ($principal === 0.0) {
            return 0.0;
        }

        $r = $this->interestRate / 100; // rate is already per-month (%/month)
        $n = max(1, $this->termMonths);

        if ($r == 0.0) {
            return round($principal / $n, 2);
        }

        return round($principal * $r * pow(1 + $r, $n) / (pow(1 + $r, $n) - 1), 2);
    }

    public function getTotalPaymentProperty(): float
    {
        return round($this->monthlyPayment * $this->termMonths, 2);
    }

    public function getTotalInterestProperty(): float
    {
        return round($this->totalPayment - max(0, $this->productPrice - $this->downPayment), 2);
    }

    public function render()
    {
        return view('livewire.loan-calculator');
    }
}
