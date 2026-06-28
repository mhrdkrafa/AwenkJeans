<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900">Komplain Pelanggan</h1>
         <p class="mt-1 text-sm text-slate-500">Lihat dan kelola komplain dari pelanggan terkait produk.</p>
    </x-slot>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Menunggu</p>
            <p class="mt-2 text-2xl font-bold text-amber-900">{{ $totalOpen }}</p>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-[#1D4ED8]">Diproses</p>
            <p class="mt-2 text-2xl font-bold text-blue-900">{{ $totalInProgress }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Selesai</p>
            <p class="mt-2 text-2xl font-bold text-emerald-900">{{ $totalResolved }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-500">Pelanggan</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Judul</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Produk</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Invoice</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Tanggal</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($complaints as $complaint)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $complaint->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ Str::limit($complaint->subject, 30) }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ Str::limit($complaint->product->name ?? '-', 25) }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $complaint->transaction->invoice_number ?? '-' }}</td>
                        <td class="px-6 py-4">
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
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $complaint->created_at->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('karyawan.complaints.show', $complaint) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:bg-slate-50">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada komplain.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $complaints->links() }}
    </div>
</x-admin-layout>
