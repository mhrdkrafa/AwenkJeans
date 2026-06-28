<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Daftar Kategori</h2>
            <p class="mt-1 text-sm text-slate-500">Lihat kategori produk yang tersedia di katalog. Pengelolaan kategori dilakukan oleh Administrator.</p>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-900">Daftar Kategori</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Nama Kategori</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Slug</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Jumlah Produk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($categories as $category)
                        <tr class="group transition hover:bg-slate-50/50">
                            <td class="py-4 pr-4 font-bold text-slate-900">{{ $category->name }}</td>
                            <td class="py-4 pr-4 text-slate-500">{{ $category->slug }}</td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-[#1D4ED8]">
                                    {{ $category->products_count }} Produk
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-slate-500">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
