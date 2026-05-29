<?php

namespace App\Http\Controllers;

use App\Models\TradeIn;
use App\Services\TelegramService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TradeInController extends Controller
{
    public function index(): View
    {
        return view('sell.index');
    }

    public function submit(Request $request, TelegramService $telegram): RedirectResponse
    {
        $data = $request->validate([
            'device_type'     => ['required', 'string', 'in:iPhone,iPad,MacBook,Apple Watch,Other'],
            'model'           => ['required', 'string', 'max:120'],
            'storage'         => ['nullable', 'string', 'max:16'],
            'condition_grade' => ['nullable', 'string', 'in:A+,A,B,C'],
            'battery_health'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'asking_price'    => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'customer_name'   => ['required', 'string', 'max:255'],
            'customer_phone'  => ['required', 'string', 'max:50'],
            'contact_method'  => ['nullable', 'string', 'in:whatsapp,telegram,phone'],
            'photos'          => ['nullable', 'array', 'max:4'],
            'photos.*'        => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $tradeIn = TradeIn::create([
            'device_type'     => $data['device_type'],
            'model'           => $data['model'],
            'storage'         => $data['storage'] ?? null,
            'condition_grade' => $data['condition_grade'] ?? null,
            'battery_health'  => $data['battery_health'] ?? null,
            'asking_price'    => isset($data['asking_price']) ? (int) round(((float) $data['asking_price']) * 100) : null,
            'description'     => $data['description'] ?? null,
            'customer_name'   => $data['customer_name'],
            'customer_phone'  => $data['customer_phone'],
            'contact_method'  => $data['contact_method'] ?? null,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $tradeIn->addMedia($photo)->toMediaCollection('photos');
            }
        }

        $telegram->notifyNewTradeIn($tradeIn);

        return redirect()
            ->route('sell')
            ->with('success', __('Thanks! We received your device details (ref :ticket). We\'ll contact you shortly with a quote.', ['ticket' => $tradeIn->ticket_number]));
    }
}
