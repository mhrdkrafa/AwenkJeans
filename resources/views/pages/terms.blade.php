<x-app-layout>
    {{-- Spacer for fixed navbar --}}
    <div class="h-[80px] md:h-[100px] bg-slate-50"></div>

    <div class="bg-slate-50 min-h-screen font-sans text-slate-900 pb-20">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-white border-b border-slate-200 py-16">
            <div class="absolute inset-0 pointer-events-none opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[60%] rounded-full bg-blue-500/5 blur-[130px] pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-[0.25em] text-[#D97706] mb-3 inline-block">ATURAN LAYANAN</span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight leading-tight mb-4 text-slate-900 uppercase">
                    Syarat & Ketentuan
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-xl mx-auto font-medium">
                    Ketentuan penggunaan layanan dan aturan belanja di toko fisik serta website resmi Awenk Jeans.
                </p>
            </div>
        </div>

        {{-- Legal Text Content --}}
        <div class="max-w-4xl mx-auto px-6 mt-16">
            <div class="bg-white rounded-3xl border border-slate-200/60 p-8 md:p-12 shadow-lg shadow-slate-200/30 space-y-8 text-sm md:text-base text-slate-600 font-medium leading-relaxed">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-950 mb-3 tracking-tight">Ketentuan Umum</h2>
                    <p>
                        Dengan mendaftar sebagai pelanggan dan bertransaksi di kasir POS maupun menggunakan website Awenk Jeans, Anda menyatakan setuju untuk terikat secara hukum dengan seluruh Syarat & Ketentuan yang berlaku di bawah ini.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">1. Transaksi & Pembelian</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Semua pembelian dilakukan secara langsung di toko fisik Awenk Jeans melalui kasir POS.</li>
                        <li>Agar transaksi tercatat di akun website Anda, Anda wajib memberikan informasi nama/nomor HP Anda yang terdaftar pada sistem website ke petugas kasir saat memproses checkout.</li>
                        <li>Kasir POS kami menerima pembayaran secara tunai, transfer bank, dan QRIS/E-Wallet secara sah.</li>
                        <li>Bukti pembayaran fisik (struk) akan dicetak langsung oleh kasir dan salinan invoice elektronik akan otomatis tersedia di menu **Riwayat Pembelian** pada akun pelanggan Anda.</li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">2. Kebijakan Komplain & Pengembalian Barang</h2>
                    <p>Kami berkomitmen menjaga kepuasan Anda melalui garansi perlindungan produk cacat produksi dengan ketentuan ketat sebagai berikut:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Tenggat Waktu Komplain</strong>: Pengajuan klaim komplain/garansi dibatasi maksimal **3 hari (72 jam)** sejak waktu selesai proses pembayaran kasir (tercantum pada struk transaksi). Lewat dari tenggat tersebut, sistem otomatis menutup pengajuan komplain.</li>
                        <li><strong>Bukti Wajib</strong>: Saat mengajukan komplain di website, pelanggan **diharuskan mengunggah file bukti berupa gambar/foto atau video** yang memperlihatkan kecacatan produk atau ketidaksesuaian pesanan. Pengajuan tanpa bukti lampiran tidak akan diterima oleh sistem.</li>
                        <li><strong>Penguncian Chat Komplain</strong>: Jika komplain telah dinyatakan selesai oleh karyawan kami atau batas tenggat waktu 3 hari terlampaui, fitur obrolan komplain akan terkunci otomatis secara permanen. Percakapan lama akan tetap disimpan sebagai arsip.</li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">3. Akun Pelanggan & Keamanan</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Anda bertanggung jawab menjaga kerahasiaan informasi login akun website Anda (email dan password).</li>
                        <li>Kami tidak bertanggung jawab atas kerugian transaksi akibat penyalahgunaan akun Anda oleh pihak ketiga karena kelalaian penyimpanan kredensial login.</li>
                    </ul>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-between items-center text-xs text-slate-400">
                    <span>Terakhir diperbarui: 27 Juni 2026</span>
                    <span>Awenk Jeans Legal Team</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
