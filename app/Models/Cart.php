<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;

class CartService
{
    public function add(Product $product, int $qty = 1): void
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'product' => $product,
                'qty' => $qty,
                'price' => $product->price
            ];
        }

        session()->put('cart', $cart);
    }

    public function update(int $productId, int $qty): void
    {
        $cart = session()->get('cart');

        if ($qty <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['qty'] = $qty;
        }

        session()->put('cart', $cart);
    }

    public function remove(int $productId): void
    {
        $cart = session()->get('cart');
        unset($cart[$productId]);
        session()->put('cart', $cart);
    }

    public function getTotal(): float
    {
        return collect(session('cart'))->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    public function variants()
{
    return $this->belongsToMany(ProductVariant::class)
        ->withPivot('quantity');
}

}
