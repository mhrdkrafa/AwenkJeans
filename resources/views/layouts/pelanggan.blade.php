<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Akun Saya</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 font-sans antialiased text-slate-900">
        <div x-data="{ sidebarOpen: false, userMenuOpen: false }" class="min-h-screen flex">
            <!-- Mobile Sidebar Overlay -->
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"
                style="display: none;"
            ></div>

            <!-- Sidebar -->
            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-40 flex w-72 transform flex-col border-r border-slate-200 bg-white text-slate-600 transition duration-300 ease-in-out lg:static lg:inset-auto lg:translate-x-0 shadow-sm"
            >
                <div class="border-b border-slate-100 px-6 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#1D4ED8] text-lg font-bold text-white shadow-lg shadow-blue-900/20">
                            AJ
                        </div>
                        <div>
                            <p class="text-lg font-black tracking-tight text-slate-900">Awenk<span class="text-[#D97706]">Jeans</span></p>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Akun Pelanggan</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto px-4 py-6">
                    <p class="px-3 text-xs font-bold uppercase tracking-widest text-slate-400">Menu Utama</p>

                    <nav class="mt-4 space-y-1.5">
                        <a href="{{ route('pelanggan.orders') }}" class="{{ request()->routeIs('pelanggan.orders*') ? 'bg-[#1D4ED8] text-white shadow-md shadow-blue-900/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('pelanggan.orders*') ? 'bg-white/20' : 'bg-slate-100' }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </span>
                            Riwayat Pembelian
                        </a>
                        <a href="{{ route('pelanggan.complaints.index') }}" class="{{ request()->routeIs('pelanggan.complaints*') ? 'bg-[#1D4ED8] text-white shadow-md shadow-blue-900/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('pelanggan.complaints*') ? 'bg-white/20' : 'bg-slate-100' }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </span>
                            Komplain Saya
                        </a>
                        <a href="{{ route('catalog.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </span>
                            Lihat Katalog
                        </a>
                    </nav>
                </div>

                <div class="border-t border-slate-100 px-4 py-5">
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Pelanggan</p>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex min-w-0 flex-1 flex-col">
                <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur-md">
                    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                        <div class="flex items-center gap-3">
                            <button
                                @click="sidebarOpen = !sidebarOpen"
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-slate-900 hover:bg-slate-50 lg:hidden transition"
                            >
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                                </svg>
                            </button>

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#1D4ED8]">Dasbor</p>
                                @isset($header)
                                    <div class="text-lg font-black text-slate-900 tracking-tight">{{ $header }}</div>
                                @else
                                    <h1 class="text-lg font-black text-slate-900 tracking-tight">Riwayat Pembelian</h1>
                                @endisset
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <button
                                    @click="userMenuOpen = !userMenuOpen"
                                    type="button"
                                    class="flex items-center gap-2 rounded-xl bg-white border border-slate-200 px-3 py-2 text-sm transition hover:bg-slate-50"
                                >
                                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#1D4ED8]/10 text-xs font-bold text-[#1D4ED8]">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="hidden font-bold text-slate-700 sm:block">{{ auth()->user()->name ?? 'User' }}</span>
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div
                                    x-show="userMenuOpen"
                                    x-transition
                                    @click.outside="userMenuOpen = false"
                                    class="absolute right-0 mt-2 w-48 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl"
                                    style="display: none;"
                                >
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil
                                    </a>
                                    
                                    <div class="my-1 border-t border-slate-100"></div>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-left text-sm font-bold text-rose-600 transition hover:bg-rose-50">
                                            <svg class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                    @if (session('success'))
                        <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 flex items-start gap-3">
                            <div class="mt-0.5 text-emerald-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-8 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 flex items-start gap-3">
                            <div class="mt-0.5 text-rose-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="text-sm font-semibold text-rose-800">{{ session('error') }}</div>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
