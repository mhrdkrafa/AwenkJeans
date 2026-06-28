<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Manajemen Stok</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau ketersediaan stok, produk hampir habis, dan riwayat pergerakan.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-6 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Produk di Gudang</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format($totalStock, 0, ',', '.') }} <span class="text-lg font-medium text-slate-500">unit</span></p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Stok Menipis (<= 10)</p>
                <p class="mt-2 text-3xl font-semibold text-amber-600">{{ $lowStockCount }} <span class="text-lg font-medium text-amber-400">produk</span></p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Stok Kosong</p>
                <p class="mt-2 text-3xl font-semibold text-rose-600">{{ $outOfStockCount }} <span class="text-lg font-medium text-rose-400">produk</span></p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Daftar Stok Produk</h3>
                <div class="flex gap-3">
                    <a href="{{ route('karyawan.stock.movements') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Riwayat Pergerakan
                    </a>
                    <a href="{{ route('karyawan.stock.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-[#002d73]">
                        Catat Pergerakan Stok
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Produk</th>
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Kategori & Ukuran</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Batas Minimum</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Stok Saat Ini</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($products as $product)
                            <tr class="group transition hover:bg-slate-50/50">
                                <td class="py-4 pr-4 font-bold text-slate-900">{{ $product->name }}</td>
                                <td class="py-4 pr-4 text-slate-500">{{ optional($product->category)->name }} / {{ optional($product->size)->name ?? '-' }}</td>
                                <td class="py-4 pr-4 text-right text-slate-500">{{ $product->min_stock }}</td>
                                <td class="py-4 pr-4 text-right font-bold text-slate-900">{{ $product->stock }}</td>
                                <td class="py-4 text-right">
                                    @if($product->stock <= 0)
                                        <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-600">Kosong</span>
                                    @elseif($product->stock <= $product->min_stock)
                                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-600">Menipis</span>
                                    @else
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">Aman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">Belum ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
