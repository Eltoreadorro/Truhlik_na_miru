<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Cart;
use App\Models\ProductVariant;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'sku'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')->singleFile();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
{
    return $this->belongsToMany(Cart::class)->withPivot('quantity');
}

public function variants()

{

return $this->hasMany(ProductVariant::class);

}
}
