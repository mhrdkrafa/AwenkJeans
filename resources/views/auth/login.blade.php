<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-2 tracking-tight">
            Masuk <span class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-400 bg-clip-text text-transparent">Akun</span>
        </h2>
        <p class="text-xs text-slate-500 leading-relaxed">Masukkan akun ada untuk mengakses.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 pl-1">{{ __('Email') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email" 
                       class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-4 py-3.5 transition-all duration-300 outline-none" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required autofocus autocomplete="username" 
                       placeholder="name@awenkjeans.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 pl-1 text-rose-600 text-2xs font-semibold" />
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
                <input id="password" 
                       :type="show ? 'text' : 'password'"
                       class="block w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-2xl text-xs pl-12 pr-12 py-3.5 transition-all duration-300 outline-none"
                       type="password"
                       name="password"
                       required autocomplete="current-password" 
                       placeholder="••••••••" />
                
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

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1 px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group select-none">
                <div class="relative flex items-center justify-center w-4 h-4 mr-2">
                    <input id="remember_me" type="checkbox" class="peer sr-only" name="remember">
                    <div class="w-4 h-4 rounded-md border border-slate-300 bg-white peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-200 animate-none"></div>
                    <svg class="absolute w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100 transition duration-200 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-xs text-slate-500 group-hover:text-slate-700 transition duration-200">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-indigo-600 hover:text-indigo-700 font-semibold transition duration-200" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold uppercase tracking-wider rounded-2xl py-3.5 shadow-md shadow-indigo-600/10 hover:shadow-indigo-600/20 transform active:scale-[0.98] transition-all duration-300 cursor-pointer">
                {{ __('Masuk Akun') }}
            </button>
        </div>
        
        <!-- Register Redirection -->
        <div class="mt-8 text-center text-xs text-slate-500">
            Belum punya akun?
            <a class="text-indigo-600 hover:text-indigo-700 font-bold transition duration-200" href="{{ route('register') }}">
                {{ __('Register') }}
            </a>
        </div>
    </form>
</x-guest-layout>
