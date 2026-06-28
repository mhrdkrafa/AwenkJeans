<x-kasir-layout>
    <div x-data="posSystem()" class="grid gap-6 lg:grid-cols-3 xl:gap-8 h-[calc(100vh-140px)]">
        {{-- Product List (Left Side) --}}
        <div class="lg:col-span-2 flex flex-col h-full rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    placeholder="Cari produk berdasarkan nama..." 
                    class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#003B95] focus:ring-[#003B95]"
                >
            </div>
            
            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div 
                            @click="addToCart(product)"
                            class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:border-[#003B95] hover:shadow-md"
                        >
                            <div class="aspect-square bg-slate-50 relative">
                                <template x-if="product.image">
                                    <img :src="`/storage/${product.image}`" class="h-full w-full object-cover" :alt="product.name">
                                </template>
                                <template x-if="!product.image">
                                    <div class="flex h-full w-full items-center justify-center text-slate-500">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                </template>
                                
                                <div class="absolute inset-0 bg-[#1D4ED8]/0 transition group-hover:bg-[#1D4ED8]/10"></div>
                                
                                <span class="absolute right-2 top-2 rounded-lg bg-white/90 px-2 py-1 text-xs font-bold text-[#1D4ED8] shadow-sm backdrop-blur-sm">
                                    Sisa <span x-text="product.stock"></span>
                                </span>
                            </div>
                            <div class="p-4 flex flex-col flex-1 justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm line-clamp-2" x-text="product.name"></h3>
                                    <p class="text-xs text-slate-500 mt-1"><span x-text="product.category_name"></span> <span x-show="product.size_name">/ <span x-text="product.size_name"></span></span></p>
                                </div>
                                <p class="mt-3 font-bold text-emerald-600 text-sm" x-text="'Rp ' + formatRupiah(product.price)"></p>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="filteredProducts.length === 0" class="flex flex-col items-center justify-center py-12 text-center" style="display: none;">
                    <div class="rounded-full bg-slate-50 p-4 mb-4 text-slate-500">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Produk tidak ditemukan</p>
                </div>
            </div>
        </div>

        {{-- Cart & Checkout (Right Side) --}}
        <div class="flex flex-col h-full rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <form action="{{ route('kasir.pos.store') }}" method="POST" id="checkout-form" class="flex flex-col h-full" @submit="submitCheckout($event)">
                @csrf
                <div class="border-b border-slate-200 bg-[#1D4ED8] px-6 py-5 text-white">
                    <h3 class="font-bold text-lg">Detail Transaksi</h3>
                </div>

                {{-- Customer Info - Searchable Dropdown --}}
                <div class="border-b border-slate-200 p-6 bg-slate-50 space-y-4">
                    <div class="relative">
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Pelanggan <span class="text-rose-500">*</span></label>
                        
                        {{-- Search Input --}}
                        <div class="relative" x-show="!selectedCustomer">
                            <input 
                                type="text" 
                                x-model="customerSearch"
                                @focus="showCustomerDropdown = true"
                                @click="showCustomerDropdown = true"
                                @input="filterCustomers()"
                                placeholder="Cari nama / telepon pelanggan..." 
                                class="w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] text-sm pr-10"
                                autocomplete="off"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>

                        {{-- Selected Customer Badge --}}
                        <div x-show="selectedCustomer" class="mt-2 flex items-center gap-2 rounded-lg bg-blue-50 border border-blue-200 px-3 py-2">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-blue-900" x-text="selectedCustomer?.name"></p>
                                <p class="text-xs text-blue-600" x-text="selectedCustomer?.phone || 'No telepon tidak tersedia'"></p>
                            </div>
                            <button type="button" @click="clearCustomer()" class="text-blue-400 hover:text-blue-600 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        {{-- Dropdown --}}
                        <div 
                            x-show="showCustomerDropdown && !selectedCustomer" 
                            @click.outside="showCustomerDropdown = false"
                            class="absolute z-50 mt-1 w-full max-h-60 overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl"
                            style="display: none;"
                        >
                            {{-- Walk-in option --}}
                            <button 
                                type="button"
                                @click="selectWalkIn()"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left transition hover:bg-slate-50 border-b border-slate-100"
                            >
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Pelanggan Umum (Walk-in)</p>
                                    <p class="text-xs text-slate-400">Pelanggan tidak terdaftar</p>
                                </div>
                            </button>

                            {{-- Customer list --}}
                            <template x-for="customer in filteredCustomers" :key="customer.id">
                                <button 
                                    type="button"
                                    @click="selectCustomer(customer)"
                                    class="flex w-full items-center gap-3 px-4 py-3 text-left transition hover:bg-blue-50"
                                >
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600 font-bold text-xs">
                                        <span x-text="customer.name.charAt(0).toUpperCase()"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-900 truncate" x-text="customer.name"></p>
                                        <p class="text-xs text-slate-500" x-text="customer.phone || customer.email || '-'"></p>
                                    </div>
                                </button>
                            </template>

                            <div x-show="filteredCustomers.length === 0 && customerSearch.length > 0" class="px-4 py-6 text-center">
                                <p class="text-sm text-slate-400">Pelanggan tidak ditemukan</p>
                            </div>
                        </div>

                        {{-- Hidden inputs --}}
                        <input type="hidden" name="pelanggan_id" :value="selectedCustomer?.id || ''">
                        <input type="hidden" name="customer_name" :value="customerName">
                        <input type="hidden" name="customer_phone" :value="customerPhone">
                    </div>
                </div>

                {{-- Cart Items --}}
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div class="flex items-center gap-4 rounded-xl border border-slate-200 p-3 shadow-sm relative">
                            {{-- Hidden inputs to submit cart --}}
                            <input type="hidden" :name="`items[${index}][id]`" :value="item.id">
                            <input type="hidden" :name="`items[${index}][qty]`" :value="item.qty">

                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-900 text-sm truncate" x-text="item.name"></h4>
                                <p class="text-xs font-semibold text-[#1D4ED8] mt-1" x-text="'Rp ' + formatRupiah(item.price)"></p>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <button type="button" @click="decreaseQty(item)" class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-200 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                </button>
                                <span class="w-6 text-center text-sm font-bold text-slate-900" x-text="item.qty"></span>
                                <button type="button" @click="increaseQty(item)" class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-500 hover:bg-slate-200 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="cart.length === 0" class="flex flex-col items-center justify-center py-12 text-center" style="display: none;">
                        <svg class="h-12 w-12 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <p class="text-sm font-medium text-slate-500">Keranjang masih kosong</p>
                    </div>
                </div>

                {{-- Checkout Footer --}}
                <div class="border-t border-slate-200 bg-slate-50 p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="cash" class="peer sr-only" checked x-model="paymentMethod">
                                <div class="rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-center transition peer-checked:border-[#1D4ED8] peer-checked:bg-blue-50">
                                    <span class="block text-sm font-bold text-slate-500 peer-checked:text-[#1D4ED8]">Tunai / Cash</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="midtrans" class="peer sr-only" x-model="paymentMethod">
                                <div class="rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-center transition peer-checked:border-[#1D4ED8] peer-checked:bg-blue-50 flex items-center justify-center">
                                    <span class="block text-sm font-bold text-slate-500 peer-checked:text-[#1D4ED8]">Midtrans</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-500">Total Tagihan</span>
                        <span class="text-2xl font-black text-[#1D4ED8]" x-text="'Rp ' + formatRupiah(cartTotal)"></span>
                    </div>

                    <button 
                        type="submit" 
                        :disabled="cart.length === 0 || !customerName.trim() || isProcessing"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#1D4ED8] px-6 py-4 text-base font-bold text-white shadow-lg shadow-blue-900/20 transition hover:bg-[#002d73] disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none"
                    >
                        <template x-if="isProcessing">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Memproses...
                            </span>
                        </template>
                        <template x-if="!isProcessing">
                            <span class="flex items-center gap-2">
                                Proses Transaksi
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

    @php
        $mappedProducts = $products->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'stock' => $p->stock,
                'image' => $p->image,
                'category_name' => optional($p->category)->name,
                'size_name' => optional($p->size)->name,
            ];
        });

        $mappedCustomers = $customers->map(function($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'phone' => $c->phone ?? '',
                'email' => $c->email ?? '',
            ];
        });
    @endphp
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('posSystem', () => ({
                products: @json($mappedProducts),
                allCustomers: @json($mappedCustomers),
                searchQuery: '',
                cart: [],
                
                // Customer search
                customerSearch: '',
                showCustomerDropdown: false,
                selectedCustomer: null,
                filteredCustomers: @json($mappedCustomers),

                get customerName() {
                    if (this.selectedCustomer) {
                        return this.selectedCustomer.name;
                    }
                    return '';
                },

                get customerPhone() {
                    if (this.selectedCustomer) {
                        return this.selectedCustomer.phone || '';
                    }
                    return '';
                },

                paymentMethod: 'cash',
                isProcessing: false,

                filterCustomers() {
                    const q = this.customerSearch.toLowerCase();
                    if (!q) {
                        this.filteredCustomers = this.allCustomers;
                    } else {
                        this.filteredCustomers = this.allCustomers.filter(c => 
                            c.name.toLowerCase().includes(q) || 
                            (c.phone && c.phone.includes(q)) ||
                            (c.email && c.email.toLowerCase().includes(q))
                        );
                    }
                    this.showCustomerDropdown = true;
                },

                selectCustomer(customer) {
                    this.selectedCustomer = customer;
                    this.customerSearch = customer.name;
                    this.showCustomerDropdown = false;
                },

                selectWalkIn() {
                    this.selectedCustomer = { id: null, name: 'Pelanggan Umum', phone: '', email: '' };
                    this.customerSearch = 'Pelanggan Umum';
                    this.showCustomerDropdown = false;
                },

                clearCustomer() {
                    this.selectedCustomer = null;
                    this.customerSearch = '';
                    this.filteredCustomers = this.allCustomers;
                },

                get filteredProducts() {
                    if (this.searchQuery === '') {
                        return this.products;
                    }
                    return this.products.filter(product => {
                        return product.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                    });
                },

                get cartTotal() {
                    return this.cart.reduce((total, item) => {
                        return total + (item.price * item.qty);
                    }, 0);
                },

                addToCart(product) {
                    const existingItem = this.cart.find(item => item.id === product.id);
                    
                    if (existingItem) {
                        if (existingItem.qty < product.stock) {
                            existingItem.qty++;
                        } else {
                            alert('Stok tidak mencukupi!');
                        }
                    } else {
                        if (product.stock > 0) {
                            this.cart.push({
                                ...product,
                                qty: 1
                            });
                        } else {
                            alert('Stok habis!');
                        }
                    }
                },

                increaseQty(item) {
                    if (item.qty < item.stock) {
                        item.qty++;
                    } else {
                        alert('Stok tidak mencukupi!');
                    }
                },

                decreaseQty(item) {
                    if (item.qty > 1) {
                        item.qty--;
                    } else {
                        this.cart = this.cart.filter(cartItem => cartItem.id !== item.id);
                    }
                },

                formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID').format(angka);
                },

                submitCheckout(event) {
                    if (!this.customerName.trim()) {
                        alert('Silakan pilih pelanggan terlebih dahulu!');
                        event.preventDefault();
                        return;
                    }
                    if (this.cart.length === 0) {
                        alert('Keranjang belanja kosong!');
                        event.preventDefault();
                        return;
                    }
                    
                    if(!confirm('Proses transaksi ini?')) {
                        event.preventDefault();
                        return;
                    }

                    // Jika metode pembayaran Midtrans, kirim via AJAX
                    if (this.paymentMethod === 'midtrans') {
                        event.preventDefault();
                        this.processMidtrans();
                    }
                    // Jika cash, biarkan form submit secara normal
                },

                async processMidtrans() {
                    if (this.isProcessing) return;
                    this.isProcessing = true;

                    // Siapkan data form
                    const items = this.cart.map((item, index) => ({
                        id: item.id,
                        qty: item.qty,
                    }));

                    try {
                        const response = await fetch("{{ route('kasir.pos.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                pelanggan_id: this.selectedCustomer?.id || '',
                                customer_name: this.customerName,
                                customer_phone: this.customerPhone,
                                payment_method: 'midtrans',
                                items: items,
                            })
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            const errorMsg = data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Terjadi kesalahan');
                            alert('Gagal: ' + errorMsg);
                            this.isProcessing = false;
                            return;
                        }

                        // Langsung buka popup Midtrans Snap
                        window.snap.pay(data.snap_token, {
                            onSuccess: (result) => {
                                // Update status pembayaran di server
                                fetch("{{ route('kasir.pos.midtrans-update') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: result.transaction_status,
                                    })
                                })
                                .then(res => res.json())
                                .then(updateData => {
                                    alert('Pembayaran berhasil!');
                                    window.location.href = updateData.redirect || "{{ route('kasir.pos.index') }}";
                                })
                                .catch(() => {
                                    alert('Pembayaran berhasil!');
                                    window.location.href = "{{ route('kasir.pos.index') }}";
                                });
                            },
                            onPending: (result) => {
                                alert('Menunggu pembayaran. Silakan selesaikan pembayaran Anda.');
                                window.location.reload();
                            },
                            onError: (result) => {
                                alert('Pembayaran gagal! Silakan coba lagi.');
                                window.location.reload();
                            },
                            onClose: () => {
                                alert('Anda menutup popup sebelum menyelesaikan pembayaran. Transaksi masih pending.');
                                this.isProcessing = false;
                            }
                        });

                    } catch (error) {
                        console.error('Midtrans Error:', error);
                        alert('Gagal memproses pembayaran Midtrans. Silakan coba lagi.');
                        this.isProcessing = false;
                    }
                }
            }))
        })
    </script>
    @endpush
</x-kasir-layout>
