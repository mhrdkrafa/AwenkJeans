<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\ProductController as KaryawanProductController;
use App\Http\Controllers\Karyawan\CategoryController as KaryawanCategoryController;
use App\Http\Controllers\Karyawan\StockController;
use App\Http\Controllers\Karyawan\TransactionController as KaryawanTransactionController;
use App\Http\Controllers\Karyawan\ReviewController as KaryawanReviewController;
use App\Http\Controllers\Karyawan\VisitorController;
use App\Http\Controllers\Karyawan\ReportController as KaryawanReportController;
use App\Http\Controllers\Karyawan\ComplaintController as KaryawanComplaintController;
use App\Http\Controllers\Administrator\ProductController as AdministratorProductController;
use App\Http\Controllers\Administrator\CategoryController as AdministratorCategoryController;
use App\Http\Controllers\Administrator\BrandController as AdministratorBrandController;
use App\Http\Controllers\Administrator\ColorController as AdministratorColorController;
use App\Http\Controllers\Administrator\ProductModelController as AdministratorProductModelController;
use App\Http\Controllers\Administrator\UserController as AdministratorUserController;
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
            return redirect()->route('catalog.index');
        }
        return redirect()->route('catalog.index');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== KARYAWAN ROUTES =====================
Route::middleware(['auth', 'verified', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');

    // Products (view-only: karyawan hanya bisa lihat daftar dan detail)
    Route::get('/products', [KaryawanProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [KaryawanProductController::class, 'show'])->name('products.show');

    // Categories (view-only: karyawan hanya bisa lihat daftar)
    Route::get('/categories', [KaryawanCategoryController::class, 'index'])->name('categories.index');

    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
    Route::get('/stock/movements', [StockController::class, 'movements'])->name('stock.movements');

    // Transactions
    Route::get('/transactions', [KaryawanTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [KaryawanTransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/receipt-pdf', [KaryawanTransactionController::class, 'receiptPdf'])->name('transactions.receipt.pdf');

    // Reviews
    Route::get('/reviews', [KaryawanReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [KaryawanReviewController::class, 'destroy'])->name('reviews.destroy');

    // Visitor Tracking
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');

    // Complaints Management - Karyawan mengelola komplain
    Route::get('/complaints', [KaryawanComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [KaryawanComplaintController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{complaint}', [KaryawanComplaintController::class, 'update'])->name('complaints.update');
    Route::post('/complaints/{complaint}/reply', [KaryawanComplaintController::class, 'reply'])->name('complaints.reply');

    // Reports - Karyawan juga bisa melihat laporan
    Route::get('/reports', [KaryawanReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [KaryawanReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [KaryawanReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/movements', [KaryawanReportController::class, 'movements'])->name('reports.movements');
    Route::get('/reports/sales/pdf', [KaryawanReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('/reports/stock/pdf', [KaryawanReportController::class, 'stockPdf'])->name('reports.stock.pdf');
    Route::get('/reports/movements/pdf', [KaryawanReportController::class, 'movementsPdf'])->name('reports.movements.pdf');
});

// ===================== OWNER ROUTES (View-only: Laporan) =====================
Route::middleware(['auth', 'verified', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

    // Detail Transaksi - Owner bisa melihat detail
    Route::get('/transactions/{transaction}', [OwnerDashboardController::class, 'showTransaction'])->name('transactions.show');

    // Laporan - Owner hanya melihat
    Route::get('/reports', [KaryawanReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [KaryawanReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [KaryawanReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/movements', [KaryawanReportController::class, 'movements'])->name('reports.movements');
    Route::get('/reports/sales/pdf', [KaryawanReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('/reports/stock/pdf', [KaryawanReportController::class, 'stockPdf'])->name('reports.stock.pdf');
    Route::get('/reports/movements/pdf', [KaryawanReportController::class, 'movementsPdf'])->name('reports.movements.pdf');
});

// ===================== ADMINISTRATOR ROUTES (Produk, Kategori, Merek, Warna, Model, Kelola Akun) =====================
Route::middleware(['auth', 'verified', 'role:administrator'])->prefix('administrator')->name('administrator.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Administrator\DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Produk - Hanya Administrator
    Route::resource('products', AdministratorProductController::class);

    // Manajemen Kategori - Hanya Administrator
    Route::resource('categories', AdministratorCategoryController::class)->except(['show']);

    // Manajemen Merek - Hanya Administrator
    Route::resource('brands', AdministratorBrandController::class)->except(['show']);

    // Manajemen Warna - Hanya Administrator
    Route::resource('colors', AdministratorColorController::class)->except(['show']);

    // Manajemen Model Produk - Hanya Administrator
    Route::resource('product-models', AdministratorProductModelController::class)->except(['show']);

    // Manajemen Akun - Hanya Administrator
    Route::resource('users', AdministratorUserController::class);
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
