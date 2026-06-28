<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'size'])
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,qris',
        ]);

        return DB::transaction(function () use ($request) {
            $items = $request->input('items', []);
            $paymentMethod = $request->input('payment_method');

            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'user_id' => Auth::id(),
                'customer_name' => $request->input('customer_name'),
                'total_price' => 0, // Will be updated
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'cash' ? 'paid' : 'pending',
            ]);

            $totalPrice = 0;

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item['id']);
                
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi.");
                }

                $subtotal = $product->price * $item['qty'];
                $totalPrice += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['qty']);

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['qty'],
                    'description' => "Penjualan: {$transaction->invoice_number}",
                    'reference_id' => $transaction->id,
                ]);
            }

            $transaction->update(['total_price' => $totalPrice]);

            if ($paymentMethod === 'qris') {
                // Midtrans integration would happen here
                // return response with snap_token
            }

            return redirect()->route('pos.index')->with('success', 'Transaksi berhasil disimpan.');
        });
    }
}
