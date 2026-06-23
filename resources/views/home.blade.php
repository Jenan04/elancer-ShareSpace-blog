<x-layouts.app>
    <x-slot:title>Dashboard - ShareSpace</x-slot>

    <main class="bg-white min-h-screen w-full flex flex-col items-center justify-center px-6 py-16 relative z-10 font-sans">
        <div class="mb-10">
            <x-logo />
        </div>

        <div class="text-center max-w-xl mb-8">
            <h1 class="font-sans text-3xl md:text-4xl font-bold text-[#162B1E] tracking-tight mb-5 leading-tight">
                Welcome to ShareSpace
            </h1>
            <p class="font-sans text-base text-on-surface-variant/80 max-w-md mx-auto leading-relaxed">
                You are signed in as <span class="font-semibold text-on-surface">{{ $user->email }}</span>.
            </p>
        </div>

        <div class="w-full max-w-md px-2 text-center">
            <p class="text-sm text-on-surface-variant/70">
                Your SaaS profile space is ready. Start building your blog from here.
            </p>
        </div>
    </main>
</x-layouts.app>
