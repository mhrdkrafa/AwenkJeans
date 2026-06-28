<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('owner.reports.index');
    }

    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $transactions = Transaction::with(['user', 'details.product'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total_price');
        $totalTransactions = $transactions->count();

        return view('owner.reports.sales', compact('transactions', 'totalRevenue', 'totalTransactions', 'startDate', 'endDate'));
    }

    public function stock()
    {
        $products = Product::with(['category', 'size'])->orderBy('stock', 'asc')->get();
        $totalStock = $products->sum('stock');
        $totalValue = $products->sum(fn($p) => $p->stock * $p->price);

        return view('owner.reports.stock', compact('products', 'totalStock', 'totalValue'));
    }

    public function movements(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $movements = StockMovement::with('product')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $totalIn = $movements->where('type', 'in')->sum('quantity');
        $totalOut = $movements->where('type', 'out')->sum('quantity');

        return view('owner.reports.movements', compact('movements', 'totalIn', 'totalOut', 'startDate', 'endDate'));
    }

    public function salesPdf(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $transactions = Transaction::with(['user', 'details.product'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total_price');

        $pdf = Pdf::loadView('owner.reports.pdf.sales', compact('transactions', 'totalRevenue', 'startDate', 'endDate'));
        return $pdf->download('laporan-penjualan-' . $startDate . '-' . $endDate . '.pdf');
    }

    public function stockPdf()
    {
        $products = Product::with(['category', 'size'])->orderBy('stock', 'asc')->get();
        $totalStock = $products->sum('stock');
        $totalValue = $products->sum(fn($p) => $p->stock * $p->price);

        $pdf = Pdf::loadView('owner.reports.pdf.stock', compact('products', 'totalStock', 'totalValue'));
        return $pdf->download('laporan-stok-' . now()->format('Y-m-d') . '.pdf');
    }
}
