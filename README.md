
# Admin panel package for Laravel

### Step to Install
#### You can install this package into your Laravel application by running this bellow command into your root directory.

```ssh
    composer require harish/laravel-admin
```
#### Publish all the things in your application via bellow command.
```ssh
    php artisan multidots-admin:install
```
#### For store images in public directory add a new disk in config/filesystem.php 

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

Open your config/auth.php file and modify it as below code. 

```php

<?php

return [
   
   .........
   
    'guards' => [
            .......

            'administrator' => [
                    'driver' => 'session',
                    'provider' => 'administrators',
                ],
            .......
    ],
    
    
    'providers' => [
            ..........

            'administrators' => [
                    'driver' => 'eloquent',
                    'model' => App\Models\Administrator::class,
                ]
            .........
    ],
    
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
#### Database migration
```ssh
    php artisan migrate
```
#### Database seeding
```ssh
    php artisan db:seed --class=AdministratorsTableSeeder
```
#### Run the laravel application
```ssh    
    php artisan serve
```

#### Go to the URL http://127.0.0.1:8000/admin/

    Your Admin panel is installed successfully.
    
    Default user: demo@gmail.com
    Default password: thinker99
    
#### Thank you 

  -Feel Free to rais any issue in this Laravel Admin Panel Package :)
