<x-app-layout>
    {{-- Spacer for fixed navbar --}}
    <div class="h-[80px] md:h-[100px] bg-slate-50"></div>

    <div class="bg-slate-50 min-h-screen font-sans text-slate-900 pb-20">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-white border-b border-slate-200 py-20">
            <div class="absolute inset-0 pointer-events-none opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[60%] rounded-full bg-blue-500/5 blur-[130px] pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-[0.25em] text-[#D97706] mb-3 inline-block">SIZE GUIDE</span>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight mb-6 text-slate-900 uppercase">
                    Konsultasi & <span class="text-[#1D4ED8]">Panduan Ukuran</span>
                </h1>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-2xl mx-auto font-medium">
                    Temukan potongan denim terbaik yang sesuai dengan lekuk tubuh Anda. Silakan pilih jenis potongan di bawah ini untuk melihat detail panduan ukuran kami.
                </p>
            </div>
        </div>

        {{-- Size Chart Section with Alpine.js Tabs --}}
        <div class="max-w-5xl mx-auto px-6 mt-16" x-data="{ activeTab: 'slim-fit' }">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-950">Tabel Panduan Ukuran Celana</h2>
                <p class="text-slate-500 text-sm font-medium mt-2">Semua satuan ukuran menggunakan Sentimeter (cm). Toleransi ukuran ± 1-2 cm.</p>
            </div>

            {{-- Tabs --}}
            <div class="flex flex-wrap justify-center gap-2 p-1.5 bg-slate-200/60 border border-slate-300/40 rounded-2xl max-w-2xl mx-auto mb-10">
                <button 
                    @click="activeTab = 'slim-fit'"
                    :class="activeTab === 'slim-fit' ? 'bg-[#1D4ED8] text-white shadow-md' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-300 flex-1 md:flex-initial"
                >
                    Slim Fit
                </button>
                <button 
                    @click="activeTab = 'skinny'"
                    :class="activeTab === 'skinny' ? 'bg-[#1D4ED8] text-white shadow-md' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-300 flex-1 md:flex-initial"
                >
                    Skinny Style
                </button>
                <button 
                    @click="activeTab = 'regular'"
                    :class="activeTab === 'regular' ? 'bg-[#1D4ED8] text-white shadow-md' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-300 flex-1 md:flex-initial"
                >
                    Regular Fit
                </button>
                <button 
                    @click="activeTab = 'loose'"
                    :class="activeTab === 'loose' ? 'bg-[#1D4ED8] text-white shadow-md' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-300 flex-1 md:flex-initial"
                >
                    Loose Fit
                </button>
            </div>

            {{-- Tab Contents --}}
            <div class="bg-white rounded-3xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-6 md:p-8 mb-16 overflow-hidden">
                <!-- Slim Fit Table -->
                <div x-show="activeTab === 'slim-fit'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-950">Potongan Slim Fit</h3>
                            <p class="text-slate-500 text-xs md:text-sm font-medium mt-1">Potongan modern yang agak merapat dari pinggul hingga ujung mata kaki, memberikan siluet ramping.</p>
                        </div>
                        <span class="px-3.5 py-1.5 bg-blue-50 border border-blue-100 rounded-xl text-xs font-bold text-[#1D4ED8] uppercase tracking-wider shrink-0">Best Seller Fit</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm font-medium text-slate-600">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-900 font-bold bg-slate-50">
                                    <th class="p-4 rounded-l-xl">Size (Inci)</th>
                                    <th class="p-4">Lingkar Pinggang (cm)</th>
                                    <th class="p-4">Panjang Celana (cm)</th>
                                    <th class="p-4">Lingkar Paha (cm)</th>
                                    <th class="p-4 rounded-r-xl">Lebar Ujung Kaki (cm)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr><td class="p-4 text-slate-950 font-bold">28</td><td class="p-4">76 cm</td><td class="p-4">100 cm</td><td class="p-4">52 cm</td><td class="p-4">16 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">30</td><td class="p-4">81 cm</td><td class="p-4">101 cm</td><td class="p-4">54 cm</td><td class="p-4">17 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">32</td><td class="p-4">86 cm</td><td class="p-4">102 cm</td><td class="p-4">56 cm</td><td class="p-4">18 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">34</td><td class="p-4">91 cm</td><td class="p-4">103 cm</td><td class="p-4">58 cm</td><td class="p-4">19 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">36</td><td class="p-4">96 cm</td><td class="p-4">104 cm</td><td class="p-4">60 cm</td><td class="p-4">20 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">38</td><td class="p-4">101 cm</td><td class="p-4">105 cm</td><td class="p-4">62 cm</td><td class="p-4">21 cm</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Skinny Table -->
                <div x-show="activeTab === 'skinny'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-950">Potongan Skinny Style</h3>
                            <p class="text-slate-500 text-xs md:text-sm font-medium mt-1">Potongan ketat yang pas mengikuti bentuk kaki secara penuh dari paha hingga mata kaki.</p>
                        </div>
                        <span class="px-3.5 py-1.5 bg-amber-50 border border-amber-100 rounded-xl text-xs font-bold text-[#D97706] uppercase tracking-wider shrink-0">Super Stretch Fit</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm font-medium text-slate-600">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-900 font-bold bg-slate-50">
                                    <th class="p-4 rounded-l-xl">Size (Inci)</th>
                                    <th class="p-4">Lingkar Pinggang (cm)</th>
                                    <th class="p-4">Panjang Celana (cm)</th>
                                    <th class="p-4">Lingkar Paha (cm)</th>
                                    <th class="p-4 rounded-r-xl">Lebar Ujung Kaki (cm)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr><td class="p-4 text-slate-950 font-bold">28</td><td class="p-4">74 cm</td><td class="p-4">98 cm</td><td class="p-4">48 cm</td><td class="p-4">14 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">30</td><td class="p-4">79 cm</td><td class="p-4">99 cm</td><td class="p-4">50 cm</td><td class="p-4">14.5 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">32</td><td class="p-4">84 cm</td><td class="p-4">100 cm</td><td class="p-4">52 cm</td><td class="p-4">15 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">34</td><td class="p-4">89 cm</td><td class="p-4">101 cm</td><td class="p-4">54 cm</td><td class="p-4">15.5 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">36</td><td class="p-4">94 cm</td><td class="p-4">102 cm</td><td class="p-4">56 cm</td><td class="p-4">16 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">38</td><td class="p-4">99 cm</td><td class="p-4">103 cm</td><td class="p-4">58 cm</td><td class="p-4">16.5 cm</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Regular Fit Table -->
                <div x-show="activeTab === 'regular'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-950">Potongan Regular Fit</h3>
                            <p class="text-slate-500 text-xs md:text-sm font-medium mt-1">Potongan lurus klasik yang memberikan ruang gerak seimbang dan kenyamanan ekstra.</p>
                        </div>
                        <span class="px-3.5 py-1.5 bg-indigo-50 border border-indigo-100 rounded-xl text-xs font-bold text-indigo-600 uppercase tracking-wider shrink-0">Classic Fit</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm font-medium text-slate-600">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-900 font-bold bg-slate-50">
                                    <th class="p-4 rounded-l-xl">Size (Inci)</th>
                                    <th class="p-4">Lingkar Pinggang (cm)</th>
                                    <th class="p-4">Panjang Celana (cm)</th>
                                    <th class="p-4">Lingkar Paha (cm)</th>
                                    <th class="p-4 rounded-r-xl">Lebar Ujung Kaki (cm)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr><td class="p-4 text-slate-950 font-bold">28</td><td class="p-4">78 cm</td><td class="p-4">102 cm</td><td class="p-4">54 cm</td><td class="p-4">18 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">30</td><td class="p-4">83 cm</td><td class="p-4">103 cm</td><td class="p-4">56 cm</td><td class="p-4">19 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">32</td><td class="p-4">88 cm</td><td class="p-4">104 cm</td><td class="p-4">58 cm</td><td class="p-4">20 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">34</td><td class="p-4">93 cm</td><td class="p-4">105 cm</td><td class="p-4">60 cm</td><td class="p-4">21 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">36</td><td class="p-4">98 cm</td><td class="p-4">106 cm</td><td class="p-4">62 cm</td><td class="p-4">22 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">38</td><td class="p-4">103 cm</td><td class="p-4">107 cm</td><td class="p-4">64 cm</td><td class="p-4">23 cm</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Loose Fit Table -->
                <div x-show="activeTab === 'loose'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-950">Potongan Loose Fit</h3>
                            <p class="text-slate-500 text-xs md:text-sm font-medium mt-1">Potongan longgar bergaya retro/oversized dari paha hingga kaki bawah untuk kenyamanan gerak ekstrem.</p>
                        </div>
                        <span class="px-3.5 py-1.5 bg-emerald-50 border border-emerald-100 rounded-xl text-xs font-bold text-emerald-600 uppercase tracking-wider shrink-0">Oversized Fit</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm font-medium text-slate-600">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-900 font-bold bg-slate-50">
                                    <th class="p-4 rounded-l-xl">Size (Inci)</th>
                                    <th class="p-4">Lingkar Pinggang (cm)</th>
                                    <th class="p-4">Panjang Celana (cm)</th>
                                    <th class="p-4">Lingkar Paha (cm)</th>
                                    <th class="p-4 rounded-r-xl">Lebar Ujung Kaki (cm)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr><td class="p-4 text-slate-950 font-bold">28</td><td class="p-4">80 cm</td><td class="p-4">102 cm</td><td class="p-4">58 cm</td><td class="p-4">20 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">30</td><td class="p-4">85 cm</td><td class="p-4">103 cm</td><td class="p-4">60 cm</td><td class="p-4">21 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">32</td><td class="p-4">90 cm</td><td class="p-4">104 cm</td><td class="p-4">62 cm</td><td class="p-4">22 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">34</td><td class="p-4">95 cm</td><td class="p-4">105 cm</td><td class="p-4">64 cm</td><td class="p-4">23 cm</td></tr>
                                <tr><td class="p-4 text-slate-950 font-bold">36</td><td class="p-4">100 cm</td><td class="p-4">106 cm</td><td class="p-4">66 cm</td><td class="p-4">24 cm</td></tr>
                                <tr class="bg-slate-50/50"><td class="p-4 text-slate-950 font-bold">38</td><td class="p-4">105 cm</td><td class="p-4">107 cm</td><td class="p-4">68 cm</td><td class="p-4">25 cm</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Measurement Guide --}}
            <div class="bg-white rounded-3xl border border-slate-200/60 p-8 shadow-lg shadow-slate-200/30">
                <h3 class="text-xl font-extrabold text-slate-950 mb-6 tracking-tight">Cara Mengukur Ukuran Celana Anda</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center font-bold text-[#1D4ED8] shrink-0 text-sm">1</span>
                            <div>
                                <h4 class="font-bold text-slate-950">Lingkar Pinggang</h4>
                                <p class="text-slate-500 text-xs md:text-sm leading-relaxed mt-1">Ukur lingkar pinggang Anda tepat di tempat biasa Anda memakai celana jeans. Gunakan meteran kain dengan melingkar horizontal secara santai, jangan ditarik terlalu kencang.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center font-bold text-[#1D4ED8] shrink-0 text-sm">2</span>
                            <div>
                                <h4 class="font-bold text-slate-950">Panjang Celana</h4>
                                <p class="text-slate-500 text-xs md:text-sm leading-relaxed mt-1">Ukur dari jahitan pinggang bagian atas celana ke arah bawah secara vertikal hingga ke pergelangan kaki atau batas panjang celana yang Anda inginkan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center font-bold text-[#1D4ED8] shrink-0 text-sm">3</span>
                            <div>
                                <h4 class="font-bold text-slate-950">Lingkar Paha</h4>
                                <p class="text-slate-500 text-xs md:text-sm leading-relaxed mt-1">Ukur lingkar paha terbesar Anda (tepat di bawah selangkangan). Hal ini penting untuk tipe potongan slim-fit dan skinny agar tidak terlalu sesak saat berjalan atau duduk.</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl border border-slate-200/60 p-4 flex gap-3 items-center">
                            <div class="text-amber-500 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed"><strong>Saran:</strong> Jika Anda ragu di antara dua ukuran, pilihlah ukuran yang lebih besar untuk kenyamanan pergerakan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
