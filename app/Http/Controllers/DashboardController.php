<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Transaction::where('payment_status', 'paid')->sum('total_price');
        $todaySales = Transaction::where('payment_status', 'paid')->whereDate('created_at', today())->sum('total_price');
        $monthlySales = Transaction::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        // Jika data kosong, kita bisa tambahkan logika untuk testing (opsional)
        // Namun kita biarkan apa adanya agar user tahu data realnya.

        $totalTransactions = Transaction::count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $paidTransactions = Transaction::where('payment_status', 'paid')->count();
        $pendingTransactions = Transaction::where('payment_status', 'pending')->count();

        $totalProducts = Product::count();
        $activeProducts = Product::where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<=', 10)->get();
        $lowStockCount = $lowStockProducts->count();

        $topProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.payment_status', 'paid')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with(['user'])->latest()->take(5)->get();

        $recentStockMovements = \App\Models\StockMovement::with('product')
            ->latest()
            ->take(5)
            ->get();

        $stockInToday = \App\Models\StockMovement::where('type', 'in')
            ->whereDate('created_at', today())
            ->sum('quantity');

        $stockOutToday = \App\Models\StockMovement::where('type', 'out')
            ->whereDate('created_at', today())
            ->sum('quantity');

        $averageTransaction = $paidTransactions > 0 ? $totalSales / $paidTransactions : 0;

        // ===================== WEEKLY CHART =====================
        $weeklySales = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayName = $date->translatedFormat('D');
            $fullDate = $date->toDateString();
            
            $total = Transaction::where('payment_status', 'paid')
                ->whereDate('created_at', $fullDate)
                ->sum('total_price');
                
            $weeklySales->push([
                'label' => $dayName,
                'full_label' => $date->translatedFormat('d M'),
                'total' => (float)$total
            ]);
        }

        // ===================== MONTHLY CHART =====================
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

        // ===================== CATEGORY STACKED CHART =====================
        $categoryLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $categoryLabels[] = now()->subMonths($i)->translatedFormat('M Y');
        }

        $categories = \App\Models\Category::take(4)->get();
        $categoryChartData = [];

        foreach ($categories as $category) {
            $data = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $total = TransactionDetail::whereHas('product', function($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                    ->whereHas('transaction', function($q) use ($month) {
                        $q->where('payment_status', 'paid')
                            ->whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year);
                    })
                    ->sum('subtotal');
                $data[] = (float)$total;
            }
            $categoryChartData[] = [
                'name' => $category->name,
                'data' => $data
            ];
        }

        // Jika category kosong, buat data placeholder agar chart tidak error
        if ($categories->isEmpty()) {
            $categoryChartData = [[
                'name' => 'Belum ada kategori',
                'data' => array_fill(0, 6, 0)
            ]];
        }

        return view('dashboard', compact(
            'totalSales',
            'todaySales',
            'monthlySales',
            'totalTransactions',
            'todayTransactions',
            'paidTransactions',
            'pendingTransactions',
            'totalProducts',
            'activeProducts',
            'outOfStockProducts',
            'lowStockProducts',
            'lowStockCount',
            'topProducts',
            'recentTransactions',
            'recentStockMovements',
            'stockInToday',
            'stockOutToday',
            'averageTransaction',
            'weeklySales',
            'monthlyChartLabels',
            'monthlyChartData',
            'categoryChartData',
            'categoryLabels'
        ));
    }
}