<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::findByName('admin');
        $user = Role::findByName('user');

        $routes = collect(Route::getRoutes());

        foreach ($routes as $route) {
            $permissionName = $route->getName();

            if ($permissionName && str_starts_with($permissionName, 'api.')) {
                $permission = Permission::create(['name' => $permissionName]);

                $admin->givePermissionTo($permission);

                if (str_starts_with($permissionName, 'api.tickets.') || str_starts_with($permissionName, 'api.users.tickets.')) {
                    $user->givePermissionTo($permission);
                }
            }
        }
    }
}
