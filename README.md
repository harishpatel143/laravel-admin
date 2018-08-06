
## #About Laravel Admin Panel

This is Laravel Admin panel package, Developed for a quick start with any new project come in development.
It will save time for basic functionality,Like:

### Step to Install
    Create a new project or install in the existing project.
    Setup new laravel application if you new to laravel refer the link to install new laravel project.
	
    https://laravel.com/docs/5.6/installation

### Run the following composer command to install the multidots admin panel.  

        composer require harish/laravel-admin

### After installation publishes all the things in your application via bellow command.
Note: Before running this command be sure that you have configured database settings in your .env file.

        php artisan multidots-admin:install

    -This command publishes all the controller, models, view, request file and routes files to your local environment. And also migrate the database.

### For store images in public directory add a new disk in config/filesystem.php 

```php

'disks' => [
    
    .......
    
    'public_local' => [
        'driver' => 'local',
        'root' => public_path(''),
    ],
    
    .......
    
],

```
#### Define an Authentication guard for administrator

For that open your config/auth.php file and modify it with below code. It will look like this after adding the guard.

```php

<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Authentication Defaults
      |--------------------------------------------------------------------------
      |
      | This option controls the default authentication "guard" and password
      | reset options for your application. You may change these defaults
      | as required, but they're a perfect start for most applications.
      |
     */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    /*
      |--------------------------------------------------------------------------
      | Authentication Guards
      |--------------------------------------------------------------------------
      |
      | Next, you may define every authentication guard for your application.
      | Of course, a great default configuration has been defined for you
      | here which use session storage and the Eloquent user provider.
      |
      | All authentication drivers have a user provider. This defines how the
      | users are actually retrieved out of your database or other storage
      | mechanisms used by this application to persist your user's data.
      |
      | Supported: "session", "token"
      |
     */
    'guards' => [

	......
        'administrator' => [
            'driver' => 'session',
            'provider' => 'administrators',
        ],
	......
    ],
    /*
      |--------------------------------------------------------------------------
      | User Providers
      |--------------------------------------------------------------------------
      |
      | All authentication drivers have a user provider. This defines how the
      | users are actually retrieved out of your database or other storage
      | mechanisms used by this application to persist your user's data.
      |
      | If you have multiple user tables or models you may configure multiple
      | sources which represent each model/table. These sources may then
      | be assigned to any extra authentication guards you have defined.
      |
      | Supported: "database", "eloquent"
      |
     */
    'providers' => [

      ..........
        'administrators' => [
            'driver' => 'eloquent',
            'model' => App\Models\Administrator::class,
        ]
	.........
    ],
    /*
      |--------------------------------------------------------------------------
      | Resetting Passwords
      |--------------------------------------------------------------------------
      |
      | You may specify multiple password reset configurations if you have more
      | than one user table or model in the application and you want to have
      | separate password reset settings based on the specific user types.
      |
      | The expire time is the number of minutes that the reset token should be
      | considered valid. This security feature keeps tokens short-lived so
      | they have less time to be guessed. You may change this as needed.
      |
     */
    'passwords' => [

        ..........
        'administrators' => [
            'provider' => 'administrators',
            'table' => 'administrator_password_resets',
            'expire' => 60,
        ],
	..........
    ],
];
```

#### Run the laravel application

  
            php artisan serve


#### Go to the URL http://127.0.0.1:8000/admin/

    Your Admin panel is installed successfully.

#### Thank you 

  -Feel Free to rais any issue in this Laravel Admin Panel Package :)