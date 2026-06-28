<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">Buat Komplain</h2>
        <p class="mt-1 text-sm text-slate-500">Laporkan masalah terkait produk yang Anda beli.</p>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-2xl">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                        <p class="text-sm font-semibold text-slate-900">Komplain untuk Produk</p>
                        <p class="text-xs text-slate-500">Invoice: {{ $transaction->invoice_number }}</p>
                    </div>

                    <div class="px-6 py-4 border-b border-slate-200">
                        <div class="flex items-center gap-4">
                            @if($detail->product && $detail->product->image)
                                <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" class="h-20 w-20 rounded-xl object-cover">
                            @else
                                <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-slate-50 text-slate-500">
                                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $detail->product->name ?? 'Produk' }}</p>
                                <p class="text-sm text-slate-500">{{ $detail->quantity }}x &bull; Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-slate-500">Dibeli pada {{ $transaction->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('pelanggan.complaints.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-6 space-y-5"
                          x-data
                          @submit.prevent="
                              const fileInput = $el.querySelector('input[name=\'attachments[]\']');
                              if (!fileInput || fileInput.files.length === 0) {
                                  $dispatch('show-attachment-error');
                                  alert('Wajib upload gambar/video sebagai bukti komplain.');
                                  fileInput.closest('[x-data]').scrollIntoView({ behavior: 'smooth', block: 'center' });
                                  return;
                              }
                              $el.submit();
                          ">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <input type="hidden" name="product_id" value="{{ $detail->product_id }}">

                        <div>
                            <label for="subject" class="block text-sm font-medium text-slate-600 mb-1">Judul Komplain</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]"
                                placeholder="Contoh: Barang tidak sesuai deskripsi">
                            @error('subject')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-600 mb-1">Detail Komplain</label>
                            <textarea name="message" id="message" rows="5" required
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]"
                                placeholder="Jelaskan masalah yang Anda alami secara detail...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- File Upload --}}
                        @include('components.complaint-upload', ['required' => true])
                        @error('attachments')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                        @error('attachments.*')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit" class="inline-flex items-center rounded-xl bg-[#1D4ED8] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-orange-600">
                                Kirim Komplain
                            </button>
                            <a href="{{ route('pelanggan.orders') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
