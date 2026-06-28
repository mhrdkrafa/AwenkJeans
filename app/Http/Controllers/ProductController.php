<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'size'])->paginate(10);
        $productStats = [
            'total' => Product::count(),
            'active' => Product::where('stock', '>', 0)->count(),
            'low_stock' => Product::whereColumn('stock', '<=', 'min_stock')->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
        ];

        return view('products.index', compact('products', 'productStats'));
    }

    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('products.create', compact('categories', 'sizes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $product = Product::with(['category', 'size'])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();

        return view('products.edit', compact('product', 'categories', 'sizes'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $this->validateProduct($request, $product->id);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle image removal
        if ($request->boolean('remove_image') && !$request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = null;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'nullable|exists:sizes,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Remove 'image' from validated since we handle it separately
        unset($validated['image']);

        $slug = Str::slug($validated['name']);
        $suffix = 1;
        $baseSlug = $slug;

        while (
            Product::where('slug', $slug)
                ->when($productId, fn ($query) => $query->where('id', '!=', $productId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        $validated['slug'] = $slug;
        $validated['min_stock'] = $validated['min_stock'] ?? 5;

        return $validated;
    }
}
