<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for language parameter in URL
        $lang = $request->get('lang');

        if ($lang && in_array($lang, ['en', 'ar'])) {
            App::setLocale($lang);
            // Store in session for persistence
            session(['locale' => $lang]);
        } elseif (session('locale')) {
            // Use session locale if no URL parameter
            App::setLocale(session('locale'));
        } else {
            // Default to Arabic
            App::setLocale('ar');
        }

        return $next($request);
    }
}
