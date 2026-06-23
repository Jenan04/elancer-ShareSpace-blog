<x-layouts.app>
    <x-slot:title>Sign Up - ShareSpace</x-slot>

    <main class="bg-white min-h-screen w-full flex flex-col items-center justify-center px-6 py-16 relative z-10 font-sans animate-fade-in">
        
        <div class="mb-10 transform transition-transform hover:scale-105 duration-300 scale-115">
            <x-logo />
        </div>

        <div class="text-center max-w-xl mb-12">
            <h1 class="font-sans text-3xl md:text-4xl lg:text-5xl font-bold text-[#162B1E] tracking-tight mb-5 leading-tight">
                {{ $heading ?? 'Bring your stories to life' }}
            </h1>
            <p class="font-sans text-base text-on-surface-variant/80 max-w-md mx-auto leading-relaxed">
                {{ $description ?? 'Enter your email to secure your piece of ShareSpace. An elegant home for your essays, research, and daily thoughts—designed for everyone who loves to write.' }}
            </p>
        </div>

        <div class="w-full max-w-md px-2">
            <form action="{{ $submitRoute ?? route('signup') }}" method="POST" class="w-full space-y-5">
                @csrf

                <div class="w-full relative group flex flex-col">
                    <input class="w-full px-4 py-4 font-sans text-sm border-2 border-outline-variant/50 rounded-xl bg-surface-container-lowest focus:outline-none focus:border-accent-purple focus:ring-4 focus:ring-accent-purple/10 transition-all duration-200 placeholder:text-on-surface-variant/40 shadow-inner" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="you@example.com" 
                           required 
                           type="email"/>
                    
                    @error('email')
                        <div class="mt-2 text-error text-xs font-semibold px-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button class="w-full py-4 bg-accent-purple text-white font-sans text-sm font-bold rounded-xl hover:opacity-95 active:scale-[0.98] transition-all shadow-md cursor-pointer tracking-wide" 
                        type="submit">
                    Continue
                </button>
            </form>

            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-outline-variant/30"></div>
                </div>
                <div class="relative flex justify-center text-xs font-bold">
                    <span class="bg-[#fcf9f4] px-4 text-on-surface-variant/50 tracking-widest uppercase">OR</span>
                </div>
            </div>

            <div class="w-full">
                <a class="flex items-center justify-center gap-3 py-4 border-2 border-outline-variant/50 text-on-surface bg-surface-container-lowest rounded-xl hover:bg-surface-container-low transition-all duration-200 hover:scale-[1.01] active:scale-98 font-bold text-sm shadow-sm hover:shadow cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>
            </div>

            <footer class="bg-white mt-12 text-center space-y-5">
                <p class="text-xs text-on-surface-variant/60 px-2 leading-relaxed">
                    By continuing, you agree to our <a class="underline hover:text-accent-purple transition-colors" href="#">Terms of Service</a> and <a class="underline hover:text-accent-purple transition-colors" href="#">Privacy Policy</a>.
                </p>
                <div class="pt-2">
                    <a href="{{ $alternateRoute ?? route('signin') }}" class="text-sm text-accent-purple font-bold hover:underline flex items-center justify-center gap-ss-1 transition-colors cursor-pointer">
                        {{ $alternateLabel ?? 'Sign in to an existing blog' }}
                        <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                    </a>
                </div>
            </footer>
        </div>
    </main>
</x-layouts.app>