<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $topVariants = ProductVariant::with(['product.media', 'product.category', 'colorRelation'])
            ->whereHas('product', fn($q) => $q->where('category_id', 8))
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $products = Product::with(['media', 'variants.colorRelation', 'category'])
            ->whereHas('variants')
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->paginate(12);

        $categories = Category::all();

        if (request()->ajax()) {
            return view('products.load-more', compact('products'));
        }

        return view('products.index', compact('products', 'topVariants', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load([
            'media',
            'variants.media',
            'variants.colorRelation',
            'category'
        ]);

        if ($product->variants->isEmpty()) {
            abort(404, 'Product has no variants');
        }

        $similarProducts = Product::with(['media', 'variants.colorRelation', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'similarProducts' => $similarProducts,
            'selectedVariant' => $product->variants->first()
        ]);
    }

    public function loadMore(Request $request)
    {
        $products = Product::with(['media', 'variants.colorRelation', 'category'])
            ->whereHas('variants')
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->paginate(12);

        if ($request->ajax()) {
            return view('products.load-more', compact('products'));
        }

        return abort(404);
    }
}
