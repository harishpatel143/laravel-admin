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
        'Multidots\Admin\Console\Admin',
    ];

    /**
     * Controller Names
     */
    protected $controllerNames = [];

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

//        if (file_exists($routes = admin_path('routes.php'))) {
//            $this->loadRoutesFrom($routes);
//        }

        if ($this->app->runningInConsole()) {

            //CONTROLLERS
            $this->publishes(
                    [
                $this->changeControllerNamespace('Controller.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controller.php'),
                $this->changeControllerNamespace('AccountController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'AccountController.php'),
                $this->changeControllerNamespace('AdministratorController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'AccountController.php'),
                $this->changeControllerNamespace('ForgotPasswordController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'ForgotPasswordController.php'),
                $this->changeControllerNamespace('HomeController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'HomeController.php'),
                $this->changeControllerNamespace('LoginController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'LoginController.php'),
                $this->changeControllerNamespace('ResetPasswordController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'ResetPasswordController.php'),
                $this->changeControllerNamespace('RoleController.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'RoleController.php')
                    ], 'admin-controllers');
            //MODELS
            $this->publishes([
                $this->changeModelNamespace('Administrator.php') => app_path('Models' . DIRECTORY_SEPARATOR . 'Administrator.php'),
                $this->changeModelNamespace('Role.php') => app_path('Models' . DIRECTORY_SEPARATOR . 'Role.php'),
                $this->changeModelNamespace('Permission.php') => app_path('Models' . DIRECTORY_SEPARATOR . 'Permission.php'),
                    ], 'admin-models');
            //MODELS
            $this->publishes([
                $this->changeRequestNamespace('AdministratorRequest.php') => app_path('Http' . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'AdministratorRequest.php')
                    ], 'admin-request');
            //VIEWS
            $this->publishes([__DIR__ . '/resources/views' => resource_path('views/admin')], 'admin-views');
            //MIGRATIONS
            $this->publishes([__DIR__ . '/database/migrations' => database_path('migrations')], 'admin-migrations');
            //SEEDS
            $this->publishes([__DIR__ . '/database/seeds' => database_path('seeds')], 'admin-seeds');
            //ASSETS
            $this->publishes([__DIR__ . '/public' => public_path('admin')], 'admin-assets');

            // Register commands
            $this->app->bind('admin:make', function ($app) {
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
        $this->mergeConfigFrom(
                __DIR__ . '/config/admin.php', 'admin'
        );

        include __DIR__ . '/routes/web.php';
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
     * @param type $file
     * @return type
     */
    public function changeControllerNamespace($file)
    {
        $filename = public_path() . '/Temp/' . $file;
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
        $writing = fopen($filename, 'w');
        $contentData = array_map(array($this, 'replaceControllerNameSpace'), file(__DIR__ . '/Http/Controllers/' . $file));
        fclose($writing);
        file_put_contents($filename, implode('', $contentData));

        return $filename;
    }

    /**
     * 
     * @param type $data
     * @return string
     */
    public function replaceControllerNameSpace($data)
    {
        if (stristr($data, 'namespace')) {
            return "namespace App\Http\Admin\Controllers;\n";
        }
        return $data;
    }

    /**
     * 
     * @param type $file
     * @return type
     */
    public function changeModelNamespace($file)
    {
        $filename = public_path() . '/Temp/' . $file;
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
        $writing = fopen($filename, 'w');
        $contentData = array_map(array($this, 'replaceModelNameSpace'), file(__DIR__ . '/Models/' . $file));
        fclose($writing);
        file_put_contents($filename, implode('', $contentData));

        return $filename;
    }

    /**
     * 
     * @param type $data
     * @return string
     */
    public function replaceModelNameSpace($data)
    {
        if (stristr($data, 'namespace')) {
            return "namespace App\Models;\n";
        }
        return $data;
    }

    /**
     * 
     * @param type $file
     * @return type
     */
    public function changeRequestNamespace($file)
    {
        $filename = public_path() . '/Temp/' . $file;
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
        $writing = fopen($filename, 'w');
        $contentData = array_map(array($this, 'replaceRequestNameSpace'), file(__DIR__ . '/Http/Requests/' . $file));
        fclose($writing);
        file_put_contents($filename, implode('', $contentData));

        return $filename;
    }

    /**
     * 
     * @param type $data
     * @return string
     */
    public function replaceRequestNameSpace($data)
    {
        if (stristr($data, 'namespace')) {
            return "namespace App\Http\Requests;\n";
        }
        return $data;
    }

    /**
     * 
     * @param type $names
     */
    public function removeTempFile()
    {
        $publicPath = public_path() . '/Temp/';
        foreach ($this->controllerNames as $name) {
            unlink($publicPath . $name);
        }
    }

}
