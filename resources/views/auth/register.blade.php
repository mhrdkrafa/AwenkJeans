<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-2 tracking-tight">
            Buat Akun <span class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-400 bg-clip-text text-transparent">Baru</span>
        </h2>
        <p class="text-xs text-slate-500 leading-relaxed">Daftar untuk menikmati kemudahan belanja.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 pl-1">{{ __('Nama Lengkap') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name" class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-4 py-3.5 transition-all duration-300 outline-none" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 pl-1 text-rose-600 text-2xs font-semibold" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 pl-1">{{ __('Email') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email" class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-4 py-3.5 transition-all duration-300 outline-none" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="john@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 pl-1 text-rose-600 text-2xs font-semibold" />
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 pl-1">Nomor Telepon</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <input id="phone" class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-4 py-3.5 transition-all duration-300 outline-none" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="08123456789" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2 pl-1 text-rose-600 text-2xs font-semibold" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 pl-1">{{ __('Password') }}</label>
            <div x-data="{ show: false }" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-12 py-3.5 transition-all duration-300 outline-none"
                                type="password"
                                :type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition duration-200">
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 pl-1 text-rose-600 text-2xs font-semibold" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 pl-1">{{ __('Konfirmasi Password') }}</label>
            <div x-data="{ show: false }" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password_confirmation" class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-12 py-3.5 transition-all duration-300 outline-none"
                                type="password"
                                :type="show ? 'text' : 'password'"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition duration-200">
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 pl-1 text-rose-600 text-2xs font-semibold" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold uppercase tracking-wider rounded-2xl py-3.5 shadow-md shadow-indigo-600/10 hover:shadow-indigo-600/20 transform active:scale-[0.98] transition-all duration-300 cursor-pointer">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6 font-sans">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-bold transition">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
