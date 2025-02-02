Package: devil999/solidgenerator: 

     Solid Generator generates solid code with controller api resources, custom request, with repo pattern, migrations based on model_schema_json file  with admin panel for blade etc..
     Note: For better result: 
            Think to design software and write your schema according in model_schema_json.json file formate stored in root path and run solid:make commands 

#### For collaboration or contribution: Mail to: official.kaushalg+devil@gmail.com 

Initial Required packages:
    
    laravel breeze, spatie (for roles, logs, etc,)
    installation:
            composer require laravel/breeze --dev  OR php artisan breeze:install blade
            composer require spatie/laravel-permission

Register Service Provider :
    
    Laravel 11 :
            Add :    SolidPrincipleServiceProvider::class to bootstrap/providers.php
        Laravel 10 : Find you self 

    Public solid-generator assets :    php artisan vendor:publish --tag=solid-app
    Globle :   php artisan solid:make --publish
    
Operations:
    
    Role and permission (options)
    Steps: 1)(Optional): Add: 
            the below code in app/Providers/AuthServiceProvider.php inside boot function at last</br>  
            Gate::before(function ($user, $ability) {</br>  
                return ($user->super_admin == 1 && $user->status == 1) ? true : null;</br>  
           });

        For laravel 10:
            Steps: 2): Add: following inside app/Kernel inside: protected $routeMiddleware = [] at last, like</br>
            protected $routeMiddleware = [</br>
            '...'=>'...',</br>
            '...'=>'...',</br>
            '...'=>'...',</br>
            'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,</br>
            'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,</br>
            'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,</br>
            ]</br> 
        For laravel 11: find spatie way to add middleware alias 

            Steps: 3) Add: trait 'HasRoles' in User Model;

            Steps: 5) Seed:  UserRolePermissionSeeder; command here <br>  php artisan db:seed --class=UserRolePermissionSeeder

First test command after setup :
    
    php artisan solid:make --crud 

    // This will Generates Following files: Example for api enabled and repo design patter, Vary in Configuration you provides

    1. Traits FileManager.php . // to manage file uploading
    2. Traits Api_Response.php . // to manage api response
    3. Interfaces SolidInterface.php File. 
    4. Repositories SolidBaseRepository.php File.
    5. Models DemoProduct.php File.
    6. Repositories DemoProductRepository.php File.
    7. API CreateDemoProductRequest.php File.
    8. Controllers DemoProductController.php File.
    9. migrations 2025_02_02_070024_create_demoproducts_table.php File.
    Resources:  
        10. DemoProductListResource.php File.
        11. DemoProductCreateResource.php File.
        12. DemoProductShowResource.php File.
        13. DemoProductEditResource.php File.
        
    
    Notice incide configuration file:   'design_pattern'=> "repository", //Design patterns are : none or repository


Global function :

    app('sidebar')

`Commands: (depends on solid configuration file)`
 
      php artisan solid:make {model_name? : Optional model_name parameter}

                 {--config|config : Generate Package configuration }
                 {--crud|crud : Generate Plain CRUD files }
                 {--api|api : Generate api resources}
                 {--repo-crud|repo-crud : Generate CRUD files for Repository design pattern }
                 {--m|model : Generate model}
                 {--view|view : Generate model}
                 {--c|controller : Generate Controller }
                 {--i|interface : Generate interface}
                 {--re|repo  : Generate repository}
                 {--mi|migration  : Generate migration}
                 {--r|request : Generate custom request}
                 {--ro|route : Generate routes}
                 {--layout|layout  } layout_type? : Generate Layout}
                 {--newAdminPanel|new-admin-panel : Generate fresh Admin panel}
                 {--publish|publish : Generate Publish files }
                 {--h|help}
                 {--t|test}


