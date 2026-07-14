<x-app-layout>
    {{-- Spacer for fixed navbar --}}
    <div class="h-[80px] md:h-[100px] bg-slate-50"></div>

    <div x-data="{ filterOpen: false }" class="bg-slate-50 min-h-screen font-sans text-slate-900">
        
        {{-- HERO SECTION --}}
        <div class="relative overflow-hidden bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center py-16 gap-12 relative z-10">
                    <div class="lg:w-1/2">
                        <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] mb-6 tracking-tighter uppercase">
                            Timeless<br>Fashion,<br>Modern <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1D4ED8] to-blue-400">Soul</span>
                        </h1>
                        <p class="text-slate-500 max-w-md mb-8 text-sm md:text-base leading-relaxed font-medium">
                            Koleksi denim premium dengan potongan klasik, dirancang untuk kenyamanan dan gaya sejati. Jelajahi koleksi terbaru kami.
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="#catalog-grid" class="px-8 py-3.5 bg-[#1D4ED8] hover:bg-blue-800 text-white font-bold rounded-full transition-all text-xs md:text-sm uppercase tracking-wider shadow-lg shadow-blue-500/30">
                                Shop Now
                            </a>
                            <a href="#catalog-grid" class="px-8 py-3.5 bg-transparent border border-slate-300 hover:border-slate-500 text-slate-700 font-bold rounded-full transition-all text-xs md:text-sm uppercase tracking-wider">
                                2026 Collection
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/2 relative w-full">
                        {{-- Hero Image --}}
                        <div class="aspect-[4/3] md:aspect-[4/3] lg:aspect-[4/3] rounded-3xl overflow-hidden relative shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&q=80&w=1200" alt="Hero Model" class="w-full h-full object-cover object-top">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-90"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PROMO MARQUEE --}}
        <div class="bg-[#D97706] py-3 overflow-hidden whitespace-nowrap border-y border-amber-700">
            <div class="marquee-content font-black uppercase text-xs md:text-sm tracking-[0.2em] text-white flex">
                <div class="flex-shrink-0 flex items-center">
                    <span class="mx-6">Selamat datang di AwenkJeans!</span> &bull; 
                    <span class="mx-6">Selamat berbelanja dan temukan koleksi favorit Anda</span> &bull; 
                    <span class="mx-6">Selamat datang di AwenkJeans!</span> &bull; 
                    <span class="mx-6">Selamat berbelanja dan temukan koleksi favorit Anda</span> &bull; 
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <span class="mx-6">Selamat datang di AwenkJeans!</span> &bull; 
                    <span class="mx-6">Selamat berbelanja dan temukan koleksi favorit Anda</span> &bull; 
                    <span class="mx-6">Selamat datang di AwenkJeans!</span> &bull; 
                    <span class="mx-6">Selamat berbelanja dan temukan koleksi favorit Anda</span> &bull; 
                </div>
            </div>
        </div>

        {{-- CATALOG SECTION --}}
        <div id="catalog-grid" class="max-w-7xl mx-auto px-4 py-20 relative">
            
            {{-- Section Header & Horizontal Categories --}}
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 gap-8">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tighter leading-tight">
                    Where Modesty<br>Meets <span class="text-[#1D4ED8] relative inline-block">Style<svg class="absolute -bottom-2 left-0 w-full text-[#1D4ED8]" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 15 100 5" stroke="currentColor" stroke-width="3" fill="none"/></svg></span>
                </h2>
                
                {{-- Horizontal Pills (Categories + Filter Button) --}}
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('catalog.index') }}" class="px-5 py-2.5 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-all {{ !request('category') ? 'bg-[#1D4ED8] text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="px-5 py-2.5 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider transition-all {{ request('category') == $cat->slug ? 'bg-[#1D4ED8] text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                    
                    {{-- Filter Button --}}
                    <button @click="filterOpen = true" class="px-5 py-2.5 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider bg-white hover:bg-slate-50 text-slate-800 transition-all ml-auto lg:ml-4 flex items-center gap-2 border border-slate-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filters
                        @if(request()->hasAny(['size', 'min_price', 'max_price', 'gender', 'color']))
                            <span class="w-2 h-2 bg-[#D97706] rounded-full"></span>
                        @endif
                    </button>
                </div>
            </div>

            {{-- Active Filters indicator --}}
            @if(request()->hasAny(['size', 'min_price', 'max_price', 'gender', 'color', 'brand']))
            <div class="flex flex-wrap items-center gap-2 mb-8 -mt-4">
                <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">Active Filters:</span>
                @if(request('size'))
                <span class="px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-bold rounded-full">
                    Size: {{ \App\Models\Size::find(request('size'))->name ?? request('size') }}
                </span>
                @endif
                @if(request('gender'))
                <span class="px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-bold rounded-full">
                    Gender: {{ ucfirst(request('gender')) }}
                </span>
                @endif
                @if(request('color'))
                <span class="px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-bold rounded-full">
                    Warna: {{ request('color') }}
                </span>
                @endif
                @if(request('brand'))
                <span class="px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-bold rounded-full">
                    Brand: {{ request('brand') }}
                </span>
                @endif
                @if(request('min_price') || request('max_price'))
                <span class="px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-bold rounded-full">
                    Price: Rp {{ number_format(request('min_price', 0), 0, ',', '.') }} - Rp {{ request('max_price') ? number_format(request('max_price'), 0, ',', '.') : 'Max' }}
                </span>
                @endif
                <a href="{{ route('catalog.index', ['category' => request('category')]) }}" class="text-[10px] text-rose-500 hover:text-rose-700 font-bold underline ml-2">Clear All</a>
            </div>
            @endif

            {{-- Products Grid --}}
            @if($products->isEmpty())
                <div class="py-20 text-center bg-white rounded-3xl border border-slate-200 shadow-sm">
                    <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-4 text-lg font-bold text-slate-900 uppercase tracking-wide">Tidak Ada Produk</h3>
                    <p class="mt-2 text-slate-500 text-sm">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                    <a href="{{ route('catalog.index') }}" class="mt-6 inline-block px-6 py-2.5 bg-[#1D4ED8] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-blue-800 transition">Reset Filter</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col relative">
                            {{-- Image Container --}}
                            <a href="{{ route('catalog.show', $product->slug) }}" class="relative aspect-[4/5] overflow-hidden bg-slate-100 block">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                        <svg class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif


                                
                                {{-- Hover Actions Overlay --}}
                                <div class="absolute inset-0 bg-slate-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                                    <button class="w-10 h-10 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-[#1D4ED8] hover:text-white transition-colors shadow-lg scale-0 group-hover:scale-100 duration-300 delay-75">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    </button>
                                </div>
                            </a>

                            {{-- Product Info --}}
                            <div class="p-5 flex flex-col flex-1">
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-2">{{ $product->category->name }}</div>
                                <h3 class="text-base font-black text-slate-900 uppercase tracking-tight mb-2 line-clamp-1 group-hover:text-[#1D4ED8] transition-colors">
                                    <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                
                                <div class="flex items-center gap-1 mb-2">
                                    <span class="text-[10px] text-slate-500 font-semibold mr-1">SIZE:</span>
                                    @php
                                        $availableSizes = $product->available_sizes ?? [];
                                    @endphp
                                    @forelse(array_slice($availableSizes, 0, 4) as $sz)
                                        <span class="text-[10px] font-bold text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded">{{ $sz }}</span>
                                    @empty
                                        <span class="text-[10px] font-bold text-rose-500 bg-rose-50 px-1.5 py-0.5 rounded">Habis</span>
                                    @endforelse
                                    @if(count($availableSizes) > 4)
                                        <span class="text-[10px] font-bold text-slate-500">...</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 mb-4">
                                    @if($product->color)
                                        <span class="text-[10px] font-bold text-slate-500 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-[#1D4ED8] inline-block"></span>
                                            {{ $product->color }}
                                        </span>
                                    @endif
                                    @if($product->gender && $product->gender !== 'unisex')
                                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $product->gender === 'pria' ? 'text-blue-600 bg-blue-50 border-blue-200' : 'text-pink-600 bg-pink-50 border-pink-200' }} border px-2 py-0.5 rounded-full">
                                            {{ $product->gender }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-auto flex items-center justify-between">
                                    <div>
                                        <div class="text-lg font-black text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    </div>
                                    <a href="{{ route('catalog.show', $product->slug) }}" class="w-8 h-8 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center hover:bg-[#1D4ED8] hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-16 text-center">
                    {{ $products->links() }}
                </div>
            @endif

        </div>

        {{-- SLIDE-OVER FILTER PANEL --}}
        <div x-show="filterOpen" style="display: none;" class="relative z-[100]" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div x-show="filterOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="filterOpen = false"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="filterOpen"
                             x-transition:enter="transform transition ease-in-out duration-300"
                             x-transition:enter-start="translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transform transition ease-in-out duration-300"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="translate-x-full"
                             class="pointer-events-auto relative w-screen max-w-md">
                             
                            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl border-l border-slate-200">
                                <div class="px-6 py-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10">
                                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-widest" id="slide-over-title">Filter Produk</h2>
                                    <button type="button" @click="filterOpen = false" class="rounded-full w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-500 hover:text-slate-900 transition">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="relative mt-6 flex-1 px-6">
                                    <form action="{{ route('catalog.index') }}" method="GET" class="space-y-8" id="filterForm">
                                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif

                                        <div>
                                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Ukuran</h3>
                                            <div class="grid grid-cols-4 gap-2">
                                                @foreach(\App\Models\Size::orderBy('name')->get() as $size)
                                                <label class="relative">
                                                    <input type="radio" name="size" value="{{ $size->id }}" class="peer sr-only" {{ request('size') == $size->id ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                                    <div class="flex items-center justify-center px-3 py-2 text-sm font-bold border border-slate-200 rounded-xl cursor-pointer text-slate-500 hover:border-slate-300 peer-checked:border-[#1D4ED8] peer-checked:bg-[#1D4ED8] peer-checked:text-white transition-all">
                                                        {{ $size->name }}
                                                    </div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="border-t border-slate-100 pt-8">
                                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Jenis Kelamin</h3>
                                            <div class="grid grid-cols-3 gap-2">
                                                @foreach(['pria' => 'Pria', 'wanita' => 'Wanita', 'unisex' => 'Unisex'] as $genderVal => $genderLabel)
                                                <label class="relative">
                                                    <input type="radio" name="gender" value="{{ $genderVal }}" class="peer sr-only" {{ request('gender') == $genderVal ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                                    <div class="flex items-center justify-center px-3 py-2 text-sm font-bold border border-slate-200 rounded-xl cursor-pointer text-slate-500 hover:border-slate-300 peer-checked:border-[#1D4ED8] peer-checked:bg-[#1D4ED8] peer-checked:text-white transition-all">
                                                        {{ $genderLabel }}
                                                    </div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        @if($availableColors->count() > 0)
                                        <div class="border-t border-slate-100 pt-8">
                                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Warna</h3>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($availableColors as $colorOption)
                                                <label class="relative">
                                                    <input type="radio" name="color" value="{{ $colorOption }}" class="peer sr-only" {{ request('color') == $colorOption ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                                    <div class="flex items-center gap-1.5 px-3 py-2 text-sm font-bold border border-slate-200 rounded-xl cursor-pointer text-slate-500 hover:border-slate-300 peer-checked:border-[#1D4ED8] peer-checked:bg-[#1D4ED8] peer-checked:text-white transition-all">
                                                        <span class="w-3 h-3 rounded-full border border-slate-300 inline-block" style="background-color: {{ $colorOption }}"></span>
                                                        {{ $colorOption }}
                                                    </div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        @if($availableBrands->count() > 0)
                                        <div class="border-t border-slate-100 pt-8">
                                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Brand</h3>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($availableBrands as $brandOption)
                                                <label class="relative">
                                                    <input type="radio" name="brand" value="{{ $brandOption }}" class="peer sr-only" {{ request('brand') == $brandOption ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                                    <div class="flex items-center gap-1.5 px-3 py-2 text-sm font-bold border border-slate-200 rounded-xl cursor-pointer text-slate-500 hover:border-slate-300 peer-checked:border-[#1D4ED8] peer-checked:bg-[#1D4ED8] peer-checked:text-white transition-all">
                                                        {{ $brandOption }}
                                                    </div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        <div class="border-t border-slate-100 pt-8">
                                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Rentang Harga</h3>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Minimum (Rp)</label>
                                                    <input type="number" name="min_price" value="{{ request('min_price') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-[#1D4ED8] focus:ring-[#1D4ED8] rounded-xl text-sm font-medium text-slate-900 px-4 py-2" placeholder="0">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Maksimum (Rp)</label>
                                                    <input type="number" name="max_price" value="{{ request('max_price') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-[#1D4ED8] focus:ring-[#1D4ED8] rounded-xl text-sm font-medium text-slate-900 px-4 py-2" placeholder="Unltd">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="border-t border-slate-100 pt-8 space-y-3">
                                            <button type="submit" class="w-full bg-[#1D4ED8] text-white font-bold py-3.5 rounded-xl uppercase tracking-widest text-xs hover:bg-blue-800 transition">
                                                Terapkan Filter
                                            </button>
                                            <a href="{{ route('catalog.index', ['category' => request('category')]) }}" class="w-full flex items-center justify-center bg-white border border-slate-200 text-slate-700 font-bold py-3.5 rounded-xl uppercase tracking-widest text-xs hover:bg-slate-50 transition">
                                                Reset
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Divider --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-slate-200">
    </div>

    {{-- ============ LOCATION SECTION ============ --}}
    <section class="bg-slate-50 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-12">
                <span class="inline-block text-[11px] font-black text-[#D97706] uppercase tracking-[0.25em] mb-3">Lokasi</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight leading-tight">Temukan Kami dengan<br>Lebih Mudah</h2>
                <p class="mt-4 text-slate-500 text-sm md:text-base max-w-xl mx-auto leading-relaxed">Informasi alamat, WhatsApp, dan jam operasional ditata lebih jelas agar pelanggan mudah menghubungi dan datang ke lokasi.</p>
            </div>

            {{-- Content: Cards Left + Map Right --}}
            <div class="responsive-location-container">
                {{-- Left: Info Cards (fixed width) --}}
                <div class="responsive-location-info">
                    {{-- Address Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 flex-1">
                        <div class="flex gap-4 items-start">
                            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0 text-red-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Alamat</p>
                                <p class="text-[15px] font-bold text-slate-900 leading-snug mb-1">Jl. Raya Plumpang Semper No. 86 RT15 RW 4, Kel. Rawa Badak Selatan, Kec. Koja, Jakarta Utara 14230.</p>
                                <p class="text-[13px] text-slate-500 leading-relaxed">Silakan hubungi dahulu untuk konfirmasi jadwal kunjungan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 flex-1">
                        <div class="flex gap-4 items-start">
                            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center shrink-0 text-[#25D366]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">WhatsApp</p>
                                <p class="text-[15px] font-bold text-slate-900 leading-snug mb-1">+62 812-3456-7890</p>
                                <p class="text-[13px] text-slate-500 leading-relaxed">Gunakan WhatsApp untuk konsultasi danpenjadwalan layanan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Map (stretches wide to fill remaining space) --}}
                <div class="responsive-location-map">
                    <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm" style="height:100%; min-height:450px;">
                        <div id="store-map" style="width:100%; height:100%; min-height:450px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Custom CSS for Marquee & Location Section --}}
    <style>
        .marquee-content {
            animation: scroll 30s linear infinite;
            width: max-content;
        }
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .responsive-location-container {
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
            align-items: stretch;
        }
        .responsive-location-info {
            width: 300px;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .responsive-location-map {
            flex: 1;
            min-width: 0;
        }

        @media (max-width: 1023px) {
            .responsive-location-container {
                flex-direction: column !important;
            }
            .responsive-location-info {
                width: 100% !important;
                min-width: 0 !important;
            }
        }
    </style>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        .leaflet-popup-content-wrapper { border-radius: 1rem; box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.15); }
        .leaflet-popup-content { font-family: inherit; margin: 10px 14px; }
        .leaflet-popup-tip { box-shadow: 0 3px 14px rgb(0 0 0 / 0.1); }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var storeCoord = [-6.130612017467972, 106.89453488744131];
            
            var map = L.map('store-map', {
                zoomControl: true,
                scrollWheelZoom: true
            }).setView(storeCoord, 16);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var redIcon = L.icon({
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var gmapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + storeCoord[0] + ',' + storeCoord[1];
            var marker = L.marker(storeCoord, {icon: redIcon}).addTo(map);
            marker.bindPopup("<div style='text-align:center; padding:4px 2px;'><b style='font-size:14px; color:#0f172a;'>Awenk Jeans</b><br><span style='font-size:12px; color:#64748b; display:block; margin-top:4px;'>Jl. Raya Plumpang Semper No. 86</span><a href='" + gmapsUrl + "' target='_blank' rel='noopener' style='font-size:11px; color:#1D4ED8; display:block; margin-top:6px; font-weight:600; text-decoration:underline;'>📍 Buka di Google Maps</a></div>").openPopup();

            // Fix map rendering in hidden/dynamic containers
            setTimeout(function() { map.invalidateSize(); }, 300);
        });
    </script>
    @endpush

</x-app-layout>

