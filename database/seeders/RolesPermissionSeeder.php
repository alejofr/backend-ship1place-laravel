<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleClient = Role::create(['name' => 'Client']);
        $roleSubClient = Role::create(['name' => 'SubClient', 'guard_name' => 'api']);

        //El rol administrador.
        Permission::create(['name' => '*'])->syncRoles($roleAdmin);

        //Rol de cliente
        Permission::create(['name' => 'all-client'])->syncRoles($roleClient);

        //Rol de cliente
        Permission::create(['name' => 'all-sub-client', 'guard_name' => 'api'])->syncRoles($roleSubClient);
    }
}
