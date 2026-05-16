<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6" id="main-header">
    <nav
        class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3 bg-surface-container-high/80 backdrop-blur-md sticky top-4 mx-auto w-11/12 rounded-full shadow-sm border border-outline-variant/20 transition-all duration-300">
        <x-logo />
        <div class="hidden md:flex items-center gap-lg">
            <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                href="#features">Features</a>

            <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                href="#features">
                Articles
            </a>

            <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                href="#cta">
                Join Us
            </a>
        </div>
        <div class="flex items-center gap-md">

            <x-button variant="ghost" size="nav" href="{{ route('login') }}"
                class="hidden lg:block font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-200 scale-95 active:scale-90">
                Sign In
            </x-button>

            <x-button variant="primary" size="nav" href="{{ route('register') }}">
                Get Started
            </x-button>
        </div>
    </nav>
</header>