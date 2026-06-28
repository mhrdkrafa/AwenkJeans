<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">Detail Pembelian</h2>
        <p class="mt-1 text-sm text-slate-500">Rincian pesanan dan produk yang Anda beli.</p>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-3xl space-y-6">
                <a href="{{ route('pelanggan.orders') }}" class="inline-flex items-center text-sm font-medium text-[#1D4ED8] hover:underline bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition hover:bg-slate-50">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke riwayat pembelian
                </a>

                {{-- Complaint Deadline Notice --}}
                @php
                    $daysSincePurchase = $transaction->created_at->diffInDays(now());
                    $daysRemaining = max(0, 3 - $daysSincePurchase);
                @endphp
                @if($daysSincePurchase <= 3)
                    <div class="rounded-xl border border-blue-200 bg-blue-50 px-5 py-3 flex items-center gap-3">
                        <svg class="h-5 w-5 text-[#1D4ED8] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm text-blue-800 font-medium">
                            Anda masih memiliki <strong>{{ $daysRemaining }} hari</strong> untuk mengajukan komplain pada transaksi ini.
                        </p>
                    </div>
                @else
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-3 flex items-center gap-3">
                        <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm text-slate-500 font-medium">
                            Batas waktu komplain (3 hari) telah berakhir untuk transaksi ini.
                        </p>
                    </div>
                @endif

                <!-- Transaction Info -->
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $transaction->invoice_number }}</p>
                            <p class="text-xs text-slate-500">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                    </div>

                    <div class="px-6 py-4 space-y-3 border-b border-slate-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Kasir</span>
                            <span class="font-medium text-slate-900">{{ $transaction->cashier->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Metode Pembayaran</span>
                            <span class="font-medium text-slate-900">{{ strtoupper($transaction->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-2 pt-2 border-t border-dashed border-slate-200">
                            <span class="text-slate-600 font-semibold">Total Pembayaran</span>
                            <span class="font-bold text-lg text-[#1D4ED8]">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($transaction->details as $detail)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 gap-4">
                                <div class="flex items-center gap-4">
                                    @if($detail->product && $detail->product->image)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" class="h-16 w-16 rounded-xl object-cover border border-slate-200">
                                    @else
                                        <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-slate-50 text-slate-500">
                                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $detail->product->name ?? 'Produk dihapus' }}</p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            <span class="inline-block bg-slate-50 px-2 py-0.5 rounded text-slate-500">{{ $detail->product->category->name ?? '' }}</span>
                                            <span class="inline-block bg-slate-50 px-2 py-0.5 rounded text-slate-500">{{ $detail->product->size->name ?? '' }}</span>
                                            &bull; {{ $detail->quantity }}x
                                            &bull; Rp {{ number_format($detail->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm font-bold text-slate-900 mt-1.5">
                                            Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 self-start sm:self-center">
                                    <a href="{{ route('catalog.show', $detail->product->slug ?? '#') }}" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:bg-slate-50 bg-white shadow-sm">
                                        Review
                                    </a>
                                    @if($transaction->created_at->diffInDays(now()) <= 3)
                                        <a href="{{ route('pelanggan.complaints.create', ['transaction_id' => $transaction->id, 'product_id' => $detail->product_id]) }}" class="inline-flex items-center rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-100 shadow-sm">
                                            Komplain
                                        </a>
                                    @else
                                        <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-400 cursor-not-allowed" title="Batas waktu komplain 3 hari telah lewat">
                                            <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Komplain (Expired)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Complaints for this transaction -->
                @if($transaction->complaints->count() > 0)
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                            <h3 class="font-semibold text-slate-900">Komplain untuk Transaksi Ini</h3>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($transaction->complaints as $complaint)
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-medium text-slate-900">{{ $complaint->subject }}</p>
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                            @if($complaint->status === 'open') bg-amber-100 text-amber-700
                                            @elseif($complaint->status === 'in_progress') bg-orange-100 text-[#1D4ED8]
                                            @elseif($complaint->status === 'resolved') bg-emerald-100 text-emerald-700
                                            @else bg-slate-50 text-slate-600
                                            @endif
                                        ">
                                            @if($complaint->status === 'open') Menunggu
                                            @elseif($complaint->status === 'in_progress') Diproses
                                            @elseif($complaint->status === 'resolved') Selesai
                                            @else Ditutup
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-500">{{ Str::limit($complaint->message, 100) }}</p>
                                    <a href="{{ route('pelanggan.complaints.show', $complaint) }}" class="text-xs font-bold text-[#1D4ED8] hover:underline mt-2 inline-flex items-center gap-1">
                                        Lihat Detail Komplain
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
