<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductVariant extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $fillable = [
        'product_id',
        'height',
        'width',
        'color', // Это строка (HEX код)
        'price',
        'stock',
        'sku'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('variants')
             ->singleFile()
             ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(500)
            ->height(500)
            ->nonQueued();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Отношение к цвету через таблицу colors
    public function colorRelation()
    {
        return $this->belongsTo(Color::class, 'color', 'hex_code');
    }

    // Метод для получения данных цвета
    public function getColorDataAttribute()
    {
        // Если есть связь с таблицей цветов
        if ($this->colorRelation) {
            return (object)[
                'name' => $this->colorRelation->name,
                'hex_code' => $this->colorRelation->hex_code,
                'contrast_color' => $this->getContrastColor($this->colorRelation->hex_code)
            ];
        }

        // Для обратной совместимости с HEX кодами
        return (object)[
            'name' => $this->color,
            'hex_code' => $this->color,
            'contrast_color' => $this->getContrastColor($this->color)
        ];
    }

    public static function getContrastColor($hexColor)
    {
        if (!preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $hexColor)) {
            return '#ffffff';
        }

        $hexColor = str_replace('#', '', $hexColor);
        if (strlen($hexColor) === 3) {
            $hexColor = $hexColor[0].$hexColor[0].$hexColor[1].$hexColor[1].$hexColor[2].$hexColor[2];
        }

        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

        return $brightness > 128 ? '#000000' : '#ffffff';
    }

    // Форматированные размеры
    public function getFormattedDimensionsAttribute()
    {
        if ($this->height && $this->width) {
            return $this->height.'×'.$this->width.' cm';
        }
        return null;
    }

    // Форматированная цена
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2).' Kč';
    }

    // URL изображения
    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('variants');
    }

    // URL thumbnail
    public function getThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('variants', 'thumb');
    }
}
