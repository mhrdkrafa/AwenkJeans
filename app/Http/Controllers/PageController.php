<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Tampilkan halaman Tentang Kami.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Tampilkan halaman Cara Pembelian di Toko.
     */
    public function howToBuy()
    {
        return view('pages.how-to-buy');
    }

    /**
     * Tampilkan halaman Konsultasi Ukuran.
     */
    public function sizeGuide()
    {
        return view('pages.size-guide');
    }

    /**
     * Tampilkan halaman Kebijakan Privasi.
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Tampilkan halaman Syarat & Ketentuan.
     */
    public function terms()
    {
        return view('pages.terms');
    }
}
