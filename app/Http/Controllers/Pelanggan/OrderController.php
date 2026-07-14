<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pembelian pelanggan.
     */
    public function index()
    {
        $userPhone = Auth::user()->phone;

        $transactions = Transaction::with(['details.product.category', 'details.product.size', 'cashier'])
            ->where(function($query) use ($userPhone) {
                $query->where('pelanggan_id', Auth::id());
                
                if (!empty($userPhone)) {
                    $query->orWhere(function($subQuery) use ($userPhone) {
                        $subQuery->whereNull('pelanggan_id')
                                 ->where('customer_phone', $userPhone);
                    });
                }
            })
            ->where('payment_status', 'paid')
            ->latest()
            ->paginate(5);

        return view('pelanggan.orders.index', compact('transactions'));
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(Transaction $transaction)
    {
        // Pastikan transaksi milik pelanggan yang sedang login (via pelanggan_id atau nomor telepon guest)
        $userPhone = Auth::user()->phone;
        $isOwner = $transaction->pelanggan_id === Auth::id() || 
                   ($transaction->pelanggan_id === null && !empty($userPhone) && $transaction->customer_phone === $userPhone);

        if (!$isOwner) {
            abort(403, 'Unauthorized.');
        }

        $transaction->load(['details.product.category', 'details.product.size', 'cashier', 'complaints']);
        return view('pelanggan.orders.show', compact('transaction'));
    }
}
