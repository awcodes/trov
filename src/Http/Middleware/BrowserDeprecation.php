<?php

namespace Trov\Http\Middleware;

use Closure;
use Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BrowserDeprecation
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
        if (Browser::isIE() || Browser::isEdge() && Browser::browserVersion() < 79) {
            if (Route::currentRouteName() !== 'outdated-browser') {
                return redirect()->route('outdated-browser');
            }
        }

        return $next($request);
    }
}
