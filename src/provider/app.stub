<?php
namespace App\Providers;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Devil\Solidprinciple\app\Services\SideBar;
use Devil\Solidprinciple\app\Services\SubLink;
use Illuminate\Support\ServiceProvider;

class SolidAppServiceProvider extends ServiceProvider
{
    public function registerSidebar(): void
    {
//         SideBar::add('Product', Product::class)
//            ->icon('fa-brands fa-product-hunt')
//            ->position(1)
//            ->hide(false)
//            ->subLinks(
//                SubLink::add('Add Product')
//                    ->icon('fa-solid fa-plus')
//                    ->route('/admin/products/create'),
//                SubLink::add('List Products')
//                    ->icon('fa-solid fa-list')
//                    ->route('/admin/products')
//            );
         SideBar::add('User Management')
                ->group('SETTINGS')
                ->icon('fa-solid fa-users')
                ->subLinks(
                    SubLink::add('Users', User::class)
                        ->icon('fa-solid fa-user ')
                        ->route('/admin/users'),
                    SubLink::add('Roles', Role::class)
                        ->icon('fa-solid fa-user ')
                        ->route('/admin/roles')
                );

         SideBar::add('Application Setting')
                ->group('SETTINGS')
                ->hide()
                ->icon('fa-solid fa-gear')
                ->subLinks(
                    SubLink::add('Frontend')
                        ->icon('fa-solid fa-f')
                        ->route('#'),
                    SubLink::add('Admin Panel')
                        ->icon('fa-solid fa-a')
                        ->route('#')
                );
    }

    public function registerRoutes() : void
    {
        if(file_exists(base_path('routes/solid.php'))) include_once base_path('routes/solid.php');
    }
    public function boot(): void
    {
        $this->registerSidebar();
        $this->registerRoutes();
    }

}
