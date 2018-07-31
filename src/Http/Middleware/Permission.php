<?php

namespace Multidots\Admin\Middleware;

use Auth;
use Closure;
use Multidots\Admin\Traits\Permissions;

class Permission
{

    use Permissions;

    /**
     * Handle an incoming request.
     * check the specific permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param type $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = null)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->view('admin::errors.401');
        }
        if (!empty($permissions)) {
            $permissions = is_array($permissions) ? $permissions : explode('|', $permissions);
        }

        if (Permissions::checkPermission($permissions)) {
            return $next($request);
        }

        return response()->view('admin::errors.401');
    }

}
