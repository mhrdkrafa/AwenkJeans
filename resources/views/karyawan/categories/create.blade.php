<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Tambah Kategori</h2>
            <p class="mt-1 text-sm text-slate-500">Tambahkan kategori produk baru ke katalog.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('karyawan.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-600">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#003B95] focus:ring-[#003B95] sm:text-sm" required autofocus>
                @error('name')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1D4ED8] px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-[#002d73]">
                    Simpan Kategori
                </button>
                <a href="{{ route('karyawan.categories.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
