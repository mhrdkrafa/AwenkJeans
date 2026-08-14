<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductModelController extends Controller
{
    public function index()
    {
        $productModels = ProductModel::with('brand')->withCount('products')->latest()->get();
        return view('administrator.product-models.index', compact('productModels'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('administrator.product-models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        ProductModel::create($validated);

        return redirect()->route('administrator.product-models.index')->with('success', 'Model produk berhasil ditambahkan.');
    }

    public function edit(ProductModel $productModel)
    {
        $brands = Brand::orderBy('name')->get();
        return view('administrator.product-models.edit', compact('productModel', 'brands'));
    }

    public function update(Request $request, ProductModel $productModel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $productModel->update($validated);

        return redirect()->route('administrator.product-models.index')->with('success', 'Model produk berhasil diperbarui.');
    }

    public function destroy(ProductModel $productModel)
    {
        if ($productModel->products()->count() > 0) {
            return redirect()->route('administrator.product-models.index')->with('error', 'Model tidak bisa dihapus karena masih memiliki produk.');
        }

        $productModel->delete();

        return redirect()->route('administrator.product-models.index')->with('success', 'Model produk berhasil dihapus.');
    }
}
