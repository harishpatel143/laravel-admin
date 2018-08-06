<?php

namespace Multidots\Admin;

use Illuminate\Support\ServiceProvider;
use Multidots\Admin\Console\Admin;

class AdminServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $commands = [
        'Multidots\Admin\Console\AdminInstall',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth' => \Multidots\Admin\Middleware\AuthenticateAdmin::class,
        'permission' => \Multidots\Admin\Middleware\Permission::class,
//        'admin.redirect-authenticate' => \Multidots\Admin\Middleware\RedirectIfAuthenticated::class,
        'admin.not-authenticate' => \Multidots\Admin\Middleware\RedirectIfNotAdmin::class,
        \Multidots\Admin\Middleware\RolePermission::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.auth',
//            'admin.redirect-authenticate',
            'admin.not-authenticate',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'admin');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if ($this->app->runningInConsole()) {

            //CONTROLLERS
            $this->publishes(
                    [
                $this->replaceNamespace('Controller.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controller.php'),
                $this->replaceNamespace('AccountController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'AccountController.php'),
                $this->replaceNamespace('AdministratorController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'AdministratorController.php'),
                $this->replaceNamespace('ForgotPasswordController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'ForgotPasswordController.php'),
                $this->replaceNamespace('HomeController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'HomeController.php'),
                $this->replaceNamespace('LoginController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'LoginController.php'),
                $this->replaceNamespace('ResetPasswordController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'ResetPasswordController.php'),
                $this->replaceNamespace('RoleController.php', __DIR__ . '/Http/Controllers/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'RoleController.php')
                    ], 'admin-controllers');
            //MODELS
            $this->publishes([
                $this->replaceNamespace('Administrator.php', __DIR__ . '/Models/') => app_path('Models' . DIRECTORY_SEPARATOR . 'Administrator.php'),
                $this->replaceNamespace('Role.php', __DIR__ . '/Models/') => app_path('Models' . DIRECTORY_SEPARATOR . 'Role.php'),
                $this->replaceNamespace('Permission.php', __DIR__ . '/Models/') => app_path('Models' . DIRECTORY_SEPARATOR . 'Permission.php'),
                    ], 'admin-models');
            //MODELS
            $this->publishes([
                $this->replaceNamespace('AdministratorRequest.php', __DIR__ . '/Http/Requests/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . 'AdministratorRequest.php'),
                $this->replaceNamespace('RoleRequest.php', __DIR__ . '/Http/Requests/') => app_path('Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . 'RoleRequest.php')
                    ], 'admin-request');
            //Traits
            $this->publishes([
                $this->replaceNamespace('CheckRolePermission.php', __DIR__ . '/Traits/') => app_path('Traits' . DIRECTORY_SEPARATOR . 'CheckRolePermission.php'),
                $this->replaceNamespace('Permissions.php', __DIR__ . '/Traits/') => app_path('Traits' . DIRECTORY_SEPARATOR . 'Permissions.php'),
                    ], 'admin-traits');
            //Traits
            $this->publishes([
                $this->replaceNamespace('MDImageHelper.php', __DIR__ . '/Helpers/') => app_path('Helpers' . DIRECTORY_SEPARATOR . 'MDImageHelper.php'),
                $this->replaceNamespace('CommonHelper.php', __DIR__ . '/Helpers/') => app_path('Helpers' . DIRECTORY_SEPARATOR . 'CommonHelper.php'),
                    ], 'admin-md-helper');
            //Traits
            $this->publishes([
                $this->replaceNamespace('AdminResetPasswordNotification.php', __DIR__ . '/Notifications/') => app_path('Notifications' . DIRECTORY_SEPARATOR . 'AdminResetPasswordNotification.php'),
                    ], 'admin-notifications');
            //VIEWS
            $this->publishes([__DIR__ . '/resources/views' => resource_path('views/admin')], 'admin-views');
            //MIGRATIONS
            $this->publishes([__DIR__ . '/database/migrations' => database_path('migrations')], 'admin-migrations');
            //SEEDS
            $this->publishes([__DIR__ . '/database/seeds' => database_path('seeds')], 'admin-seeds');
            //ASSETS
            $this->publishes([__DIR__ . '/public' => public_path('multidots/admin')], 'admin-assets');
            $this->publishes([__DIR__ . '/config' => config_path()], 'admin-config');
            $this->publishes([__DIR__ . '/helpers.php' => app_path('Http' . DIRECTORY_SEPARATOR . 'helpers.php')], 'admin-helper');

            // Register commands
            $this->app->bind('multidots-admin:install', function ($app) {
                return new Admin();
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // merge default config
        $this->mergeConfigFrom(__DIR__ . '/config/admin.php', 'admin');
        $this->app->make('Multidots\Admin\Http\Controllers\AccountController');
        $this->app->make('Multidots\Admin\Http\Controllers\AdministratorController');
        $this->app->make('Multidots\Admin\Http\Controllers\Controller');
        $this->app->make('Multidots\Admin\Http\Controllers\ForgotPasswordController');
        $this->app->make('Multidots\Admin\Http\Controllers\HomeController');
        $this->app->make('Multidots\Admin\Http\Controllers\LoginController');
        $this->app->make('Multidots\Admin\Http\Controllers\ResetPasswordController');
        $this->app->make('Multidots\Admin\Http\Controllers\RoleController');

        $this->loadAdminAuthConfig();
        $this->registerRouteMiddleware();
        $this->commands($this->commands);
    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('admin.auth', []), 'auth.'));
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
// register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

// register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }

    /**
     * 
     */
    public function replaceNamespace($file, $dir)
    {
        $tempFile = public_path() . '/Temp/' . $file;
        if (!is_dir(dirname($tempFile))) {
            mkdir(dirname($tempFile), 0777, true);
        }
        $string = str_replace("Multidots\Admin", "App", file_get_contents($dir . $file));
        file_put_contents($tempFile, $string);
        $string = str_replace("App\Http\Controllers", "App\Http\Controllers\Admin", file_get_contents($tempFile));
        file_put_contents($tempFile, $string);
        $string = str_replace("admin::", "admin.", file_get_contents($tempFile));
        file_put_contents($tempFile, $string);

        return $tempFile;
    }

}
