<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Cari role dengan nama "admin" pada tabel roles
        $adminRole = Role::where('name', 'admin')->first();

        // Pastikan role "admin" sudah ada sebelum membuat user admin
        if ($adminRole) {
            // Buat data user sebagai admin
            User::create([
                'name' => 'Admin Satu',
                'username' => 'admin',
                'password' => bcrypt('password'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $adminRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
        } else {
            // Tampilkan pesan jika role "admin" tidak ditemukan
            $this->command->error('Role "admin" not found. Make sure to seed roles table first.');
        }
    }
}
