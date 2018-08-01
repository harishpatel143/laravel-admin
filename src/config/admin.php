<?php

return [
    /*
     * Laravel-admin name.
     */
    'name' => 'Laravel-admin',
    /*
     * Logo in admin panel header.
     */
    'logo' => '<b>Laravel</b> admin',
    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>La</b>',
    /*
     * Route configuration.
     */
    'route' => [
        'prefix' => 'admin',
        'namespace' => 'App\\Admin\\Controllers',
        'middleware' => ['web', 'admin'],
    ],
    /*
     * Laravel-admin install directory.
     */
    'directory' => app_path('Admin'),
    /*
     * Laravel-admin html title.
     */
    'title' => 'Admin',
    /**
     * public all the css, js, plugin path
     */
    'public-js-css' => 'multidots/admin/',
    /*
     * Use https.
     */
    'secure' => false,
    /*
     * Laravel-admin authentication.
     */
    'auth' => [
        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admin',
            ],
        ],
        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model' => Multidots\Admin\Models\Administrator::class,
            ],
        ],
        'passwords' => [
            'admin' => [
                'provider' => 'admin',
                'table' => 'admin_password_resets',
                'expire' => 60,
            ],
        ],
    ],
    /*
     * Laravel-admin database setting.
     */
    'database' => [
        // Database connection for following tables.
        'connection' => '',
        // Administrators tables and model.
        'administrators_table' => 'administrators',
        'administrators_model' => Multidots\Admin\Models\Administrator::class,
        // Administrator reset password tables and model.
        'administrator_password_resets_table' => 'administrator_password_resets',
        // Role table and model.
        'roles_table' => 'roles',
        'roles_model' => Multidots\Admin\Models\Role::class,
        // Permission table and model.
        'permissions_table' => 'permissions',
        'permissions_model' => Multidots\Admin\Models\Permission::class,
        // Pivot table for table above.
        'role_permission_table' => 'permission_role',
    ],
    'ADMIN_CONST' => [
        'ADMIN_IMAGE_PATH' => public_path('uploads' . DIRECTORY_SEPARATOR . 'admins' . DIRECTORY_SEPARATOR),
        'ADMIN_IMAGE_URL' => 'uploads/admins/',
        'DEFAULT_IMAGE_URL' => 'img/default-avatar.png',
        'STATUS_DELETE' => 2,
        'STATUS_ACTIVE' => 1,
        'STATUS_INACTIVE' => 0,
        'SUPER_ADMIN' => 1,
        'CACHE_EXPIRE_TIME' => 1440,
        'DOMAIN_NAME' => 'front',
        'ADMIN_PREFIX' => 'admin',
        'ADMIN_DOMAIN_NAME' => 'admin',
        'DATABASE_DEFAULT_STATUS' => 1
    ],
];
