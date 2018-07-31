<?php

namespace Multidots\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        echo '<pre>'; print_r('RedirectIfAuthenticated'); die;
        if (Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        return $next($request);
    }

}
