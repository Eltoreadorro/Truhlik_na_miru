<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductVariantController extends Controller
{
    public function index(Product $product)
{
    $variants = $product->variants()->with(['media'])->paginate(10); // Только media
    return view('admin.products.variants.index', compact('product', 'variants'));
}

    public function create(Product $product)
    {
        $colors = Color::all();
        return view('admin.products.variants.create', compact('product', 'colors'));
    }

    public function store(Request $request, Product $product)
{
    \DB::listen(function($query) {
    \Log::debug($query->sql, $query->bindings);
});
    // Добавим логирование входных данных
    Log::debug('Variant creation input data:', $request->all());

    $validated = $request->validate([
        'color' => 'required|string|max:255',
        'height' => 'nullable|numeric|min:0',
        'width' => 'nullable|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    // Генерация SKU
    $validated['sku'] = 'SKU-'.strtoupper(substr($product->name, 0, 3)).'-'.Str::random(6);

    DB::beginTransaction();
    try {
        Log::debug('Attempting to create variant with data:', $validated);

        $variant = $product->variants()->create($validated);
        Log::debug('Variant created:', ['id' => $variant->id]);

        if ($request->hasFile('image')) {
            Log::debug('Processing image upload');
            $variant->addMedia($request->file('image'))
                   ->usingFileName('variant_'.$variant->id.'_'.time().'.'.$request->file('image')->extension())
                   ->toMediaCollection('variants', 'public');
            Log::debug('Image uploaded successfully');
        }

        DB::commit();
        Log::info('Variant created successfully', ['variant_id' => $variant->id]);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant was successfully added');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Variant creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all()
        ]);
        return back()->withInput()->with('error', 'Error: '.$e->getMessage());
    }
}

    public function show(Product $product, ProductVariant $variant)
{
    return view('admin.products.variants.show', compact('product', 'variant'));
}

    public function edit(Product $product, ProductVariant $variant)
    {
        $colors = Color::all();
        return view('admin.products.variants.edit', compact('product', 'variant', 'colors'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'color' => 'required|string|max:255',
            'height' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_image' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        try {
            $variant->update($validated);

            if ($request->has('delete_image') && $request->delete_image) {
                $variant->clearMediaCollection('variants');
            }

            if ($request->hasFile('image')) {
                $variant->clearMediaCollection('variants');
                $variant->addMedia($request->file('image'))
                       ->usingFileName('variant_'.$variant->id.'_'.time().'.'.$request->file('image')->extension())
                       ->toMediaCollection('variants', 'public');
            }

            DB::commit();
            return redirect()->route('admin.products.variants.index', $product)
                ->with('success', 'Variant was successfully updated');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Variant update failed', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        DB::beginTransaction();
        try {
            $variant->media()->delete();
            $variant->delete();

            DB::commit();
            return redirect()->route('admin.products.variants.index', $product)
                ->with('success', 'Variant was successfully deleted');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }
}
