<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Review Pelanggan</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola ulasan dan feedback dari pelanggan terhadap produk.</p>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Tanggal</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Pelanggan</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Produk</th>
                        <th class="pb-4 text-center font-bold text-slate-500 uppercase tracking-wider text-xs">Rating</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Komentar</th>
                        <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($reviews as $review)
                        <tr class="group transition hover:bg-slate-50/50">
                            <td class="py-4 pr-4 text-slate-500">{{ $review->created_at->format('d M Y') }}</td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-slate-900">{{ $review->customer_name ?: optional($review->user)->name ?: 'Guest' }}</p>
                                @if($review->customer_phone)
                                    <p class="text-xs text-slate-500 mt-1 font-mono">{{ $review->customer_phone }}</p>
                                @endif
                            </td>
                            <td class="py-4 pr-4 text-slate-500">{{ optional($review->product)->name }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-xs font-bold text-amber-600 border border-amber-100">
                                    <svg class="h-3 w-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    {{ $review->rating }}.0
                                </span>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="text-slate-500 max-w-xs truncate text-xs">{{ $review->comment ?: '-' }}</p>
                                @if($review->image)
                                    <a href="{{ asset('storage/' . $review->image) }}" target="_blank" class="text-[10px] font-bold text-[#1D4ED8] hover:underline mt-1 inline-block">Lihat Foto</a>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                <form action="{{ route('karyawan.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus review ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-rose-600 transition hover:text-rose-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">Belum ada review pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    </div>
</x-admin-layout>
