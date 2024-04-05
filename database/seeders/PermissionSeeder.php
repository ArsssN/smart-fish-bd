<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard_name = config('backpack.base.guard') ?? 'web';

        // Roles
        require_once(__DIR__ . '/seeder-data/roles.php');
        DB::table('roles')->insert($roles ?? []);

        // Model Roles
        require_once(__DIR__ . '/seeder-data/model_has_roles.php');
        DB::table('model_has_roles')->insert($model_has_roles ?? []);

        // Permissions
        $routes      = collect(Route::getRoutes()->getRoutes());
        $adminPermissions = $routes->filter(
            fn($route) => !($routePrefix = config('backpack.base.route_prefix'))
                          || Str::startsWith($route->getPrefix(), $routePrefix)
        )->map(
            fn($route) => [
                'name'       => $route->getName(),
                'guard_name' => $guard_name,
                'created_at' => $created_at = now(),
                'updated_at' => $created_at
            ]
        )->reject(
            fn($route) => !$route['name']
        )->toArray();
        $otherRoutes = [
            "l5-swagger.default.api",
        ];
        $otherPermissions = array_map(
            fn($route) => [
                'name'       => $route,
                'guard_name' => $guard_name,
                'created_at' => $created_at = now(),
                'updated_at' => $created_at
            ],
            $otherRoutes
        );
        DB::table('permissions')->insert([...$adminPermissions, ...$otherPermissions]);

        // Model Permissions
        $permissionIDs = DB::table('permissions')->pluck('id')->toArray();
        setPermissionsToRoles($permissionIDs, ['SuperAdmin', 'Admin', 'User', 'ShellAdmin', 'Customer']);
    }
}
