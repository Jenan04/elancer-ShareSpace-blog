<x-layouts.app>
    <x-slot:title>Link expired - ShareSpace</x-slot>

    <main class="bg-white min-h-screen w-full flex flex-col items-center justify-center px-6 py-16 relative z-10 font-sans animate-fade-in">
        <div class="mb-10 transform transition-transform hover:scale-105 duration-300 scale-115">
            <x-logo />
        </div>

        <div class="text-center max-w-xl mb-12">
            <h1 class="font-sans text-3xl md:text-4xl font-bold text-[#162B1E] tracking-tight mb-5 leading-tight">
                This link has expired
            </h1>
            <p class="font-sans text-base text-on-surface-variant/80 max-w-md mx-auto leading-relaxed">
                Magic links are valid for 15 minutes. Request a new code to sign in.
            </p>
        </div>

        <div class="w-full max-w-md px-2">
            <a
                href="{{ route('signin') }}"
                class="block w-full py-4 bg-accent-purple text-white font-sans text-sm font-bold rounded-xl hover:opacity-95 active:scale-[0.98] transition-all shadow-md cursor-pointer tracking-wide text-center"
            >
                Back to sign in
            </a>
        </div>
    </main>
</x-layouts.app>
