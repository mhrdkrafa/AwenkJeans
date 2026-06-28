<x-owner-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Laporan Pergerakan Stok</h2>
            <p class="mt-1 text-sm text-slate-500">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <form action="{{ route('owner.reports.movements') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-slate-600">Mulai Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-slate-600">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-[#002d73]">
                        Filter
                    </button>
                    <!-- Uncomment jika ingin PDF pergerakan:
                    <a href="#" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Export PDF
                    </a>
                    -->
                </div>
            </form>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-emerald-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">Total Barang Masuk (IN)</p>
                <p class="mt-2 text-3xl font-black text-emerald-600">+{{ number_format($totalIn, 0, ',', '.') }} <span class="text-lg font-medium">unit</span></p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-amber-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-amber-800 uppercase tracking-wider">Total Barang Keluar (OUT)</p>
                <p class="mt-2 text-3xl font-black text-amber-600">-{{ number_format($totalOut, 0, ',', '.') }} <span class="text-lg font-medium">unit</span></p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
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
                                <td class="py-4 pr-4 text-slate-500">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
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
                                <td class="py-4 text-slate-500">{{ $movement->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">Tidak ada pergerakan stok pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-owner-layout>
