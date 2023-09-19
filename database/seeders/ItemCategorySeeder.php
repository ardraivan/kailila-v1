<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ItemCategory;
use Illuminate\Support\Facades\DB;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemCategories = [
            [
                'name' => 'Furniture',
            ],
            [
                'name' => 'Toilet',
            ],
            [
                'name' => 'Alat Tulis',
            ],
            [
                'name' => 'Buku-buku',
            ],
            [
                'name' => 'Materi Konseling',
            ],
            [
                'name' => 'Assesment - Informal',
            ],
            [
                'name' => 'Assesment - Formal',
            ],
            [
                'name' => 'Kesiapan - Kontak Mata',
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];
    
        DB::table('item_categories')->insert($itemCategories);
    }
}
