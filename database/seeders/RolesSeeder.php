<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // Seed default roles
                Role::create([
                    'name' => 'superadmin',
                ]);
        
                Role::create([
                    'name' => 'admin',
                ]);
        
                Role::create([
                    'name' => 'therapist',
                ]);
    }
}
