
### About Laravel Admin Panel

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

   This command publishes all the controller, models, view, request file and routes files to your local environment. And also migrate the database.

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

For that open your config/auth.php file and modify it with below code. 

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

#### Run the laravel application

  
            php artisan serve


#### Go to the URL http://127.0.0.1:8000/admin/

    Your Admin panel is installed successfully.

#### Thank you 

  -Feel Free to rais any issue in this Laravel Admin Panel Package :)
