<x-owner-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Detail Transaksi: {{ $transaction->invoice_number }}</h2>
            <p class="mt-1 text-sm text-slate-500">Rincian lengkap pesanan dan item yang dibeli oleh pelanggan.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-[1fr_300px]">
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900">Item Produk</h3>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $transaction->details->count() }} Macam Barang</span>
                    </div>
                    <div class="p-6">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Produk</th>
                                    <th class="pb-3 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Harga</th>
                                    <th class="pb-3 text-center font-bold text-slate-500 uppercase tracking-wider text-xs">Qty</th>
                                    <th class="pb-3 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($transaction->details as $detail)
                                <tr>
                                    <td class="py-4 pr-4">
                                        <p class="font-bold text-slate-900">{{ optional($detail->product)->name }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ optional(optional($detail->product)->category)->name }} / {{ optional(optional($detail->product)->size)->name ?? '-' }}</p>
                                    </td>
                                    <td class="py-4 px-4 text-right font-medium text-slate-500">
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center font-bold text-slate-900">
                                        {{ $detail->quantity }}
                                    </td>
                                    <td class="py-4 pl-4 text-right font-bold text-slate-900">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-4 pr-4 text-right font-bold text-slate-900">Total Keseluruhan</td>
                                    <td class="py-4 pl-4 text-right text-lg font-black text-amber-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-slate-900 border-b border-slate-200 pb-4 mb-4">Informasi Pelanggan</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Pembeli</p>
                            <p class="font-bold text-slate-900 text-lg">{{ $transaction->customer_name ?: 'Pelanggan Walk-in (Tanpa Nama)' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-slate-900 border-b border-slate-200 pb-4 mb-4">Informasi Pembayaran</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Metode Bayar</span>
                            <span class="font-bold text-slate-900 uppercase tracking-wider">{{ $transaction->payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500">Status</span>
                            <span @class([
                                'inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider',
                                'bg-emerald-50 text-emerald-600' => $transaction->payment_status === 'paid',
                                'bg-amber-50 text-amber-600' => $transaction->payment_status === 'pending',
                                'bg-rose-50 text-rose-600' => in_array($transaction->payment_status, ['failed', 'expired']),
                            ])>
                                {{ $transaction->payment_status }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kasir</span>
                            <span class="font-bold text-slate-900">{{ optional($transaction->user)->name ?? 'Sistem' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Waktu Proses</span>
                            <span class="font-bold text-slate-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('owner.dashboard') }}" class="flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 shadow-sm">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-owner-layout>