`Config : config/solid.php`

    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                   WARNING :  DEVIL000/SOLID - PACKAGE                  //
    //            DO NO ALTER DEFAULT CONFIGURATION UNLESS REQUIRED           //
    //                   ALTERING HERE MAY CAUSE MALFUNCTION                  //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////
    //--NOTE:NOTE--//
    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //         All Directory Name pattern should match the pattern below      //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////

    'modular_app'=>false, // If the app is built on top of module based system design. (Coming soon...)
    'model_schema_json_path' => base_path("model_schema_json.json"),  // root path/base_path
    'is_api' => true,  // Is this application is developing an api's.
    'api_with_resource_classes'=>true,  // Depends on is_api, This will create an api resources for models if is_api is true.
    'react_with_inertia'=>false, // coming soon...
    'model_path' => "app/Models",
    'controller_path' => "app/Http/Controllers",
    'api_resources_path' => "app/Http/Resources",
    'request_path'=>"app/Http/Requests",
    'view_path' =>"resources/views",  // When is_api is true this will be disabled automatically.
    'migration_path'=>"database/migrations", // Migration Path
    'seeder_path'=>"database/seeders",   // Seeder Path
    'backend_admin_view_path' => "resources/views/backend/admin",  // Storage for View files of Admin/backend.
    'frontend_view_path' => "resources/views/frontend",  // Storage for View files of Frontend.
    // Configuration for Repository design pattern
    'design_pattern'=> "repository", //Design patterns are : none or repository
    'interface_path' => "app/Interfaces",  // Interface Path
    'repo_path' => "app/Repositories",   // Repository Path
    'base_interface_name' => "SolidInterface",  // Base Interface name
    'base_repository_name' => "SolidBaseRepository",  // Base Repository name
    // Other Configuration
    'show_file_already_exists_warning' => false,  //
    'show_folder_already_exists_warning' => false,
    // Override created file : This may delete the contents of previous file generated by SOLID (Not applied Yet)
    'override_previous_file_data' => false,
    "carbon_immutable" => true



# Bugs:

    1. By default, the middlware function are applied in Controller files 
       you need to remove it manually if you dont use auth and spatie permission package


# Sidebar Configuration Documentation

This documentation describes how to use the `SideBar::add() OR route: localhost://sidebar`  method to create a custom sidebar configuration with multiple options, including sub-links, icons, visibility, permissions, and active routes.

## Sidebar Configuration Example

### Adding a Sidebar

The following example demonstrates how to add a "Product" on sidebar with its associated sub-links:

php
```
SideBar::add('Product', Product::class) //$model is optional
    ->icon('fa-brands fa-product-hunt')
    ->route('') //optional
    ->title('Product')
    ->group('Purchase') // group under the 'Purchase' category # default is core
    ->hide(true) 
    ->permission(true)
    ->activeOnRoutes('admin/products/mainSidebar')
    ->subLinks(
        SubLink::add('Add Product')
            ->icon('fa-solid fa-plus')
            ->route('/admin/products/create')
            ->hide(true)
            ->permission(true)
            ->activeOnRoutes('/products/other_route'),
        SubLink::add('List Products')
            ->icon('fa-solid fa-list')
            ->route('/admin/products')
            ->hide(true)
            ->permission(true)
            ->activeOnRoutes(['admin/products\other_list])
    );
```

### Breakdown of the Configuration

#### Adding Sidebar:

-   `SideBar::add('Product')`: This creates a new sidebar item titled "Product".

#### Sidebar Properties:

-   `->group('Purchase')`: Sets the sidebar item’s icon using Font Awesome. Here, it uses the "fa-product-hunt" icon.
-   `->icon('fa-brands fa-product-hunt')`: Sets the sidebar item’s icon using Font Awesome. Here, it uses the "fa-product-hunt" icon.
-   `->route('')`: Defines the route for the sidebar item. In this case, the route is left blank, which can be configured based on your needs.
-   `->title('Product')`: The title that appears on the sidebar. It is set as "Product".
-   `->hide(true)`: Specifies that the sidebar item is visible. Set to `true` to make it visible.
-   `->permission(true)`: Specifies that the sidebar item is available for users with permission. Set to `true` to allow access.
-   `->activeOnRoutes('admin/products/mainSidebar')`: Defines the route(s) where this sidebar item should be marked as active. In this case, it is active when the route matches `admin/products/mainSidebar`.

