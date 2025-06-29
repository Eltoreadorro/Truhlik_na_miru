<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = Category::paginate(10);
    return view('admin.categories.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.categories.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories',
        'description' => 'nullable|string',
    ]);

    // Автоматически генерируем slug из названия
    $validated['slug'] = Str::slug($validated['name']);

    Category::create($validated);

    return redirect()->route('admin.categories.index')
                   ->with('success', 'Kategorie byla úspěšně vytvořena!');
                }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                       ->with('success', 'Kategorie byla upravena!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
                       ->with('success', 'Kategorie byla smazána!');
    }
}
