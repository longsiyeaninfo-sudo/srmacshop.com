<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::where('is_active', true)->select('slug', 'updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $static = [
            ['url' => route('home'),    'priority' => '1.0', 'freq' => 'weekly'],
            ['url' => route('shop'),    'priority' => '0.9', 'freq' => 'daily'],
            ['url' => route('about'),   'priority' => '0.6', 'freq' => 'monthly'],
            ['url' => route('contact'), 'priority' => '0.6', 'freq' => 'monthly'],
        ];

        foreach ($static as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$page['url']}</loc>\n";
            $xml .= "    <changefreq>{$page['freq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($products as $product) {
            $url = route('product', $product->slug);
            $lastmod = $product->updated_at->toAtomString();
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
