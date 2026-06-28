<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Awenk Jeans') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-600 bg-slate-50 min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden select-none">
        
        <!-- Ambient Blur Orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[130px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-amber-500/5 blur-[130px] pointer-events-none"></div>

        <!-- Technical Dotted Grid Background -->
        <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>

        <!-- Main Card Wrapper -->
        <div class="w-full max-w-[940px] bg-white rounded-3xl border border-slate-200/60 shadow-[0_20px_60px_rgba(15,23,42,0.08)] grid grid-cols-1 lg:grid-cols-12 overflow-hidden relative z-10">
            
            <!-- Left Side Content (Form Area) -->
            <div class="p-8 sm:p-12 lg:col-span-5 flex flex-col justify-between min-h-[580px] relative bg-white">
                
                <!-- Brand Header / Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-600/15 border border-indigo-500/10">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 22h4l3-6h6l3 6h4L12 2z"/>
                            <path d="M9 16h6" stroke-dasharray="2 2" stroke="currentColor"/>
                            <path d="M12 2v8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-base font-black text-slate-900 tracking-tight uppercase">Awenk<span class="text-indigo-600 font-semibold">Jeans</span></span>
                        <span class="block text-[8px] uppercase tracking-[0.25em] text-slate-400 font-bold -mt-0.5">Denim Atelier</span>
                    </div>
                </div>

                <!-- Form Container -->
                <div class="w-full max-w-sm mx-auto my-auto py-8">
                    {{ $slot }}
                </div>
                
                <!-- Footer Info -->
                <div class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold flex items-center justify-between">
                    <span>&copy; {{ date('Y') }} Awenk Jeans</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500/20"></span>
                </div>
            </div>

            <!-- Right Side (Image Cover) -->
            <div class="hidden lg:block lg:col-span-7 p-3 bg-white">
                <div class="relative w-full h-full rounded-2xl overflow-hidden min-h-[580px] border border-slate-100 shadow-inner group">
                    <!-- Image with subtle zoom on hover -->
                    <img src="{{ asset('images/login_page.jpg') }}" alt="Awenk Jeans Editorial" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-102">
                    
                    <!-- Vignette Overlays -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent opacity-80"></div>
                    
                    <!-- Top-Right Glassmorphic Badge -->
                    <div class="absolute top-6 right-6 bg-white/70 backdrop-blur-md border border-white/30 px-3.5 py-1.5 rounded-full shadow-md">
                        <span class="text-[9px] font-bold text-slate-800 tracking-widest uppercase">Est. 2024</span>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>
