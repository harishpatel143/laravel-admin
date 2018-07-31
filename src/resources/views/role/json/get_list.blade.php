<?php

if ($roles->count() > 0) {
    $incNumber = (($page - 1)) * $limit;
    foreach ($roles as $role) {
        $incNumber++;
        $records[] = [
            $incNumber,
            $role->name,
            ($role->status) ? 'Active' : 'Inactive',
            ($role->id != config('admin.ADMIN_CONST.SUPER_ADMIN')) ? '<a href="' . route('manage-role-permission', [$role->id]) . '" class="btn btn-xs" title="Manage permissions"><button type="button" class="btn btn-navy"><i class="fa fa-cogs"></i></button></a>' .
            ((Multidots\Admin\Traits\CheckRolePermission::hasAccess('edit-role')) ? '<a href="' . route('roles-edit', [ $role->id]) . '" data-toggle="modal" data-target="#modal-default" class="btn btn-xs" title="Edit role"><button type="button" class="btn btn-success"><i class="fa fa-edit"></i></button></a>' : '') .
            ((Multidots\Admin\Traits\CheckRolePermission::hasAccess('delete-role')) ? '<a href="' . route('roles-delete', [ $role->id]) . '" onclick="return confirm(`Are you sure you want to delete ' . $role->name . '?`)" class="btn btn-xs" title="Delete role"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>' : '') : ''
        ];
    }
} else {
    $records = [];
}
$response = [
    'data' => $records,
    'recordsTotal' => $paginationCount,
    'recordsFiltered' => $paginationCount,
];
echo json_encode($response);
?>


