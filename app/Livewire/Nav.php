<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        $branding = Setting::get('site.branding', []) ?: [];

        $logoPath   = $branding['logo_path'] ?? null;
        $logoUrl    = $logoPath
            ? Storage::disk('public')->url($logoPath)
            : asset('img/srmac-logo.svg');

        return view('livewire.nav', [
            'cartCount'     => app(CartService::class)->itemCount(),
            'navCategories' => Category::ordered()
                ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
                ->take(8)
                ->get(),
            'logoUrl'    => $logoUrl,
            'logoPrefix' => $branding['logo_prefix'] ?? 'SR',
            'logoText'   => $branding['logo_text']   ?? 'MAC SHOP',
            'showLogoText' => (bool) ($branding['show_text'] ?? true),
        ]);
    }

    #[On('cart.updated')]
    public function refreshCount(): void
    {
        // re-render via event from CartDrawer
    }
}
