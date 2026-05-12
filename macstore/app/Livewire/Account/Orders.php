<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Orders extends Component
{
    public function render()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('livewire.account.orders', [
    'orders' => $orders,
        ]);
    }
}
