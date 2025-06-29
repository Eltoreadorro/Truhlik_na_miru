<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsUpdateSeeder extends Seeder
{
    public function run()
    {
        $colors = Color::all();
        $categories = Category::all();

        // Новое описание для всех продуктов
        $newDescription = 'Truhlik z eko ratanu pro vaší pokojové rostliny, zahradu, kanceláře atd.';

        // Данные для обновления продуктов (volume => [height, width, price])
        $productSpecs = [
            5 => ['height' => 19, 'width' => 30, 'price' => 950],
            12 => ['height' => 26, 'width' => 41, 'price' => 1600],
            20 => ['height' => 30, 'width' => 45, 'price' => 1900],
            '12_high' => ['height' => 47, 'width' => 41, 'price' => 2400], // Высокий 12л
            '20_high' => ['height' => 60, 'width' => 45, 'price' => 2800], // Высокий 20л
            '12_rope' => ['height' => 26, 'width' => 41, 'price' => 1850], // С веревочкой 12л
            40 => ['height' => 35, 'width' => 45, 'price' => 3200],
            60 => ['height' => 34, 'width' => 60, 'price' => 4200],
            300 => ['height' => 92, 'width' => 80, 'price' => 9499],
        ];

        // Обновляем описание всех продуктов
        Product::query()->update(['description' => $newDescription]);

        // Создаем продукт для 5 литров если его нет
        $product5L = Product::where('name', 'LIKE', '%5%')->first();
        if (!$product5L) {
            $category5L = $categories->firstWhere('name', 'LIKE', '%5%')
                ?? $categories->first(); // Fallback к первой категории если нет подходящей

            $product5L = Product::create([
                'name' => 'Plastový truhlík 5 l',
                'description' => $newDescription,
                'category_id' => $category5L->id,
            ]);

            // Создаем варианты для 5-литрового продукта
            foreach ($colors as $color) {
                $colorCode = $this->getColorCode($color->name);
                $sku = 'SKU-' . strtoupper(substr($product5L->name, 0, 3)) . '-' . Str::random(6);

                ProductVariant::create([
                    'product_id' => $product5L->id,
                    'color' => $color->hex_code,
                    'height' => $productSpecs[5]['height'],
                    'width' => $productSpecs[5]['width'],
                    'price' => $productSpecs[5]['price'],
                    'stock' => rand(5, 20),
                    'sku' => $sku,
                ]);
            }
        }

        // Обновляем существующие варианты продуктов
        $this->updateProductVariants($productSpecs);
    }

    private function updateProductVariants($productSpecs)
    {
        // Обновляем обычные 12л
        $this->updateVariantsByProductName('12', $productSpecs[12], ['высокий', 'high', 'провазек', 'rope', 'веревочк']);

        // Обновляем обычные 20л
        $this->updateVariantsByProductName('20', $productSpecs[20], ['высокий', 'high']);

        // Обновляем высокие 12л
        $this->updateVariantsByProductName(['12', 'высокий'], $productSpecs['12_high']);
        $this->updateVariantsByProductName(['12', 'high'], $productSpecs['12_high']);

        // Обновляем высокие 20л
        $this->updateVariantsByProductName(['20', 'высокий'], $productSpecs['20_high']);
        $this->updateVariantsByProductName(['20', 'high'], $productSpecs['20_high']);

        // Обновляем с веревочкой 12л
        $this->updateVariantsByProductName(['12', 'провазек'], $productSpecs['12_rope']);
        $this->updateVariantsByProductName(['12', 'rope'], $productSpecs['12_rope']);
        $this->updateVariantsByProductName(['12', 'веревочк'], $productSpecs['12_rope']);

        // Обновляем 40л
        $this->updateVariantsByProductName('40', $productSpecs[40]);

        // Обновляем 60л
        $this->updateVariantsByProductName('60', $productSpecs[60]);

        // Обновляем 300л
        $this->updateVariantsByProductName('300', $productSpecs[300]);
    }

    private function updateVariantsByProductName($namePattern, $specs, $excludePatterns = [])
    {
        $query = Product::query();

        if (is_array($namePattern)) {
            // Если передан массив, ищем продукты содержащие ВСЕ элементы
            foreach ($namePattern as $pattern) {
                $query->where('name', 'LIKE', "%{$pattern}%");
            }
        } else {
            // Если передана строка, ищем продукты содержащие эту строку
            $query->where('name', 'LIKE', "%{$namePattern}%");
        }

        $products = $query->get();

        foreach ($products as $product) {
            // Проверяем исключения
            $shouldExclude = false;
            foreach ($excludePatterns as $excludePattern) {
                if (stripos($product->name, $excludePattern) !== false) {
                    $shouldExclude = true;
                    break;
                }
            }

            if ($shouldExclude) {
                continue;
            }

            // Обновляем все варианты этого продукта
            ProductVariant::where('product_id', $product->id)->update([
                'height' => $specs['height'],
                'width' => $specs['width'],
                'price' => $specs['price'],
            ]);

            // Регенерируем SKU для всех вариантов
            $variants = ProductVariant::where('product_id', $product->id)->get();
            foreach ($variants as $variant) {
                $variant->update([
                    'sku' => 'SKU-' . strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(6))
                ]);
            }
        }
}
}
