<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Data Transaksi</h2>
            <p class="mt-1 text-sm text-slate-500">Daftar lengkap seluruh transaksi penjualan dari POS maupun online.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-6 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Pendapatan Bersih</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Transaksi</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format($totalTransactions, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Transaksi Sukses (Paid)</p>
                <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ number_format($paidCount, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900">Riwayat Transaksi</h3>
            </div>

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
                                    <a href="{{ route('karyawan.transactions.show', $transaction->id) }}" class="font-medium text-[#1D4ED8] transition hover:text-[#002d73]">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">Belum ada data transaksi.</td>
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
</x-admin-layout>
