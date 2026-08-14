<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('administrator.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('administrator.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']) ?: Str::random(6);

        Brand::create($validated);

        return redirect()->route('administrator.brands.index')->with('success', 'Merek berhasil ditambahkan.');
    }

    public function edit(Brand $brand)
    {
        return view('administrator.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']) ?: Str::random(6);

        $brand->update($validated);

        return redirect()->route('administrator.brands.index')->with('success', 'Merek berhasil diperbarui.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return redirect()->route('administrator.brands.index')->with('error', 'Merek tidak bisa dihapus karena masih memiliki produk.');
        }

        $brand->delete();

        return redirect()->route('administrator.brands.index')->with('success', 'Merek berhasil dihapus.');
    }
}
