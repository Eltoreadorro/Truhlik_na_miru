<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'email',
        'address',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'deposit_amount',
        'notes',
        'delivery_method',
        'tracking_number',
        'estimated_delivery_date',
        'variable_symbol',
        'ip_address',
        'user_agent',
        'tracking_number',
    'estimated_delivery_date',
    'delivery_service',
    ];

    protected $casts = [
        'total' => 'float',
        'deposit_amount' => 'float',
        'estimated_delivery_date' => 'date',
    ];

    protected $appends = ['status_text'];
    // Статусы заказов
    public const STATUS_NEW = 'new';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_READY = 'ready';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'Nová objednávka',
            self::STATUS_PROCESSING => 'Zpracovává se',
            self::STATUS_READY => 'Připraveno k odeslání',
            self::STATUS_SHIPPED => 'Odesláno',
            self::STATUS_DELIVERED => 'Doručeno',
            self::STATUS_CANCELLED => 'Zrušeno'
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            self::STATUS_NEW => 'bg-blue-100 text-blue-800',
            self::STATUS_PROCESSING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_READY => 'bg-purple-100 text-purple-800',
            self::STATUS_SHIPPED => 'bg-indigo-100 text-indigo-800',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusTextAttribute()
{
    return match($this->status) {
        self::STATUS_NEW => 'Nová objednávka',
        self::STATUS_PROCESSING => 'Zpracovává se',
        self::STATUS_READY => 'Připraveno k odeslání',
        self::STATUS_SHIPPED => 'Odesláno',
        self::STATUS_DELIVERED => 'Doručeno',
        self::STATUS_CANCELLED => 'Zrušeno',
        default => 'Neznámý stav'
    };
}

public function getFormattedDeliveryInfoAttribute()
{
    return [
        'service' => $this->delivery_service ?? 'Nespecifikováno',
        'method' => $this->delivery_method === 'courier' ? 'Doručení poštou' : 'Osobní odběr',
        'tracking_number' => $this->tracking_number,
        'estimated_date' => $this->estimated_delivery_date?->format('d.m.Y') ?? 'do 3 pracovních dnů',
        'address' => $this->delivery_method === 'courier' ? $this->address : config('app.pickup_address')
    ];
}

public function getItemsSummaryAttribute()
{
    return $this->items->map(function($item) {
        return [
            'name' => $item->variant->product->name,
            'variant' => $item->variant->formatted_dimensions,
            'quantity' => $item->quantity,
            'price' => number_format($item->price, 2) . ' Kč',
            'total' => number_format($item->price * $item->quantity, 2) . ' Kč'
        ];
    });
}

public function getPaymentInfoAttribute()
{
    return [
        'method' => $this->payment_method === 'full_prepayment' ? 'Plná předplatba' : 'Částečná předplatba',
        'status' => $this->payment_status,
        'variable_symbol' => $this->variable_symbol,
        'total' => number_format($this->total, 2) . ' Kč',
        'deposit' => $this->deposit_amount > 0 ? number_format($this->deposit_amount, 2) . ' Kč' : null
    ];
}

public function statusHistory()
{
    return $this->hasMany(OrderStatusHistory::class)->latest();
}

public function getCancellationReasonAttribute()
{
    return $this->seller_comment ?? 'Zrušeno bez uvedení důvodu';
}
}
