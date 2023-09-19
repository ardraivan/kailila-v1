<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class TherapistUserSeeder extends Seeder
{
    public function run()
    {
        // Cari role dengan nama "therapist" pada tabel roles
        $therapistRole = Role::where('name', 'therapist')->first();

        // Pastikan role "therapist" sudah ada sebelum membuat user therapist
        if ($therapistRole) {
            // Buat data user sebagai therapist
            User::create([
                'name' => 'Anggun Verenica Rahma',
                'username' => 'anggun',
                'password' => bcrypt('anggun123'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $therapistRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
            User::create([
                'name' => 'Cindy Natalia',
                'username' => 'cindy',
                'password' => bcrypt('cindy123'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $therapistRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
            User::create([
                'name' => 'Anastasya Siti Meutia',
                'username' => 'tasya',
                'password' => bcrypt('tasya123'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $therapistRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
            User::create([
                'name' => 'An Nisa Meylinda',
                'username' => 'annisa',
                'password' => bcrypt('nisa123'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $therapistRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
            User::create([
                'name' => 'Melviantin Ranidanika',
                'username' => 'melvin',
                'password' => bcrypt('melvin123'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $therapistRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
            User::create([
                'name' => 'Arifia Azizi',
                'username' => 'azizi',
                'password' => bcrypt('azizi123'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $therapistRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
        } else {
            // Tampilkan pesan jika role "therapist" tidak ditemukan
            $this->command->error('Role "therapist" not found. Make sure to seed roles table first.');
        }
    }
}
