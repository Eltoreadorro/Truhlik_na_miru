<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductVariant::truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $colors = Color::all();
        $categories = Category::all();

        $products = [
            [
                'name' => 'Plastový truhlík 12 l',
                'price' => 557,
                'category' => 'Truhlík 12 litrů',
                'height' => 30.5,
                'width' => 25.0
            ],
            [
                'name' => 'Plastový truhlík 20 l',
                'price' => 743,
                'category' => 'Truhlík 20 litrů',
                'height' => 30.5,
                'width' => 25.0
            ],
            [
                'name' => 'Vysoký plastový truhlík 12 l',
                'price' => 1178,
                'category' => 'Vysoký truhlík 12 litrů',
                'height' => 45.0,
                'width' => 25.0
            ],
            [
                'name' => 'Vysoký plastový truhlík 20 l',
                'price' => 1195,
                'category' => 'Vysoký truhlík 20 litrů',
                'height' => 45.0,
                'width' => 25.0
            ],
            [
                'name' => 'Květináč s provázkem 12 l',
                'price' => 680,
                'category' => 'Květináč s provázkem 12 litrů',
                'height' => 30.5,
                'width' => 25.0
            ],
            [
                'name' => 'Truhlík 40 l s uchy',
                'price' => 1418,
                'category' => 'Truhlík 40 litrů s uchy',
                'height' => 40.0,
                'width' => 35.0
            ],
            [
                'name' => 'Truhlík 60 l',
                'price' => 4200,
                'category' => 'Truhlík 60 litrů',
                'height' => 50.0,
                'width' => 40.0
            ],
            [
                'name' => 'Truhlík 300 l',
                'price' => 5099,
                'category' => 'Truhlík 300 litrů',
                'height' => 80.0,
                'width' => 60.0
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            $volume = (float)filter_var($productData['category'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $product = Product::create([
                'name' => $productData['name'],
                'description' => 'Kvalitní plastový truhlík vhodný pro pěstování květin a zeleniny.',
                'category_id' => $category->id,
            ]);

            foreach ($colors as $color) {
                // Генерируем SKU только из латинских символов
                $colorCode = $this->getColorCode($color->name);
                $sku = 'TRH-'.$colorCode.'-'.$volume.'L-'.Str::random(4);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'color' => $color->hex_code,
                    'height' => $productData['height'],
                    'width' => $productData['width'],
                    'price' => $productData['price'],
                    'stock' => rand(5, 20),
                    'sku' => $sku,
                ]);
            }
        }
    }

    protected function getColorCode($colorName)
    {
        // Словарь для замены чешских символов
        $translit = [
            'á' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e',
            'í' => 'i', 'ň' => 'n', 'ó' => 'o', 'ř' => 'r', 'š' => 's',
            'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z',
            ' ' => '', '-' => ''
        ];

        // Приводим к верхнему регистру и заменяем символы
        $clean = strtr(mb_strtolower($colorName), $translit);
        return strtoupper(substr($clean, 0, 3));
    }
}
