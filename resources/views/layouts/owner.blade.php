<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Owner</title>

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
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-500 text-lg font-bold text-white shadow-lg shadow-amber-950/40">
                                AJ
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-white">Awenk Jeans</p>
                                <p class="text-xs text-amber-400">Owner Dashboard</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto px-4 py-6">
                        <p class="px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Menu</p>

                        <nav class="mt-4 space-y-1.5">
                            <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5 12 4l9 9.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 11.25V20h13.5v-8.75" />
                                    </svg>
                                </span>
                                Dashboard
                            </a>
                        </nav>

                        <p class="mt-8 px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Laporan</p>

                        <nav class="mt-4 space-y-1.5">
                            <a href="{{ route('owner.reports.index') }}" class="{{ request()->routeIs('owner.reports.index') ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                                Ringkasan Laporan
                            </a>
                            <a href="{{ route('owner.reports.sales') }}" class="{{ request()->routeIs('owner.reports.sales') ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Laporan Penjualan
                            </a>
                            <a href="{{ route('owner.reports.stock') }}" class="{{ request()->routeIs('owner.reports.stock') ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </span>
                                Laporan Stok
                            </a>
                            <a href="{{ route('owner.reports.movements') }}" class="{{ request()->routeIs('owner.reports.movements') ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                </span>
                                Pergerakan Stok
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
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Owner' }}</p>
                            <p class="mt-1 text-xs uppercase tracking-wide text-amber-400">Owner</p>
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
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-500">Owner Dashboard</p>
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
                                    <p class="text-xs text-slate-500">Hanya bisa melihat laporan</p>
                                </div>

                                <div class="relative">
                                    <button
                                        @click="userMenuOpen = !userMenuOpen"
                                        type="button"
                                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm transition hover:border-slate-300"
                                    >
                                        <div class="hidden text-right sm:block">
                                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'Owner' }}</p>
                                            <p class="text-xs text-slate-500">Owner</p>
                                        </div>
                                        <div class="h-10 w-10 rounded-xl bg-amber-500 flex items-center justify-center text-white font-bold shadow-lg shadow-amber-600/20">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'O', 0, 1)) }}
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

                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
