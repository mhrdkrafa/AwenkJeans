<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">Pengaturan Profil</h2>
        <p class="mt-1 text-sm text-slate-400">Perbarui informasi akun, keamanan login, dan pengaturan Anda.</p>
    </x-slot>

    <div class="py-12 bg-[#1a1a1a]">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
                <div class="rounded-2xl border border-white/10 bg-[#222] p-6 shadow-sm">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border border-white/10 bg-[#222] p-6 shadow-sm">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="rounded-2xl border border-rose-200 bg-[#222] p-6 shadow-sm">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
