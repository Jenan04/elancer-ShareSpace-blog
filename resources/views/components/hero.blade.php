<section class="pt-40 pb-20 px-6 overflow-hidden mb-ss-base">
    <div class="max-w-7xl mx-auto text-center">
        <div
            class="inline-flex items-center gap-2 bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full mb-ss-lg border border-outline-variant/30">
            <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
            <span class="font-label-md text-label-md">New: AI-Powered Writing Assistant & SEO Sync</span>
        </div>

        <h1 class="font-display text-display text-accent-purple mb-ss-md max-w-4xl mx-auto">
            Publish your thoughts. Build your space.
        </h1>

        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-ss-lg">
            ShareSpace is the modern blogging platform where deep thoughts meet dynamic content creation. Write,
            optimize with AI, and share your tech stories with the world effortlessly.
        </p>

        <div class="flex flex-col sm:flex-row gap-base justify-center mb-ss-xl">
            <x-button variant="primary" size="hero" href="{{ route('signup') }}">
                Start Your Blog
            </x-button>

            <x-button variant="outline" size="hero" href="#features">
                Explore Articles
            </x-button>
        </div>

        <div class="relative mt-lg max-w-6xl mx-auto mt-5">
            <div
                class="absolute -inset-4 bg-gradient-to-b from-primary/10 to-transparent rounded-[40px] blur-3xl -z-10">
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-ss-base border border-outline-variant/10">
                <img alt="SaaS Blog Dashboard Mockup" class="rounded-xl w-full shadow-inner" {{--
                    src="{{ asset('assets/blog-dashboard.png') }}" --}}
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD1uLm6G84Z9yKv34oqph4P7Rtsn9P_63jDmde9Ba-p4eQQEDWCUyUxoDWy3SJrmVayX7ZMNeDGbDgxFUcv5QP2T2F2qyvT-ITJCkFxY8MNI35C8aZly1YD_5YQRuQSLW156D5nYT4Xoixq8Geu8smIEdOdDV8Zv293lEz95nWPlzkyFJy6uVrmIaiWi8rMpHD1YGsJFmPBMEHIdbut8veQZXaR03d6Aq1SyiJAJa0jPag07ysUNb8i9JkuZ6-HdxAT0M4zs2A4cM8">

            </div>

            <div
                class="absolute -bottom-10 -right-4 md:-right-10 bg-white p-6 rounded-2xl shadow-2xl border border-outline-variant/20 max-w-[280px] hidden sm:block text-left backdrop-blur-sm bg-white/95">
                <div class="flex items-center gap-sm mb-3">
                    <div class="w-10 h-10 bg-primary-container rounded-full flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">psychology</span>
                    </div>
                    <span class="text-sm text-on-surface font-bold leading-tight">AI Blogging Co-pilot</span>
                </div>

                <p class="text-xs text-on-surface-variant leading-relaxed mb-ss-base">
                    "I've analyzed your draft. Adding these 3 keywords will improve your SEO ranking by 25%."
                </p>

                <div class="flex flex-wrap gap-2">
                    <span
                        class="px-2.5 py-1 bg-surface-container text-on-surface-variant rounded-full text-[10px] font-bold uppercase tracking-wider">SEO
                        Optimized</span>
                    <span
                        class="px-2.5 py-1 bg-surface-container text-on-surface-variant rounded-full text-[10px] font-bold uppercase tracking-wider">Grammar
                        Check</span>
                </div>
            </div>
        </div>
    </div>
</section>