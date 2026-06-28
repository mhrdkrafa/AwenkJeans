<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Catat Pergerakan Stok</h2>
            <p class="mt-1 text-sm text-slate-500">Catat penambahan (restock) atau pengurangan stok secara manual.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('karyawan.stock.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="product_id" class="block text-sm font-semibold text-slate-600">Pilih Produk</label>
                <select name="product_id" id="product_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" required>
                    <option value="">Pilih Produk...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
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
                    <label for="quantity" class="block text-sm font-semibold text-slate-600">Jumlah (Unit)</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" required>
                    @error('quantity')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-600">Keterangan / Catatan</label>
                <textarea name="description" id="description" rows="3" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" placeholder="Contoh: Barang baru datang dari supplier">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-[#002d73]">
                    Simpan Pergerakan
                </button>
                <a href="{{ route('karyawan.stock.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