### Sub Links

The sidebar item can have multiple sub-links. These sub-links are defined using the `subLinks()` method.

#### Add Product Sub-Link:

php

```
SubLink::add('Add Product')
    ->icon('fa-solid fa-plus')
    ->route('/admin/products/route_create11')
    ->hide(true)
    ->permission(true)
    ->activeOnRoutes('/kaushala/products/active_on_create1')
```

-   `SubLink::add('Add Product')`: Creates a sub-link titled "Add Product".
-   `->icon('fa-solid fa-plus')`: Sets the icon for the sub-link. In this case, it's a plus icon.
-   `->route('/admin/products/route_create11')`: Specifies the route for this sub-link.
-   `->hide(true)`: Makes the sub-link visible.
-   `->permission(true)`: Grants permission for the sub-link.
-   `->activeOnRoutes('/kaushala/products/active_on_create1')`: Marks the sub-link as active for the specified route.

#### List Products Sub-Link:

php

```
SubLink::add('List Products')
    ->icon('fa-solid fa-list')
    ->route('/admin/products/route_create')
    ->hide(true)
    ->permission(true)
    ->activeOnRoutes(['hari/admin/products+a'])
```

-   `SubLink::add('List Products')`: Creates another sub-link titled "List Products".
-   `->icon('fa-solid fa-list')`: Sets the icon for the sub-link as a list icon.
-   `->route('/admin/products/route_create')`: Specifies the route for the "List Products" sub-link.
-   `->hide(true)`: Ensures the sub-link is visible.
-   `->permission(true)`: Grants permission for the sub-link.
-   `->activeOnRoutes(['hari/admin/products+a'])`: Marks the sub-link as active for the specified route(s).

## Method Details

### `SideBar::add($name)`

-   **Description**: Adds a new sidebar item.
-   **Parameters**:
    -   `$name`: The title of the sidebar item (e.g., 'Product').

### `->icon($icon)`

-   **Description**: Sets the icon for the sidebar item.
-   **Parameters**:
    -   `$icon`: The Font Awesome class for the icon (e.g., 'fa-brands fa-product-hunt').

### `->route($route)`

-   **Description**: Defines the route for the sidebar item.
-   **Parameters**:
    -   `$route`: The route URL for the sidebar item (can be a string or a route name).

### `->title($title)`

-   **Description**: Sets the title text that will be displayed for the sidebar item.
-   **Parameters**:
    -   `$title`: The title of the sidebar item (e.g., 'Product').

### `->hide($hide)`

-   **Description**: Controls the hide of the sidebar item.
-   **Parameters**:
    -   `$hide`: `true` to make the item visible, `false` to hide it.

### `->permission($permission)`

-   **Description**: Determines whether the sidebar item is accessible based on user permissions.
-   **Parameters**:
    -   `$permission`: `true` if the item is accessible, `false` if not.

### `->activeOnRoutes($routes)`

-   **Description**: Defines the routes where the sidebar item will be marked as active.
-   **Parameters**:
    -   `$routes`: A string or an array of route names or URLs.

### `subLinks($subLinks)`

-   **Description**: Adds sub-links to the sidebar item.
-   **Parameters**:
    -   `$subLinks`: An array of `SubLink` instances, each representing a sub-link.

## SubLink Configuration

### Example SubLink Method:

php

```
SubLink::add('Link Name')
    ->icon('fa-solid fa-icon')
    ->route('/link/route')
    ->hide(true)
    ->permission(true)
    ->activeOnRoutes('/route/active_on_link');
```

### SubLink Method Details:

-   `SubLink::add($name)`: Adds a sub-link with the specified name.
-   `->icon($icon)`: Sets the icon for the sub-link.
-   `->route($route)`: Defines the route for the sub-link.
-   `->hide($hide)`: Controls the visibility of the sub-link.
-   `->permission($permission)`: Specifies whether the sub-link is available based on permissions.
-   `->activeOnRoutes($routes)`: Marks the sub-link as active for the given route(s).

