<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    /**
     * Handle Midtrans payment notification (webhook).
     * URL ini harus didaftarkan di Midtrans Dashboard > Settings > Payment Notification URL
     */
    public function notification(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new \Midtrans\Notification();
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        \Log::info('Midtrans Notification:', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        $transaction = Transaction::where('invoice_number', $orderId)->first();

        if (!$transaction) {
            \Log::warning("Midtrans Notification: Transaction not found for order_id: {$orderId}");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

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

        return response()->json(['message' => 'OK']);
    }

    /**
     * Handle Midtrans finish redirect (setelah customer selesai bayar di popup Snap).
     */
    public function finish(Request $request)
    {
        $orderId = $request->input('order_id');
        $transaction = Transaction::where('invoice_number', $orderId)->first();

        if ($transaction) {
            return redirect()->route('kasir.pos.receipt', $transaction)
                ->with('success', 'Pembayaran berhasil diproses!');
        }

        return redirect()->route('kasir.pos.index')
            ->with('info', 'Transaksi selesai.');
    }
}
