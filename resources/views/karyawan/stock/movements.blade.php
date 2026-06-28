<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Riwayat Pergerakan Stok</h2>
            <p class="mt-1 text-sm text-slate-500">Log semua aktivitas penambahan dan pengurangan stok produk.</p>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">Riwayat Transaksi Gudang</h3>
            <div class="flex gap-3">
                <a href="{{ route('karyawan.stock.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Kembali ke Stok
                </a>
                <a href="{{ route('karyawan.reports.movements') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100">
                    Laporan Pergerakan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Tanggal</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Produk</th>
                        <th class="pb-4 text-center font-bold text-slate-500 uppercase tracking-wider text-xs">Tipe</th>
                        <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Jumlah</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($movements as $movement)
                        <tr class="group transition hover:bg-slate-50/50">
                            <td class="py-4 pr-4 text-slate-500">{{ $movement->created_at->format('d M Y H:i') }}</td>
                            <td class="py-4 pr-4 font-bold text-slate-900">{{ optional($movement->product)->name }}</td>
                            <td class="py-4 px-4 text-center">
                                @if($movement->type === 'in')
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-emerald-600">IN</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-600">OUT</span>
                                @endif
                            </td>
                            <td class="py-4 pr-4 text-right font-bold text-slate-900">
                                @if($movement->type === 'in')
                                    <span class="text-emerald-600">+{{ $movement->quantity }}</span>
                                @else
                                    <span class="text-amber-600">-{{ $movement->quantity }}</span>
                                @endif
                            </td>
                            <td class="py-4 text-slate-500 max-w-xs truncate">{{ $movement->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">Belum ada riwayat pergerakan stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $movements->links() }}
        </div>
    </div>
</x-admin-layout>
