
## About Laravel Admin Panel

This is Laravel Admin panel package,Developed for quick start with any new project come in development.
It will save time for basic functionlity,Like:

- Administator Login, logout, forgot password, reset password,Edit profile,
- Add, edit, View, Delete and listing of the Administators
- Add, edit, view, Delete and listing of the Roles
- Add, edit, view, Delete ,listing and manage the permission of the Role.


## Step to Install

### Run the following command to install new laravel appplication setup.

 
            composer create-project --prefer-dist laravel/laravel blog
  


### After installing laravel application configgure database details in the env file

            - DB_CONNECTION=mysql
            - DB_HOST=127.0.0.1
            - DB_PORT=3306
            - DB_DATABASE=homestead
            - DB_USERNAME=homestead
            - DB_PASSWORD=secret
    

- Open the App\Provider\AppServiveProvider.php and add the following code into the boot() method to avoid "Specified key was too long" error at the time of database migrate.

```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    ....
    
    Schema::defaultStringLength(191);
    
    .....
}

```

### After the run the following composer command to install the multidots admin panel 


  
            composer require harish/laravel-admin



### After successfully installation of package we need to publish and install in our application for that run this command 


            php artisan multidots-admin:install


### This command publish all the controller,models, view , request file and routes files to your local envronment.

In this command ask you for create roll and default admin for the admin panel. enter the correct information.

### Before you run the application!
  
  Open the App\Provider\AppServiceProvider.php file create a method called as registerHelper() add the following code and call this method from boot() method. Your AppServiveProvider.php file Loop like this afteradding the code.

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->registerHelpers();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        // Load the helpers in app/Http/helpers.php
        if (file_exists($file = app_path('Http/helpers.php'))) {
            require $file;
        }
    }

}


```
It will registerthe helper function that we use in our admin package.

#### For store images in public directory add new disk in config/filesystem.php 

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
#### After creating a disk you need to define a Authentication gaurd for administrator

For that open your config/auth.php file and modify it with bellow code. It will look like this after adding the guard.

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
      | here which uses session storage and the Eloquent user provider.
      |
      | All authentication drivers have a user provider. This defines how the
      | users are actually retrieved out of your database or other storage
      | mechanisms used by this application to persist your user's data.
      |
      | Supported: "session", "token"
      |
     */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
        'administrator' => [
            'driver' => 'session',
            'provider' => 'administrators',
        ],
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
      | sources which represent each model / table. These sources may then
      | be assigned to any extra authentication guards you have defined.
      |
      | Supported: "database", "eloquent"
      |
     */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
        'administrators' => [
            'driver' => 'eloquent',
            'model' => App\Models\Administrator::class,
        ]
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
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'administrators' => [
            'provider' => 'administrators',
            'table' => 'administrator_password_resets',
            'expire' => 60,
        ],
    ],
];




```


#### For Email sending you have to configure the mail credetials in .env file

-Emails is used to send Forgot password link.




            MAIL_DRIVER=smtp
            MAIL_HOST=smtp.mailtrap.io
            MAIL_PORT=2525
            MAIL_USERNAME=null
            MAIL_PASSWORD=null
            MAIL_ENCRYPTION=null


#### Run the laravel application

  
              php artisan serve


#### Go to the url http://127.0.0.1:8000/admin/


#### Your Admin panel is install successfully.

#### Thank you 

   -Feel Free to rais any issue in this Laravel Admin Panel Package :)













