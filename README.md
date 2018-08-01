
## About Laravel Admin Panel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

## Step to Install

### Run the following command to install new laravel appplication setup.

composer create-project --prefer-dist laravel/laravel blog

### After installing laravel application configgure database details in the env file
```php 

    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=homestead
    - DB_USERNAME=homestead
    - DB_PASSWORD=secret
    
```

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

```php 
  
composer require harish/laravel-admin

```

### After successfully installation of package we need to publish and install in our application for that run this command 

```php 

php artisan multidots-admin:install

```

### This command publish all the controller,models, view , request file and routes files to your local envronment.

In this command ask you for create roll and default admin for the admin panel. enter the correct information.

### You are almost done!

### Run the laravel application

```php 
  
  php artinsa serve

```

### Go to the url http://127.0.0.1:8000/admin/

## Your Admin panel is install successfully

















