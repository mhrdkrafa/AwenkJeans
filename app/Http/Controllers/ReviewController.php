<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Pelanggan harus login untuk review (Poin 5)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan review.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'rating.required' => 'Mohon berikan rating bintang.',
            'image.image' => 'File yang diupload harus berupa gambar.',
        ]);

        $userId = Auth::id();

        // Check if pelanggan pernah membeli produk ini
        $userPhone = Auth::user()->phone;
        $hasPurchased = Transaction::where(function($query) use ($userId, $userPhone) {
                $query->where('pelanggan_id', $userId);
                if (!empty($userPhone)) {
                    $query->orWhere('customer_phone', $userPhone);
                }
            })
            ->where('payment_status', 'paid')
            ->whereHas('details', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Gagal mengirim ulasan. Anda belum pernah membeli produk ini.');
        }

        // Cek apakah sudah pernah review produk ini
        $existingReview = Review::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah pernah memberikan review untuk produk ini.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas feedback Anda.');
    }
}
