<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar komplain pelanggan.
     */
    public function index()
    {
        $complaints = Complaint::with(['product', 'transaction', 'messages' => function ($q) {
                $q->where('is_admin', true)->latest()->limit(1);
            }, 'messages.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pelanggan.complaints.index', compact('complaints'));
    }

    /**
     * Form untuk membuat komplain baru.
     */
    public function create(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $productId = $request->query('product_id');

        // Pastikan transaksi milik pelanggan
        $userPhone = Auth::user()->phone;
        $transaction = Transaction::where('id', $transactionId)
            ->where(function($query) use ($userPhone) {
                $query->where('pelanggan_id', Auth::id());
                if (!empty($userPhone)) {
                    $query->orWhere('customer_phone', $userPhone);
                }
            })
            ->where('payment_status', 'paid')
            ->firstOrFail();

        // Cek batas waktu komplain 3 hari
        if ($transaction->created_at->diffInDays(now()) > 3) {
            return redirect()->route('pelanggan.orders.show', $transaction)
                ->with('error', 'Batas waktu komplain telah berakhir. Komplain hanya dapat diajukan dalam 3 hari setelah transaksi.');
        }

        // Pastikan produk ada dalam transaksi
        $detail = TransactionDetail::where('transaction_id', $transactionId)
            ->where('product_id', $productId)
            ->firstOrFail();

        $detail->load('product');

        return view('pelanggan.complaints.create', compact('transaction', 'detail'));
    }

    /**
     * Simpan komplain baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments' => 'required|array|min:1',
            'attachments.*' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:20480',
        ], [
            'attachments.required' => 'Wajib upload gambar/video sebagai bukti komplain.',
            'attachments.min' => 'Wajib upload minimal 1 gambar/video sebagai bukti komplain.',
            'attachments.*.mimes' => 'Format file harus: JPG, PNG, GIF, WebP, MP4, MOV, atau AVI.',
            'attachments.*.max' => 'Ukuran file maksimal 20MB.',
        ]);

        // Pastikan transaksi milik pelanggan
        $userPhone = Auth::user()->phone;
        $transaction = Transaction::where('id', $request->transaction_id)
            ->where(function($query) use ($userPhone) {
                $query->where('pelanggan_id', Auth::id());
                if (!empty($userPhone)) {
                    $query->orWhere('customer_phone', $userPhone);
                }
            })
            ->where('payment_status', 'paid')
            ->firstOrFail();

        // Cek batas waktu komplain 3 hari
        if ($transaction->created_at->diffInDays(now()) > 3) {
            return redirect()->route('pelanggan.orders')
                ->with('error', 'Batas waktu komplain telah berakhir. Komplain hanya dapat diajukan dalam 3 hari setelah transaksi.');
        }

        // Pastikan produk ada dalam transaksi
        TransactionDetail::where('transaction_id', $request->transaction_id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaints/attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }

        Complaint::create([
            'user_id' => Auth::id(),
            'transaction_id' => $request->transaction_id,
            'product_id' => $request->product_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
            'status' => 'open',
        ]);

        return redirect()->route('pelanggan.complaints.index')->with('success', 'Komplain berhasil dikirim. Kami akan segera merespon.');
    }

    public function show(Complaint $complaint)
    {
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $complaint->load(['product', 'transaction.details.product', 'messages.user']);
        return view('pelanggan.complaints.show', compact('complaint'));
    }

    /**
     * Membalas pesan komplain.
     */
    public function reply(Request $request, Complaint $complaint)
    {
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        // Cek apakah komplain sudah diselesaikan atau ditutup
        if (in_array($complaint->status, ['resolved', 'closed'])) {
            return back()->with('error', 'Komplain ini telah diselesaikan. Anda tidak dapat mengirim pesan lagi.');
        }

        // Cek apakah sudah lebih dari 3 hari
        if ($complaint->created_at->diffInDays(now()) > 3) {
            return back()->with('error', 'Batas waktu percakapan telah berakhir (lebih dari 3 hari).');
        }

        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:20480',
        ]);

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaints/attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }

        $complaint->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
            'is_admin' => false,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}
