<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if lang parameter is in the request
        if ($request->has('lang')) {
      $locale = $request->get('lang');
            if (in_array($locale, ['en', 'km'])) {
                session(['locale' => $locale]);
                app()->setLocale($locale);
            }
        } elseif (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
