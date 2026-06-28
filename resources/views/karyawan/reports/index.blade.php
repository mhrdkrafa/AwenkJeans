<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Pusat Laporan</h2>
            <p class="mt-1 text-sm text-slate-500">Akses laporan penjualan, stok, dan pergerakan barang dalam satu tempat.</p>
        </div>
    </x-slot>

    <div class="grid gap-6 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md hover:border-[#003B95]/30">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-[#1D4ED8]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Laporan Penjualan</h3>
            <p class="mt-2 text-sm text-slate-500">Lihat rekapitulasi penjualan harian, bulanan, atau periode tertentu beserta total pendapatan.</p>
            <a href="{{ route('karyawan.reports.sales') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-[#002d73]">
                Buka Laporan
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md hover:border-[#003B95]/30">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Laporan Sisa Stok</h3>
            <p class="mt-2 text-sm text-slate-500">Pantau sisa stok terkini di gudang, estimasi nilai aset barang, dan produk yang menipis.</p>
            <a href="{{ route('karyawan.reports.stock') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-emerald-700">
                Buka Laporan
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md hover:border-[#003B95]/30">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Pergerakan Stok</h3>
            <p class="mt-2 text-sm text-slate-500">Lacak riwayat barang masuk (restock) dan barang keluar (penjualan/penyesuaian).</p>
            <a href="{{ route('karyawan.reports.movements') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-600">
                Buka Laporan
            </a>
        </div>
    </div>
</x-admin-layout>
