<?php

namespace Multidots\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Multidots\Admin\Traits\CheckRolePermission;

class RolePermission
{

    use CheckRolePermission;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check() && CheckRolePermission::rolePermissions()) {
            if (CheckRolePermission::performAccessValidation($request)) {
                return $next($request);
            }
        }

        return $next($request);
    }

}
