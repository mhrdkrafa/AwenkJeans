<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900">Tambah Akun Baru</h1>
    </x-slot>

    <div class="max-w-2xl">
        <a href="{{ route('administrator.users.index') }}" class="inline-flex items-center text-sm text-[#1D4ED8] hover:underline mb-4">
            ← Kembali ke daftar akun
        </a>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                <p class="text-sm font-semibold text-slate-900">Buat Akun Kasir atau Admin Baru</p>
                <p class="text-xs text-slate-500">Isi form berikut untuk membuat akun baru</p>
            </div>

            <form action="{{ route('administrator.users.store') }}" method="POST" class="px-6 py-6 space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]">
                    @error('email')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-slate-600 mb-1">Role</label>
                    <select name="role_id" id="role_id" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]">
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-600 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]">
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-600 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-[#003B95] focus:ring-[#003B95]">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center rounded-xl bg-[#1D4ED8] px-6 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-orange-600">
                        Buat Akun
                    </button>
                    <a href="{{ route('administrator.users.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
