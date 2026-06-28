<x-kasir-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
        <p class="mt-1 text-sm font-medium text-slate-500">Berikut adalah ringkasan aktivitas kasir Anda hari ini.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <div class="rounded-3xl border border-blue-200 bg-gradient-to-br from-[#1D4ED8] to-blue-800 p-6 text-slate-900 shadow-lg shadow-blue-900/20 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-slate-100 blur-2xl"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-md">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="font-bold text-blue-100">Pendapatan Hari Ini</p>
                </div>
                <h3 class="text-3xl font-black">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm relative overflow-hidden">
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <p class="font-bold text-slate-500">Transaksi Berhasil</p>
            </div>
            <h3 class="text-3xl font-black text-slate-900 relative z-10">{{ $todayTransactions }} <span class="text-sm font-bold text-slate-500">struk</span></h3>
        </div>
        
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col justify-center items-center text-center transition hover:border-[#1D4ED8] hover:shadow-md">
            <a href="{{ route('kasir.pos.index') }}" class="group flex flex-col items-center justify-center w-full h-full">
                <div class="mb-3 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#1D4ED8]/10 text-[#1D4ED8] transition group-hover:scale-110 group-hover:bg-[#1D4ED8] group-hover:text-slate-900 group-hover:shadow-lg group-hover:shadow-blue-900/20">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                </div>
                <h3 class="font-black text-slate-900">Buat Transaksi Baru</h3>
                <p class="mt-1 text-xs font-bold text-slate-500">Buka mesin POS</p>
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight">Riwayat Transaksi Terakhir Anda</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Waktu</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Invoice</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Pelanggan</th>
                        <th class="pb-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Item</th>
                        <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-[10px]">Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($recentTransactions as $transaction)
                        <tr class="group transition hover:bg-slate-50">
                            <td class="py-4 pr-4 font-medium text-slate-500">{{ $transaction->created_at->format('H:i, d M Y') }}</td>
                            <td class="py-4 pr-4 font-bold text-slate-900">{{ $transaction->invoice_number }}</td>
                            <td class="py-4 pr-4 font-medium text-slate-500">{{ $transaction->customer_name ?: '-' }}</td>
                            <td class="py-4 px-4 text-center font-bold text-slate-600">{{ $transaction->details->sum('quantity') }}</td>
                            <td class="py-4 text-right font-black text-emerald-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500 font-medium">Anda belum melakukan transaksi hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-kasir-layout>
