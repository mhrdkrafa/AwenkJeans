<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">Detail Komplain</h2>
        <p class="mt-1 text-sm text-slate-500">Informasi detail mengenai keluhan Anda dan respon admin.</p>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-2xl space-y-6">
                <a href="{{ route('pelanggan.complaints.index') }}" class="inline-flex items-center text-sm font-medium text-[#1D4ED8] hover:underline bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm transition hover:bg-slate-50">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke daftar komplain
                </a>

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $complaint->subject }}</p>
                            <p class="text-xs text-slate-500">{{ $complaint->created_at->translatedFormat('d F Y, H:i') }}</p>
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

                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Invoice</p>
                            <p class="text-sm text-slate-600 font-medium">{{ $complaint->transaction->invoice_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Produk</p>
                            <p class="text-sm font-medium text-slate-900">{{ $complaint->product->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Pesan Komplain</p>
                            <p class="text-sm text-slate-600 whitespace-pre-line leading-relaxed">{{ $complaint->message }}</p>
                            @include('components.complaint-attachments', ['attachments' => $complaint->attachments])
                        </div>

                        @if($complaint->admin_response)
                            <div class="rounded-xl bg-blue-50 border border-blue-100 p-5 mt-6 ml-8">
                                <p class="text-xs font-semibold uppercase tracking-wide text-[#1D4ED8] mb-2">Admin &bull; Terkirim</p>
                                <p class="text-sm text-orange-800 whitespace-pre-line leading-relaxed">{{ $complaint->admin_response }}</p>
                            </div>
                        @endif

                        @forelse($complaint->messages as $msg)
                            @if($msg->is_admin)
                                <div class="rounded-xl bg-blue-50 border border-blue-100 p-5 mt-4 ml-8">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#1D4ED8] mb-2">Admin &bull; {{ $msg->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    <p class="text-sm text-orange-800 whitespace-pre-line leading-relaxed">{{ $msg->message }}</p>
                                    @include('components.complaint-attachments', ['attachments' => $msg->attachments])
                                </div>
                            @else
                                <div class="rounded-xl bg-slate-50 border border-slate-200 p-5 mt-4 mr-8">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Anda &bull; {{ $msg->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    <p class="text-sm text-slate-900 whitespace-pre-line leading-relaxed">{{ $msg->message }}</p>
                                    @include('components.complaint-attachments', ['attachments' => $msg->attachments])
                                </div>
                            @endif
                        @empty
                            @if(!$complaint->admin_response)
                                <div class="rounded-xl bg-amber-50 border border-amber-100 p-5 mt-6">
                                    <p class="text-sm text-amber-700">Komplain Anda sedang menunggu respon dari admin. Kami akan segera membalas secepatnya.</p>
                                </div>
                            @endif
                        @endforelse

                        @php
                            $isResolved = in_array($complaint->status, ['resolved', 'closed']);
                            $isExpired = $complaint->created_at->diffInDays(now()) > 3;
                            $canReply = !$isResolved && !$isExpired;
                        @endphp

                        @if($canReply)
                            <form action="{{ route('pelanggan.complaints.reply', $complaint) }}" method="POST" enctype="multipart/form-data" class="mt-6 pt-6 border-t border-slate-200">
                                @csrf
                                <div>
                                    <label for="message" class="block text-sm font-medium text-slate-600 mb-1">Tulis Balasan</label>
                                    <textarea name="message" id="message" rows="3" required
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]"
                                        placeholder="Ketik pesan atau tanggapan Anda..."></textarea>
                                </div>

                                {{-- File Upload --}}
                                @include('components.complaint-upload')

                                <div class="mt-3 flex justify-end">
                                    <button type="submit" class="inline-flex items-center rounded-lg bg-[#1D4ED8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 mt-6 text-center">
                                @if($isResolved)
                                    <p class="text-sm text-slate-500">Komplain ini telah diselesaikan. Percakapan tidak dapat dilanjutkan.</p>
                                @elseif($isExpired)
                                    <p class="text-sm text-slate-500">Batas waktu percakapan telah berakhir (lebih dari 3 hari). Percakapan tidak dapat dilanjutkan.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
