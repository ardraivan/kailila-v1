<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cari role dengan nama "superadmin" pada tabel roles
        $superadminRole = Role::where('name', 'superadmin')->first();

        // Pastikan role "superadmin" sudah ada sebelum membuat user superadmin
        if ($superadminRole) {
            // Buat data user sebagai superadmin
            User::create([
                'name' => 'Bu Evi',
                'username' => 'evisabir',
                'password' => bcrypt('password'), // Ganti "password" dengan password yang ingin Anda gunakan
                'role_id' => $superadminRole->id,
                // tambahkan atribut lain sesuai dengan kebutuhan
            ]);
        } else {
            // Tampilkan pesan jika role "superadmin" tidak ditemukan
            $this->command->error('Role "superadmin" not found. Make sure to seed roles table first.');
        }
    }
}
