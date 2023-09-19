<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\StorageType;
use Illuminate\Support\Facades\DB;

class StorageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storageTypes = [
            [
                'name' => 'Therapy Room',
                'description' => 'A dedicated room or space in the facility where therapy sessions are conducted.',
            ],
            [
                'name' => 'Warehouse',
                'description' => 'A large storage area used to store therapeutic equipment, toys, and other items in bulk.',
            ],
            [
                'name' => 'Digital Storage',
                'description' => 'A storage solution for electronic files and documents related to therapy sessions, client information, and administrative records.',
            ],
            [
                'name' => 'Cloud Storage',
                'description' => 'Online storage services that allow data to be stored and accessed over the internet.',
            ],
            [
                'name' => 'File Cabinet',
                'description' => 'A physical storage cabinet with drawers used to organize and store printed documents.',
            ],
            [
                'name' => 'Other',
                'description' => 'A storage solution that does not fit into the predefined categories.',
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];
    
        DB::table('storage_types')->insert($storageTypes);
    }
}
