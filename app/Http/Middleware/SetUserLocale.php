<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->user()?->language ?: session('locale', config('app.locale'));

        if (in_array($locale, ['id', 'en'], true)) {
            App::setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
