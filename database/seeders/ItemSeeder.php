<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\ItemCategory;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data sebenarnya yang ingin dimasukkan ke dalam tabel Item
        $realData = [
            [
                'name' => 'AC + Remote + Tempat Remote',
                'description' => 'Satu set Air Conditioner',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],            
            [
                'name' => 'Lemari Kayu Besar',
                'description' => 'Lemari untuk menyimpan ayam',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Cermin',
                'description' => 'Untuk berkaca dan introspeksi diri agar menjadi pribadi yang lebih baik',
                'item_category_id' => 2, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Tempat Tissue',
                'description' => 'Untuk menyimpan tissue di toilet',
                'item_category_id' => 2, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Tempat Alat Tulis',
                'description' => 'Tempat menyimpan alat tulis (pensil, bolpen, peggaris, dll)',
                'item_category_id' => 3, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Bolpen Hitam',
                'description' => 'Alat untuk menulis dengan tinta warna hitam',
                'item_category_id' => 3, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Lovaas Me Book',
                'description' => 'Buku yang bercerita tentang kecintaan terhadap diri sendiri',
                'item_category_id' => 4, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'C. Maurice',
                'description' => 'Buku yang bercerita tentang kisah perjalanan hidup Maurice dari susah sampai kaya raya',
                'item_category_id' => 4, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Buku Panduan Besar',
                'description' => 'Buku ukuran besar yang berisi panduan-panduan hidup',
                'item_category_id' => 5, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Reward Box + Item',
                'description' => 'Self reward',
                'item_category_id' => 5, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Laci Kayu 6 Tingkat',
                'description' => 'Laci untuk menyimpan banyak perhiasan',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Harry Potter',
                'description' => 'Novel terbaik di dunia yang bercerita tentang petualangan seorang penyihir dan teman-temannya',
                'item_category_id' => 4, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Tempat Sampah',
                'description' => 'Untuk membuang aku, karena aku sampah',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Bantal',
                'description' => 'Untuk tidur lebih nyaman',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Jam Dinding',
                'description' => 'Untuk melihat waktu yang salah - Fiersa Besari',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Kemoceng',
                'description' => 'Untuk membersihkan segala sesuatu dari butiran debu',
                'item_category_id' => 1, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Lem',
                'description' => 'Untuk mempererat suatu hubungan',
                'item_category_id' => 3, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Penghapus',
                'description' => 'Untuk menghapus kenangan manis - pamungkas',
                'item_category_id' => 3, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Crayon / Pensil Warna (1 Set)',
                'description' => 'Untuk mewarnai hari-harimu yang terlalu monokrom',
                'item_category_id' => 3, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Note Book',
                'description' => 'Untuk mencatat amal baik dan buruk',
                'item_category_id' => 3, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            [
                'name' => 'Tape + Cassette + Baterai',
                'description' => 'Untuk memutar dan mendengarkan musik religi',
                'item_category_id' => 5, // ID kategori yang sesuai dari tabel ItemCategory
            ],
            // ... dan seterusnya
        ];

        // Simpan data ke dalam database
        foreach ($realData as $data) {
            Item::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'item_category_id' => $data['item_category_id'],
            ]);
        }
    }
}