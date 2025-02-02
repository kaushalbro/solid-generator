Initial Package required: laravel breeze, spatie (for roles, logs, etc,)
<br>composer require laravel/breeze --dev  php artisan breeze:install blade
<br>composer require spatie/laravel-permission



Steps: 1)(Optional): Add: the below code in app/Providers/AuthServiceProvider.php inside boot function at last</br>  
        Gate::before(function ($user, $ability) {</br>  
            return ($user->super_admin == 1 && $user->status == 1) ? true : null;</br>  
       });

Steps: 2): Add: following inside app/Kernel inside: protected $routeMiddleware = [] at last, like</br>
protected $routeMiddleware = [</br>
'...'=>'...',</br>
'...'=>'...',</br>
'...'=>'...',</br>
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,</br>
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,</br>
'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,</br>
]</br> 


Steps: 3) Add: trait 'HasRoles' in User Model;

Steps: 4) Run: php artisan db:seed

Steps: 5) Seed:  UserRolePermissionSeeder; command here <br>  php artisan db:seed --class=UserRolePermissionSeeder

php artisan solid:make --publish // this will copy routes to app/routes

Global function
app('sidebar')
