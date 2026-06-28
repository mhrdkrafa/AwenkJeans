<x-owner-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Laporan Sisa Stok</h2>
            <p class="mt-1 text-sm text-slate-500">Kondisi per {{ now()->format('d M Y') }}</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Rekapitulasi Stok Gudang</h3>
                <p class="text-sm text-slate-500">Nilai aset berdasarkan harga jual produk.</p>
            </div>
            <a href="{{ route('owner.reports.stock.pdf') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-emerald-700">
                Export PDF
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-indigo-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-indigo-800 uppercase tracking-wider">Total Item Barang</p>
                <p class="mt-2 text-3xl font-black text-[#1D4ED8]">{{ number_format($totalStock, 0, ',', '.') }} <span class="text-lg font-medium">unit</span></p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-emerald-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">Estimasi Nilai Aset</p>
                <p class="mt-2 text-3xl font-black text-emerald-600">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Produk</th>
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Kategori/Size</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Harga Jual</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Sisa Stok</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($products as $product)
                            <tr class="group transition hover:bg-slate-50/50">
                                <td class="py-4 pr-4 font-bold text-slate-900">{{ $product->name }}</td>
                                <td class="py-4 pr-4 text-slate-500">{{ optional($product->category)->name }} / {{ optional($product->size)->name ?? '-' }}</td>
                                <td class="py-4 pr-4 text-right text-slate-500">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-4 pr-4 text-right">
                                    <span @class([
                                        'font-bold',
                                        'text-emerald-600' => $product->stock > $product->min_stock,
                                        'text-amber-600' => $product->stock > 0 && $product->stock <= $product->min_stock,
                                        'text-rose-600' => $product->stock == 0,
                                    ])>
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="py-4 text-right font-bold text-slate-900">Rp {{ number_format($product->price * $product->stock, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">Tidak ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-owner-layout>
