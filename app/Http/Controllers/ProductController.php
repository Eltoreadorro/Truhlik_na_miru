<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::with(['variants', 'category'])
        ->whereHas('variants')
        ->paginate(12);

    return view('products.index', compact('products'));
}

public function show(Product $product)
{
    $product->load(['variants', 'category']);

    $similarProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->with(['variants', 'category'])
        ->take(4)
        ->get();

    return view('products.show', compact('product', 'similarProducts'));
}

public function loadMore(Request $request)
{
    $products = Product::with(['variants', 'category'])
        ->whereHas('variants')
        ->paginate(12);

    if ($request->ajax()) {
        return view('products.load-more', compact('products'))->render();
    }

    return abort(404);
}
}
