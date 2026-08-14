<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::withCount('products')->latest()->get();
        return view('administrator.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('administrator.colors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
        ]);

        Color::create($validated);

        return redirect()->route('administrator.colors.index')->with('success', 'Warna berhasil ditambahkan.');
    }

    public function edit(Color $color)
    {
        return view('administrator.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
        ]);

        $color->update($validated);

        return redirect()->route('administrator.colors.index')->with('success', 'Warna berhasil diperbarui.');
    }

    public function destroy(Color $color)
    {
        if ($color->products()->count() > 0) {
            return redirect()->route('administrator.colors.index')->with('error', 'Warna tidak bisa dihapus karena masih memiliki produk.');
        }

        $color->delete();

        return redirect()->route('administrator.colors.index')->with('success', 'Warna berhasil dihapus.');
    }
}
