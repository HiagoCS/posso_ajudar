<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'boss']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'kitchen']);
        Role::create(['name' => 'bar']);
        Role::create(['name' => 'cashier']);
        Role::create(['name' => 'waiter']);
    }
}