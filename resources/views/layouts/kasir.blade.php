<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Kasir</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-slate-50 font-sans antialiased text-slate-900">
        <div x-data="{ userMenuOpen: false }" class="min-h-screen flex flex-col">
            {{-- Top Navbar --}}
            <header class="sticky top-0 z-20 bg-white border-b border-slate-200 shadow-sm">
                <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8 max-w-screen-2xl mx-auto w-full">
                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E85D40] text-sm font-bold text-white shadow-lg shadow-[#E85D40]/30">
                            AJ
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Awenk Jeans</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest">Kasir Panel</p>
                        </div>
                    </div>

                    <nav class="hidden md:flex items-center gap-1 bg-slate-50 p-1 rounded-xl border border-slate-200">
                        <a href="{{ route('kasir.dashboard') }}" class="{{ request()->routeIs('kasir.dashboard') ? 'bg-white shadow-sm text-slate-900' : 'text-slate-600 hover:text-slate-900' }} px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                            Dashboard
                        </a>
                        <a href="{{ route('kasir.pos.index') }}" class="{{ request()->routeIs('kasir.pos.*') ? 'bg-white shadow-sm text-slate-900' : 'text-slate-600 hover:text-slate-900' }} px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                            POS Kasir
                        </a>
                    </nav>

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                type="button"
                                class="flex items-center gap-2 rounded-xl bg-slate-50 border border-slate-200 px-3 py-2 text-sm transition hover:bg-slate-100"
                            >
                                <div class="h-8 w-8 rounded-lg bg-[#E85D40] text-white flex items-center justify-center font-bold text-xs shadow-md shadow-[#E85D40]/20">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                                </div>
                                <span class="hidden sm:block font-medium text-slate-700">{{ auth()->user()->name ?? 'Kasir' }}</span>
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div
                                x-show="userMenuOpen"
                                x-transition
                                @click.outside="userMenuOpen = false"
                                class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl"
                                style="display: none;"
                            >
                                <a href="{{ route('profile.edit') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center rounded-lg px-3 py-2 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 w-full max-w-screen-2xl mx-auto">
                <div class="mx-auto w-full">
                    @if (session('success'))
                        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                            <p class="font-semibold">Periksa input berikut:</p>
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

        @stack('scripts')
    </body>
</html>
