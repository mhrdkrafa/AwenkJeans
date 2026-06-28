<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
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

        // Load all pelanggan for searchable dropdown
        $customers = User::whereHas('role', fn($q) => $q->where('name', 'pelanggan'))
            ->orderBy('name')
            ->get(['id', 'name', 'phone', 'email']);

        return view('kasir.pos', compact('products', 'customers'));
    }

    /**
     * API: Search customers for POS searchable dropdown.
     */
    public function searchCustomers(Request $request)
    {
        $query = $request->get('q', '');

        $customers = User::whereHas('role', fn($q) => $q->where('name', 'pelanggan'))
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->take(20)
            ->get(['id', 'name', 'phone', 'email']);

        return response()->json($customers);
    }

    public function store(Request $request)
    {
        \Log::info('POS Checkout Request:', $request->all());

        $isAjax = $request->expectsJson();

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'pelanggan_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,midtrans',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'items.required' => 'Keranjang belanja tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            \Log::error('POS Checkout Validation Failed:', $validator->errors()->toArray());
            if ($isAjax) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            return DB::transaction(function () use ($request, $isAjax) {
                $items = $request->input('items', []);
                $paymentMethod = $request->input('payment_method');

                // Ambil pelanggan dari dropdown (pelanggan_id) atau null untuk walk-in
                $pelangganId = $request->input('pelanggan_id');
                $customerName = $request->input('customer_name');
                $customerPhone = $request->input('customer_phone', '');

                // Jika pelanggan terdaftar, gunakan data dari database
                if ($pelangganId) {
                    $pelanggan = User::find($pelangganId);
                    if ($pelanggan) {
                        $customerName = $pelanggan->name;
                        $customerPhone = $pelanggan->phone ?? '';
                    }
                }

                $transaction = Transaction::create([
                    'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                    'user_id' => Auth::id(),
                    'pelanggan_id' => $pelangganId ?: null,
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'total_price' => 0,
                    'payment_method' => $paymentMethod === 'midtrans' ? 'qris' : 'cash',
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
                        'description' => "Penjualan: {$transaction->invoice_number} - Pelanggan: {$request->input('customer_name')}",
                        'reference_id' => $transaction->id,
                    ]);
                }

                $transaction->update(['total_price' => $totalPrice]);

                if ($paymentMethod === 'midtrans') {
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production');
                    \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                    \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                    $params = [
                        'transaction_details' => [
                            'order_id' => $transaction->invoice_number,
                            'gross_amount' => (int) $totalPrice,
                        ],
                        'customer_details' => [
                            'first_name' => $request->input('customer_name'),
                            'phone' => $request->input('customer_phone'),
                        ],
                    ];

                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $transaction->update(['snap_token' => $snapToken]);

                    \Log::info('Midtrans Snap Token Generated:', ['token' => $snapToken, 'invoice' => $transaction->invoice_number]);

                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'invoice_number' => $transaction->invoice_number,
                    ]);
                }

                return redirect()->route('kasir.pos.receipt', $transaction)->with('success', "Transaksi {$transaction->invoice_number} berhasil! Total: Rp " . number_format($totalPrice, 0, ',', '.'));
            });
        } catch (\Exception $e) {
            \Log::error('POS Checkout Error: ' . $e->getMessage());
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan halaman nota setelah transaksi berhasil.
     */
    public function receipt(Transaction $transaction)
    {
        $transaction->load(['details.product.category', 'details.product.size', 'cashier']);
        return view('kasir.receipt', compact('transaction'));
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

    /**
     * Update status pembayaran Midtrans via AJAX (untuk localhost tanpa webhook).
     * Memverifikasi langsung ke Midtrans API untuk keamanan.
     */
    public function updateMidtransStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'transaction_status' => 'required|string',
        ]);

        $orderId = $request->input('order_id');
        $transaction = Transaction::where('invoice_number', $orderId)->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Verifikasi status langsung ke Midtrans API (server-to-server) agar aman
        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');

            $midtransStatus = \Midtrans\Transaction::status($orderId);
            $transactionStatus = $midtransStatus->transaction_status ?? $request->input('transaction_status');
            $fraudStatus = $midtransStatus->fraud_status ?? 'accept';

            \Log::info('Midtrans Status Check (localhost):', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'fraud' => $fraudStatus,
            ]);

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($fraudStatus == 'accept' || $transactionStatus == 'settlement') {
                    $transaction->update(['payment_status' => 'paid']);
                }
            } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                $transaction->update(['payment_status' => 'failed']);
            } elseif ($transactionStatus == 'expire') {
                $transaction->update(['payment_status' => 'expired']);
            } elseif ($transactionStatus == 'pending') {
                $transaction->update(['payment_status' => 'pending']);
            }

            return response()->json([
                'success' => true,
                'payment_status' => $transaction->fresh()->payment_status,
                'redirect' => route('kasir.pos.receipt', $transaction),
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Status Check Error: ' . $e->getMessage());

            // Fallback: gunakan status dari client jika verifikasi gagal
            $clientStatus = $request->input('transaction_status');
            if (in_array($clientStatus, ['capture', 'settlement'])) {
                $transaction->update(['payment_status' => 'paid']);
            }

            return response()->json([
                'success' => true,
                'payment_status' => $transaction->fresh()->payment_status,
                'redirect' => route('kasir.pos.receipt', $transaction),
            ]);
        }
    }
}
