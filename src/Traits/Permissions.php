<?php

namespace Multidots\Admin\Traits;

use Auth;
use Cache;
use Multidots\Admin\Models\Permission;
use Multidots\Admin\Models\Role;

trait Permissions
{

    /**
     * Permission data for current administrator's role
     *
     * @var array
     */
    public static $userPermissionData = [];

    /**
     * Fetch data to its assign permission.
     *
     * @param type $permissions
     */
    public static function addPermissionKeys($permissions)
    {
        foreach ($permissions as $permission) {
            if (strpos($permission, 'manage') !== false || strpos($permission, 'listing') !== false) {
                $permissionTitle = explode('-', $permission);
                $permissionTitle = $permissionTitle[1];
            } else {
                $permissionTitle = $permissions[1];
            }
            $permissionData[] = [
                'permission_key' => $permission,
                'title' => ucwords(str_replace('-', ' ', $permissionTitle)),
            ];
        }
        self::savePermissionKey($permissionData);
    }

    /**
     * Store a newly created resource in storage.
     * save the permission key.
     *
     * @param type $permissionData
     */
    public static function savePermissionKey($permissionData)
    {
        if (empty($permissionData)) {
            return;
        }

        $parentId = 0;
        $permissions = [];
        foreach ($permissionData as $key => $value) {
            if ($key != 0) {
                $permissions = self::getPermissionByKey($value['permission_key']);
            }
            if (!empty($permissions)) {
                $parentId = $permissions->id;
                $permissions = [];
                continue;
            }
            $Permission = Permission::firstOrCreate(['parent_id' => $parentId, 'permission_key' => $value['permission_key'], 'title' => $value['title']]);
            if ($key == 0) {
                $parentId = $Permission->id;
            }
        }

        /* Remove Old Cache */
        if (Cache::has('permissions_list')) {
            Cache::forget('permissions_list');
            Cache::flush();
        }
    }

    /**
     * Get permissions
     * 
     * @param string $permissionKey permission key
     * @return array
     */
    public static function getPermissionByKey($permissionKey)
    {
        $permissionData = Permission::notDeleted()->select('id')
                ->where('permission_key', '=', $permissionKey)
                ->first();

        return $permissionData;
    }

    /**
     * Get permission list
     * 
     * @return type
     */
    public static function getPermissionList()
    {
        if (Cache::has("permissions_list")) {
            $permissionList = Cache::get("permissions_list");
        } else {
            $permissionList = Permission::notDeleted()->pluck('permission_key', 'id')->toArray();
            Cache::put("permissions_list", $permissionList, config('admin.ADMIN_CONST.CACHE_EXPIRE_TIME'));
        }

        return $permissionList;
    }

    /**
     * Sets current administrator's permission based on assigned role
     *
     * @return void
     */
    public static function rolePermissions()
    {
        $userPermissionData = self::getList(Auth::guard('admin')->user()->role_id);

        return $userPermissionData;
    }

    /**
     * Returns role and it's permissions
     *
     * @param int $roleId Role ID
     * @return array
     */
    public static function getList($roleId)
    {
        if (empty($roleId)) {
            return [];
        }

        if (Cache::has("role_permission_" . $roleId)) {
            $permissionData = Cache::get("role_permission_" . $roleId);
        } else {
            $permissionData = self::getPermissionData($roleId);
        }

        return $permissionData;
    }

    /**
     * Finds role and it's permissions
     *
     * @param int $roleId Role Id
     * @return array
     */
    protected static function getPermissionData($roleId)
    {
        $rolePermissions = Role::notDeleted()->select(['id', 'name'])->with('permission')->where('id', '=', $roleId)->first();

        if (!empty($rolePermissions)) {
            $permissionData['Role'] = [
                'id' => $rolePermissions->id,
                'name' => $rolePermissions->name
            ];

            $systemPermissions = Permission::getPermissionList();

            if (!empty($rolePermissions->permission)) {
                foreach ($rolePermissions->permission as $permission) {
                    if (array_key_exists($permission->id, $systemPermissions)) {
                        $permissionData['Permissions'][$permission->id] = $systemPermissions[$permission->id];
                    }
                }
            }
            Cache::put("role_permission_" . $roleId, $permissionData, config('admin.ADMIN_CONST.CACHE_EXPIRE_TIME'));

            return $permissionData;
        }
    }

    /**
     * Get list of all permission available in table
     * 
     * @return array
     */
    public static function getPermission()
    {
        return Cache::remember('threaded_permissions_data', config('admin.ADMIN_CONST.CACHE_EXPIRE_TIME'), function () {
                    return Permission::with('childrens')->whereHas('childrens')
                                    ->where('status', '<>', config('admin.ADMIN_CONST.STATUS_DELETE'))
                                    ->orderBy('title', 'ASC')
                                    ->get()->toArray();
                });
    }

    /**
     * Check for the permission keys.
     *
     * @param type $permissions
     * @return boolean
     */
    public static function checkPermission($permissions)
    {
        if (empty($permissions)) {
            return;
        }

        $permissionKey = !is_array($permissions) ? [$permissions] : $permissions;
        $permissionList = Permission::getPermissionList();

        if (array_diff($permissionKey, $permissionList)) {
            Permission::addPermissionKeys($permissions);
        }
        self::$userPermissionData = Permission::rolePermissions();
        if (self::$userPermissionData['Role']['id'] === config('admin.ADMIN_CONST.SUPER_ADMIN')) {
            return TRUE;
        }
        if (!empty(self::$userPermissionData['Permissions'])) {
            $result = array_intersect(self::$userPermissionData['Permissions'], $permissions);
            if (!empty($result)) {
                return TRUE;
            }
        }

        return FALSE;
    }
}
