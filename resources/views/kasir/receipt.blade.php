<x-kasir-layout>
    <div class="max-w-4xl mx-auto space-y-8 pb-10">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-8 py-5 text-base text-emerald-700 font-medium shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Receipt Card -->
        <div class="rounded-3xl border border-slate-200 bg-white shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#1D4ED8] text-slate-900 px-10 py-8 text-center">
                <h1 class="text-3xl font-bold tracking-wider">AWENK JEANS</h1>
                <p class="text-base text-blue-200 mt-2">Nota Pembayaran</p>
            </div>

            <!-- Invoice Info -->
            <div class="px-10 py-8 border-b border-slate-200">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-2">No. Invoice</p>
                        <p class="text-lg font-bold text-slate-900">{{ $transaction->invoice_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-2">Tanggal</p>
                        <p class="text-base font-medium text-slate-900">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-2">Pelanggan</p>
                        <p class="text-base font-bold text-slate-900">{{ $transaction->customer_name ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $transaction->customer_phone ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-2">Kasir</p>
                        <p class="text-base font-bold text-slate-900">{{ $transaction->cashier->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-2">Metode Bayar</p>
                        <p class="text-base font-bold text-slate-900">{{ strtoupper($transaction->payment_method) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-2">Status</p>
                        <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-bold tracking-wider {{ $transaction->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $transaction->payment_status === 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="px-10 py-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-slate-200">
                            <th class="py-4 text-left text-sm font-semibold uppercase tracking-wide text-slate-500">Produk</th>
                            <th class="py-4 text-center text-sm font-semibold uppercase tracking-wide text-slate-500">Qty</th>
                            <th class="py-4 text-right text-sm font-semibold uppercase tracking-wide text-slate-500">Harga</th>
                            <th class="py-4 text-right text-sm font-semibold uppercase tracking-wide text-slate-500">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($transaction->details as $detail)
                        <tr>
                            <td class="py-5">
                                <p class="text-lg font-bold text-slate-900">{{ $detail->product->name ?? 'Produk dihapus' }}</p>
                                <p class="text-sm text-slate-500 mt-1">{{ $detail->product->category->name ?? '-' }} / {{ $detail->product->size->name ?? '-' }}</p>
                            </td>
                            <td class="py-5 text-center text-lg font-medium text-slate-600">{{ $detail->quantity }}</td>
                            <td class="py-5 text-right text-base text-slate-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="py-5 text-right text-lg font-bold text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <div class="px-10 py-8 bg-slate-50 border-t-2 border-dashed border-slate-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-base font-medium text-slate-500">Total Keseluruhan</p>
                        <p class="text-sm text-slate-500 mt-1">{{ $transaction->details->sum('quantity') }} item barang</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-500 mb-1">TOTAL BAYAR</p>
                        <p class="text-4xl font-black text-[#1D4ED8]">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="px-10 py-6 text-center border-t border-slate-200">
                <p class="text-base font-bold text-[#1D4ED8]">Terima Kasih Atas Pembelian Anda!</p>
                <p class="text-sm text-slate-500 mt-2">Barang yang sudah dibeli tidak dapat ditukar kecuali melalui fitur komplain.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('kasir.pos.receipt.pdf', $transaction) }}" target="_blank"
                class="inline-flex items-center gap-2 rounded-xl bg-[#1D4ED8] px-8 py-4 text-base font-bold text-slate-900 shadow-lg transition hover:bg-orange-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download PDF
            </a>

            <button onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border-2 border-slate-200 bg-white px-8 py-4 text-base font-bold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:border-slate-200">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Nota
            </button>

            <a href="{{ route('kasir.pos.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border-2 border-slate-200 bg-white px-8 py-4 text-base font-bold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:border-slate-200">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Transaksi Baru
            </a>
        </div>
    </div>

    <!-- Sembunyikan elemen lain saat di-print (CTRL+P dari browser) -->
    <style>
        @media print {
            body * { visibility: hidden; }
            .max-w-4xl, .max-w-4xl * { visibility: visible; }
            .max-w-4xl { position: absolute; left: 0; top: 0; width: 100%; max-width: 100%; margin: 0; padding: 0; }
            .flex.items-center.justify-center.gap-4 { display: none !important; }
            .rounded-3xl { border: none !important; box-shadow: none !important; }
        }
    </style>
</x-kasir-layout>
