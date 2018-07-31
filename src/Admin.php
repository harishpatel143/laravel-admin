<?php

namespace Multidots\Admin;

use Closure;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;

/**
 * Class Admin.
 */
class Admin
{

    public static $extensions = [];

    public static function demo()
    {
        echo '<pre>';
        print_r('called');
        die;
    }

    /**
     * Get admin title.
     *
     * @return Config
     */
    public function title()
    {
        return config('admin.title');
    }

    /**
     * Get current login user.
     *
     * @return mixed
     */
    public function user()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Register the auth routes.
     *
     * @return void
     */
    public function registerAuthRoutes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'namespace' => 'Multidots\Admin\Controllers',
//            'middleware' => config('admin.route.middleware'),
        ];

        Route::group($attributes, function ($router) {

            /* @var \Illuminate\Routing\Router $router */
            $router->group([], function ($router) {

                /* @var \Illuminate\Routing\Router $router */
//                $router->get('/account/dashboard', 'HomeController@index')->name('home');
            });
//            
//            $router->get('auth/login', 'AuthController@getLogin');
//            $router->get('/', 'LoginController@showLoginForm');
//            $router->get('/account/login', 'LoginController@showLoginForm')->name('admin-login');
//            $router->post('/account/login', 'LoginController@login')->name('admin-login');
//            $router->get('pack-test', 'TestController@index');
//
//            $router->get('/account/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin-password-reset');
//            $router->post('/account/forgot-password/check_email', 'ForgotPasswordController@checkAdminEmail');
//            $router->post('/account/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin-password-email');
//
//            $router->get('/account/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin-reset-form');
//            $router->post('/account/password/reset', 'ResetPasswordController@reset')->name('password.reset');
//            $router->post('/account/reset-password/check_email', 'ResetPasswordController@checkAdminEmail');
            
//            $router->get('login', function() {
//                return view('admin::home');
//            });
        });
    }

    /**
     * Extend a extension.
     *
     * @param string $name
     * @param string $class
     *
     * @return void
     */
    public static function extend($name, $class)
    {
        static::$extensions[$name] = $class;
    }
}
