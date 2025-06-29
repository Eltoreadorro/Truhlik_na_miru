<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contacts()
    {
        return view('contact');
    }

    public function delivery()
    {
        $deliveryOptions = [
            [
                'icon' => 'post',
                'name' => 'Česká pošta',
                'price' => '89 Kč',
                'time' => '2-3 pracovní dny',
                'description' => 'Doručení na adresu nebo na vybranou poštu.'
            ],
            [
                'icon' => 'courier',
                'name' => 'PPL',
                'price' => '129 Kč',
                'time' => '1-2 pracovní dny',
                'description' => 'Expresní doručení poštou s možností sledování zásilky.'
            ],
            [
                'icon' => 'pickup',
                'name' => 'Osobní odběr',
                'price' => 'Zdarma',
                'time' => 'Dle domluvy',
                'description' => 'Sulicka 42, Sulice, 25168 Praha-vychod'
            ]
        ];

        $paymentMethods = [
            [
                'icon' => 'card',
                'name' => 'Platba kartou online',
                'description' => 'Bezpečná platba přes platební bránu. Zatím není dostupná.'
            ],
            [
                'icon' => 'bank',
                'name' => 'Bankovní převod',
                'description' => 'Číslo účtu: 4753073093/0800'
            ]
        ];

        return view('pages.delivery', compact('deliveryOptions', 'paymentMethods'));
    }

    public function returns()
    {
        return view('pages.returns');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
