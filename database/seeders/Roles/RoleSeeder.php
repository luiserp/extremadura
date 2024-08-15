<?php

namespace Database\Seeders\Roles;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminRole = Role::create(['name' => 'admin']);

        $addBook = Permission::create(['name' => 'add books']);
        $editBook = Permission::create(['name' => 'edit books']);
        $deleteBook = Permission::create(['name' => 'delete books']);

        $adminRole->givePermissionTo($addBook);
        $adminRole->givePermissionTo($editBook);
        $adminRole->givePermissionTo($deleteBook);

        $userRole = Role::create(['name' => 'user']);

    }
}
