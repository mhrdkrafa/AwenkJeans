<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ringkasan Penjualan (view-only)
        $totalSales = Transaction::where('payment_status', 'paid')->sum('total_price');
        $todaySales = Transaction::where('payment_status', 'paid')->whereDate('created_at', today())->sum('total_price');
        $monthlySales = Transaction::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $totalTransactions = Transaction::count();
        $paidTransactions = Transaction::where('payment_status', 'paid')->count();
        $totalProducts = Product::count();

        // Monthly Chart
        $monthlyChartLabels = [];
        $monthlyChartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyChartLabels[] = $date->translatedFormat('M Y');
            $total = Transaction::where('payment_status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');
            $monthlyChartData[] = (float)$total;
        }

        // Top 5 products
        $topProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.payment_status', 'paid')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'details.product'])->latest()->take(10)->get();

        return view('owner.dashboard', compact(
            'totalSales', 'todaySales', 'monthlySales',
            'totalTransactions', 'paidTransactions', 'totalProducts',
            'topProducts', 'recentTransactions',
            'monthlyChartLabels', 'monthlyChartData'
        ));
    }

    public function showTransaction(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product.category', 'details.product.size']);
        return view('owner.transactions.show', compact('transaction'));
    }
}
