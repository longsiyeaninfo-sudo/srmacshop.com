<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $recentOrders = $user->orders()->latest()->limit(5)->get();
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->where('payment_status', 'paid')->sum('grand_total');

      return view('livewire.account.dashboard', [
            'user' => $user,
          'recentOrders' => $recentOrders,
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
        ]);
    }
}
