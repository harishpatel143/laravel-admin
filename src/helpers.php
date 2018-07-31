<?php

if (!function_exists('admin_path')) {

    /**
     * Get admin path.
     * 
     * @param string $path
     * @return string
     */
    function admin_path($path = '')
    {
        return ucfirst(config('admin.directory')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

}

if (!function_exists('activeInactiveStatus')) {

    /**
     * This function display the status to be set.
     *
     * @param $request
     * @return void
     */
    function activeInactiveStatus()
    {
        return $activeInactive = collect([
            '' => 'Select Status',
            config('admin.ADMIN_CONST.STATUS_ACTIVE') => 'Active',
            config('admin.ADMIN_CONST.STATUS_INACTIVE') => 'Inactive'
        ]);
    }

}

