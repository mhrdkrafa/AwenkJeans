<x-app-layout>
    {{-- Spacer for fixed navbar --}}
    <div class="h-[80px] md:h-[100px] bg-slate-50"></div>

    <div class="bg-slate-50 min-h-screen font-sans text-slate-900 pb-20">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-white border-b border-slate-200 py-16">
            <div class="absolute inset-0 pointer-events-none opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[60%] rounded-full bg-blue-500/5 blur-[130px] pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-[0.25em] text-[#D97706] mb-3 inline-block">LEGAL PRIVASI</span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight leading-tight mb-4 text-slate-900 uppercase">
                    Kebijakan Privasi
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-xl mx-auto font-medium">
                    Bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat menggunakan layanan Awenk Jeans.
                </p>
            </div>
        </div>

        {{-- Legal Text Content --}}
        <div class="max-w-4xl mx-auto px-6 mt-16">
            <div class="bg-white rounded-3xl border border-slate-200/60 p-8 md:p-12 shadow-lg shadow-slate-200/30 space-y-8 text-sm md:text-base text-slate-600 font-medium leading-relaxed">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-950 mb-3 tracking-tight">Pendahuluan</h2>
                    <p>
                        Awenk Jeans berkomitmen penuh untuk melindungi privasi pelanggan dan pengguna website kami. Kebijakan Privasi ini menjelaskan bagaimana kami memproses data pribadi Anda ketika Anda mengunjungi toko fisik kami, mendaftarkan nomor telepon di kasir POS, atau menggunakan fitur-fitur pada website.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">1. Informasi yang Kami Kumpulkan</h2>
                    <p>Kami mengumpulkan data pribadi yang Anda berikan secara sukarela untuk memproses transaksi dan memfasilitasi keluhan, termasuk:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Identitas Pribadi</strong>: Nama lengkap, alamat email, dan nomor telepon aktif (digunakan untuk sinkronisasi transaksi dari kasir POS).</li>
                        <li><strong>Data Transaksi</strong>: Riwayat pembelian barang, tanggal transaksi, metode pembayaran, dan status tagihan.</li>
                        <li><strong>Data Komplain</strong>: Pesan keluhan, lampiran media (foto/video sebagai bukti klaim komplain).</li>
                        <li><strong>Data Kunjungan</strong>: Alamat IP, jenis perangkat browser, dan halaman yang dikunjungi (digunakan untuk tracking statistik pengunjung toko secara anonim).</li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">2. Penggunaan Informasi</h2>
                    <p>Kami menggunakan data pribadi Anda untuk tujuan berikut:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Mengintegrasikan hasil transaksi kasir fisik (POS) ke dalam dasbor akun website pelanggan Anda.</li>
                        <li>Memproses pengajuan komplain mandiri Anda dalam batas tenggat waktu 3 hari.</li>
                        <li>Menghubungi Anda terkait status pesanan, pembayaran, atau tindak lanjut dari tim admin/karyawan kami terkait keluhan/komplain.</li>
                        <li>Meningkatkan kualitas pelayanan toko fisik dan performa website kami.</li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">3. Keamanan Informasi</h2>
                    <p>
                        Kami menggunakan langkah-langkah keamanan teknis dan organisasional yang memadai untuk melindungi data Anda dari akses tanpa izin, kehilangan, manipulasi, atau penyalahgunaan. Sistem pembayaran kartu digital dan QRIS dilakukan secara langsung melalui payment gateway (Midtrans) yang tersertifikasi PCI-DSS, sehingga kami tidak pernah menyimpan data rahasia kartu kredit atau e-wallet Anda.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-extrabold text-slate-950 tracking-tight">4. Berbagi Informasi dengan Pihak Ketiga</h2>
                    <p>
                        Kami tidak akan pernah menjual, menyewakan, atau memberikan data pribadi Anda kepada pihak ketiga mana pun di luar grup perusahaan kami untuk tujuan pemasaran komersial tanpa persetujuan eksplisit dari Anda. Informasi hanya dibagikan dengan mitra penyedia jasa pihak ketiga yang tepercaya demi menunjang pengiriman dan proses pembayaran digital secara sah (seperti jasa logistik ekspedisi dan Midtrans).
                    </p>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-between items-center text-xs text-slate-400">
                    <span>Terakhir diperbarui: 27 Juni 2026</span>
                    <span>Awenk Jeans Legal Team</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
