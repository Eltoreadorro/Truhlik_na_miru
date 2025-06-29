<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorsTableSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Bílý', 'hex_code' => '#FFFFFF'],
            ['name' => 'Bílá bereza', 'hex_code' => '#F5F5DC'],
            ['name' => 'Bronzové', 'hex_code' => '#CD7F32'],
            ['name' => 'Světlé dřevo česání', 'hex_code' => '#E6C229'],
            ['name' => 'Dřevo česání', 'hex_code' => '#D2B48C'],
            ['name' => 'Tmavé dřevo česání', 'hex_code' => '#A0522D'],
            ['name' => 'Granitový', 'hex_code' => '#696969'],
            ['name' => 'Tmavé dřevo', 'hex_code' => '#654321'],
            ['name' => 'Venge', 'hex_code' => '#5D3954'],
            ['name' => 'Blanž', 'hex_code' => '#E6E6FA'], // Примерный код (лавандовый)
            ['name' => 'Červené dřevo', 'hex_code' => '#A52A2A'],
            ['name' => 'Šeřík', 'hex_code' => '#C8A2C8'],
            ['name' => 'Melanž', 'hex_code' => '#D3D3D3'], // Примерный код (светло-серый)
            ['name' => 'Háky', 'hex_code' => '#BDB76B'], // Примерный код (темный хаки)
            ['name' => 'Černý', 'hex_code' => '#000000'],
            ['name' => 'Tyrkysový', 'hex_code' => '#40E0D0'],
        ];

        // Используем create вместо insert для обработки каждого цвета отдельно
        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
