<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Administrator\ProductController as AdministratorProductController;
use App\Http\Controllers\Administrator\CategoryController as AdministratorCategoryController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\POSController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Pelanggan\OrderController;
use App\Http\Controllers\Pelanggan\ComplaintController as PelangganComplaintController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::redirect('/', '/katalog');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/search-suggestions', [CatalogController::class, 'searchSuggestions'])->name('catalog.search.suggestions');
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Halaman Statis Footer
Route::get('/tentang-kami', [PageController::class, 'about'])->name('pages.about');
Route::get('/cara-pembelian', [PageController::class, 'howToBuy'])->name('pages.how-to-buy');
Route::get('/konsultasi-ukuran', [PageController::class, 'sizeGuide'])->name('pages.size-guide');
Route::get('/kebijakan-privasi', [PageController::class, 'privacyPolicy'])->name('pages.privacy-policy');
Route::get('/syarat-ketentuan', [PageController::class, 'terms'])->name('pages.terms');


// Review membutuhkan login (Poin 5)
Route::post('/produk/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('catalog.reviews.store');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdministrator()) {
            return redirect()->route('administrator.dashboard');
        } elseif ($user->isKaryawan()) {
            return redirect()->route('karyawan.dashboard');
        } elseif ($user->isKasir()) {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->isOwner()) {
            return redirect()->route('owner.dashboard');
        } elseif ($user->isPelanggan()) {
            return redirect()->route('pelanggan.orders');
        }
        return redirect()->route('catalog.index');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== KARYAWAN ROUTES (sebelumnya Admin) =====================
Route::middleware(['auth', 'verified', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');

    // Products (view-only: karyawan hanya bisa lihat daftar dan detail)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Categories (view-only: karyawan hanya bisa lihat daftar)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
    Route::get('/stock/movements', [StockController::class, 'movements'])->name('stock.movements');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/receipt-pdf', [TransactionController::class, 'receiptPdf'])->name('transactions.receipt.pdf');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Visitor Tracking
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');

    // Complaints Management - Karyawan mengelola komplain
    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{complaint}', [AdminComplaintController::class, 'update'])->name('complaints.update');
    Route::post('/complaints/{complaint}/reply', [AdminComplaintController::class, 'reply'])->name('complaints.reply');

    // Reports - Karyawan juga bisa melihat laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/movements', [ReportController::class, 'movements'])->name('reports.movements');
    Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('/reports/stock/pdf', [ReportController::class, 'stockPdf'])->name('reports.stock.pdf');
});

// ===================== OWNER ROUTES (View-only: Laporan) =====================
Route::middleware(['auth', 'verified', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

    // Laporan - Owner hanya melihat
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/movements', [ReportController::class, 'movements'])->name('reports.movements');
    Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('/reports/stock/pdf', [ReportController::class, 'stockPdf'])->name('reports.stock.pdf');
});

// ===================== ADMINISTRATOR ROUTES (Produk, Kategori, Kelola Akun) =====================
Route::middleware(['auth', 'verified', 'role:administrator'])->prefix('administrator')->name('administrator.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Administrator\DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Produk - Hanya Administrator
    Route::resource('products', AdministratorProductController::class);

    // Manajemen Kategori - Hanya Administrator
    Route::resource('categories', AdministratorCategoryController::class)->except(['show']);

    // Manajemen Akun - Hanya Administrator
    Route::resource('users', UserController::class);
});

// ===================== KASIR ROUTES =====================
Route::middleware(['auth', 'verified', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos', [POSController::class, 'store'])->name('pos.store');
    Route::post('/pos/midtrans-update', [POSController::class, 'updateMidtransStatus'])->name('pos.midtrans-update');
    Route::get('/pos/receipt/{transaction}', [POSController::class, 'receipt'])->name('pos.receipt');
    Route::get('/pos/receipt/{transaction}/pdf', [POSController::class, 'receiptPdf'])->name('pos.receipt.pdf');

    // API: Search customers for POS dropdown
    Route::get('/pos/customers', [POSController::class, 'searchCustomers'])->name('pos.customers');
});

// ===================== PELANGGAN ROUTES =====================
Route::middleware(['auth', 'verified', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    // Riwayat Pembelian (Poin 8)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{transaction}', [OrderController::class, 'show'])->name('orders.show');

    // Komplain (Poin 8)
    Route::get('/complaints', [PelangganComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [PelangganComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [PelangganComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [PelangganComplaintController::class, 'show'])->name('complaints.show');
    Route::post('/complaints/{complaint}/reply', [PelangganComplaintController::class, 'reply'])->name('complaints.reply');
});

// ===================== MIDTRANS CALLBACK ROUTES =====================
Route::post('/midtrans/notification', [App\Http\Controllers\MidtransCallbackController::class, 'notification'])->name('midtrans.notification');
Route::get('/midtrans/finish', [App\Http\Controllers\MidtransCallbackController::class, 'finish'])->name('midtrans.finish');

require __DIR__.'/auth.php';
