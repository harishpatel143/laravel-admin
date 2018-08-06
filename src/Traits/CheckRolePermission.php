<?php

namespace Multidots\Admin\Traits;

use Auth;
use Multidots\Admin\Traits\Permissions;

trait CheckRolePermission
{

    /**
     * Permission data for current administrator's role
     *
     * @var array
     */
    public static $userPermissionData = [];

    /**
     * Check for the permission keys.
     *
     * @param type $permissions
     * @return boolean
     */
    public static function rolePermissions()
    {
        self::$userPermissionData = Permissions::rolePermissions();
        return self::$userPermissionData;
    }

    /**
     * Checks whether current administrator has access to particular thing
     *
     * @param mixed $permissionKey Permission key or array of keys
     * @return bool
     */
    public static function hasAccess($permissionKey = "")
    {
        self::rolePermissions();

        if (config('admin.ADMIN_CONST.SUPER_ADMIN') === Auth::guard('admin')->user()->role_id) {
            return true;
        }

        if (empty($permissionKey) || empty(self::$userPermissionData['Permissions'])) {
            return false;
        }

        if (is_array($permissionKey) && count(array_intersect($permissionKey, self::$userPermissionData['Permissions'])) !== 0) {
            return true;
        }

        if (in_array($permissionKey, self::$userPermissionData['Permissions'])) {
            return true;
        }

        return false;
    }

    /**
     * Performs permission validation     
     * Checks current action against the assigned permission.
     *
     * @param $request.
     * @return bool
     * @throws PermissionDeniedException If user has not a permission
     */
    public static function performAccessValidation($request)
    {
        if (config('admin.ADMIN_CONST.SUPER_ADMIN') === Auth::guard('admin')->user()->role_id) {
            return true;
        }

        $middlwareName = $request->route()->computedMiddleware;

        if (!empty($middlwareName[2])) {
            $middlwareName = str_replace(":", "|", $middlwareName[2]);
            $permissionKey = explode('|', $middlwareName);
            array_shift($permissionKey);

            if (!empty(self::$userPermissionData['Permissions']) && !empty(array_intersect($permissionKey, self::$userPermissionData['Permissions']))) {
                return true;
            } else {
                return response()->view('admin.errors.403');
            }
        }
    }
}
