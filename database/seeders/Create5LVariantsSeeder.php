<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Create5LVariantsSeeder extends Seeder
{
    public function run()
    {
        // Находим 5-литровый продукт
        $product5L = Product::where('name', 'LIKE', '%5%')->first();

        if (!$product5L) {
            $this->command->error('5-литровый продукт не найден!');
            return;
        }

        $this->command->info("Найден продукт: {$product5L->name} (ID: {$product5L->id})");

        // Проверяем, есть ли уже варианты
        $existingVariants = ProductVariant::where('product_id', $product5L->id)->count();
        if ($existingVariants > 0) {
            $this->command->info("У продукта уже есть {$existingVariants} вариантов. Пропускаем...");
            return;
        }

        // Получаем все цвета
        $colors = Color::all();

        if ($colors->isEmpty()) {
            $this->command->error('Цвета не найдены в таблице colors!');
            return;
        }

        $this->command->info("Найдено {$colors->count()} цветов");

        // Характеристики для 5-литрового продукта
        $specs = [
            'height' => 19,
            'width' => 30,
            'price' => 950,
        ];

        // Создаем варианты для каждого цвета
        foreach ($colors as $color) {
            $sku = 'SKU-' . strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(6));

            ProductVariant::create([
                'product_id' => $product5L->id,
                'color' => $color->hex_code,
                'height' => $specs['height'],
                'width' => $specs['width'],
                'price' => $specs['price'],
                'stock' => rand(5, 20),
                'sku' => $sku,
            ]);

            $this->command->info("Создан вариант: {$color->name} ({$color->hex_code}) - SKU: {$sku}");
        }

        $this->command->info("Создано " . $colors->count() . " вариантов для продукта '{$product5L->name}'");
    }
}
