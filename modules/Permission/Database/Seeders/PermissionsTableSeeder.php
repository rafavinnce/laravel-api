<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Permission\Entities\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Permission::class)->create(['name' => 'users.index', 'title' => 'List users', 'module' => 'User']);
        factory(Permission::class)->create(['name' => 'users.show', 'title' => 'Show user', 'module' => 'User']);
        factory(Permission::class)->create(['name' => 'users.store', 'title' => 'Create user', 'module' => 'User']);
        factory(Permission::class)->create(['name' => 'users.update', 'title' => 'Update user', 'module' => 'User']);
        factory(Permission::class)->create(['name' => 'users.destroy', 'title' => 'Delete user', 'module' => 'User']);
    }
}
