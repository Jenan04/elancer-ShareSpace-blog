<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6" id="main-header">
    <nav
        class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3 bg-surface-container-high/80 backdrop-blur-md sticky top-4 mx-auto w-11/12 rounded-full shadow-sm border border-outline-variant/20 transition-all duration-300">
        <x-logo />
        
        <div class="hidden md:flex items-center gap-8">
            @auth
                @canany(['manage_roles', 'manage_users'])
                <a class="relative font-label-md text-label-md text-primary font-bold hover:text-primary/80 transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-full after:h-[2px] after:bg-primary"
                    href="{{ route('roles.index') }}">Dashboard</a>
                @endcanany
                <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                    href="{{ route('feed') }}">Feed</a>

                <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                    href="{{ route('posts.create') }}">Create Post</a>

                <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                    href="{{ route('profile.show', auth()->user()->username) }}">My Profile</a>
            @else
                <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                    href="/#features">Features</a>

                <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                    href="{{ route('feed') }}">
                    Articles
                </a>

                <a class="relative font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300 pb-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[2px] after:bg-primary hover:after:w-full after:transition-all after:duration-300"
                    href="/#cta">
                    Join Us
                </a>
            @endauth
        </div>

        <div class="flex items-center gap-6">
            @auth
                <x-button variant="ghost" size="nav" href="{{ route('posts.create') }}"
                    class="hidden lg:block font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-200 scale-95 active:scale-90">
                    Write
                </x-button>

                <a href="{{ route('profile.show', auth()->user()->username) }}" 
                   class="text-xs font-semibold px-4 py-2 bg-primary text-white rounded-full shadow-sm hover:bg-primary/95 transition-all">
                    {{ auth()->user()->name ?? explode('@', auth()->user()->email)[0] }}
                </a>
            @else
                <x-button variant="ghost" size="nav" href="{{ route('signin') }}"
                    class="hidden lg:block font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-200 scale-95 active:scale-90">
                    Sign In
                </x-button>

                <x-button variant="primary" size="nav" href="{{ route('signup') }}">
                    Get Started
                </x-button>
            @endauth
        </div>
    </nav>
</header>