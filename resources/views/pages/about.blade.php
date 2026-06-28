<x-app-layout>
    {{-- Spacer for fixed navbar --}}
    <div class="h-[80px] md:h-[100px] bg-slate-50"></div>

    <div class="bg-slate-50 min-h-screen font-sans text-slate-900 pb-20">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-white border-b border-slate-200 py-20">
            <div class="absolute inset-0 pointer-events-none opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[60%] rounded-full bg-blue-500/5 blur-[130px] pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-[0.25em] text-[#D97706] mb-3 inline-block">ATELIER DENIM LOKAL</span>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight mb-6 text-slate-900 uppercase">
                    Tentang <span class="text-[#1D4ED8]">Awenk Jeans</span>
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-2xl mx-auto font-medium">
                    Kisah dedikasi kami dalam menghadirkan produk denim lokal berkualitas ekspor, menggabungkan tradisi kerajinan tangan terbaik dengan potongan modern yang tangguh.
                </p>
            </div>
        </div>

        {{-- Content Sections --}}
        <div class="max-w-6xl mx-auto px-6 mt-16">
            <div class="flex flex-col lg:flex-row gap-12 items-center mb-20">
                <div class="lg:w-1/2 space-y-6">
                    <span class="text-[10px] font-black text-[#1D4ED8] uppercase tracking-widest block">CERITA KAMI</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-950 tracking-tight leading-tight">Mulai dari Mimpi Kecil di Pasar Ular Jakarta</h2>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed font-medium">
                        Didirikan sejak tahun 2024, <strong>Awenk Jeans</strong> lahir dari semangat untuk membuktikan bahwa produk lokal mampu bersaing dengan kualitas denim internasional. Berlokasi di kawasan bersejarah perdagangan pakaian Pasar Ular, Jakarta Utara, kami tumbuh sebagai workshop denim yang mengedepankan kualitas jahitan dan bahan.
                    </p>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed font-medium">
                        Setiap helai celana jeans yang kami produksi melewati proses kurasi bahan denim yang ketat. Kami percaya bahwa jeans bukan sekadar pakaian biasa, melainkan pelindung aktivitas sehari-hari Anda yang memiliki cerita unik seiring berjalannya waktu.
                    </p>
                </div>
                <div class="lg:w-1/2 w-full">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/5 border border-slate-200/60 p-2 bg-white">
                        <div class="aspect-[4/3] rounded-2xl bg-gradient-to-tr from-slate-900 to-indigo-900 flex items-center justify-center text-white relative">
                            <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=600')] bg-cover bg-center mix-blend-overlay"></div>
                            <div class="relative text-center p-6 z-10">
                                <p class="text-[11px] font-bold text-[#D97706] tracking-widest uppercase mb-1">Dibuat Dengan Bangga</p>
                                <p class="text-2xl font-black tracking-tight">Kualitas Ekspor 100% Produk Lokal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vision & Mission --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-lg shadow-slate-200/30 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-[#1D4ED8] mb-6 border border-blue-100">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-950 mb-3 tracking-tight">Visi Kami</h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Menjadi merk denim premium lokal nomor satu pilihan masyarakat Indonesia, dikenal dengan ketahanan legendaris, kenyamanan optimal, serta menjadi ikon kebanggaan produk lokal kualitas dunia.
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-lg shadow-slate-200/30 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-[#D97706] mb-6 border border-amber-100">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-950 mb-3 tracking-tight">Misi Kami</h3>
                        <ul class="space-y-3 text-slate-600 text-sm font-medium leading-relaxed">
                            <li class="flex items-start gap-2">
                                <span class="text-[#D97706] font-bold">•</span>
                                Menggunakan bahan denim berkualitas tinggi yang tahan lama dan ramah lingkungan dalam proses produksi.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D97706] font-bold">•</span>
                                Menghadirkan pola potongan jeans yang ergonomis untuk kenyamanan aktivitas sepanjang hari.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D97706] font-bold">•</span>
                                Memberikan pelayanan purna jual dan garansi kepuasan pelanggan terbaik demi pengalaman berbelanja yang aman.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Core Values --}}
            <div class="bg-white rounded-3xl border border-slate-200/60 p-8 md:p-12 shadow-lg shadow-slate-200/30">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-[10px] font-black text-[#1D4ED8] uppercase tracking-widest block mb-2">NILAI UTAMA</span>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-slate-950 tracking-tight">Mengapa Memilih Awenk Jeans?</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1D4ED8] flex items-center justify-center font-bold text-lg">01</div>
                        <h4 class="text-lg font-bold text-slate-950">Bahan Denim Premium</h4>
                        <p class="text-slate-500 text-xs md:text-sm leading-relaxed font-medium">
                            Kami memilih kain denim dengan gramasi yang tepat dan kekuatan serat optimal, menghasilkan warna fade alami yang artistik dari waktu ke waktu.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#D97706] flex items-center justify-center font-bold text-lg">02</div>
                        <h4 class="text-lg font-bold text-slate-950">Jahitan Ganda Kuat</h4>
                        <p class="text-slate-500 text-xs md:text-sm leading-relaxed font-medium">
                            Diproduksi menggunakan teknik jahitan ganda (chainstitch) berkekuatan tinggi di titik kritis tarikan, menjamin kekuatan celana bertahun-tahun.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">03</div>
                        <h4 class="text-lg font-bold text-slate-950">Garansi Komplain 3 Hari</h4>
                        <p class="text-slate-500 text-xs md:text-sm leading-relaxed font-medium">
                            Jika terdapat cacat produksi atau ketidaksesuaian barang, kami menyediakan fasilitas komplain mandiri di website dalam waktu 3 hari.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
