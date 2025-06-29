<?php

namespace App\Services;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function add(ProductVariant $variant, int $quantity = 1): void
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity'] += $quantity;
        } else {
            $cart[$variant->id] = [
                'variant_id' => $variant->id,
                'quantity' => $quantity,
                'price' => $variant->price,
                'variant_data' => $variant->toArray()
            ];
        }

        Session::put('cart', $cart);
    }

    public function remove(ProductVariant $variant): void
    {
        $cart = Session::get('cart', []);

    if (array_key_exists($variant->id, $cart)) {
        unset($cart[$variant->id]);
        Session::put('cart', $cart);
        Session::save(); // Явное сохранение сессии
    }
    }

    public function update(ProductVariant $variant, int $quantity): void
    {
        $cart = Session::get('cart', []);

        if ($quantity <= 0) {
            $this->remove($variant);
            return;
        }

        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
    }

    public function getItems(): array
    {
        $cart = Session::get('cart', []);
        $items = [];

        foreach ($cart as $item) {
            $variant = ProductVariant::with('product')->find($item['variant_id']);
            if ($variant) {
                $items[] = [
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];
            }
        }

        return $items;
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCartCount(): int
    {
        $count = 0;
        $cart = Session::get('cart', []);

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    public function clear(): void
    {
        Session::forget('cart');
    }

    public function getItemsWithDetails(): array
{
    $items = [];
    $cart = Session::get('cart', []);

    foreach ($cart as $item) {
        $variant = ProductVariant::with('product')->find($item['variant_id']);
        if ($variant) {
            $items[] = [
                'variant_id' => $variant->id,
                'variant' => [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'volume' => $variant->volume,
                    'color' => $variant->color,
                    'product' => [
                        'id' => $variant->product->id,
                        'name' => $variant->product->name,
                        // добавьте другие необходимые поля продукта
                    ]
                ],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
        }
    }

    return $items;
}

public function getCartItemsWithDetails(): array
{
    $items = [];
    $cart = Session::get('cart', []);

    foreach ($cart as $item) {
        $variant = ProductVariant::with(['product', 'media'])->find($item['variant_id']);
        if ($variant) {
            $items[] = [
                'variant' => $variant,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'image_url' => $variant->getFirstMediaUrl('variants', 'thumb'),
                'color_name' => $variant->color_data->name,
                'color_hex' => $variant->color_data->hex_code,
                'dimensions' => $variant->formatted_dimensions
            ];
        }
    }

    return $items;
}
}
