<x-app-layout>
    {{-- Spacer for fixed navbar --}}
    <div class="h-[80px] md:h-[100px] bg-slate-50"></div>

    <div class="bg-slate-50 min-h-screen font-sans text-slate-900 pb-20">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-white border-b border-slate-200 py-20">
            <div class="absolute inset-0 pointer-events-none opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[60%] rounded-full bg-blue-500/5 blur-[130px] pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-[0.25em] text-[#D97706] mb-3 inline-block">PANDUAN PEMBELIAN</span>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight mb-6 text-slate-900 uppercase">
                    Cara Pembelian <span class="text-[#1D4ED8]">di Toko Kami</span>
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-2xl mx-auto font-medium">
                    Awenk Jeans melayani pembelian langsung di toko fisik kami dengan pencatatan transaksi kasir digital (POS) yang terintegrasi langsung dengan akun pelanggan Anda di website.
                </p>
            </div>
        </div>

        {{-- Process Steps --}}
        <div class="max-w-5xl mx-auto px-6 mt-16">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-950">4 Langkah Mudah Berbelanja</h2>
                <p class="text-slate-500 text-sm font-medium mt-2">Dapatkan jeans premium impian Anda dengan pelayanan cepat dan terpercaya</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <!-- Step 1 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-lg shadow-slate-200/30 flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#1D4ED8] font-black text-xl shrink-0">
                        1
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-950">Kunjungi Toko Fisik Kami</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Datang langsung ke workshop/toko kami di <strong>Pasar Ular, Jl Raya Plumpang Semper No. 86, Jakarta Utara</strong>. Anda dapat melihat secara langsung berbagai pilihan denim dan kualitas jahitan kami.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-lg shadow-slate-200/30 flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-[#D97706] font-black text-xl shrink-0">
                        2
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-950">Pilih Model & Fitting Ukuran</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Pilih potongan jeans yang sesuai dengan gaya Anda (Slim Fit, Skinny, Regular Fit, atau Loose Fit). Kami menyediakan ruang pas (fitting room) agar Anda mendapatkan ukuran yang paling pas dan nyaman.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-lg shadow-slate-200/30 flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xl shrink-0">
                        3
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-950">Pembayaran di Kasir (POS)</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Lakukan pembayaran di kasir. <strong>Penting:</strong> Sebutkan nama atau nomor HP Anda yang terdaftar di website kami ke kasir. Kasir kami akan menginput data transaksi langsung ke sistem POS agar riwayat transaksi masuk ke akun Anda.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-lg shadow-slate-200/30 flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-black text-xl shrink-0">
                        4
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-950">Terima Struk & Garansi</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Kasir akan mencetak struk belanja fisik Anda dan mengirim invoice digital ke website. Anda akan mendapatkan garansi komplain selama 3 hari sejak pembayaran kasir selesai untuk pengembalian atau penukaran barang jika terjadi cacat produksi.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Payment Information --}}
            <div class="bg-white rounded-3xl border border-slate-200/60 p-8 shadow-lg shadow-slate-200/30">
                <div class="flex flex-col md:flex-row gap-8 items-center">
                    <div class="md:w-2/3 space-y-4">
                        <span class="text-[10px] font-black text-[#D97706] uppercase tracking-widest block">METODE PEMBAYARAN</span>
                        <h3 class="text-2xl font-extrabold text-slate-950 tracking-tight">Mendukung Transaksi Cashless & Digital</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Demi kenyamanan dan keamanan transaksi Anda, kasir POS Awenk Jeans menerima pembayaran tunai (Cash), Transfer Bank, serta pembayaran QRIS/E-Wallet (GoPay, OVO, Dana, ShopeePay) yang terintegrasi secara aman.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">Tunai / Cash</span>
                            <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">Transfer Bank</span>
                            <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">QRIS / E-Wallet</span>
                        </div>
                    </div>
                    <div class="md:w-1/3 w-full bg-slate-50 border border-slate-200/60 rounded-2xl p-6 text-center">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Butuh Bantuan?</p>
                        <p class="text-sm font-bold text-slate-700 mb-4">Hubungi Admin Kasir Toko</p>
                        <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs uppercase tracking-wider transition-colors shadow-lg shadow-emerald-500/20">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 2.015 14.075.993 11.5.993c-5.439 0-9.865 4.371-9.87 9.8.001 2.002.529 3.957 1.528 5.688l-.999 3.648 3.733-.966c1.654.897 3.254 1.343 4.665 1.343zm11.566-7.673c-.314-.157-1.854-.915-2.141-1.018-.287-.104-.497-.157-.707.157-.21.314-.813 1.018-.996 1.227-.183.21-.365.236-.679.079-.314-.157-1.326-.488-2.528-1.559-.933-.833-1.563-1.862-1.747-2.176-.183-.314-.02-.485.137-.641.141-.14.314-.366.47-.549.157-.183.21-.314.314-.523.104-.21.052-.393-.026-.549-.079-.157-.707-1.7-.969-2.327-.255-.612-.516-.53-.707-.54-.183-.01-.393-.012-.602-.012s-.549.079-.837.393c-.287.314-1.099 1.073-1.099 2.616 0 1.543 1.125 3.033 1.282 3.243.157.21 2.213 3.379 5.361 4.739.75.324 1.336.518 1.793.662.753.239 1.439.205 1.981.125.604-.09 1.854-.759 2.115-1.465.261-.706.261-1.308.183-1.438-.078-.13-.287-.209-.601-.366z"/></svg>
                            Hubungi WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
