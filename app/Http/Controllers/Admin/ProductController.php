<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Middleware\Middleware;
use App\Models\Category;

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
        $products = Product::with(['category', 'media'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        return view('admin.products.create', compact('categories', 'colors'));
    }

    public function store(Request $request)
{
    // Временный лог для отладки
    Log::info('Product store request data:', $request->all());
    Log::info('Files in request:', [
        'main_image' => $request->hasFile('main_image'),
        'gallery_images' => $request->hasFile('gallery_images')
            ? count($request->file('gallery_images'))
            : 0
    ]);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'gallery_images' => 'nullable|array',
        'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    DB::beginTransaction();
    try {
        $product = Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
        ]);

        Log::info('Product created:', ['id' => $product->id]);

        // Главное изображение
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $product->addMedia($mainImage)
                   ->usingName('main_'.$product->id)
                   ->usingFileName('product_'.$product->id.'_main.'.$mainImage->extension())
                   ->toMediaCollection('main', 'public');
            Log::info('Main image uploaded');
        }

        // Галерея изображений
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $key => $image) {
                $product->addMedia($image)
                       ->usingName('gallery_'.$product->id.'_'.$key)
                       ->usingFileName('product_'.$product->id.'_gallery_'.$key.'.'.$image->extension())
                       ->toMediaCollection('gallery', 'public');
            }
            Log::info('Gallery images uploaded: '.count($request->file('gallery_images')));
        }

        DB::commit();
        Log::info('Product created successfully');

        return redirect()->route('admin.products.index')
            ->with('success', 'Product was successfully created');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Product creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all()
        ]);

        return back()->withInput()
            ->with('error', 'Product creation failed: '.$e->getMessage());
    }
}

    public function show(Product $product)
{
    $product->load(['variants', 'category', 'media']); // Убрали color
    return view('admin.products.show', compact('product'));
}

    public function edit(Product $product)
{
    $categories = Category::all();
    $colors = Color::all(); // Оставляем для выбора цветов в форме
    $product->load(['variants', 'media']);
    return view('admin.products.edit', compact('product', 'categories', 'colors'));
}

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'delete_media' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            $product->update($validated);

            // Update main image
            if ($request->hasFile('main_image')) {
                $product->clearMediaCollection('main');
                $product->addMedia($request->file('main_image'))
                       ->usingFileName('product_'.$product->id.'_main.'.$request->file('main_image')->extension())
                       ->toMediaCollection('main', 'public');
            }

            // Add new gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $key => $image) {
                    $product->addMedia($image)
                           ->usingFileName('product_'.$product->id.'_gallery_'.$key.'.'.$image->extension())
                           ->toMediaCollection('gallery', 'public');
                }
            }

            // Delete marked images
            if ($request->has('delete_media')) {
                Media::whereIn('id', $request->delete_media)->delete();
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product was successfully updated');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->media()->delete();
            $product->variants()->each(function($variant) {
                $variant->media()->delete();
                $variant->delete();
            });
            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product was successfully deleted');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }
}
