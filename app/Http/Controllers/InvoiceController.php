<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function show(Order $order): Response
    {
        $order->load('items');
        $pdf = Pdf::loadView('checkout.invoice', compact('order'));
      return $pdf->stream("invoice-{$order->order_number}.pdf");
    }
}
