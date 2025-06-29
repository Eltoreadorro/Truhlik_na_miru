<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Models\ProductVariant;

class CartTable extends Component
{
    public $items = [];
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function updateCart()
    {
        $cartService = app(CartService::class);
        $this->items = $cartService->getItems();
        $this->total = $cartService->getTotal();
    }

    public function incrementQuantity($variantId)
    {
        $cartService = app(CartService::class);
        $variant = ProductVariant::find($variantId);

        if ($variant) {
            $currentQty = $this->getCurrentQuantity($variantId);
            $cartService->update($variant, $currentQty + 1);
            $this->dispatch('refreshCart');
            $this->dispatch('cartUpdated');
        }
    }

    public function decrementQuantity($variantId)
    {
        $cartService = app(CartService::class);
        $variant = ProductVariant::find($variantId);

        if ($variant) {
            $currentQty = $this->getCurrentQuantity($variantId);

            if ($currentQty > 1) {
                $cartService->update($variant, $currentQty - 1);
            } else {
                $this->removeItem($variantId);
            }

            $this->dispatch('refreshCart');
            $this->dispatch('cartUpdated');
        }
    }

    public function removeItem($variantId)
{
    $cartService = app(CartService::class);
    $variant = ProductVariant::find($variantId);

    if ($variant) {
        $cartService->remove($variant);
        $this->dispatch('cartUpdated');
        return redirect()->route('cart.index'); // Перезагрузка страницы
    }
}

    public function refreshCart()
    {
        $cartService = app(CartService::class);
        $this->items = $cartService->getItems();
        $this->total = $cartService->getTotal();
    }

    private function getCurrentQuantity($variantId): int
    {
        foreach ($this->items as $item) {
            if ($item['variant']->id == $variantId) {
                return $item['quantity'];
            }
        }
        return 0;
    }

    public function render()
    {
        return view('livewire.cart-table');
    }
}
