<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartCounter extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render(CartService $cart)
    {
        return view('livewire.cart-counter', [
            'count' => count($cart->getItems()),
            'total' => $cart->getTotal()
        ]);
    }
}
