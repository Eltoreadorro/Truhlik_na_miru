<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'method', // или 'payment_method' в зависимости от структуры таблицы
        'status',
        'transaction_id',
        'variable_symbol',
        'details'
    ];

    protected $casts = [
        'amount' => 'float',
        'details' => 'array'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
