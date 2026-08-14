<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'size'])->orderBy('stock', 'asc')->paginate(15);
        $totalStock = Product::sum('stock');
        $lowStockCount = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        return view('karyawan.stock.index', compact('products', 'totalStock', 'lowStockCount', 'outOfStockCount'));
    }

    public function create()
    {
        $products = Product::with(['category', 'size'])->orderBy('name')->get();
        return view('karyawan.stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
            'min_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi.'])->withInput();
        }

        if ($validated['type'] === 'in') {
            $product->increment('stock', $validated['quantity']);
        } else {
            $product->decrement('stock', $validated['quantity']);
        }

        if (array_key_exists('min_stock', $validated) && $validated['min_stock'] !== null) {
            $product->min_stock = $validated['min_stock'];
            $product->save();
        }

        $product->refresh();

        StockMovement::create([
            'product_id' => $validated['product_id'],
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'] ?? ($validated['type'] === 'in' ? 'Restock manual' : 'Pengeluaran stok manual'),
            'stock_after' => $product->stock,
        ]);

        return redirect()->route('karyawan.stock.index')->with('success', 'Pergerakan stok berhasil dicatat.');
    }

    public function movements()
    {
        $movements = StockMovement::with(['product', 'user'])->latest()->paginate(20);
        return view('karyawan.stock.movements', compact('movements'));
    }
}
