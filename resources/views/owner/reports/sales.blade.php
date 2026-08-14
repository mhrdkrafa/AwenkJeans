<x-owner-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Laporan Penjualan</h2>
            <p class="mt-1 text-sm text-slate-500">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <form action="{{ route('owner.reports.sales') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-slate-600">Mulai Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-slate-600">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#002d73]">
                        Filter
                    </button>
                    <a href="{{ route('owner.reports.sales.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-indigo-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-indigo-800 uppercase tracking-wider">Total Pendapatan</p>
                <p class="mt-2 text-3xl font-black text-[#1D4ED8]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-emerald-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">Total Transaksi</p>
                <p class="mt-2 text-3xl font-black text-emerald-600">{{ $totalTransactions }} <span class="text-lg font-medium">struk</span></p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Waktu & Kasir</th>
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Pelanggan</th>
                            <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Total Pembayaran</th>
                            <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($transactions as $transaction)
                            <tr class="group transition hover:bg-slate-50/50">
                                <td class="py-4 pr-4">
                                    <p class="font-bold text-slate-900">{{ $transaction->invoice_number }}</p>
                                    <p class="mt-1 flex items-center gap-2 text-xs text-slate-500">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $transaction->created_at->format('d M Y, H:i') }}
                                        <span class="mx-1">•</span>
                                        {{ optional($transaction->user)->name ?? 'System' }}
                                    </p>
                                </td>
                                <td class="py-4 pr-4">
                                    <p class="font-bold text-[#1D4ED8]">{{ $transaction->customer_name ?: '-' }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $transaction->details->sum('quantity') }} items</p>
                                </td>
                                <td class="py-4 pr-4">
                                    <span @class([
                                        'inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider',
                                        'bg-emerald-50 text-emerald-600 border border-emerald-100' => $transaction->payment_status === 'paid',
                                        'bg-amber-50 text-amber-600 border border-amber-100' => $transaction->payment_status === 'pending',
                                        'bg-rose-50 text-rose-600 border border-rose-100' => in_array($transaction->payment_status, ['failed', 'expired']),
                                    ])>
                                        {{ $transaction->payment_status }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4 text-right">
                                    <p class="font-bold text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mt-1">{{ $transaction->payment_method }}</p>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('owner.transactions.show', $transaction->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-50 border border-amber-200 px-3 py-1.5 text-xs font-bold text-amber-700 transition hover:bg-amber-100">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">Tidak ada transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-owner-layout>
