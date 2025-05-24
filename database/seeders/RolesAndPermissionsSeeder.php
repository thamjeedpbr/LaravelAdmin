<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $arrayOfPermissionNames = [
            'roles',
            'users',
            'room',
            'booking',
            'patient',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        collect($arrayOfPermissionNames)->map(function ($permission) {
            $permissions = [
                ['name' => 'create-' . $permission, 'module_name' => $permission, 'guard_name' => 'web'],
                ['name' => 'view-' . $permission, 'module_name' => $permission, 'guard_name' => 'web'],
                ['name' => 'edit-' . $permission, 'module_name' => $permission, 'guard_name' => 'web'],
                ['name' => 'delete-' . $permission, 'module_name' => $permission, 'guard_name' => 'web'],
            ];
            Permission::insert($permissions);
        });

        // Create roles
        $super_admin = Role::create(['name' => 'super-admin', 'display_name' => 'Super Admin']);
        $company_admin = Role::create(['name' => 'company', 'display_name' => 'Company Admin']);

        // Assign permissions to roles
        $super_admin->givePermissionTo(Permission::all());

        // Assign roles to users
        $superuser = User::where('email', 'superadmin@admin.com')->first();
        $companyuser = User::where('email', 'user@admin.com')->first();

        if ($superuser) {
            $superuser->assignRole($super_admin->id);
        }
        // Course Admin permissions: only course permissions, excluding delete
        $company_permissions = Permission::where('module_name', 'booking')
            ->get();
        $company_admin->givePermissionTo($company_permissions);

        if ($companyuser) {
            $companyuser->assignRole($company_admin->id);
        }

    }
}
