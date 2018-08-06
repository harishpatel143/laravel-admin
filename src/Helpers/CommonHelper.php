<?php

namespace Multidots\Admin\Helpers;

class CommonHelper
{

    /**
     * Status array 
     * 
     * @return type
     */
    public static function activeInactiveStatus()
    {
        return collect([
            config('admin.ADMIN_CONST.STATUS_ACTIVE') => 'Active',
            config('admin.ADMIN_CONST.STATUS_INACTIVE') => 'Inactive'
        ]);
    }

}
