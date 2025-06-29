<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::paginate(10);
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:colors',
            'hex_code' => 'required|string|size:7|starts_with:#',
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')
                       ->with('success', 'Barva byla úspěšně přidána!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:colors,name,'.$color->id,
            'hex_code' => 'required|string|size:7|starts_with:#',
        ]);

        $color->update($validated);

        return redirect()->route('admin.colors.index')
                       ->with('success', 'Barva byla úspěšně upravena!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')
                       ->with('success', 'Barva byla smazána!');
    }

}
