<x-administrator-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Manajemen Model Produk</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola model produk yang tersedia di katalog.</p>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">Daftar Model Produk</h3>
            <a href="{{ route('administrator.product-models.create') }}" class="inline-flex items-center justify-center rounded-xl bg-purple-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-purple-700">
                Tambah Model
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Nama Model</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Merek</th>
                        <th class="pb-4 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Jumlah Produk</th>
                        <th class="pb-4 text-right font-bold text-slate-500 uppercase tracking-wider text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($productModels as $model)
                        <tr class="group transition hover:bg-slate-50/50">
                            <td class="py-4 pr-4 font-bold text-slate-900">{{ $model->name }}</td>
                            <td class="py-4 pr-4 text-slate-500">
                                @if($model->brand)
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600">{{ $model->brand->name }}</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-purple-600">
                                    {{ $model->products_count }} Produk
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('administrator.product-models.edit', $model->id) }}" class="font-medium text-purple-600 transition hover:text-purple-800">Edit</a>
                                    @if($model->products_count == 0)
                                    <form action="{{ route('administrator.product-models.destroy', $model->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus model ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-rose-600 transition hover:text-rose-800">Hapus</button>
                                    </form>
                                    @else
                                    <span class="text-xs text-slate-500 cursor-not-allowed" title="Model ini memiliki produk">Hapus</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">Belum ada data model produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-administrator-layout>
