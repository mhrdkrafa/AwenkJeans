<x-administrator-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Edit Model Produk</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui informasi model produk.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('administrator.product-models.update', $productModel->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-600">Nama Model</label>
                <input type="text" name="name" id="name" value="{{ old('name', $productModel->name) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-purple-600 focus:ring-purple-600 sm:text-sm" required autofocus>
                @error('name')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="brand_id" class="block text-sm font-semibold text-slate-600">Merek (Opsional)</label>
                <select name="brand_id" id="brand_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-purple-600 focus:ring-purple-600 sm:text-sm">
                    <option value="">— Tanpa Merek —</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id', $productModel->brand_id) == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                    Perbarui Model
                </button>
                <a href="{{ route('administrator.product-models.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-administrator-layout>
