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
        $adminRole = Role::findOrCreate('admin');

        $addBook = Permission::findOrCreate('add books');
        $editBook = Permission::findOrCreate('edit books');
        $deleteBook = Permission::findOrCreate('delete books');
        $downloadBook = Permission::findOrCreate('download books');

        $adminRole->givePermissionTo($addBook);
        $adminRole->givePermissionTo($editBook);
        $adminRole->givePermissionTo($deleteBook);
        $adminRole->givePermissionTo($downloadBook);

        $userRole = Role::findOrCreate('user');
    }
}
