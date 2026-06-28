<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">Riwayat Pembelian</h2>
        <p class="mt-1 text-sm text-slate-500">Daftar semua transaksi yang pernah Anda lakukan.</p>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if($transactions->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">Belum Ada Pembelian</h3>
                    <p class="mt-2 text-sm text-slate-500">Anda belum memiliki riwayat pembelian. Silakan kunjungi katalog kami.</p>
                    <a href="{{ route('catalog.index') }}" class="mt-6 inline-flex items-center rounded-xl bg-[#1D4ED8] px-6 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-orange-600">
                        Lihat Katalog
                    </a>
                </div>
            @else
                @foreach($transactions as $transaction)
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 bg-slate-50 px-6 py-4 gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $transaction->invoice_number }}</p>
                                <p class="text-xs text-slate-500">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                                <span class="text-sm font-bold text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @foreach($transaction->details as $detail)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 gap-4">
                                    <div class="flex items-center gap-4">
                                        @if($detail->product && $detail->product->image)
                                            <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" class="h-16 w-16 rounded-xl object-cover">
                                        @else
                                            <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-slate-50 text-slate-500">
                                                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $detail->product->name ?? 'Produk dihapus' }}</p>
                                            <p class="text-xs text-slate-500">{{ $detail->product->category->name ?? '' }} {{ $detail->product->size->name ?? '' }} &bull; {{ $detail->quantity }}x</p>
                                            <p class="text-sm text-slate-500">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 self-start sm:self-center">
                                        <a href="{{ route('catalog.show', $detail->product->slug ?? '#') }}" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:bg-slate-50">
                                            Review
                                        </a>
                                        <a href="{{ route('pelanggan.complaints.create', ['transaction_id' => $transaction->id, 'product_id' => $detail->product_id]) }}" class="inline-flex items-center rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-100">
                                            Komplain
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-slate-200 bg-slate-50 px-6 py-3 flex justify-between items-center">
                            <p class="text-xs text-slate-500">
                                Kasir: <span class="font-medium text-slate-600">{{ $transaction->cashier->name ?? '-' }}</span>
                                &bull; Pembayaran: <span class="font-medium text-slate-600">{{ strtoupper($transaction->payment_method) }}</span>
                            </p>
                            <a href="{{ route('pelanggan.orders.show', $transaction->id) }}" class="text-xs font-bold text-[#1D4ED8] hover:underline">Detail Transaksi →</a>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
