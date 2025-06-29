<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductVariant;

class Color extends Model
{
        protected $fillable = ['name', 'hex_code'];

        public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getContrastColor()
{
    // Удаляем # если есть
    $hexColor = str_replace('#', '', $this->hex_code);

    // Конвертируем в RGB
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    // Рассчитываем яркость
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

    // Возвращаем черный или белый в зависимости от яркости фона
    return $brightness > 128 ? '#000000' : '#FFFFFF';
}
}
