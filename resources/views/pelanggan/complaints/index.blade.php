<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">Komplain Saya</h2>
        <p class="mt-1 text-sm text-slate-500">Status dan riwayat komplain produk Anda.</p>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if($complaints->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">Tidak Ada Komplain</h3>
                    <p class="mt-2 text-sm text-slate-500">Anda belum memiliki komplain. Jika ada masalah dengan pembelian, Anda bisa membuat komplain dari halaman riwayat pembelian.</p>
                    <a href="{{ route('pelanggan.orders') }}" class="mt-6 inline-flex items-center rounded-xl bg-[#1D4ED8] px-6 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-orange-600">
                        Ke Riwayat Pembelian
                    </a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach($complaints as $complaint)
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden flex flex-col h-full">
                            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $complaint->subject }}</p>
                                    <p class="text-xs text-slate-500">{{ $complaint->created_at->translatedFormat('d F Y') }} &bull; {{ $complaint->transaction->invoice_number ?? '-' }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
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
                            <div class="px-6 py-4 flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <p class="text-sm text-slate-500"><span class="font-medium text-slate-900">Produk:</span> {{ $complaint->product->name ?? '-' }}</p>
                                </div>
                                <p class="text-sm text-slate-600">{{ Str::limit($complaint->message, 150) }}</p>

                                @php
                                    $latestAdminMsg = $complaint->messages->first();
                                @endphp

                                @if($latestAdminMsg)
                                    <div class="mt-4 rounded-xl bg-blue-50 border border-blue-100 p-4">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <div class="w-5 h-5 rounded-full bg-[#1D4ED8]/20 text-[#1D4ED8] flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <p class="text-xs font-bold text-[#1D4ED8]">Respon {{ $latestAdminMsg->user->name ?? 'Admin' }}:</p>
                                            <span class="text-[10px] text-slate-400 ml-auto">{{ $latestAdminMsg->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-slate-700 pl-7">{{ Str::limit($latestAdminMsg->message, 120) }}</p>
                                    </div>
                                @elseif($complaint->admin_response)
                                    <div class="mt-4 rounded-xl bg-blue-50 border border-blue-100 p-4">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <div class="w-5 h-5 rounded-full bg-[#1D4ED8]/20 text-[#1D4ED8] flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <p class="text-xs font-bold text-[#1D4ED8]">Respon Admin:</p>
                                        </div>
                                        <p class="text-sm text-slate-700 pl-7">{{ Str::limit($complaint->admin_response, 120) }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="border-t border-slate-200 bg-slate-50 px-6 py-3">
                                <a href="{{ route('pelanggan.complaints.show', $complaint) }}" class="text-sm font-bold text-[#1D4ED8] hover:underline flex items-center gap-1">
                                    Lihat Detail Komplain
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $complaints->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
