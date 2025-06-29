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
        return view('cart.index');
    }

    public function add(ProductVariant $variant, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $this->cartService->add($variant, $quantity);

        return redirect()->route('cart.index')
            ->with('success', 'Produkt byl přidán do košíku');
    }

    public function remove(ProductVariant $variant)
    {
        $this->cartService->remove($variant);
        return back()->with('success', 'Produkt byl odstraněn z košíku');
    }
}
