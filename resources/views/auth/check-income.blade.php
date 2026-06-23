<x-layouts.app>
    <x-slot:title>Check your inbox - ShareSpace</x-slot>

    <main class="bg-white min-h-screen w-full flex flex-col items-center justify-center px-6 py-16 relative z-10 font-sans animate-fade-in">
        <div class="mb-10 transform transition-transform hover:scale-105 duration-300 scale-115">
            <x-logo />
        </div>

        <div class="text-center max-w-xl mb-12">
            <h1 class="font-sans text-3xl md:text-4xl lg:text-5xl font-bold text-[#162B1E] tracking-tight mb-5 leading-tight">
                Check your inbox
            </h1>
            <p class="font-sans text-base text-on-surface-variant/80 max-w-md mx-auto leading-relaxed">
                We sent a 6-digit code and a magic link to
                <span class="font-semibold text-on-surface">{{ $email }}</span>.
                Use either method to continue.
            </p>
        </div>

        <div class="w-full max-w-md px-2">
            <form action="{{ route('auth.verify-otp') }}" method="POST" class="w-full space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="w-full relative group flex flex-col">
                    <label for="otp" class="text-xs font-bold text-on-surface-variant/70 mb-2 px-1 uppercase tracking-widest">
                        Verification code
                    </label>
                    <input
                        class="w-full px-4 py-4 font-sans text-sm border-2 border-outline-variant/50 rounded-xl bg-surface-container-lowest focus:outline-none focus:border-accent-purple focus:ring-4 focus:ring-accent-purple/10 transition-all duration-200 placeholder:text-on-surface-variant/40 shadow-inner text-center text-2xl tracking-[0.5em] font-bold"
                        id="otp"
                        name="otp"
                        value="{{ old('otp') }}"
                        placeholder="000000"
                        required
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        autocomplete="one-time-code"
                    />

                    @error('otp')
                        <div class="mt-2 text-error text-xs font-semibold px-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button
                    class="w-full py-4 bg-accent-purple text-white font-sans text-sm font-bold rounded-xl hover:opacity-95 active:scale-[0.98] transition-all shadow-md cursor-pointer tracking-wide"
                    type="submit"
                >
                    Verify code
                </button>
            </form>

            <p class="mt-8 text-center text-xs text-on-surface-variant/60 leading-relaxed">
                Didn't receive anything? Check your spam folder or
                <a href="{{ route('signup') }}" class="text-accent-purple font-bold hover:underline">try again</a>.
            </p>
        </div>
    </main>
</x-layouts.app>
