<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Transaction::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->where('user_id', auth()->id())
            ->sum('total_price');

        $todayTransactions = Transaction::whereDate('created_at', today())
            ->where('user_id', auth()->id())
            ->count();

        $recentTransactions = Transaction::with(['details.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact('todaySales', 'todayTransactions', 'recentTransactions'));
    }
}
