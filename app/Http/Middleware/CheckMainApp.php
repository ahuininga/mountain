<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Url;
use Closure;
use Illuminate\Http\Request;

class CheckMainApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $domain = request()->host();
        $mainDomain = (new Url())->getMainUrl($domain);

        if ($mainDomain !== $domain) {
            redirect()->away('https://'.$mainDomain)->send();
        }

        return $next($request);
    }
}
