<?php

if ($administrators->count() > 0) {
    $incNumber = (($page - 1)) * $limit;
    foreach ($administrators as $administrator) {
        $incNumber++;
        $name = !empty($administrator->full_name) ? '<a href="' . route('administrators-view', [$administrator->id]) . '">' . $administrator->full_name . '</a>' : '-';
        $records[] = [
            $incNumber,
            $name,
            $administrator->username,
            $administrator->email,
            $administrator->role->name,
            ($administrator->status) ? 'Active' : 'Inactive',
            ((Multidots\Admin\Traits\CheckRolePermission::hasAccess('edit-administrator')) ? '<a href="' . route('administrators-edit', [ $administrator->id]) . '" class="btn btn-xs" title="Edit admin"><button type="button" class="btn btn-success"><i class="fa fa-edit"></i></button></a>' : '') .
            ((Multidots\Admin\Traits\CheckRolePermission::hasAccess('delete-administrator')) ? '<a href="' . route('administrators-delete', [ $administrator->id]) . '" onclick="return confirm(`Are you sure you want to delete ' . $administrator->full_name . '?`)" class="btn btn-xs" title="Delete admin"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>' : '')
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


