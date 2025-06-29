<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;

class HomeController extends Controller
{
    public function index()
{
    $featuredVariants = ProductVariant::with([
        'product.media', // Загружаем медиа продукта
        'product.category',
        'colorRelation'
    ])
    ->inRandomOrder()
    ->take(8)
    ->get();

    return view('home', [
        'featuredProducts' => $featuredVariants
    ]);
}
}
