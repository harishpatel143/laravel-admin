<?php

namespace Multidots\Admin\Middleware;

use Closure;
use Auth;

class AuthenticateAdmin
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
//        echo '<pre>'; print_r('AuthenticateAdmin'); die;
        // If request does not comes from logged in administratore
        // then he shall be redirected to Login page
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin-login');
        }

        return $next($request);
    }

}
