<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (settings('multi_language')) {
            $locale = Session::get('language');

            if ( ! $locale) {
                $defaultLanguage = Cache::rememberForever('default_language', function () {
                    return Language::where('is_default', true)->value('code');
                });

                $locale = $defaultLanguage ?? config('app.locale');
                Session::put('language', $locale);
            }

            app()->setLocale($locale);
        } else {
            // If multi_language is false, set the locale to the default language directly
            $defaultLanguage = Cache::rememberForever('default_language', function () {
                return Language::where('is_default', true)->value('code');
            });

            app()->setLocale($defaultLanguage ?? config('app.locale'));
        }

        return $next($request);
    }
}
