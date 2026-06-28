<x-administrator-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Dashboard Administrator</h2>
            <p class="mt-1 text-sm text-slate-500">Superadmin kontrol penuh seluruh sistem aplikasi.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Stats Cards Users --}}
        <div>
            <h3 class="text-lg font-bold text-slate-900 mb-4">Statistik Pengguna</h3>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Akun</p>
                    <h3 class="mt-2 text-2xl font-bold text-slate-900">{{ $totalUsers }}</h3>
                </div>
                <div class="rounded-[2rem] border border-purple-200 bg-purple-50 p-6 shadow-sm">
                    <p class="text-xs font-medium text-purple-600 uppercase tracking-wider">Karyawan</p>
                    <h3 class="mt-2 text-2xl font-bold text-purple-900">{{ $totalKaryawan }}</h3>
                </div>
                <div class="rounded-[2rem] border border-orange-200 bg-orange-50 p-6 shadow-sm">
                    <p class="text-xs font-medium text-orange-600 uppercase tracking-wider">Kasir</p>
                    <h3 class="mt-2 text-2xl font-bold text-orange-900">{{ $totalKasir }}</h3>
                </div>
                <div class="rounded-[2rem] border border-amber-200 bg-amber-50 p-6 shadow-sm">
                    <p class="text-xs font-medium text-amber-600 uppercase tracking-wider">Owner</p>
                    <h3 class="mt-2 text-2xl font-bold text-amber-900">{{ $totalOwner }}</h3>
                </div>
                <div class="rounded-[2rem] border border-blue-200 bg-blue-50 p-6 shadow-sm">
                    <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Pelanggan</p>
                    <h3 class="mt-2 text-2xl font-bold text-blue-900">{{ $totalPelanggan }}</h3>
                </div>
            </div>
        </div>

            {{-- Recent Users --}}
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Pengguna Terbaru</h3>
                    <a href="{{ route('administrator.users.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider
                            @if($user->role->name === 'administrator') bg-slate-900 text-white
                            @elseif($user->role->name === 'karyawan') bg-purple-100 text-purple-700
                            @elseif($user->role->name === 'kasir') bg-orange-100 text-orange-700
                            @elseif($user->role->name === 'owner') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600
                            @endif
                        ">
                            {{ $user->role->name }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500">Belum ada data pengguna.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-administrator-layout>
