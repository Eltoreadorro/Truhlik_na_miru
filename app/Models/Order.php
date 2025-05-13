<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    protected $casts = [
        'items' => 'array'
    ];

    protected $fillable = ['user_id', 'customer_name', 'phone', 'address', 'total', 'status', 'payment_method', 'payment_status', 'deposit_amount', 'notes'];

    public function items()

{
return $this->hasMany(OrderItem::class);
}
}
