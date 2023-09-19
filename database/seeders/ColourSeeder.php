<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colour;

class ColourSeeder extends Seeder
{
    public function run()
    {
        $colours = [
            [
                'name' => 'Blue',
                'hexcode' => '#0000FF',
            ],
            [
                'name' => 'Red',
                'hexcode' => '#FF0000',
            ],
            [
                'name' => 'Yellow',
                'hexcode' => '#FFFF00',
            ],
            [
                'name' => 'Green',
                'hexcode' => '#00FF00',
            ],
            [
                'name' => 'Purple',
                'hexcode' => '#800080',
            ],
            [
                'name' => 'White',
                'hexcode' => '#FAF8F6',
            ],
            [
                'name' => 'Orange',
                'hexcode' => '#FFA500',
            ],
            [
                'name' => 'Gray',
                'hexcode' => '#808080',
            ],
        ];

        Colour::insert($colours);
    }
}

