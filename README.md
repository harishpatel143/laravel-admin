
## Admin panel package for Laravel
#### Compatibility
    
    - Laravel +5.5
    
#### Step to Install
#### You can install this package into your Laravel application by running this bellow command into your root directory.
```ssh
    composer require harish/laravel-admin
```
#### Publish all the things in your application via bellow command.
```ssh
    php artisan multidots-admin:install
```
#### Database migration
```ssh
    php artisan migrate
```
#### Database seeding
Run the bellow commands:
```ssh
    composer dump-autoload
    
    php artisan db:seed --class=AdministratorsTableSeeder
```
#### Run the laravel application
```ssh    
    php artisan serve
```
#### You have done.
    Go to http://127.0.0.1:8000/admin/ for open laravel admin panel.

    user: demo@gmail.com
    password: thinker99

