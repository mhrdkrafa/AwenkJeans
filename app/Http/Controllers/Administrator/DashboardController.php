<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalKaryawan = User::whereHas('role', fn($q) => $q->where('name', 'karyawan'))->count();
        $totalKasir = User::whereHas('role', fn($q) => $q->where('name', 'kasir'))->count();
        $totalOwner = User::whereHas('role', fn($q) => $q->where('name', 'owner'))->count();
        $totalPelanggan = User::whereHas('role', fn($q) => $q->where('name', 'pelanggan'))->count();

        $totalSales = Transaction::where('payment_status', 'paid')->sum('total_price');
        $totalTransactions = Transaction::count();

        // Recent users
        $recentUsers = User::with('role')->latest()->take(5)->get();

        return view('administrator.dashboard', compact(
            'totalUsers', 'totalKaryawan', 'totalKasir', 'totalOwner', 'totalPelanggan',
            'totalSales', 'totalTransactions', 'recentUsers'
        ));
    }
}
