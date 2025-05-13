<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Middleware\Middleware;


class ProductController extends Controller
{
   public static function middleware(): array {
        return [
            'auth',
            new Middleware('role:admin'),
        ];
    }

    public function index()
    {
        $products = Product::with(['category', 'variants'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sku_prefix' => 'required|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.volume' => 'required|numeric|min:0.1',
            'variants.*.height' => 'required|numeric|min:1',
            'variants.*.width' => 'required|numeric|min:1',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.price' => 'required|numeric|min:0.01',
            'variants.*.stock' => 'required|integer|min:0'
        ]);

        // Создаем основной продукт
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'sku_prefix' => $validated['sku_prefix']
        ]);

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->update(['image' => $imagePath]);
        }

        // Создаем варианты продукта
        foreach ($validated['variants'] as $variantData) {
            $sku = $product->sku_prefix . '-' . $variantData['volume'] . 'L-' . Str::upper(substr($variantData['color'], 0, 3));

            $product->variants()->create([
                'volume' => $variantData['volume'],
                'height' => $variantData['height'],
                'width' => $variantData['width'],
                'color' => $variantData['color'],
                'price' => $variantData['price'],
                'stock' => $variantData['stock'],
                'sku' => $sku
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно добавлен!');
    }

    public function show(Product $product)
    {
        $product->load(['variants', 'category']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('variants');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sku_prefix' => 'required|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'sometimes|exists:product_variants,id',
            'variants.*.volume' => 'required|numeric|min:0.1',
            'variants.*.height' => 'required|numeric|min:1',
            'variants.*.width' => 'required|numeric|min:1',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.price' => 'required|numeric|min:0.01',
            'variants.*.stock' => 'required|integer|min:0'
        ]);

        // Обновляем основной продукт
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'sku_prefix' => $validated['sku_prefix']
        ]);

        // Обновляем изображение
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->update(['image' => $imagePath]);
        }

        // Обновляем варианты
        $existingVariantIds = $product->variants->pluck('id')->toArray();
        $updatedVariantIds = [];

        foreach ($validated['variants'] as $variantData) {
            $sku = $product->sku_prefix . '-' . $variantData['volume'] . 'L-' . Str::upper(substr($variantData['color'], 0, 3));

            if (isset($variantData['id'])) {
                // Обновляем существующий вариант
                $variant = $product->variants()->find($variantData['id']);
                $variant->update([
                    'volume' => $variantData['volume'],
                    'height' => $variantData['height'],
                    'width' => $variantData['width'],
                    'color' => $variantData['color'],
                    'price' => $variantData['price'],
                    'stock' => $variantData['stock'],
                    'sku' => $sku
                ]);
                $updatedVariantIds[] = $variantData['id'];
            } else {
                // Создаем новый вариант
                $product->variants()->create([
                    'volume' => $variantData['volume'],
                    'height' => $variantData['height'],
                    'width' => $variantData['width'],
                    'color' => $variantData['color'],
                    'price' => $variantData['price'],
                    'stock' => $variantData['stock'],
                    'sku' => $sku
                ]);
            }
        }

        // Удаляем варианты, которых нет в обновленных данных
        $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
        if (!empty($variantsToDelete)) {
            $product->variants()->whereIn('id', $variantsToDelete)->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен!');
    }

    public function destroy(Product $product)
    {
        // Удаляем изображение
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Удаляем продукт и связанные варианты (каскадное удаление)
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален!');
    }
}
