<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $allProducts = Product::with(['category', 'size', 'brandRelation', 'modelRelation', 'colorRelation'])->latest()->get();

        // Group products by name + category_id
        $grouped = $allProducts->groupBy(function ($product) {
            return $product->name . '|' . $product->category_id;
        });

        $groupedProducts = $grouped->map(function ($variants) {
            $representative = $variants->firstWhere('image', '!=', null) ?? $variants->first();
            $representative->total_stock = $variants->sum('stock');
            $representative->all_variants = $variants->map(function ($v) {
                return [
                    'id' => $v->id,
                    'size_name' => $v->size->name ?? '-',
                    'size_id' => $v->size_id,
                    'stock' => $v->stock,
                    'min_stock' => $v->min_stock,
                    'price' => $v->price,
                ];
            })->values()->toArray();
            $representative->available_sizes = $variants->map(function ($v) {
                return $v->size->name ?? '-';
            })->unique()->sort()->values()->toArray();
            $representative->variant_count = $variants->count();
            return $representative;
        })->values();

        // Manual pagination
        $page = request()->input('page', 1);
        $perPage = 10;
        $total = $groupedProducts->count();
        $items = $groupedProducts->slice(($page - 1) * $perPage, $perPage)->values();
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $perPage, $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $productStats = [
            'total' => $grouped->count(),
            'active' => $grouped->filter(fn ($variants) => $variants->sum('stock') > 0)->count(),
            'low_stock' => $grouped->filter(fn ($variants) => $variants->contains(fn ($v) => $v->stock > 0 && $v->stock <= $v->min_stock))->count(),
            'out_of_stock' => $grouped->filter(fn ($variants) => $variants->sum('stock') <= 0)->count(),
        ];

        return view('administrator.products.index', compact('products', 'productStats'));
    }

    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $brands = Brand::all();
        $models = ProductModel::all();
        $colors = Color::all();
        return view('administrator.products.create', compact('categories', 'sizes', 'brands', 'models', 'colors'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['stock'] = 0;
        $data['min_stock'] = 0;

        Product::create($data);

        return redirect()->route('administrator.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $product = Product::with(['category', 'size', 'brandRelation', 'modelRelation', 'colorRelation'])->findOrFail($id);
        return view('administrator.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();
        $brands = Brand::all();
        $models = ProductModel::all();
        $colors = Color::all();
        return view('administrator.products.edit', compact('product', 'categories', 'sizes', 'brands', 'models', 'colors'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $this->validateProduct($request, $product->id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
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

        // Jangan update stock dan min_stock — itu dikelola karyawan di manajemen stok
        unset($data['stock'], $data['min_stock']);

        $product->update($data);

        return redirect()->route('administrator.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete image file if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('administrator.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'nullable|exists:sizes,id',
            'brand_id' => 'nullable|exists:brands,id',
            'model_id' => 'nullable|exists:product_models,id',
            'color_id' => 'nullable|exists:colors,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gender' => 'nullable|in:pria,wanita,unisex',
        ]);

        // Populate text fields from selected entities
        if (!empty($validated['brand_id'])) {
            $b = Brand::find($validated['brand_id']);
            $validated['brand'] = $b ? $b->name : null;
        } else {
            $validated['brand'] = null;
        }

        if (!empty($validated['model_id'])) {
            $m = ProductModel::find($validated['model_id']);
            $validated['model'] = $m ? $m->name : null;
        } else {
            $validated['model'] = null;
        }

        if (!empty($validated['color_id'])) {
            $c = Color::find($validated['color_id']);
            $validated['color'] = $c ? $c->name : null;
        } else {
            $validated['color'] = null;
        }

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

        return $validated;
    }
}
