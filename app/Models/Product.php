<?php
namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\InteractsWithMedia;
    use App\Models\Cart;
    use App\Models\ProductVariant;
    use App\Models\Category;
    use App\Models\Color;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
    use Illuminate\Support\Str;

    class Product extends Model implements HasMedia
    {
        use HasFactory, InteractsWithMedia;

        protected $fillable = [
            'name',
            'description',
            'category_id',
        ];

        public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')
             ->singleFile()
             ->useDisk('public');

        $this->addMediaCollection('gallery')
             ->useDisk('public');
    }

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function carts()
        {
            return $this->belongsToMany(Cart::class)->withPivot('quantity');
        }

        public function getColorNameAttribute()
        {
            if (Str::startsWith($this->color, '#')) {
                $color = Color::where('hex_code', $this->color)->first();
                return $color ? $color->name : $this->color;
            }
            return $this->color;
        }

        // Метод для стиля цвета
        public function getColorStyleAttribute()
        {
            if (Str::startsWith($this->color, '#')) {
                $textColor = $this->color === '#FFFFFF' ? 'black' : 'white';
                return "background: {$this->color}; color: {$textColor};";
            }
            return ''; // Для текстовых названий цветов
        }

        public function variants()
        {
            return $this->hasMany(ProductVariant::class);
        }

        public function getMainColorAttribute()
    {
        return $this->variants->first()->color ?? null;
    }

     public function getMinPriceAttribute()
    {
        return $this->variants->min('price');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(400)
            ->height(400)
            ->nonQueued();
    }

    }
