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
                'variant_id' => $variant->id, // Явно указываем variant_id
                'quantity' => $quantity,
                'price' => $variant->price
            ];
        }

        Session::put('cart', $cart);
    }

    public function update(ProductVariant $variant, int $quantity): void
    {
        $cart = Session::get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$variant->id]);
        } else {
            $cart[$variant->id]['quantity'] = $quantity;
        }

        Session::put('cart', $cart);
    }

    public function remove(ProductVariant $variant): void
    {
        $cart = Session::get('cart', []);
        unset($cart[$variant->id]);
        Session::put('cart', $cart);
    }

    public function getTotal(): float
    {
        $total = 0;
        $cart = Session::get('cart', []);

        foreach ($cart as $item) {
            if (isset($item['price'], $item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        return (float) $total;
    }

    public function getItems(): array
    {
        $cart = Session::get('cart', []);
        $items = [];

        foreach ($cart as $item) {
            if (!isset($item['variant_id'])) {
                continue;
            }

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

    public function clear(): void
    {
        Session::forget('cart');
    }

    public function getCartCount(): int
    {
        $count = 0;
        $cart = Session::get('cart', []);

        foreach ($cart as $item) {
            $count += $item['quantity'] ?? 0;
        }

        return $count;
    }
}
