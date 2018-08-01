<?php

namespace Multidots\Admin\Http\Controllers;

use Auth;
use Multidots\Admin\Http\Controllers\Controller;
use Multidots\Admin\Models\Administrator;
use Multidots\Admin\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Multidots\Admin\Http\Requests\AdministratorRequest;

class AdministratorController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Administrator';

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
    public $activeSidebarSubMenu = 'administrators';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusList = activeInactiveStatus();
        $roles = Role::notDeleted()->where('name', 'LIKE', '%admin%')->pluck('name', 'id')->toArray();
        config(['admin.name' => 'Administrator']);

        return view('admin::administrators.index', compact('statusList', 'roles'));
    }

    /**
     * Returns the administrators list
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
            1 => 'first_name',
            2 => 'username',
            3 => 'email',
            3 => 'role_id',
            5 => 'status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));
        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);

        $searchData = [];
        $searchData[] = ['id', '<>', Auth::guard('admin')->user()->id];

        $requestData = ['username', 'email'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (isset($request->status)) {
            $searchData[] = ['status', '=', $request->status];
        }

        if (!empty($request->role)) {
            $searchData[] = ['role_id', '=', $request->role];
        }
        $adminName = trim($request->first_name);
        $administratorsData = Administrator::active()
                ->with('role:id,name')
                ->where($searchData)
                ->where(function ($query) use ($adminName) {
                    $query->where('first_name', 'like', '%' . $adminName . '%')
                    ->orWhere('last_name', 'like', '%' . $adminName . '%')
                    ->orWhereRaw("concat(first_name, ' ', last_name) like '%$adminName%' ");
                })
                ->orderBy($columnName, $columnOrderBy);
        try {
            $administrators = $administratorsData->paginate($limit);
            $paginationCount = $administrators->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }

        return response()->view('admin::administrators.json.get_list', compact('administrators', 'paginationCount', 'limit', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::notDeleted()->pluck('name', 'id')->toArray();
        config(['admin.name' => 'Add | Admin']);

        return view('admin::administrators.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
    {
        try {
            $requestData = [
                'role_id' => $request->role_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
                'last_login' => date('Y-m-d H:i:s'),
            ];

            $administrator = Administrator::create($requestData);
            if ($administrator) {
                $request->session()->flash('success', 'Admin has been added successfully.');

                return redirect()->route('administrators');
            } else {
                $request->session()->flash('error', 'Admin could not be saved. Please, try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $administrator = Administrator::active()->with('role')->findOrFail($request->id);
            $statusList = activeInactiveStatus();
            config(['admin.name' => 'View | Admin']);

            return view('admin::administrators.view', compact('administrator', 'statusList'));
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AdministratorRequest $request)
    {
        try {
            $administrators = Administrator::active()->findOrFail($request->id);
            $roles = Role::notDeleted()->pluck('name', 'id')->toArray();
            config(['admin.name' => 'Edit | Admin']);

            return view('admin::administrators.edit', compact('administrators', 'roles'));
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministratorRequest $request)
    {
        $administrator = Administrator::active()->findOrFail($request->id);

        $updateData = $request->all();
        $updateData['status'] = empty($request->status) ? config('admin.ADMIN_CONST.STATUS_INACTIVE') : config('admin.ADMIN_CONST.STATUS_ACTIVE');

        if ($administrator) {
            if ($administrator->update($updateData)) {
                $request->session()->flash('success', 'Admin has been updated successfully.');

                return redirect()->route('administrators');
            } else {
                $request->session()->flash('error', 'Admin could not be updated. Please, try again.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $administrator = Administrator::active()->findOrFail($request->id);
            $administrator->status = config('admin.ADMIN_CONST.STATUS_DELETE');
            if ($administrator->save()) {
                $request->session()->flash('success', 'Admin has been deleted successfully.');

                return redirect()->route('administrators');
            } else {
                $request->session()->flash('error', 'Admin can not be deleted. Please try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

}
