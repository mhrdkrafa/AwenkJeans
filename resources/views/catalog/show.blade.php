<x-app-layout>
    @php
        $reviews = $product->reviews;
        $totalReviews = $reviews->count();
        $avgRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 4.8;
        
        // Rating distribution
        $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reviews as $review) {
            $r = (int)$review->rating;
            if (isset($distribution[$r])) {
                $distribution[$r]++;
            }
        }
        
        // Dynamic breakdown calculation in percentages
        $distributionPercent = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        if ($totalReviews > 0) {
            foreach ($distribution as $stars => $count) {
                $distributionPercent[$stars] = round(($count / $totalReviews) * 100);
            }
        } else {
            $distributionPercent = [5 => 82, 4 => 12, 3 => 4, 2 => 1, 1 => 1];
        }

        // Fetch sibling products of the same name+category to dynamically link sizes
        $siblingsCollection = \App\Models\Product::where('name', $product->name)
            ->where('category_id', $product->category_id)
            ->with('size')
            ->get();
        
        $siblings = $siblingsCollection->keyBy(function($p) {
            return $p->size->name ?? '';
        });

        // Build JSON map for Alpine.js: { "28": { stock: 99, slug: "mamet-jeans" }, "29": { stock: 50, slug: "mamet-jeans-1" } }
        $siblingsMap = [];
        foreach ($siblingsCollection as $s) {
            $sizeName = $s->size->name ?? '';
            if ($sizeName) {
                $siblingsMap[$sizeName] = [
                    'stock' => $s->stock,
                    'slug' => $s->slug,
                    'id' => $s->id,
                ];
            }
        }

        $totalStock = $siblingsCollection->sum('stock');
        $allSizes = \App\Models\Size::all();
        $mainImageUrl = $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&q=80&w=600';
    @endphp

    <div class="bg-slate-50 min-h-screen pb-20" x-data="{ 
        activeImage: '{{ $mainImageUrl }}', 
        activeTab: 1, 
        activeZoom: false, 
        sizeGuideOpen: false, 
        wishlisted: false,
        selectedSize: '{{ $product->size->name ?? '' }}',
        siblingsMap: {{ json_encode($siblingsMap) }},
        get currentStock() {
            if (this.selectedSize && this.siblingsMap[this.selectedSize]) {
                return this.siblingsMap[this.selectedSize].stock;
            }
            return {{ $product->stock }};
        },
        get currentSlug() {
            if (this.selectedSize && this.siblingsMap[this.selectedSize]) {
                return this.siblingsMap[this.selectedSize].slug;
            }
            return '{{ $product->slug }}';
        },
        get waLink() {
            return 'https://wa.me/628123456789?text=Halo%20Awenk%20Jeans,%20saya%20tertarik%20dengan%20produk%20' + encodeURIComponent('{{ $product->name }}') + ' (Ukuran: ' + encodeURIComponent(this.selectedSize) + ')';
        }
    }">
        {{-- Breadcrumbs & Top Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <nav class="flex text-xs font-medium text-slate-500 tracking-wide uppercase mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Katalog</a></li>
                    <li class="text-slate-600">/</li>
                    <li><a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-slate-900 transition-colors">{{ $product->category->name }}</a></li>
                    <li class="text-slate-600">/</li>
                    <li class="text-slate-900 font-semibold">{{ $product->name }}</li>
                </ol>
            </nav>

            {{-- Main Layout Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                {{-- Left: Image Gallery (Takes 7 cols on lg) --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="relative bg-white rounded-2xl overflow-hidden aspect-[4/5] border border-slate-200 shadow-sm group">
                        <!-- Main Product Image with dynamic transform depending on activeTab crop effect -->
                        <img 
                            :src="activeImage" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover transition-all duration-700 ease-out"
                            :class="{ 
                                'object-center scale-100': activeTab === 1,
                                'origin-top scale-125 object-top': activeTab === 2,
                                'origin-bottom scale-125 object-bottom': activeTab === 3,
                                'origin-center scale-150': activeTab === 4 
                            }"
                        >

                        <!-- Stock Badge -->
                        @if($product->stock <= 5 && $product->stock > 0)
                            <span class="absolute top-6 left-6 rounded-full bg-amber-500/90 backdrop-blur px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-900 shadow">
                                Stok Terbatas ({{ $product->stock }})
                            </span>
                        @elseif($product->stock == 0)
                            <span class="absolute top-6 left-6 rounded-full bg-rose-600/90 backdrop-blur px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-900 shadow">
                                Habis Terjual
                            </span>
                        @else
                            <span class="absolute top-6 left-6 rounded-full bg-slate-100/90 backdrop-blur px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-900 shadow border border-slate-200">
                                Tersedia
                            </span>
                        @endif

                        <!-- Magnifier Icon Button -->
                        <button 
                            @click="activeZoom = true" 
                            class="absolute top-6 right-6 p-3 rounded-full bg-slate-50/80 backdrop-blur border border-slate-200 hover:bg-[#1D4ED8] hover:border-[#1D4ED8] text-white shadow transition duration-200 focus:outline-none"
                            aria-label="Perbesar Gambar"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Thumbnails row -->
                    <div class="grid grid-cols-4 gap-4">
                        <button 
                            @click="activeTab = 1" 
                            class="relative aspect-[4/5] rounded-xl overflow-hidden bg-white border-2 transition-all"
                            :class="activeTab === 1 ? 'border-[#1D4ED8] shadow' : 'border-transparent hover:border-slate-300'"
                        >
                            <img src="{{ $mainImageUrl }}" alt="View 1" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
                        </button>
                        <button 
                            @click="activeTab = 2" 
                            class="relative aspect-[4/5] rounded-xl overflow-hidden bg-white border-2 transition-all"
                            :class="activeTab === 2 ? 'border-[#1D4ED8] shadow' : 'border-transparent hover:border-slate-300'"
                        >
                            <img src="{{ $mainImageUrl }}" alt="View 2 (Zoom Top)" class="w-full h-full object-cover origin-top scale-125 object-top opacity-80 hover:opacity-100 transition-opacity">
                        </button>
                        <button 
                            @click="activeTab = 3" 
                            class="relative aspect-[4/5] rounded-xl overflow-hidden bg-white border-2 transition-all"
                            :class="activeTab === 3 ? 'border-[#1D4ED8] shadow' : 'border-transparent hover:border-slate-300'"
                        >
                            <img src="{{ $mainImageUrl }}" alt="View 3 (Zoom Bottom)" class="w-full h-full object-cover origin-bottom scale-125 object-bottom opacity-80 hover:opacity-100 transition-opacity">
                        </button>
                        <button 
                            @click="activeTab = 4" 
                            class="relative aspect-[4/5] rounded-xl overflow-hidden bg-white border-2 transition-all"
                            :class="activeTab === 4 ? 'border-[#1D4ED8] shadow' : 'border-transparent hover:border-slate-300'"
                        >
                            <img src="{{ $mainImageUrl }}" alt="View 4 (Close-up)" class="w-full h-full object-cover origin-center scale-150 opacity-80 hover:opacity-100 transition-opacity">
                        </button>
                    </div>
                </div>

                {{-- Right: Product Details (Takes 5 cols on lg) --}}
                <div class="lg:col-span-5 space-y-8">
                    
                    {{-- Badges & Title --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="rounded-full bg-slate-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-600 border border-slate-200">
                                {{ $product->category->name }}
                            </span>
                            @if($product->created_at && $product->created_at->diffInDays() < 30)
                                <span class="rounded-full bg-[#1D4ED8]/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#1D4ED8] border border-[#1D4ED8]/20">
                                    Koleksi Baru
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-3">
                            {{ $product->name }}
                        </h1>
                        
                        {{-- Rating Summary --}}
                        <div class="flex items-center space-x-3 text-sm">
                            <div class="flex items-center text-[#1D4ED8]">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'fill-current' : 'text-slate-600' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="font-bold text-slate-600">{{ $avgRating }}</span>
                            <span class="text-slate-600">|</span>
                            <a href="#reviews" class="text-slate-500 hover:text-[#1D4ED8] underline transition">
                                {{ $totalReviews }} Ulasan
                            </a>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="border-b border-slate-200 pb-6">
                        <span class="text-3xl font-black text-slate-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <p class="text-xs text-slate-500 mt-1 font-medium font-sans">Stok: <span x-text="currentStock" class="font-semibold" :class="currentStock > 0 ? 'text-green-500' : 'text-red-500'"></span> Pcs | Brand: {{ $product->brand ?: 'Awenk Jeans' }}</p>
                    </div>

                    {{-- Description --}}
                    <div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Deskripsi Produk</h2>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            {{ $product->description ?: 'Jeans premium dengan potongan eksklusif yang dirancang untuk kenyamanan maksimal sepanjang hari. Dibuat menggunakan bahan denim berkualitas tinggi yang tahan lama dan memiliki detail jahitan yang presisi.' }}
                        </p>
                    </div>

                    {{-- Size Selector --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-slate-900 uppercase tracking-widest">Ukuran (Waist)</span>
                            <button 
                                @click="sizeGuideOpen = true"
                                class="text-xs font-semibold text-[#1D4ED8] hover:text-slate-900 transition flex items-center gap-1.5 focus:outline-none cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Panduan Ukuran
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allSizes as $size)
                                @php
                                    $siblingProduct = $siblings->get($size->name);
                                @endphp
                                @if($siblingProduct)
                                    <button 
                                        @click="selectedSize = '{{ $size->name }}'"
                                        class="min-w-[48px] h-11 flex items-center justify-center rounded-lg border text-sm font-bold transition focus:outline-none cursor-pointer"
                                        :class="selectedSize === '{{ $size->name }}' ? 'bg-[#1D4ED8] border-[#1D4ED8] text-white shadow-sm' : 'bg-transparent border-slate-200 text-slate-600 hover:border-[#1D4ED8] hover:text-[#1D4ED8]'"
                                        title="Pilih ukuran {{ $size->name }} - Stok: {{ $siblingProduct->stock }}"
                                    >
                                        {{ $size->name }}
                                    </button>
                                @else
                                    <span 
                                        class="min-w-[48px] h-11 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-bold relative overflow-hidden cursor-not-allowed"
                                        title="Ukuran {{ $size->name }} tidak tersedia"
                                    >
                                        {{ $size->name }}
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-full h-[1px] bg-slate-600 transform -rotate-45"></div>
                                        </div>
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- {{-- Actions Bar: WhatsApp & Wishlist --}}
                    <div class="flex items-center gap-4 pt-2">
                        <a 
                            :href="waLink"
                            target="_blank"
                            class="flex-1 bg-[#1D4ED8] hover:bg-orange-600 text-white h-14 rounded-xl flex items-center justify-center gap-2 font-bold text-sm transition-all shadow-[0_0_20px_rgba(232,93,64,0.3)] hover:shadow-[0_0_25px_rgba(232,93,64,0.5)] cursor-pointer"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.245 3.481 5.226 3.48 8.411-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.657zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.898-4.45 9.898-9.898 0-5.448-4.45-9.897-9.898-9.897-5.448 0-9.898 4.449-9.898 9.897 0 2.062.585 3.963 1.618 5.655l-1.026 3.746 3.869-1.095zm11.586-6.06c-.659-.33-3.896-1.924-4.502-2.146-.605-.221-1.047-.33-1.488.33-.441.661-1.705 2.146-2.091 2.587-.386.441-.772.496-1.431.165-4.275-2.138-6.108-6.666-6.329-7.039-.221-.373-.024-.576.155-.773.167-.183.375-.436.562-.654.188-.218.251-.373.377-.621.125-.248.063-.465-.019-.63-.082-.165-1.488-3.593-2.039-4.919-.537-1.296-1.082-1.12-1.488-1.14-.385-.02-.826-.021-1.267-.021-.441 0-1.157.165-1.762.826-.605.661-2.313 2.259-2.313 5.503 0 3.244 2.368 6.381 2.699 6.822.33.441 4.654 7.106 11.272 9.967 1.576.681 2.809 1.087 3.771 1.393 1.58.502 3.018.43 4.156.261 1.28-.19 3.896-1.593 4.446-3.136.551-1.543.551-2.864.386-3.14-.165-.276-.605-.441-1.264-.772z"/></svg>
                            Pesan via WhatsApp
                        </a>
                        <button 
                            @click="wishlisted = !wishlisted"
                            class="h-14 w-14 rounded-xl border flex items-center justify-center transition-all focus:outline-none cursor-pointer"
                            :class="wishlisted ? 'border-rose-500 bg-rose-500 text-slate-900 shadow-lg shadow-rose-500/30' : 'border-slate-200 bg-white text-slate-500 hover:border-white/30 hover:text-slate-900'"
                            aria-label="Tambah ke Wishlist"
                        >
                            <svg class="w-6 h-6" :class="wishlisted ? 'fill-current' : 'fill-none'" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div> -->

                    {{-- Fabric/Jeans Highlights --}}
                    <div class="grid grid-cols-3 gap-3 py-6 border-y border-slate-200 text-center">
                        <div class="space-y-1">
                            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-900 mx-auto">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold text-slate-900 uppercase tracking-wider">Premium Denim</p>
                            <p class="text-[9px] text-slate-500">100% Katun Murni</p>
                        </div>
                        <div class="space-y-1">
                            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-900 mx-auto">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold text-slate-900 uppercase tracking-wider">Jahitan Kuat</p>
                            <p class="text-[9px] text-slate-500">Jahitan Rantai Ganda</p>
                        </div>
                        <div class="space-y-1">
                            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-900 mx-auto">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold text-slate-900 uppercase tracking-wider">Bahan Stretch</p>
                            <p class="text-[9px] text-slate-500">Lentur & Nyaman</p>
                        </div>
                    </div>

                    {{-- Delivery/Shipping Info Box --}}
                    <div class="bg-white rounded-2xl p-6 space-y-4 border border-slate-200">
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Garansi Retur</h4>
                                <p class="text-[11px] text-slate-500 mt-0.5">Penukaran ukuran gratis dalam waktu 3 hari sejak produk diterima.</p>
                            </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Reviews Section --}}
        <div id="reviews" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
            <div class="border-t border-slate-200 pt-16">
                <div class="mb-10">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ulasan Pelanggan</h2>
                    <p class="text-xs text-slate-500 mt-1">Lihat testimonial asli dan ulasan produk dari pelanggan setia Awenk Jeans.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    
                    {{-- Reviews Score Summary (Takes 4 cols on lg) --}}
                    <div class="lg:col-span-4 bg-white rounded-2xl p-8 border border-slate-200 space-y-6">
                        <div class="text-center">
                            <span class="text-6xl font-black text-slate-900 tracking-tighter" x-text="'{{ $avgRating }}'"></span>
                            <div class="flex justify-center text-[#1D4ED8] my-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'fill-current' : 'text-slate-700' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-xs text-slate-500 font-medium font-sans">Berdasarkan {{ $totalReviews }} Ulasan</p>
                        </div>

                        {{-- Breakdown bars --}}
                        <div class="space-y-3 pt-2">
                            @foreach([5, 4, 3, 2, 1] as $star)
                                <div class="flex items-center text-xs text-slate-500">
                                    <span class="w-3 font-semibold">{{ $star }}</span>
                                    <svg class="w-3 h-3 text-[#1D4ED8] fill-current mx-1 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <div class="flex-1 h-2 bg-slate-50 rounded-full overflow-hidden mx-2 border border-slate-200">
                                        <div class="h-full bg-[#1D4ED8] rounded-full" style="width: {{ $distributionPercent[$star] }}%"></div>
                                    </div>
                                    <span class="w-8 text-right font-medium text-slate-500">{{ $distributionPercent[$star] }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reviews Feed & Form (Takes 8 cols on lg) --}}
                    <div class="lg:col-span-8 space-y-6">
                        
                        {{-- Review List --}}
                        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-[#333] scrollbar-track-[#1a1a1a]">
                            @forelse ($product->reviews as $review)
                                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition hover:shadow-md">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $reviewerName = optional($review->user)->name ?: 'Pelanggan';
                                                $initial = strtoupper(substr($reviewerName, 0, 2));
                                                $avatarStyle = 'bg-slate-50 text-slate-600 border-slate-200';
                                            @endphp
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-xs uppercase tracking-widest border {{ $avatarStyle }}">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900 leading-none">{{ $reviewerName }}</p>
                                                <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest font-semibold font-sans">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex text-[#1D4ED8]">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-700' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed">
                                        "{{ $review->comment ?: 'Produk yang luar biasa, bahan tebal dan sangat pas digunakan.' }}"
                                    </p>
                                    @if($review->image)
                                        <div class="mt-4 border-t border-slate-200 pt-4">
                                            <a href="{{ asset('storage/' . $review->image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $review->image) }}" alt="Foto Ulasan" class="w-24 h-24 object-cover rounded-xl border border-slate-200 shadow-sm cursor-zoom-in hover:opacity-90 transition">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-slate-500 p-12 rounded-2xl border border-dashed border-slate-200 text-center">
                                    <div class="h-12 w-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-500 border border-slate-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 text-sm font-semibold">Belum ada ulasan untuk produk ini.</p>
                                    <p class="text-xs text-slate-500 mt-1">Jadilah yang pertama untuk membagikan pengalaman Anda!</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Write Review --}}
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h3 class="font-extrabold text-slate-900 mb-4 text-base border-b border-slate-200 pb-3">Tulis Ulasan</h3>
                            
                            @if(session('error'))
                                <div class="mb-4 rounded-xl bg-rose-500/10 p-4 text-xs font-semibold text-rose-500 border border-rose-500/20 animate-pulse">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="mb-4 rounded-xl bg-emerald-500/10 p-4 text-xs font-semibold text-emerald-500 border border-emerald-500/20">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @auth
                                <div class="mb-4 rounded-xl bg-slate-50 border border-slate-200 p-4 flex items-center justify-between">
                                    <p class="text-xs font-medium text-slate-500">Beri ulasan sebagai: <span class="font-bold ml-1 text-slate-900">{{ auth()->user()->name }}</span></p>
                                </div>

                                <form action="{{ route('catalog.reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Rating</label>
                                        <select name="rating" required class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-900 focus:border-[#1D4ED8] focus:ring-[#1D4ED8] text-sm cursor-pointer outline-none">
                                            <option value="5">5 Bintang - Sangat Puas</option>
                                            <option value="4">4 Bintang - Puas</option>
                                            <option value="3">3 Bintang - Cukup</option>
                                            <option value="2">2 Bintang - Kurang</option>
                                            <option value="1">1 Bintang - Sangat Kecewa</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Ulasan Singkat</label>
                                        <textarea name="comment" rows="3" placeholder="Ceritakan detail kenyamanan produk, ketebalan bahan, ukuran pas, dll..." class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-900 placeholder-slate-500 focus:border-[#1D4ED8] focus:ring-[#1D4ED8] text-sm outline-none"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Foto Produk (Opsional)</label>
                                        <div class="relative w-full rounded-xl border-2 border-dashed border-slate-200 hover:border-[#1D4ED8]/50 bg-slate-50 p-6 text-center cursor-pointer transition">
                                            <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            <svg class="mx-auto h-8 w-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-2 text-xs font-bold text-slate-600">Pilih Foto atau Seret ke Sini</p>
                                            <p class="text-[10px] text-slate-500 mt-1 font-sans">PNG, JPG up to 2MB</p>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full rounded-xl bg-white py-3 text-sm font-bold text-[#1a1a1a] transition hover:bg-slate-200 shadow-sm active:scale-[0.99] cursor-pointer">
                                        Kirim Ulasan Sekarang
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-8">
                                    <div class="h-12 w-12 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-500">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-slate-600 font-semibold mb-4">Silakan login terlebih dahulu untuk memberikan ulasan produk.</p>
                                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-white px-6 py-3 text-xs font-bold text-[#1a1a1a] transition hover:bg-slate-200 shadow cursor-pointer">
                                        Login untuk Mengulas
                                    </a>
                                    <p class="text-xs text-slate-500 mt-4 font-sans">Belum punya akun? <a href="{{ route('register') }}" class="text-slate-900 hover:underline font-bold">Daftar sekarang</a></p>
                                </div>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24">
            <div class="border-t border-slate-200 pt-16">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Koleksi Terkait</h2>
                        <p class="text-xs text-slate-500 mt-1">Lengkapi penampilan Anda dengan jeans denim pilihan terbaik kami.</p>
                    </div>
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-xs font-bold text-slate-900 hover:text-[#1D4ED8] transition flex items-center gap-1.5 focus:outline-none cursor-pointer">
                        Lihat Semua
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <div class="group flex flex-col bg-white rounded-2xl border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-[0_8px_30px_rgba(0,0,0,0.5)] hover:-translate-y-1 hover:border-slate-200 relative">
                        <div class="aspect-[4/5] overflow-hidden bg-slate-50 relative">
                            <img 
                                src="{{ $related->image ? asset('storage/'.$related->image) : 'https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&q=80&w=400' }}" 
                                alt="{{ $related->name }}" 
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100"
                            >
                            <a href="{{ route('catalog.show', $related->slug) }}" class="absolute inset-0 z-10 cursor-pointer" aria-label="Lihat detail {{ $related->name }}"></a>
                        </div>
                        <div class="p-5 space-y-2 relative">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-500 block">{{ $related->category->name }}</span>
                            <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-[#1D4ED8] transition-colors truncate">
                                {{ $related->name }}
                            </h3>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-sm font-black text-slate-900">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded px-1.5 py-0.5">
                                    Size {{ $related->size->name ?? '-' }}
                                </span>
                            </div>
                            
                            {{-- Hover Explore text --}}
                            <div class="absolute bottom-5 right-5 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                <span class="text-[10px] font-black text-[#1D4ED8] uppercase tracking-widest flex items-center gap-1">
                                    Explore <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Modals Section --}}
        
        {{-- Size Guide Modal --}}
        <div 
            x-show="sizeGuideOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-50/80 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="sizeGuideOpen = false"
        >
            <div 
                @click.away="sizeGuideOpen = false"
                class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative"
            >
                <button 
                    @click="sizeGuideOpen = false"
                    class="absolute top-4 right-4 text-slate-500 hover:text-slate-900 transition cursor-pointer"
                    aria-label="Tutup"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 class="text-lg font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Panduan Ukuran Jeans Awenk
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-500 border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-600 font-bold bg-slate-50">
                                <th class="py-3 px-4">Size (Waist)</th>
                                <th class="py-3 px-4">Lingkar Pinggang (cm)</th>
                                <th class="py-3 px-4">Panjang Celana (cm)</th>
                                <th class="py-3 px-4">Lebar Paha (cm)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 font-medium">
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">28</td>
                                <td class="py-3 px-4">72 - 74</td>
                                <td class="py-3 px-4">98</td>
                                <td class="py-3 px-4">54</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">29</td>
                                <td class="py-3 px-4">74 - 76</td>
                                <td class="py-3 px-4">98</td>
                                <td class="py-3 px-4">55</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">30</td>
                                <td class="py-3 px-4">77 - 79</td>
                                <td class="py-3 px-4">99</td>
                                <td class="py-3 px-4">56</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">31</td>
                                <td class="py-3 px-4">79 - 81</td>
                                <td class="py-3 px-4">99</td>
                                <td class="py-3 px-4">57</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">32</td>
                                <td class="py-3 px-4">82 - 84</td>
                                <td class="py-3 px-4">100</td>
                                <td class="py-3 px-4">58</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">33</td>
                                <td class="py-3 px-4">84 - 86</td>
                                <td class="py-3 px-4">100</td>
                                <td class="py-3 px-4">59</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-900">34</td>
                                <td class="py-3 px-4">87 - 89</td>
                                <td class="py-3 px-4">101</td>
                                <td class="py-3 px-4">60</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="text-[10px] text-slate-500 mt-4 leading-relaxed font-sans">
                    *Ukuran dapat berbeda 1-2 cm karena proses produksi. Harap pastikan kembali ukuran pinggang Anda sebelum memesan. Anda bisa berkonsultasi via WhatsApp jika ragu.
                </p>
            </div>
        </div>

        {{-- Image Gallery Zoom Modal --}}
        <div 
            x-show="activeZoom"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-100/95 backdrop-blur-md"
            style="display: none;"
            @keydown.escape.window="activeZoom = false"
        >
            <div class="relative max-w-4xl w-full flex items-center justify-center">
                <button 
                    @click="activeZoom = false"
                    class="absolute -top-12 right-0 text-slate-500 hover:text-slate-900 transition flex items-center gap-1 text-sm font-semibold focus:outline-none cursor-pointer"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup
                </button>
                <img 
                    :src="activeImage" 
                    alt="{{ $product->name }}" 
                    class="max-h-[85vh] max-w-full rounded-2xl object-contain shadow-2xl"
                >
            </div>
        </div>

    </div>
</x-app-layout>
