<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->getTotal();

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(ProductVariant $variant, Request $request)
    {
        $quantity = $request->input('quantity', 1);

        if (!is_numeric($quantity) || $quantity < 1) {
            return back()->with('error', 'Некорректное количество');
        }

        $this->cartService->add($variant, $quantity);

        return redirect()->route('cart.index')
            ->with('success', 'Товар добавлен в корзину');
    }

    public function update(ProductVariant $variant, Request $request)
    {
        $quantity = $request->input('quantity');

        if (!is_numeric($quantity) || $quantity < 1) {
            return back()->with('error', 'Некорректное количество');
        }

        $this->cartService->update($variant, $quantity);

        return back()->with('success', 'Корзина обновлена');
    }

    public function remove(ProductVariant $variant)
    {
        $this->cartService->remove($variant);

        return back()->with('success', 'Товар удален из корзины');
    }
}
