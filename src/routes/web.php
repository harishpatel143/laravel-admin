<?php

/**
 * All the administrator route files
 */
Route::group(['prefix' => config('admin.route.prefix'), 'namespace' => 'Multidots\Admin\Http\Controllers'], function () {

    Route::group(['middleware' => 'web'], function() {
        Route::get('/', 'LoginController@showLoginForm');
        Route::get('/account/login', 'LoginController@showLoginForm')->name('admin-login');
        Route::post('/account/login', 'LoginController@login')->name('admin-login');

        Route::get('/account/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin-password-reset');
        Route::post('/account/forgot-password/check_email', 'ForgotPasswordController@checkAdminEmail');
        Route::post('/account/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin-password-email');

        Route::get('/account/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin-reset-form');
        Route::post('/account/password/reset', 'ResetPasswordController@reset')->name('password.reset');
        Route::post('/account/reset-password/check_email', 'ResetPasswordController@checkAdminEmail');
    });
    Route::group(['middleware' => ['web', 'admin']], function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/account/dashboard', 'HomeController@index')->name('home');

        // Profile  Routes
        Route::get('/account/profile', function () {
            config(['app.name' => Auth::guard('admin')->user()->full_name . ' | Edit Profile']);

            return view('admin::account.edit_profile');
        })->name('profile');
        Route::post('/account/profile', 'AccountController@updateProfile')->name('update-profile');
        Route::post('/account/profile', 'AccountController@updateProfile')->name('update-profile');
        Route::post('/account/check_email', 'AccountController@checkEmail');
        Route::post('/account/check_username', 'AccountController@checkUsername');
        Route::post('/account/check_password', 'AccountController@checkPassword');


        // Role Routes
        Route::get('/roles', 'RoleController@index')->name('roles')->middleware('permission:manage-roles|roles-listing');
        Route::post('/roles/get-list', 'RoleController@getList')->middleware('permission:manage-roles|roles-listing');
        Route::get('/role/add', 'RoleController@create')->name('roles-add')->middleware('permission:manage-roles|add-role');
        Route::post('/role/add', 'RoleController@store')->name('roles-add')->middleware('permission:manage-roles|add-role');
        Route::get('/role/edit/{id}', 'RoleController@edit')->name('roles-edit')->middleware('permission:manage-roles|edit-role');
        Route::post('/role/edit/{id}', 'RoleController@update')->name('roles-edit')->middleware('permission:manage-roles|edit-role');
        Route::get('/roles/manage-role-permissions/{id}', 'RoleController@manageRolePermissions')->name('manage-role-permission')->middleware('permission:manage-roles|role-permissions');
        Route::post('/roles/manage-role-permissions/{id}', 'RoleController@storeRolePermissions')->name('manage-role-permission')->middleware('permission:manage-roles|role-permissions');
        Route::get('/roles/delete/{id}', 'RoleController@destroy')->name('roles-delete')->middleware('permission:manage-roles|delete-role');
        Route::post('/roles/check-name', 'RoleController@checkName')->name('roles-check-name');

        // Administrator Routes
        Route::get('/administrators', 'AdministratorController@index')->name('administrators')->middleware('permission:manage-administrator|administrator-listing');
        Route::post('/administrators/get-list', 'AdministratorController@getList')->name('administrators-list')->middleware('permission:manage-administrator|administrator-listing');
        Route::get('/administrators/add', 'AdministratorController@create')->name('administrators-add')->middleware('permission:manage-administrator|add-administrator');
        Route::post('/administrators/add', 'AdministratorController@store')->name('administrators-add')->middleware('permission:manage-administrator|add-administrator');
        Route::get('/administrators/edit/{id}', 'AdministratorController@edit')->name('administrators-edit')->middleware('permission:manage-administrator|edit-administrator');
        Route::post('/administrators/edit/{id}', 'AdministratorController@update')->name('administrators-edit')->middleware('permission:manage-administrator|edit-administrator');
        Route::get('/administrators/view/{id}', 'AdministratorController@show')->name('administrators-view')->middleware('permission:manage-administrator|view-administrator');
        Route::get('/administrators/delete/{id}', 'AdministratorController@destroy')->name('administrators-delete')->middleware('permission:manage-administrator|delete-administrator');

        // Logout
        Route::post('account/logout', 'LoginController@logout')->name('account-logout');
    });
});
