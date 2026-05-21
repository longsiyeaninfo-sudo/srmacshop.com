<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function show(Order $order): View
    {
        $order->load('items');
        return view('checkout.invoice', compact('order'));
    }
}
