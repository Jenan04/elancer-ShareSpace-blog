<x-layouts.app>
    <x-slot:title>{{ $post->title }} - ShareSpace</x-slot>

    <x-navbar />

    <article class="min-h-screen bg-surface pt-32 pb-24 px-6 md:px-12 max-w-4xl mx-auto font-sans relative z-10">
        <a href="{{ route('feed') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:text-primary/80 transition-colors mb-8 group">
            <span class="material-symbols-outlined text-sm group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
            Back to Feed
        </a>

        <div class="flex items-center flex-wrap gap-3 mb-6">
            @if($post->category)
                <span class="text-xs font-semibold px-3 py-1.5 bg-primary/10 text-primary border border-primary/20 rounded-full">
                    {{ $post->category->name }}
                </span>
            @endif
            <div class="flex items-center gap-2 text-xs text-on-surface-variant/60">
                <span>Published on {{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
                <span>•</span>
                <span>{{ $post->read_time ?? 1 }} min read</span>
                <span>•</span>
                <span class="flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-xs">visibility</span>
                    {{ number_format($post->views_count) }} views
                </span>
            </div>
        </div>

        <h1 class="text-3xl md:text-5xl font-bold text-on-surface tracking-tight leading-tight mb-8">
            {{ $post->title }}
        </h1>

        <div class="flex items-center justify-between border-y border-outline-variant/20 py-6 mb-10">
            <a href="{{ route('profile.show', $post->user->username ?? 'deleted') }}" class="flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-base uppercase shadow-sm">
                    {{ substr($post->user->name ?? $post->user->email, 0, 2) }}
                </div>
                <div>
                    <h4 class="font-bold text-on-surface group-hover:text-primary transition-colors duration-200">
                        {{ $post->user->name ?? explode('@', $post->user->email)[0] }}
                    </h4>
                    <p class="text-xs text-on-surface-variant/60">
                        @ {{ $post->user->username ?? 'author' }}
                    </p>
                </div>
            </a>

            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Article URL copied to clipboard!');" 
                    class="flex items-center gap-1.5 px-4 py-2 border border-outline-variant/30 hover:border-primary/30 rounded-xl text-xs font-semibold text-on-surface-variant hover:text-primary transition-all duration-300 bg-white">
                <span class="material-symbols-outlined text-xs">share</span>
                Share Link
            </button>
        </div>

        @if($post->image_path)
            <div class="aspect-video w-full rounded-3xl overflow-hidden border border-outline-variant/20 mb-12 shadow-sm">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image_path) }}" 
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover" />
            </div>
        @endif

        <div class="prose max-w-none text-on-surface text-base md:text-lg leading-relaxed font-serif space-y-6">
            {!! nl2br(e($post->content)) !!}
        </div>

        @if($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-outline-variant/10">
                @foreach($post->tags as $tag)
                    <span class="text-xs bg-surface-container hover:bg-surface-container-high px-3.5 py-1.5 rounded-full text-on-surface-variant font-medium transition-colors">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <div class="mt-16 bg-surface-container-low rounded-3xl p-8 border border-outline-variant/20 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="font-bold text-on-surface text-lg mb-1">Was this article helpful?</h3>
                <p class="text-xs text-on-surface-variant/70">React below to share your appreciation with the author.</p>
            </div>

            <div class="flex items-center gap-3" data-post-id="{{ $post->id }}">
                @php
                    $likeCount = $post->reactions->where('type', 'like')->count();
                    $loveCount = $post->reactions->where('type', 'love')->count();
                @endphp
                
                <button onclick="reactToPost('{{ $post->id }}', 'like')" 
                        class="react-btn flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold border transition-all duration-300 {{ in_array('like', $userReactions) ? 'bg-red-50 text-red-600 border-red-200 shadow-sm' : 'bg-white hover:bg-surface-container-high border-outline-variant/20 text-on-surface-variant' }}"
                        data-type="like">
                    <span class="material-symbols-outlined text-base {{ in_array('like', $userReactions) ? 'fill-1 text-red-600' : '' }}" style="font-variation-settings: 'FILL' {{ in_array('like', $userReactions) ? 1 : 0 }}">favorite</span>
                    <span>Like</span>
                    <span class="count bg-black/5 px-2 py-0.5 rounded-full text-xs">{{ $likeCount }}</span>
                </button>

                <button onclick="reactToPost('{{ $post->id }}', 'love')" 
                        class="react-btn flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold border transition-all duration-300 {{ in_array('love', $userReactions) ? 'bg-pink-50 text-pink-600 border-pink-200 shadow-sm' : 'bg-white hover:bg-surface-container-high border-outline-variant/20 text-on-surface-variant' }}"
                        data-type="love">
                    <span class="material-symbols-outlined text-base {{ in_array('love', $userReactions) ? 'fill-1 text-pink-600' : '' }}" style="font-variation-settings: 'FILL' {{ in_array('love', $userReactions) ? 1 : 0 }}">favorite_special</span>
                    <span>Love</span>
                    <span class="count bg-black/5 px-2 py-0.5 rounded-full text-xs">{{ $loveCount }}</span>
                </button>
            </div>
        </div>
    </article>

    <script>
        function reactToPost(postId, type) {
            @guest
                window.location.href = "{{ route('signin') }}";
                return;
            @endguest

            const button = document.querySelector(`[data-post-id="${postId}"] [data-type="${type}"]`);
            if (!button) return;

            button.classList.add('scale-95');
            setTimeout(() => button.classList.remove('scale-95'), 150);

            fetch(`/posts/${postId}/react`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = "{{ route('signin') }}";
                    throw new Error('Unauthenticated');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const container = document.querySelector(`[data-post-id="${postId}"]`);
                    
                    ['like', 'love'].forEach(t => {
                        const btn = container.querySelector(`[data-type="${t}"]`);
                        const countSpan = btn.querySelector('.count');
                        const iconSpan = btn.querySelector('.material-symbols-outlined');
                        const countVal = data.stats[t] || 0;
                        countSpan.textContent = countVal;

                        const isReacted = data.user_reactions.includes(t);
                        if (isReacted) {
                            if (t === 'like') {
                                btn.className = "react-btn flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold border transition-all duration-300 bg-red-50 text-red-600 border-red-200 shadow-sm";
                            } else {
                                btn.className = "react-btn flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold border transition-all duration-300 bg-pink-50 text-pink-600 border-pink-200 shadow-sm";
                            }
                            iconSpan.style.fontVariationSettings = "'FILL' 1";
                        } else {
                            btn.className = "react-btn flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold border transition-all duration-300 bg-white hover:bg-surface-container-high border-outline-variant/20 text-on-surface-variant";
                            iconSpan.style.fontVariationSettings = "'FILL' 0";
                        }
                    });
                }
            })
            .catch(error => console.error('Error toggling reaction:', error));
        }
    </script>
</x-layouts.app>
