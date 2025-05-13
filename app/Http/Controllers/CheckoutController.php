<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'payment_method' => 'required|in:online,qr,cash'
        ]);

        $order = Order::create($validated + [
            'total' => array_reduce($cart, fn($carry, $item) =>
                $carry + ($item['variant']['price'] * $item['quantity']), 0),
            'status' => 'new'
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item['variant']['id'],
                'quantity' => $item['quantity'],
                'price' => $item['variant']['price']
            ]);
        }

        session()->forget('cart');
        return redirect()->route('order.success', $order);
    }
}
