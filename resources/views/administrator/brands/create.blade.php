<x-administrator-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Tambah Merek</h2>
            <p class="mt-1 text-sm text-slate-500">Tambahkan merek (brand) baru untuk produk.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('administrator.brands.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-600">Nama Merek</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-purple-600 focus:ring-purple-600 sm:text-sm" required autofocus>
                @error('name')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                    Simpan Merek
                </button>
                <a href="{{ route('administrator.brands.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-administrator-layout>
