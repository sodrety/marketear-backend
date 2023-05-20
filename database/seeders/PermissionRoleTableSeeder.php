<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Create Roles
        $super_admin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $finance = Role::firstOrCreate(['name' => 'finance']);
        $operator = Role::firstOrCreate(['name' => 'operator']);

        // Create Permissions
        Permission::firstOrCreate(['name' => 'view_backend']);
        Permission::firstOrCreate(['name' => 'edit_profile']);
        Permission::firstOrCreate(['name' => 'view_billing']);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        // Assign Permissions to Roles
        $super_admin->givePermissionTo(Permission::all());
        $admin->givePermissionTo('view_backend');
        $finance->givePermissionTo('view_backend');
        $finance->givePermissionTo('view_billing');
        $finance->givePermissionTo('view_workspace_detail');
        $operator->givePermissionTo('view_backend');
        $operator->givePermissionTo('view_workspace_detail');

        Schema::enableForeignKeyConstraints();
    }
}
