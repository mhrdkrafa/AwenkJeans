<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Catat Pergerakan & Minimum Stok</h2>
            <p class="mt-1 text-sm text-slate-500">Catat penambahan (restock), pengurangan stok, dan atur batas minimum stok produk.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
         x-data="{
            selectedProduct: '{{ old('product_id', request('product_id', '')) }}',
            minStock: '{{ old('min_stock', 0) }}',
            productsData: {{ json_encode($products->mapWithKeys(fn($p) => [$p->id => ['stock' => $p->stock, 'min_stock' => $p->min_stock]])) }},
            updateProductInfo() {
                if (this.selectedProduct && this.productsData[this.selectedProduct]) {
                    this.minStock = this.productsData[this.selectedProduct].min_stock;
                }
            }
         }"
         x-init="updateProductInfo()">
        <form action="{{ route('karyawan.stock.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="product_id" class="block text-sm font-semibold text-slate-600">Pilih Produk</label>
                <select name="product_id" id="product_id" x-model="selectedProduct" @change="updateProductInfo()" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" required>
                    <option value="">Pilih Produk...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok Saat Ini: {{ $product->stock }} | Min Stok: {{ $product->min_stock }})</option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="type" class="block text-sm font-semibold text-slate-600">Jenis Pergerakan</label>
                    <select name="type" id="type" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" required>
                        <option value="in">Masuk (Penambahan/Restock)</option>
                        <option value="out">Keluar (Pengurangan/Rusak)</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-slate-600">Jumlah Pergerakan (Unit)</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" required>
                    @error('quantity')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="rounded-xl bg-amber-50/70 border border-amber-200 p-4">
                <label for="min_stock" class="block text-sm font-bold text-amber-900">Batas Minimum Stok</label>
                <p class="text-xs text-amber-700 mt-0.5">Sistem akan menampilkan peringatan stok menipis jika stok produk berada di bawah atau sama dengan angka ini.</p>
                <input type="number" name="min_stock" id="min_stock" min="0" x-model="minStock" class="mt-2 block w-full rounded-xl border-amber-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm bg-white font-semibold text-slate-900" required>
                @error('min_stock')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-600">Keterangan / Catatan</label>
                <textarea name="description" id="description" rows="3" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" placeholder="Contoh: Restock barang baru dari supplier">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#002d73]">
                    Simpan Pergerakan & Min Stok
                </button>
                <a href="{{ route('karyawan.stock.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
