<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Panel Karyawan</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
    <body class="bg-slate-50 font-sans antialiased text-slate-900">
        <div x-data="{ sidebarOpen: false, userMenuOpen: false }" class="min-h-screen">
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
                style="display: none;"
            ></div>

            <div class="flex min-h-screen">
                <aside
                    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                    class="fixed inset-y-0 left-0 z-40 flex w-72 transform flex-col border-r border-slate-200/10 bg-slate-950 text-slate-200 transition duration-200 ease-in-out lg:static lg:inset-auto lg:translate-x-0"
                >
                    <div class="border-b border-white/10 px-6 py-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E85D40] text-lg font-bold text-white shadow-lg shadow-orange-950/40">
                                AJ
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-white">Awenk Jeans</p>
                                <p class="text-xs text-slate-400">Panel Karyawan</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto px-4 py-6">
                        <p class="px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Menu Utama</p>

                        <nav class="mt-4 space-y-1.5">
                            <a href="{{ route('karyawan.dashboard') }}" class="{{ request()->routeIs('karyawan.dashboard') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5 12 4l9 9.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 11.25V20h13.5v-8.75" />
                                    </svg>
                                </span>
                                Dashboard
                            </a>
                            <a href="{{ route('karyawan.products.index') }}" class="{{ request()->routeIs('karyawan.products.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </span>
                                Produk
                            </a>
                            <a href="{{ route('karyawan.categories.index') }}" class="{{ request()->routeIs('karyawan.categories.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </span>
                                Kategori
                            </a>
                        </nav>

                        <p class="mt-8 px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Stok & Transaksi</p>

                        <nav class="mt-4 space-y-1.5">
                            <a href="{{ route('karyawan.stock.index') }}" class="{{ request()->routeIs('karyawan.stock.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M4 10h16" />
                                    </svg>
                                </span>
                                Manajemen Stok
                            </a>
                            <a href="{{ route('karyawan.transactions.index') }}" class="{{ request()->routeIs('karyawan.transactions.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                    </svg>
                                </span>
                                Data Transaksi
                            </a>
                        </nav>

                        <p class="mt-8 px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Data & Monitoring</p>

                        <nav class="mt-4 space-y-1.5">
                            <a href="{{ route('karyawan.reviews.index') }}" class="{{ request()->routeIs('karyawan.reviews.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </span>
                                Review Pelanggan
                            </a>
                            <a href="{{ route('karyawan.complaints.index') }}" class="{{ request()->routeIs('karyawan.complaints.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </span>
                                Komplain Pelanggan
                            </a>
                            <a href="{{ route('karyawan.visitors.index') }}" class="{{ request()->routeIs('karyawan.visitors.*') ? 'bg-[#E85D40] text-white shadow-sm shadow-[#E85D40]/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
                                Aktivitas Pengunjung
                            </a>
                        </nav>

                        <p class="mt-8 px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Lainnya</p>

                        <nav class="mt-4 space-y-1.5">
                            <a href="{{ route('catalog.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </span>
                                Lihat Katalog
                            </a>
                        </nav>
                    </div>

                    <div class="border-t border-white/10 px-4 py-5">
                        <div class="rounded-2xl bg-white/5 p-4">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">{{ optional(auth()->user())->role->name ?? 'user' }}</p>
                        </div>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur">
                        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                            <div class="flex items-center gap-3">
                                <button
                                    @click="sidebarOpen = !sidebarOpen"
                                    type="button"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-400 lg:hidden"
                                >
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                                    </svg>
                                </button>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#E85D40]">Panel Karyawan</p>
                                    @isset($header)
                                        <div class="text-slate-900">{{ $header }}</div>
                                    @else
                                        <h1 class="text-lg font-semibold text-slate-900">Dashboard</h1>
                                    @endisset
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="hidden rounded-2xl border border-slate-200 bg-white px-4 py-2 text-right xl:block">
                                    <p class="text-sm font-semibold text-slate-900">{{ now()->translatedFormat('l, d F Y') }}</p>
                                    <p class="text-xs text-slate-500">Panel karyawan toko</p>
                                </div>

                                <div class="relative">
                                    <button
                                        @click="userMenuOpen = !userMenuOpen"
                                        type="button"
                                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm transition hover:border-slate-300"
                                    >
                                        <div class="hidden text-right sm:block">
                                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'User' }}</p>
                                            <p class="text-xs text-slate-500">{{ optional(auth()->user())->role->name ?? 'user' }}</p>
                                        </div>
                                        <div class="h-10 w-10 rounded-xl bg-[#E85D40] flex items-center justify-center text-white font-bold shadow-lg shadow-orange-600/20">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        </div>
                                    </button>

                                    <div
                                        x-show="userMenuOpen"
                                        x-transition
                                        @click.outside="userMenuOpen = false"
                                        class="absolute right-0 mt-3 w-56 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl"
                                        style="display: none;"
                                    >
                                        <a href="{{ route('profile.edit') }}" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                            Pengaturan profil
                                        </a>
                                        <a href="{{ route('catalog.index') }}" class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                            Buka katalog
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                        <div class="mx-auto w-full max-w-7xl space-y-6">
                            @if (session('success'))
                                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                                    <p class="font-semibold">Ada beberapa input yang perlu diperbaiki.</p>
                                    <ul class="mt-2 list-disc space-y-1 pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
