<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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

        return view('karyawan.products.index', compact('products', 'productStats'));
    }

    public function show(string $id)
    {
        $product = Product::with(['category', 'size', 'brandRelation', 'modelRelation', 'colorRelation'])->findOrFail($id);
        return view('karyawan.products.show', compact('product'));
    }
}
