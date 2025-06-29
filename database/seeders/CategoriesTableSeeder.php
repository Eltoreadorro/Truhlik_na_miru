<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Truhlík 12 litrů',
                'slug' => 'truhlik-12l',
                'description' => 'Kvalitní plastový truhlík o objemu 12 litrů'
            ],
            [
                'name' => 'Truhlík 20 litrů',
                'slug' => 'truhlik-20l',
                'description' => 'Kvalitní plastový truhlík o objemu 20 litrů'
            ],
            [
                'name' => 'Vysoký truhlík 12 litrů',
                'slug' => 'vysoky-truhlik-12l',
                'description' => 'Vysoký plastový truhlík o objemu 12 litrů'
            ],
            [
                'name' => 'Vysoký truhlík 20 litrů',
                'slug' => 'vysoky-truhlik-20l',
                'description' => 'Vysoký plastový truhlík o objemu 20 litrů'
            ],
            [
                'name' => 'Květináč s provázkem 12 litrů',
                'slug' => 'kvetinac-s-provazkem-12l',
                'description' => 'Květináč s praktickým provázkem pro snadné přenášení'
            ],
            [
                'name' => 'Truhlík 40 litrů s uchy',
                'slug' => 'truhlik-40l-s-uchy',
                'description' => 'Velký truhlík s uchy pro snadnou manipulaci'
            ],
            [
                'name' => 'Truhlík 60 litrů',
                'slug' => 'truhlik-60l',
                'description' => 'Extra velký truhlík pro náročné pěstitele'
            ],
            [
                'name' => 'Truhlík 300 litrů',
                'slug' => 'truhlik-300l',
                'description' => 'Profesionální truhlík pro komerční využití'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
