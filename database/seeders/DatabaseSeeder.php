<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\StorageType;
use App\Models\Storage;
use App\Models\ItemCategory;
use App\Models\Item;
use App\Models\ItemLocation;
use App\Models\Role;
use App\Models\TodoList;
use App\Models\Colour;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StorageTypeSeeder::class,
            RolesSeeder::class,
            SuperAdminUserSeeder::class,
            AdminUserSeeder::class,
            TherapistUserSeeder::class,
            ColourSeeder::class,
            StorageSeeder::class,
            ItemCategorySeeder::class,
            ItemSeeder::class,
            ItemLocationSeeder::class,
            TodoListSeeder::class,
        ]);
    }
}
