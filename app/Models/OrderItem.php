<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\ProductVariant;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price'
        ];

        public function order()

        {

        return $this->belongsTo(Order::class);

        }

        public function variant()

        {

        return $this->belongsTo(ProductVariant::class, 'product_variant_id');

        }

        public function getDisplayAttributes()
{
    return [
        'product_name' => $this->variant->product->name,
        'color_name' => $this->variant->color_data->name,
        'color_hex' => $this->variant->color_data->hex_code,
        'contrast_color' => $this->variant->color_data->contrast_color,
        'dimensions' => $this->variant->formatted_dimensions,
        'quantity' => $this->quantity,
        'price' => $this->price,
        'image_url' => $this->variant->getFirstMediaUrl('variants', 'thumb'),
        'total' => $this->price * $this->quantity
    ];
}

        }
