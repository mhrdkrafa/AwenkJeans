<x-administrator-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900">Kelola Akun</h1>
    </x-slot>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Karyawan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalKaryawan }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Kasir</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalKasir }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Owner</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalOwner }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Pelanggan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalPelanggan }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-slate-900">Daftar Akun</h2>
        <a href="{{ route('administrator.users.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#1D4ED8] px-5 py-2.5 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-orange-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Akun
        </a>
    </div>

    <!-- Table -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-500">Nama</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Email</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Role</th>
                    <th class="px-6 py-4 font-semibold text-slate-500">Terdaftar</th>
                    <th class="px-6 py-4 font-semibold text-slate-500 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-lg bg-[#1D4ED8] flex items-center justify-center text-slate-900 font-bold text-xs">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                @if($user->role->name === 'karyawan') bg-purple-100 text-purple-700
                                @elseif($user->role->name === 'kasir') bg-orange-100 text-orange-700
                                @elseif($user->role->name === 'owner') bg-amber-100 text-amber-700
                                @else bg-slate-50 text-slate-600
                                @endif
                            ">
                                {{ ucfirst($user->role->name) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($user->role->name !== 'pelanggan')
                                    <a href="{{ route('administrator.users.edit', $user) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:bg-slate-50">
                                        Edit
                                    </a>
                                @endif
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('administrator.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-medium text-rose-700 transition hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada akun.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-administrator-layout>
