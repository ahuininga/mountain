<?php

namespace App\Http\Middleware;

use App\Models\App;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class DetermineApp
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
        $app = Cache::remember(request()->getHost(), Config::get('cache.time', 0), function () {
            return App::select([
                'id',
                'name'
            ])->whereHas('urls', function ($query) {
                return $query->where('url', request()->getHost());
            })->firstOrFail();
        });

        $request->attributes->set('app', $app);

        return $next($request);
    }
}
