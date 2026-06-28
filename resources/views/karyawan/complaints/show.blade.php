<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900">Detail Komplain</h1>
    </x-slot>

    <div class="max-w-3xl space-y-6">
        <a href="{{ route('karyawan.complaints.index') }}" class="inline-flex items-center text-sm text-[#1D4ED8] hover:underline">
            ← Kembali ke daftar komplain
        </a>

        <!-- Complaint Info -->
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Pelanggan</p>
                        <p class="text-sm font-medium text-slate-900">{{ $complaint->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500">{{ $complaint->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Invoice</p>
                        <p class="text-sm text-slate-600">{{ $complaint->transaction->invoice_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Produk</p>
                        <p class="text-sm font-medium text-slate-900">{{ $complaint->product->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1">Tanggal Transaksi</p>
                        <p class="text-sm text-slate-600">{{ $complaint->transaction->created_at->translatedFormat('d F Y') ?? '-' }}</p>
                    </div>
                </div>

                {{-- Complaint Deadline Info --}}
                @php
                    $transactionDate = $complaint->transaction->created_at ?? null;
                    $deadlineDate = $transactionDate ? $transactionDate->copy()->addDays(3) : null;
                    $complaintDate = $complaint->created_at;
                    $isExpired = $deadlineDate ? $complaintDate->greaterThan($deadlineDate) : false;
                    $now = now();
                    $deadlinePassed = $deadlineDate ? $now->greaterThan($deadlineDate) : false;
                @endphp
                @if($transactionDate && $deadlineDate)
                    <div class="mt-4 rounded-xl px-4 py-3 flex items-start gap-3 {{ $isExpired ? 'border border-rose-200 bg-rose-50' : 'border border-emerald-200 bg-emerald-50' }}">
                        @if($isExpired)
                            <svg class="h-5 w-5 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                            <div>
                                <p class="text-sm font-bold text-rose-800">Komplain Melewati Batas Waktu</p>
                                <p class="text-xs text-rose-600 mt-0.5">
                                    Transaksi: <strong>{{ $transactionDate->translatedFormat('d F Y, H:i') }}</strong><br>
                                    Batas komplain: <strong>{{ $deadlineDate->translatedFormat('d F Y, H:i') }}</strong><br>
                                    Komplain diajukan pada <strong>{{ $complaintDate->translatedFormat('d F Y, H:i') }}</strong> — sudah melewati batas waktu.
                                </p>
                            </div>
                        @else
                            <svg class="h-5 w-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <div>
                                <p class="text-sm font-bold text-emerald-800">Komplain Dalam Batas Waktu</p>
                                <p class="text-xs text-emerald-600 mt-0.5">
                                    Transaksi: <strong>{{ $transactionDate->translatedFormat('d F Y, H:i') }}</strong><br>
                                    Batas komplain: <strong>{{ $deadlineDate->translatedFormat('d F Y, H:i') }}</strong>
                                    @if($deadlinePassed)
                                        <br><span class="text-slate-500">(Batas waktu komplain sudah berakhir)</span>
                                    @else
                                        <br>Sisa waktu: <strong>{{ $now->diffForHumans($deadlineDate, ['parts' => 2, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}</strong> lagi
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="pt-6 border-t border-slate-200 mt-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-4">Percakapan Komplain</p>
                    
                    <div class="space-y-4 mb-6">
                        <!-- Initial Complaint Message -->
                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-5 mr-8">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Pelanggan &bull; {{ $complaint->created_at->translatedFormat('d M Y, H:i') }}</p>
                            <p class="text-sm text-slate-900 whitespace-pre-line leading-relaxed">{{ $complaint->message }}</p>
                            @include('components.complaint-attachments', ['attachments' => $complaint->attachments])
                        </div>

                        <!-- Old Admin Response if exists -->
                        @if($complaint->admin_response)
                            <div class="rounded-xl bg-blue-50 border border-blue-100 p-5 ml-8">
                                <p class="text-xs font-semibold uppercase tracking-wide text-[#1D4ED8] mb-2">Admin &bull; Terkirim</p>
                                <p class="text-sm text-orange-800 whitespace-pre-line leading-relaxed">{{ $complaint->admin_response }}</p>
                            </div>
                        @endif

                        <!-- New Messages -->
                        @foreach($complaint->messages as $msg)
                            @if($msg->is_admin)
                                <div class="rounded-xl bg-blue-50 border border-blue-100 p-5 ml-8">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#1D4ED8] mb-2">Admin &bull; {{ $msg->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    <p class="text-sm text-orange-800 whitespace-pre-line leading-relaxed">{{ $msg->message }}</p>
                                    @include('components.complaint-attachments', ['attachments' => $msg->attachments])
                                </div>
                            @else
                                <div class="rounded-xl bg-slate-50 border border-slate-200 p-5 mr-8">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Pelanggan &bull; {{ $msg->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    <p class="text-sm text-slate-900 whitespace-pre-line leading-relaxed">{{ $msg->message }}</p>
                                    @include('components.complaint-attachments', ['attachments' => $msg->attachments])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                @if(!in_array($complaint->status, ['closed']))
                    <form action="{{ route('karyawan.complaints.reply', $complaint) }}" method="POST" enctype="multipart/form-data" class="pt-4 border-t border-slate-200">
                        @csrf
                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-600 mb-1">Tulis Balasan</label>
                            <textarea name="message" id="message" rows="3" required
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]"
                                placeholder="Ketik balasan untuk pelanggan..."></textarea>
                        </div>

                        {{-- File Upload --}}
                        @include('components.complaint-upload')

                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="inline-flex items-center rounded-lg bg-[#1D4ED8] px-5 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-orange-600">
                                Kirim Balasan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden mt-6">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                <p class="text-sm font-semibold text-slate-900">Update Status Komplain</p>
            </div>

            <form action="{{ route('karyawan.complaints.update', $complaint) }}" method="POST" class="px-6 py-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-sm font-medium text-slate-600 mb-1">Status Saat Ini</label>
                    <select name="status" id="status" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]">
                        <option value="open" {{ $complaint->status === 'open' ? 'selected' : '' }}>Menunggu (Open)</option>
                        <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>Diproses (In Progress)</option>
                        <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Selesai (Resolved)</option>
                        <option value="closed" {{ $complaint->status === 'closed' ? 'selected' : '' }}>Ditutup (Closed)</option>
                    </select>
                </div>

                <button type="submit" class="inline-flex items-center rounded-xl bg-slate-800 px-6 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-slate-700">
                    Simpan Status
                </button>
            </form>
        </div>
    </div>

</x-admin-layout>
