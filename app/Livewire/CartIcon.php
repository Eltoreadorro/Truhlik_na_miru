<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;


class CartIcon extends Component
{
    protected $listeners = ['cartUpdatedGlobal' => '$refresh'];

    public function render()
    {
        $cartService = app(CartService::class);
        return view('livewire.cart-icon', [
            'cartCount' => $cartService->getCartCount()
        ]);
    }
}
