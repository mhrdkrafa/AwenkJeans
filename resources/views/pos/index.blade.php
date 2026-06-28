<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-white">Point of Sale (POS)</h2>
            <p class="mt-1 text-sm text-slate-400">Pilih produk, susun keranjang, dan proses pembayaran dari halaman kasir.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-6 sm:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-[#222] p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">Produk siap jual</p>
                <p class="mt-2 text-3xl font-semibold text-white">{{ $products->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#222] p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">Kategori tersedia</p>
                <p class="mt-2 text-3xl font-semibold text-white">{{ $products->pluck('category_id')->unique()->count() }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-[#222] p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">Checkout status</p>
                <p class="mt-2 text-3xl font-semibold text-emerald-600">Siap</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-2xl border border-white/10 bg-[#222] p-6 shadow-sm">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Pilih produk</h3>
                        <p class="mt-1 text-sm text-slate-400">Klik produk untuk menambahkannya ke keranjang belanja.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($products as $product)
                        <button
                            type="button"
                            class="rounded-2xl border border-white/10 p-4 text-left transition hover:border-indigo-200 hover:bg-indigo-50"
                            onclick="addToCart({{ $product->id }}, @js($product->name), {{ $product->price }}, {{ $product->stock }})"
                        >
                            <p class="font-semibold text-white">{{ $product->name }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ $product->category->name }} | {{ $product->size ? $product->size->name : '-' }}</p>
                            <p class="mt-3 text-base font-semibold text-[#E85D40]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">Stok tersedia: {{ $product->stock }}</p>
                        </button>
                    @empty
                        <div class="rounded-2xl border border-dashed border-white/10 bg-[#1a1a1a] p-6 text-sm text-slate-400">
                            Tidak ada produk yang dapat dijual saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-[#222] p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white">Keranjang belanja</h3>
                <p class="mt-1 text-sm text-slate-400">Atur quantity, masukkan nama pelanggan, lalu proses pembayaran.</p>

                <form action="{{ route('pos.store') }}" method="POST" class="mt-6 flex min-h-[620px] flex-col">
                    @csrf

                    <div class="flex-1 overflow-hidden rounded-2xl border border-white/10">
                        <div class="max-h-[360px] overflow-y-auto">
                            <table class="min-w-full" id="cart-table">
                                <thead class="sticky top-0 bg-[#1a1a1a]">
                                    <tr class="text-left text-xs uppercase tracking-wide text-slate-400">
                                        <th class="px-4 py-3">Item</th>
                                        <th class="px-4 py-3">Harga</th>
                                        <th class="px-4 py-3">Qty</th>
                                        <th class="px-4 py-3 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-body">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl bg-[#1a1a1a] p-5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-400">Total pembayaran</span>
                            <span class="text-2xl font-semibold text-white" id="total-price">Rp 0</span>
                        </div>

                        <div class="mt-5 space-y-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-semibold text-slate-300">Nama pelanggan</label>
                                <input id="customer_name" type="text" name="customer_name" class="mt-2 block w-full rounded-xl border-white/10 shadow-sm focus:border-[#E85D40] focus:ring-[#E85D40]" placeholder="Opsional">
                            </div>
                            <div>
                                <label for="payment_method" class="block text-sm font-semibold text-slate-300">Metode pembayaran</label>
                                <select id="payment_method" name="payment_method" class="mt-2 block w-full rounded-xl border-white/10 shadow-sm focus:border-[#E85D40] focus:ring-[#E85D40]">
                                    <option value="cash">Tunai</option>
                                    <option value="qris">QRIS (Midtrans)</option>
                                </select>
                            </div>
                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-[#E85D40] px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                Proses Pembayaran
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        const cartBody = document.getElementById('cart-body');
        const totalPriceEl = document.getElementById('total-price');

        function addToCart(id, name, price, stock) {
            const existing = cart.find(item => item.id === id);
            if (existing && existing.qty < existing.stock) {
                existing.qty++;
            } else if (!existing) {
                cart.push({ id, name, price, qty: 1, stock });
            }
            renderCart();
        }

        function renderCart() {
            cartBody.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-400">
                            Keranjang masih kosong. Pilih produk dari panel sebelah kiri.
                        </td>
                    </tr>
                `;
            } else {
                cart.forEach((item, index) => {
                    const subtotal = item.price * item.qty;
                    total += subtotal;
                    cartBody.innerHTML += `
                        <tr class="border-t border-white/5">
                            <td class="px-4 py-4 text-sm">
                                <p class="font-semibold text-white">${item.name}</p>
                                <input type="hidden" name="items[${index}][id]" value="${item.id}">
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-400">Rp ${item.price.toLocaleString('id-ID')}</td>
                            <td class="px-4 py-4 text-sm">
                                <input type="number" min="1" max="${item.stock}" name="items[${index}][qty]" value="${item.qty}" class="w-20 rounded-xl border border-white/10 px-3 py-2" onchange="updateQty(${index}, this.value)">
                            </td>
                            <td class="px-4 py-4 text-right text-sm font-semibold text-white">Rp ${subtotal.toLocaleString('id-ID')}</td>
                        </tr>
                    `;
                });
            }

            totalPriceEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function updateQty(index, qty) {
            const parsedQty = parseInt(qty, 10);

            if (Number.isNaN(parsedQty) || parsedQty <= 0) {
                cart.splice(index, 1);
                renderCart();
                return;
            }

            cart[index].qty = Math.min(parsedQty, cart[index].stock);

            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            renderCart();
        }

        renderCart();
    </script>
</x-admin-layout>
