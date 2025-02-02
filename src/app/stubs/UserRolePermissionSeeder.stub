<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        try {
            $roles_permission=['role-view', 'role-create','role-edit','role-delete'];
            $user_permission=['user-view', 'user-create','user-edit','user-delete'];
            $permission_permission=['permission-view', 'permission-create','permission-edit','permission-delete'];
            $blog_permission=['product-view', 'product-create','product-edit','product-delete'];

            $allPermissions= array_merge($roles_permission, $user_permission, $permission_permission);
            foreach ($allPermissions as $role) {
                if(!DB::table('permissions')->where('name', $role)->exists()) {
                    Permission::create(['name' => $role]);
                }
            }
            $superAdminRole = Role::findOrCreate('super-admin','web'); //as super-admin
            $adminRole = Role::findOrCreate('admin','web'); //as admin-admin
            $staffRole = Role::findOrCreate('staff','web'); //as staff-admin
            $userRole = Role::findOrCreate('user','web'); //as user-admin

            $allPermissionNames = Permission::pluck('name')->toArray();
            $superAdminRole->givePermissionTo($allPermissionNames);

            // giving admin roles
            $adminRole->givePermissionTo(['role-view', 'role-create', 'role-edit','role-delete']);
            $adminRole->givePermissionTo(['permission-view', 'permission-create', 'permission-edit','permission-delete']);
            $adminRole->givePermissionTo(['user-view', 'user-create', 'user-edit','user-delete']);
            // Let's Create User and assign Role to it.
            $superAdminUser = User::firstOrCreate([
                'email' => 'official.kaushalg@gmail.com',
            ], [
                'name' => 'Super Admin',
                'email' => 'official.kaushalg@gmail.com',
                'email_verified_at' =>  Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make ('password'),
                'status' => 1,
                'super_admin' => 1,
            ]);
            $superAdminUser->assignRole($superAdminRole);
            $adminUser = User::firstOrCreate([
                'email' => 'admin@gmail.com'
            ], [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make ('12345678'),
                'status' => 1,
            ]);

            $adminUser->assignRole($adminRole);

        }catch (\Exception $exception){
            dd($exception);
        }

//        $staffUser = User::firstOrCreate([
//            'email' => 'staff@gmail.com',
//        ], [
//            'name' => 'Staff',
//            'email' => 'staff@gmail.com',
//            'password' => Hash::make('12345678'),
//        ]);
//        $staffUser->assignRole($staffRole);
    }
}
