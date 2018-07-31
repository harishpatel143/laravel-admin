<?php

namespace Multidots\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
//        echo '<pre>'; print_r('RedirectIfNotAdmin'); die;
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('admin-login');
        }

        return $next($request);
    }
}
