<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class DetermineLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // available language in template array
      $availableLocales = Config::get('app.available_locales');

      // Locale is enabled and allowed to be change
      if(session()->has('locale') && array_key_exists(session()->get('locale'),$availableLocales)){
        // Set the Laravel locale
        app()->setLocale(session()->get('locale'));
      }
      return $next($request);
    }
}
