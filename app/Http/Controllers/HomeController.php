<?php

namespace App\Http\Controllers;

use App\Models\HomePromoCard;
use App\Models\HomeSlide;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        // Always default to empty array — defensive against Setting::get() returning null.
        $promo = Setting::get('home_promo', []) ?: [];

        // Best Sellers: 8 active products, badged first.
        $featured = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('media', 'category')
            ->orderByRaw("CASE WHEN badge IN ('new','hot','sale') THEN 0 ELSE 1 END")
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        // Headline deal — explicit pick OR fallback to highest-discount product.
        $headline = null;
        if (! empty($promo['headline_product_id'])) {
            $headline = Product::with('media', 'category')->find($promo['headline_product_id']);
        }
        if (! $headline) {
            $headline = Product::with('media', 'category')
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->whereNotNull('original_price')
                ->whereColumn('original_price', '>', 'price')
                ->orderByRaw('(original_price - price) DESC')
                ->first();
        }
        if (! $headline) {
            $headline = $featured->first();
        }

        // Flash Deals reel — products flagged is_flash_deal=true, fallback to badge='sale'.
        $flashDeals = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('media', 'category')
            ->where('is_flash_deal', true)
            ->take(8)
            ->get();
        if ($flashDeals->isEmpty()) {
            $flashDeals = Product::query()
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->where('badge', 'sale')
                ->with('media', 'category')
                ->take(8)
                ->get();
        }

        // Hero slides: headline first, then up to 2 flash deals (excluding headline).
        $heroSlides = collect($headline ? [$headline] : [])
            ->concat($flashDeals->where('id', '!=', $headline?->id)->take(2))
            ->values();

        // ── NEW: category-specific spotlights (smartphones, tablets, macbooks). ──
        $loadProducts = fn (string $slug, int $take = 4) => Product::query()
            ->where('is_active', true)
            ->whereHas('category', fn ($q) => $q->where('slug', $slug))
            ->with('media', 'category')
            ->orderByRaw("CASE WHEN badge IN ('new','hot','sale') THEN 0 ELSE 1 END")
            ->orderBy('sort_order')
            ->take($take)
            ->get();

        $smartphones = $loadProducts('smartphones');
        $tablets     = $loadProducts('tablets-ipad');
        $macbooks    = $loadProducts('macbook-air', 2)
            ->concat($loadProducts('macbook-pro', 2))
            ->values();

        // Slideshow display config (admin-controlled via Settings → Slideshow).
        $ssConfig = Setting::get('site.slideshow', []) ?: [];
        $ssMax    = max(1, min(24, (int) ($ssConfig['max_items'] ?? 8)));

        // Homepage slideshow — admin-curated slides first, fall back to product photos.
        $homeSlides = HomeSlide::active()
            ->with(['product' => fn ($q) => $q->with('media')])
            ->take($ssMax)
            ->get();

        $slideshowProducts = collect();
        if ($homeSlides->isEmpty()) {
            $slideshowQuery = fn ($categoryFilter = null) => Product::query()
                ->where('is_active', true)
                ->with('media', 'category')
                ->when($categoryFilter, fn ($q) => $q->whereHas('category', $categoryFilter))
                ->orderByRaw("CASE WHEN badge IN ('new','hot','sale') THEN 0 ELSE 1 END")
                ->orderBy('sort_order')
                ->take($ssMax)
                ->get()
                ->filter(fn ($p) => $p->getFirstMediaUrl('gallery') !== '')
                ->values();

            $slideshowProducts = $slideshowQuery(
                fn ($q) => $q->whereIn('slug', ['smartphones', 'tablets-ipad'])
            );
            if ($slideshowProducts->isEmpty()) {
                $slideshowProducts = $slideshowQuery();
            }
        }

        // Admin-curated FB / TikTok promo cards.
        $promoCards = HomePromoCard::active()->get();

        // Store info bag (Facebook / TikTok / Telegram URLs etc.).
        $storeInfo = Setting::get('store.info', []) ?: [];

        // Explicit array — safer than compact() on PHP 8.4 (which throws on undefined vars).
        return view('home', [
            'featured'    => $featured    ?? collect(),
            'headline'    => $headline    ?? null,
            'flashDeals'  => $flashDeals  ?? collect(),
            'promo'       => $promo       ?? [],
            'heroSlides'  => $heroSlides  ?? collect(),
            'smartphones' => $smartphones ?? collect(),
            'tablets'     => $tablets     ?? collect(),
            'macbooks'    => $macbooks    ?? collect(),
            'slideshowProducts' => $slideshowProducts ?? collect(),
            'homeSlides'        => $homeSlides        ?? collect(),
            'slideshowConfig'   => $ssConfig          ?? [],
            'promoCards'  => $promoCards  ?? collect(),
            'storeInfo'   => $storeInfo   ?? [],
        ]);
    }
}
