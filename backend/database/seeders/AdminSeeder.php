<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserPersonalData;

use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '88',
            'name' => 'ADMIN', 
            'password' => bcrypt('admin@motobuddy'),
            'email' => 'hiago8cs@gmail.com'
        ])->assignRole(['boss', 'developer']);
        User::create([
            'id' => '18',
            'name' => 'Mió', 
            'password' => bcrypt('admin@possoajudar'),
            'email' => 'ikigaichupachupa@gmail.com'
        ])->assignRole(['boss']);
        User::create([
            'id' => '1',
            'name' => 'DelayCosta', 
            'password' => bcrypt('123456'),
            'email' => 'garçom@gmail.com'
        ])->assignRole(['waiter']);
        User::create([
            'id' => '2',
            'name' => 'HiguinhoLT', 
            'password' => bcrypt('123456'),
            'email' => 'higor@gmail.com'
        ])->assignRole(['waiter', 'bar']);
        User::create([
            'id' => '3',
            'name' => 'JoelsonSantos', 
            'password' => bcrypt('123456'),
            'email' => 'lennin@gmail.com'
        ])->assignRole(['manager', 'bar']);
        User::create([
            'id' => '4',
            'name' => 'Japinhaks', 
            'password' => bcrypt('123456'),
            'email' => 'kelly@gmail.com'
        ])->assignRole(['kitchen']);
        User::create([
            'id' => '5',
            'name' => 'dn fifi', 
            'password' => bcrypt('123456'),
            'email' => 'cibelle@gmail.com'
        ])->assignRole(['kitchen']);
    }
}
