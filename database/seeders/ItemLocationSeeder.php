<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ItemLocation;
use App\Models\Item;
use App\Models\Storage;

class ItemLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        $storages = Storage::all();
    
        $combinations = [];
    
        // Membuat semua kombinasi 'item_id' dan 'storage_id'
        foreach ($items as $item) {
            foreach ($storages as $storage) {
                $combinations[] = [
                    'item_id' => $item->id,
                    'storage_id' => $storage->id,
                ];
            }
        }
    
        // Mengacak urutan array
        shuffle($combinations);
    
        // Membuat record baru pada tabel 'ItemLocation'
        for ($i = 0; $i < 20; $i++) {
            ItemLocation::create([
                'item_id' => $combinations[$i]['item_id'],
                'storage_id' => $combinations[$i]['storage_id'],
                'quantity' => rand(1, 20),
            ]);
        }
    }
    

}
