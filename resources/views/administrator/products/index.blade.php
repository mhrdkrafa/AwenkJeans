<x-administrator-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-slate-900">Manajemen Produk</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola katalog produk, stok, dan informasi harga dari satu halaman.</p>
            </div>
            <a href="{{ route('administrator.products.create') }}" class="inline-flex items-center justify-center rounded-xl bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total produk</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $productStats['total'] }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Produk aktif</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $productStats['active'] }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Stok menipis</p>
                <p class="mt-2 text-3xl font-semibold text-amber-600">{{ $productStats['low_stock'] }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Stok habis</p>
                <p class="mt-2 text-3xl font-semibold text-rose-600">{{ $productStats['out_of_stock'] }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar produk</h3>
                    <p class="mt-1 text-sm text-slate-500">Produk dengan nama sama dan beda ukuran otomatis dikelompokkan.</p>
                </div>
                <div class="text-sm text-slate-500">
                    {{ $products->total() }} produk total
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Ukuran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Total Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white" x-data="{ expanded: null }">
                        @forelse ($products as $product)
                            {{-- Main grouped row --}}
                            <tr class="hover:bg-slate-50 transition-colors cursor-pointer"
                                @click="expanded = expanded === {{ $product->id }} ? null : {{ $product->id }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Thumbnail --}}
                                        <div class="h-12 w-12 flex-shrink-0 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-slate-300">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                            <p class="mt-0.5 text-xs text-slate-500">{{ $product->brand ?: 'Tanpa merek' }}{{ $product->model ? ' | ' . $product->model : '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $product->category->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->available_sizes ?? [] as $sz)
                                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">{{ $sz }}</span>
                                        @endforeach
                                    </div>
                                    @if(($product->variant_count ?? 1) > 1)
                                        <p class="mt-1 text-[10px] text-slate-400 font-medium">{{ $product->variant_count }} varian</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php $totalStock = $product->total_stock ?? $product->stock; @endphp
                                    <span @class([
                                        'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                        'bg-emerald-100 text-emerald-700' => $totalStock > $product->min_stock,
                                        'bg-amber-100 text-amber-700' => $totalStock > 0 && $totalStock <= $product->min_stock,
                                        'bg-rose-100 text-rose-700' => $totalStock <= 0,
                                    ])>
                                        {{ $totalStock }} stok
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-wrap gap-3">
                                        @if(($product->variant_count ?? 1) > 1)
                                            <button @click.stop="expanded = expanded === {{ $product->id }} ? null : {{ $product->id }}"
                                                    class="font-medium text-indigo-600 transition hover:text-indigo-800 flex items-center gap-1">
                                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded === {{ $product->id }} }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                Varian
                                            </button>
                                        @else
                                            <a href="{{ route('administrator.products.show', $product->id) }}" class="font-medium text-slate-600 transition hover:text-slate-900">Detail</a>
                                            <a href="{{ route('administrator.products.edit', $product->id) }}" class="font-medium text-purple-600 transition hover:text-purple-800">Edit</a>
                                            <form action="{{ route('administrator.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-rose-600 transition hover:text-rose-800">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Expandable variant rows --}}
                            @if(($product->variant_count ?? 1) > 1)
                                @foreach($product->all_variants ?? [] as $variant)
                                    <tr x-show="expanded === {{ $product->id }}"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="bg-slate-50/70 border-l-4 border-l-purple-200">
                                        <td class="px-6 py-3 pl-20">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                                <span class="text-sm text-slate-600">Ukuran <strong class="text-slate-900">{{ $variant['size_name'] }}</strong></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-400">—</td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center rounded-lg bg-purple-100 px-2.5 py-0.5 text-xs font-bold text-purple-700">{{ $variant['size_name'] }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-sm font-medium text-slate-700">Rp {{ number_format($variant['price'], 0, ',', '.') }}</td>
                                        <td class="px-6 py-3">
                                            <span @class([
                                                'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                                'bg-emerald-100 text-emerald-700' => $variant['stock'] > $variant['min_stock'],
                                                'bg-amber-100 text-amber-700' => $variant['stock'] > 0 && $variant['stock'] <= $variant['min_stock'],
                                                'bg-rose-100 text-rose-700' => $variant['stock'] <= 0,
                                            ])>
                                                {{ $variant['stock'] }} stok
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            <div class="flex flex-wrap gap-3">
                                                <a href="{{ route('administrator.products.show', $variant['id']) }}" class="font-medium text-slate-600 transition hover:text-slate-900">Detail</a>
                                                <a href="{{ route('administrator.products.edit', $variant['id']) }}" class="font-medium text-purple-600 transition hover:text-purple-800">Edit</a>
                                                <form action="{{ route('administrator.products.destroy', $variant['id']) }}" method="POST" onsubmit="return confirm('Hapus varian ukuran {{ $variant['size_name'] }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-rose-600 transition hover:text-rose-800">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada produk yang tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-administrator-layout>
