<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Storage;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storages = [
            [
                'storage_type_id' => 1,
                'name' => 'Set Putih',
                'colour_id' => 6,
                'user_id' => 1,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Merah',
                'colour_id' => 2,
                'user_id' => 3,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Kuning',
                'colour_id' => 3,
                'user_id' => 4,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Hijau',
                'colour_id' => 4,
                'user_id' => 5,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Ungu',
                'colour_id' => 5,
                'user_id' => 6,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Orange',
                'colour_id' => 7,
                'user_id' => 7,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Abu-abu',
                'colour_id' => 8,
                'user_id' => 8,
            ],
            [
                'storage_type_id' => 1,
                'name' => 'Set Biru',
                'colour_id' => 1,
                'user_id' => 1,
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];
    
        DB::table('storages')->insert($storages);
    }
}
