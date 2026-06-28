<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'details.product'])
            ->latest()
            ->paginate(5);

        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('total_price');
        $totalTransactions = Transaction::count();
        $paidCount = Transaction::where('payment_status', 'paid')->count();

        return view('karyawan.transactions.index', compact('transactions', 'totalRevenue', 'totalTransactions', 'paidCount'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product.category', 'details.product.size']);
        return view('karyawan.transactions.show', compact('transaction'));
    }

    /**
     * Download nota pembayaran sebagai PDF.
     */
    public function receiptPdf(Transaction $transaction)
    {
        $transaction->load(['details.product.category', 'details.product.size', 'cashier']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kasir.receipt-pdf', compact('transaction'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("Nota-{$transaction->invoice_number}.pdf");
    }
}
