<?php

namespace Multidots\Admin\Http\Controllers;

use Multidots\Admin\Http\Controllers\Controller;
use Multidots\Admin\Http\Requests\RoleRequest;
use Multidots\Admin\Models\Role;
use Multidots\Admin\Helpers\CommonHelper;
use Multidots\Admin\Models\Permission;
use Cache;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Role';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'settings';

    /**
     * Active sidebar sub-menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'roles';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusList = CommonHelper::activeInactiveStatus();
        config(['app.name' => 'Roles']);

        return view('admin::role.index', compact('statusList'));
    }

    /**
     * Returns the roles list
     *
     * @throws NotFoundException When invalid request
     */
    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }

        $columnArr = [
            0 => null,
            1 => 'name',
            2 => 'status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));
        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);

        $searchData = [];

        if (!empty($request->name)) {
            $searchData[] = ['name', 'LIKE', '%' . trim($request->name) . '%'];
        }
        if (isset($request->status)) {
            $searchData[] = ['status', '=', $request->status];
        }

        $rolesData = Role::notDeleted()->select('id', 'name', 'status')
                ->where($searchData)
                ->orderBy($columnName, $columnOrderBy);
        try {
            $roles = $rolesData->paginate($limit);
            $paginationCount = $roles->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }

        return response()->view('admin::role.json.get_list', compact('roles', 'paginationCount', 'limit', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        config(['app.name' => 'Add | Roles']);

        return view('admin::role.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $requestData = [
                'name' => $request->input('role_name'),
                'description' => $request->input('description')
            ];
            $role = Role::create($requestData);
            if ($role) {
                $request->session()->flash('success', 'Role has been added successfully.');

                return redirect()->route('roles');
            } else {
                $request->session()->flash('error', 'Role could not be saved. Please, try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin::errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $roles = Role::notDeleted()->findOrFail($id);
            config(['app.name' => 'Edit | Roles']);

            return view('admin::role.edit', compact('roles'));
        } catch (Exception $ex) {
            return response()->view('admin::errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request)
    {
        try {
            $role = Role::notDeleted()->findOrFail($request->id);

            $updateData = [
                'name' => $request->input('role_name'),
                'description' => $request->input('description'),
                'status' => empty($request->status) ? config('admin.ADMIN_CONST.STATUS_INACTIVE') : config('admin.ADMIN_CONST.STATUS_ACTIVE')
            ];

            if ($role->update($updateData)) {
                $request->session()->flash('success', 'Role has been updated successfully.');

                return redirect()->route('roles');
            } else {
                $request->session()->flash('error', 'Role could not be updated. Please, try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin::errors.404');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $role = Role::notDeleted()->findOrFail($request->id);
            $role->status = config('admin.ADMIN_CONST.STATUS_DELETE');
            if ($role->save()) {
                $role->permission()->detach();
                $request->session()->flash('success', 'Role has been deleted successfully.');

                return redirect()->route('roles');
            } else {
                $request->session()->flash('error', 'Role can not be deleted. Please try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin::errors.404');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageRolePermissions($id)
    {
        $permissionList = Permission::getPermission();
        $assignedRolePermissions = Permission::getList($id);

        config(['app.name' => 'Manage Permissions | Roles']);

        return view('admin::role.manage_role_permission', compact('permissionList', 'assignedRolePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRolePermissions(Request $request, $id)
    {
        try {
            $requestData = $request->all();
            $role = Role::notDeleted()->findorFail($id);
            $rolePermission = $role->permission()->sync($requestData['permissions']);
            if ($rolePermission) {
                if (Cache::has("role_permission_" . $id)) {
                    Cache::forget('role_permission_' . $id);
                    Cache::flush();

                    Permission::getPermissionData($id);
                }
                $request->session()->flash('success', 'Permission has been added successfully.');

                return redirect()->route('roles');
            } else {
                $request->session()->flash('error', 'Permission could not be saved. Please, try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin::errors.404');
        }
    }

    /**
     * Check email for user
     * 
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkName(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }

        $checkName = Role::notDeleted()->where('name', $request['name']);

        if (!empty($request['id'])) {
            $checkName->where('id', '<>', $request['id']);
        }
        $flag = $checkName->count() > 0 ? 'false' : 'true';

        return $flag;
    }

}
