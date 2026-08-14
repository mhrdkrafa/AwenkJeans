<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-slate-900">Detail Produk</h2>
                <p class="mt-1 text-sm text-slate-500">Lihat informasi lengkap produk.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('karyawan.products.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl">
        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 space-y-6">
                {{-- Product Image --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    @if($product->image)
                        <div class="aspect-[16/9] bg-slate-100">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="aspect-[16/9] bg-slate-50 flex flex-col items-center justify-center text-slate-300">
                            <svg class="w-16 h-16 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-slate-400 font-medium">Belum ada gambar</p>
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $product->category->name }} @if($product->size) | Ukuran {{ $product->size->name }} @endif</p>
                    </div>

                    <div class="mt-6 grid gap-5 md:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-500">Merek</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">{{ optional($product->brandRelation)->name ?: ($product->brand ?: '-') }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-500">Model</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">{{ optional($product->modelRelation)->name ?: ($product->model ?: '-') }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-500">Harga</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-500">Slug</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">{{ $product->slug }}</p>
                        </div>
                        @if($product->color || $product->colorRelation)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-500">Warna</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">{{ optional($product->colorRelation)->name ?: $product->color }}</p>
                        </div>
                        @endif
                        @if($product->gender)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-medium text-slate-500">Jenis Kelamin</p>
                            <p class="mt-2 text-base font-semibold text-slate-900">{{ ucfirst($product->gender) }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-200 p-5">
                        <p class="text-sm font-medium text-slate-500">Deskripsi</p>
                        <p class="mt-3 text-sm leading-7 text-slate-700">{{ $product->description ?: 'Belum ada deskripsi.' }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Status stok</h3>
                    <span @class([
                        'mt-4 inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                        'bg-emerald-100 text-emerald-700' => $product->stock > $product->min_stock,
                        'bg-amber-100 text-amber-700' => $product->stock > 0 && $product->stock <= $product->min_stock,
                        'bg-rose-100 text-rose-700' => $product->stock <= 0,
                    ])>
                        {{ $product->stock }} unit tersedia
                    </span>
                    <p class="mt-3 text-sm text-slate-600">Batas minimum stok ditetapkan pada {{ $product->min_stock }} unit.</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
