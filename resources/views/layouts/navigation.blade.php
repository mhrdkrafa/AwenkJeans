<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     class="fixed w-full z-50 transition-all duration-300">
    
    <!-- Top Bar (Light) -->
    <div :class="{ 'shadow-sm bg-white/95 backdrop-blur-md': scrolled, 'bg-white': !scrolled }" class="border-b border-slate-200 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20 gap-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('catalog.index') }}" class="flex items-center">
                        <span class="text-xl md:text-2xl font-black tracking-tighter text-slate-900">
                            AWENK<span class="text-[#D97706]">JEANS</span>
                        </span>
                    </a>
                </div>

                <!-- Search Bar (Centered) with Live Autocomplete -->
                <div class="hidden md:flex flex-1 max-w-xl mx-8">
                    <div x-data="liveSearch()" class="w-full relative" @click.outside="showDropdown = false">
                        <form action="{{ route('catalog.index') }}" method="GET" class="w-full relative group" @submit="onSubmit">
                            <input type="text" name="search" x-model="query" x-ref="searchInput"
                                   @input.debounce.300ms="fetchSuggestions()"
                                   @focus="if (results.products?.length || results.brands?.length) showDropdown = true"
                                   @keydown.escape="showDropdown = false"
                                   @keydown.arrow-down.prevent="navigateDown()"
                                   @keydown.arrow-up.prevent="navigateUp()"
                                   @keydown.enter.prevent="selectCurrent()"
                                   value="{{ request('search') }}"
                                   placeholder="Cari produk dan merek..." 
                                   autocomplete="off"
                                   class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-[#1D4ED8] focus:border-[#1D4ED8] rounded-full text-sm text-slate-900 placeholder-slate-400 transition-all outline-none shadow-inner">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#1D4ED8]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <!-- Loading spinner -->
                            <div x-show="loading" class="absolute right-4 top-1/2 -translate-y-1/2">
                                <svg class="animate-spin h-4 w-4 text-[#1D4ED8]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <!-- Clear button -->
                            <button x-show="query.length > 0 && !loading" @click.prevent="clearSearch()" type="button"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>

                        <!-- Dropdown Results -->
                        <div x-show="showDropdown" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
                             class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-50 max-h-[420px] overflow-y-auto"
                             style="display: none;">

                            <!-- Brand Suggestions -->
                            <template x-if="results.brands && results.brands.length > 0">
                                <div class="px-4 pt-3 pb-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Merek</p>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(brand, idx) in results.brands" :key="'b-'+idx">
                                            <a :href="'{{ route('catalog.index') }}?brand=' + encodeURIComponent(brand.name)"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-[#1D4ED8]/10 hover:text-[#1D4ED8] border border-slate-200 hover:border-[#1D4ED8]/30 rounded-full text-xs font-bold text-slate-700 transition-all"
                                               :class="activeIndex === (results.products?.length || 0) + idx ? 'bg-[#1D4ED8]/10 text-[#1D4ED8] border-[#1D4ED8]/30' : ''">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                                <span x-text="brand.name"></span>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Product Suggestions -->
                            <template x-if="results.products && results.products.length > 0">
                                <div>
                                    <div class="px-4 pt-3 pb-1" x-show="results.brands && results.brands.length > 0">
                                        <div class="border-t border-slate-100"></div>
                                    </div>
                                    <p class="px-4 pt-2 pb-1 text-[10px] font-black text-slate-400 uppercase tracking-widest">Produk</p>
                                    <template x-for="(product, idx) in results.products" :key="'p-'+idx">
                                        <a :href="'/produk/' + product.slug" 
                                           class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 transition-all cursor-pointer"
                                           :class="activeIndex === idx ? 'bg-slate-50' : ''"
                                           @mouseenter="activeIndex = idx">
                                            <!-- Product Image -->
                                            <template x-if="product.image">
                                                <img :src="product.image" :alt="product.name" class="w-10 h-10 rounded-lg object-cover border border-slate-200 shrink-0">
                                            </template>
                                            <template x-if="!product.image">
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                            </template>
                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-slate-900 truncate" x-text="product.name"></p>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-text="product.category"></span>
                                                    <template x-if="product.brand">
                                                        <span class="text-[10px] text-slate-300">&bull;</span>
                                                    </template>
                                                    <template x-if="product.brand">
                                                        <span class="text-[10px] font-semibold text-[#1D4ED8]" x-text="product.brand"></span>
                                                    </template>
                                                </div>
                                            </div>
                                            <!-- Price -->
                                            <span class="text-xs font-black text-slate-900 shrink-0" x-text="product.price"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            <!-- No Results -->
                            <template x-if="(!results.products || results.products.length === 0) && (!results.brands || results.brands.length === 0) && query.length >= 2 && !loading">
                                <div class="px-4 py-6 text-center">
                                    <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    <p class="text-sm text-slate-500">Tidak ada hasil untuk "<span class="font-semibold" x-text="query"></span>"</p>
                                </div>
                            </template>

                            <!-- Search All Footer -->
                            <template x-if="(results.products?.length > 0 || results.brands?.length > 0) && query.length >= 2">
                                <div class="border-t border-slate-100 px-4 py-3">
                                    <a :href="'{{ route('catalog.index') }}?search=' + encodeURIComponent(query)"
                                       class="flex items-center justify-center gap-2 text-xs font-bold text-[#1D4ED8] hover:text-blue-800 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        Lihat semua hasil untuk "<span x-text="query"></span>"
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center gap-2 md:gap-4">
                    @auth
                        {{-- Quick Nav Links for Pelanggan (to the left of user menu) --}}
                        @if(auth()->user()->role?->name === 'pelanggan')
                            <a href="{{ route('pelanggan.orders') }}" class="px-3 py-2 text-sm font-semibold rounded-xl transition {{ request()->routeIs('pelanggan.orders*') ? 'text-[#1D4ED8] bg-[#1D4ED8]/10' : 'text-slate-500 hover:text-[#1D4ED8] hover:bg-slate-100' }}">
                                Riwayat Pesanan
                            </a>
                            <a href="{{ route('pelanggan.complaints.index') }}" class="px-3 py-2 text-sm font-semibold rounded-xl transition {{ request()->routeIs('pelanggan.complaints*') ? 'text-[#1D4ED8] bg-[#1D4ED8]/10' : 'text-slate-500 hover:text-[#1D4ED8] hover:bg-slate-100' }}">
                                Komplain Saya
                            </a>

                            <div class="hidden md:block w-px h-6 bg-slate-200"></div>
                        @endif

                        <!-- User Dropdown Menu -->
                        <div x-data="{ userMenuOpen: false }" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen" @click.outside="userMenuOpen = false" class="flex items-center gap-2 p-2 text-slate-600 hover:text-slate-900 transition rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-[#1D4ED8]/10 text-[#1D4ED8] font-bold text-xs flex items-center justify-center border border-[#1D4ED8]/20 uppercase tracking-widest">
                                    {{ substr(auth()->user()->name, 0, 2) }}
                                </div>
                                <span class="hidden md:block text-sm font-bold text-slate-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="hidden md:block w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown List -->
                            <div x-show="userMenuOpen" 
                                 x-transition.opacity.duration.200ms
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50"
                                 style="display: none;">
                                
                                @if(auth()->user()->role?->name !== 'pelanggan')
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition font-medium">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard Sistem
                                    </a>
                                @endif


                                
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition font-medium">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Pengaturan Profil
                                </a>
                                
                                <div class="border-t border-slate-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition font-bold">
                                        <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-[#1D4ED8] border border-[#1D4ED8] rounded-xl hover:bg-[#1D4ED8] hover:text-white transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex px-4 py-2 text-sm font-bold text-white bg-[#1D4ED8] rounded-xl hover:bg-[#002d73] transition">
                                Daftar
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="open = ! open" class="md:hidden p-2 text-slate-500 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-b border-slate-200">
        <div class="px-4 pt-4 pb-3 space-y-3">
            <div x-data="liveSearch()" class="relative w-full" @click.outside="showDropdown = false">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative" @submit.prevent="onSubmit">
                    <input type="text" name="search" x-model="query" x-ref="searchInput"
                           @input.debounce.300ms="fetchSuggestions()"
                           @focus="if (results.products?.length || results.brands?.length) showDropdown = true"
                           @keydown.escape="showDropdown = false"
                           @keydown.enter.prevent="selectCurrent()"
                           value="{{ request('search') }}"
                           placeholder="Cari produk..." 
                           autocomplete="off"
                           class="w-full pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-[#1D4ED8] focus:border-[#1D4ED8] outline-none">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <!-- Loading spinner -->
                    <div x-show="loading" class="absolute right-10 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-4 w-4 text-[#1D4ED8]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <!-- Clear button -->
                    <button x-show="query.length > 0 && !loading" @click.prevent="clearSearch()" type="button"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>

                <!-- Suggestions Dropdown (Mobile) -->
                <div x-show="showDropdown" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
                     class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-50 max-h-[300px] overflow-y-auto"
                     style="display: none;">
                     <!-- Brand Suggestions -->
                     <template x-if="results.brands && results.brands.length > 0">
                         <div class="px-4 pt-3 pb-2">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Merek</p>
                             <div class="flex flex-wrap gap-2">
                                 <template x-for="(brand, idx) in results.brands" :key="'mb-'+idx">
                                     <a :href="'{{ route('catalog.index') }}?brand=' + encodeURIComponent(brand.name)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-[#1D4ED8]/10 hover:text-[#1D4ED8] border border-slate-200 rounded-full text-xs font-bold text-slate-700 transition-all">
                                         <span x-text="brand.name"></span>
                                     </a>
                                 </template>
                             </div>
                         </div>
                     </template>

                     <!-- Product Suggestions -->
                     <template x-if="results.products && results.products.length > 0">
                         <div>
                             <div class="px-4 pt-2 pb-1" x-show="results.brands && results.brands.length > 0">
                                 <div class="border-t border-slate-100"></div>
                             </div>
                             <p class="px-4 pt-2 pb-1 text-[10px] font-black text-slate-400 uppercase tracking-widest">Produk</p>
                             <template x-for="(product, idx) in results.products" :key="'mp-'+idx">
                                 <a :href="'/produk/' + product.slug" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-all cursor-pointer">
                                     <template x-if="product.image">
                                         <img :src="product.image" :alt="product.name" class="w-8 h-8 rounded-lg object-cover border border-slate-200 shrink-0">
                                     </template>
                                     <template x-if="!product.image">
                                         <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0">
                                             <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                         </div>
                                     </template>
                                     <div class="flex-1 min-w-0">
                                         <p class="text-xs font-bold text-slate-900 truncate" x-text="product.name"></p>
                                         <p class="text-[10px] font-semibold text-[#1D4ED8]" x-text="product.brand"></p>
                                     </div>
                                     <span class="text-xs font-black text-slate-900 shrink-0" x-text="product.price"></span>
                                 </a>
                             </template>
                         </div>
                     </template>

                     <!-- No Results -->
                     <template x-if="(!results.products || results.products.length === 0) && (!results.brands || results.brands.length === 0) && query.length >= 2 && !loading">
                         <div class="px-4 py-6 text-center">
                             <p class="text-xs text-slate-500">Tidak ada hasil untuk "<span class="font-semibold" x-text="query"></span>"</p>
                         </div>
                     </template>
                </div>
            </div>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-slate-100">
                <div class="px-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#1D4ED8]/10 text-[#1D4ED8] font-bold flex items-center justify-center border border-[#1D4ED8]/20 uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div>
                        <div class="font-bold text-base text-slate-900">{{ auth()->user()->name }}</div>
                        <div class="font-medium text-sm text-slate-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="mt-4 space-y-1">
                    @if(auth()->user()->role?->name !== 'pelanggan')
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                            Dashboard Sistem
                        </a>
                    @endif
                    <a href="{{ route('pelanggan.orders') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Riwayat Pembelian
                    </a>
                    <a href="{{ route('pelanggan.complaints.index') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Komplain Saya
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                        Pengaturan Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-bold text-rose-600 hover:bg-rose-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 border-t border-slate-100 flex flex-col gap-2">
                <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 text-[#1D4ED8] font-bold rounded-xl border border-[#1D4ED8] hover:bg-[#1D4ED8]/5">Masuk</a>
                <a href="{{ route('register') }}" class="w-full text-center px-4 py-2 bg-[#1D4ED8] text-white font-bold rounded-xl hover:bg-blue-800">Daftar</a>
            </div>
        @endauth
    </div>
</nav>

<script>
    function liveSearch() {
        return {
            query: '{{ request('search') }}' || '',
            loading: false,
            showDropdown: false,
            results: {
                products: [],
                brands: []
            },
            activeIndex: -1,

            fetchSuggestions() {
                if (this.query.trim().length < 2) {
                    this.results = { products: [], brands: [] };
                    this.showDropdown = false;
                    this.activeIndex = -1;
                    return;
                }

                this.loading = true;
                this.showDropdown = true;

                fetch(`/katalog/search-suggestions?q=${encodeURIComponent(this.query)}`)
                    .then(res => res.json())
                    .then(data => {
                        this.results = data;
                        this.loading = false;
                        this.activeIndex = -1;
                    })
                    .catch(err => {
                        console.error('Error fetching search suggestions:', err);
                        this.loading = false;
                    });
            },

            navigateDown() {
                const total = (this.results.products?.length || 0) + (this.results.brands?.length || 0);
                if (total === 0) return;
                this.activeIndex = (this.activeIndex + 1) % total;
            },

            navigateUp() {
                const total = (this.results.products?.length || 0) + (this.results.brands?.length || 0);
                if (total === 0) return;
                this.activeIndex = (this.activeIndex - 1 + total) % total;
            },

            selectCurrent() {
                const productsCount = this.results.products?.length || 0;
                const brandsCount = this.results.brands?.length || 0;

                if (this.activeIndex >= 0 && this.activeIndex < productsCount) {
                    const product = this.results.products[this.activeIndex];
                    window.location.href = `/produk/${product.slug}`;
                } else if (this.activeIndex >= productsCount && this.activeIndex < productsCount + brandsCount) {
                    const brandIndex = this.activeIndex - productsCount;
                    const brand = this.results.brands[brandIndex];
                    window.location.href = `{{ route('catalog.index') }}?brand=${encodeURIComponent(brand.name)}`;
                } else {
                    this.onSubmit();
                }
            },

            clearSearch() {
                this.query = '';
                this.results = { products: [], brands: [] };
                this.showDropdown = false;
                this.activeIndex = -1;
                this.$refs.searchInput.focus();
            },

            onSubmit() {
                window.location.href = `{{ route('catalog.index') }}?search=${encodeURIComponent(this.query)}`;
            }
        };
    }
</script>