### Blade Code for Frontend here:

```
@foreach(app('sidebar') as $key_1 => $group)
    @if($key_1 != 'core')
         <!-- Group Header -->
        <li class="nav-header">{{ $key_1 }}</li>
        // Handle other logic here
    @endif

    @foreach(app('sidebar')[$key_1] as $key => $main_link)
        @if( $main_link['hide'] && $main_link['permission'])
            // Handle main link logic here

            @if(count($main_link['sub_links']) > 0)
                @foreach($main_link['sub_links'] as $key_sub_link => $sub_link)
                    @if($sub_link['hide'] && $sub_link['permission'])
                        // Handle sub-link logic here
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach
@endforeach
```
### JS Code for frontend
```
const sidebar = app('sidebar'); // Assuming 'sidebar' is available in your app context

Object.keys(sidebar).forEach(key_1 => {
    if (key_1 !== 'core') {
            <!-- Group Header -->
        // Handle group logic here
    }

    sidebar[key_1].forEach(main_link => {
        if (main_link.hide && main_link.permission) {
            // Handle main link logic here

            if (main_link.sub_links && main_link.sub_links.length > 0) {
                main_link.sub_links.forEach(sub_link => {
                    if (sub_link.hide && sub_link.permission) {
                        // Handle sub-link logic here
                    }
                });
            }
        }
    });
});

```


```


This version includes more detailed descriptions and is structured for better readability. 
Let me know if you need any further enhancements!

```

### Future Implementation Grouping like this. coming soon...

```
On App : 
    Generate factory generator for every model.
On sidebar: 
         SideBar::group('setting',function(){
                     SideBar::add('User Management')
                         ->icon('fa-solid fa-users')
                         ->subLinks(
                             SubLink::add('Users', User::class)
                                 ->icon('fa-solid fa-user ')
                                 ->route('/admin/users'),
                             SubLink::add('Roles', Role::class)
                                 ->icon('fa-solid fa-user ')
                                 ->route('/admin/roles')
                         );
                     SideBar::add('User Management')
                         ->icon('fa-solid fa-users')
                         ->subLinks(
                             SubLink::add('Users', User::class)
                                 ->icon('fa-solid fa-user ')
                                 ->route('/admin/users'),
                             SubLink::add('Roles', Role::class)
                                 ->icon('fa-solid fa-user ')
                                 ->route('/admin/roles')
                         );
         });
```
`Data formate`

````
[
  {
    "model_name": "DemoProduct",
    "model_attributes": {
      "db_rules": [
        "product_code:string|required|unique",
        "type:enum(inventory,service)|required",
        "name:string|required",
        "category_id:foreign_key|required",
        "sku_code:string|nullable|unique",
        "brand:string|nullable",
        "unit:string|required",
        "units:string|nullable",
        "description:text|nullable",
        "status:enum(active,inactive)|required",
        "variation:boolean|default:false",
        "image:file|nullable",
        "supplier_id:foreign_key",
        "purchase_unit:string|nullable|required",
        "reorder_threshold_quantity:float|nullable",
        "selling_price:float|required",
        "selling_unit:string|nullable|required",
        "discount_amount:float|nullable"
      ],
      "request_rules": [
        "product_code:required|string|min:2|max:50",
        "type:required|in:inventory,service",
        "name:required|string|min:2|max:255",
        "category_id:required|int",
        "sku_code:nullable|string|min:2|max:50",
        "brand:nullable|string|max:100",
        "unit:required|string|max:50",
        "units:nullable|string|max:255",
        "description:nullable|string",
        "status:required|in:active,inactive",
        "variation:nullable|boolean",
        "image:nullable|file|mimes:jpeg,png,jpg|max:2048",
        "supplier_id:nullable|integer|exists:suppliers,id",
        "purchase_unit:nullable|string|max:50",
        "reorder_threshold_quantity:nullable|numeric|min:0",
        "selling_price:required|numeric|min:0",
        "selling_unit:nullable|string|max:50",
        "discount_amount:nullable|numeric|min:0"
      ]
    }
  }
]

````

