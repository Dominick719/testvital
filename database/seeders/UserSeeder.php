<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    
    public function run()
    {
        $rol_admin = Role::where('name', 'administrador')->first();
        User::factory()->for($rol_admin)->count(1)->create();

        $rol_admin = Role::where('name', 'organizador')->first();
        User::factory()->for($rol_admin)->count(5)->create();

        $rol_director = Role::where('name', 'estudiante')->first();
        User::factory()->for($rol_director)->count(5)->create();
    }
}
