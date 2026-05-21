<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $promo = Setting::get('home_promo', []);

        // Best Sellers: 8 active products, badged first
        $featured = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('media', 'category')
            ->orderByRaw("CASE WHEN badge IN ('new','hot','sale') THEN 0 ELSE 1 END")
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        // Headline deal — explicit pick OR fallback to highest-discount product
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

        // Flash Deals reel — products flagged is_flash_deal=true, fallback to badge='sale'
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

        // Hero slides: headline first, then up to 2 flash deals (excluding headline)
        $heroSlides = collect($headline ? [$headline] : [])
            ->concat($flashDeals->where('id', '!=', $headline?->id)->take(2))
            ->values();

        return view('home', compact('featured', 'headline', 'flashDeals', 'promo', 'heroSlides'));
    }
}
