<?php

namespace Multidots\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Admin extends Facade
{

    /**
     * Return the admin facade
     * 
     * @return type
     */
    protected static function getFacadeAccessor()
    {
        return \Multidots\Admin\Admin::class;
    }
}
