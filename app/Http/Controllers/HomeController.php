<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class HomeController extends Controller
{
public function index()
{
    $featuredProducts = Product::with(['variants', 'category'])
        ->whereHas('variants')
        ->take(6)
        ->get();

    return view('home', compact('featuredProducts'));
}
}
