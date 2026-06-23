<x-layouts.app>
    <x-slot:title>Explore ShareSpace - Latest & Trending Articles</x-slot>

    <x-navbar />

    <main class="min-h-screen bg-surface pt-32 pb-24 px-6 md:px-12 max-w-7xl mx-auto font-sans relative z-10">        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-outline-variant/20 pb-8 mb-12">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-on-surface tracking-tight mb-3">
                    Explore Stories
                </h1>
                <p class="text-on-surface-variant/80 text-lg max-w-2xl">
                    Discover deep insights, engineering essays, and stories from developers around the world.
                </p>
            </div>
                        <div class="flex bg-surface-container-high p-1 rounded-full border border-outline-variant/20 mt-6 md:mt-0 self-start">
                <a href="{{ route('feed', ['tab' => 'latest']) }}" 
                   class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $tab === 'latest' ? 'bg-primary text-white shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Latest
                </a>
                <a href="{{ route('feed', ['tab' => 'trendy']) }}" 
                   class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $tab === 'trendy' ? 'bg-primary text-white shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Trending
                </a>
            </div>
        </div>
        @if($posts->isEmpty())
            <div class="text-center py-20 bg-surface-container-low rounded-3xl border border-outline-variant/10">
                <span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-4">
                    article
                </span>
                <h3 class="text-xl font-semibold text-on-surface mb-2">No articles found</h3>
                <p class="text-on-surface-variant/70 max-w-md mx-auto mb-6">
                    Be the first to share your knowledge with the community!
                </p>
                <x-button variant="primary" href="{{ route('posts.create') }}">
                    Publish an Article
                </x-button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="group bg-surface-container-lowest rounded-3xl overflow-hidden border border-outline-variant/20 hover:border-primary/30 transition-all duration-400 hover:shadow-xl flex flex-col h-full hover:-translate-y-1">                        <a href="{{ route('posts.show', $post->slug) }}" class="block relative aspect-video overflow-hidden bg-surface-container">
                            @if($post->image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image_path) }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy" />
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-primary/10 via-tertiary/10 to-accent-purple/10 flex items-center justify-center p-6 text-center group-hover:scale-105 transition-transform duration-500">
                                    <span class="text-2xl font-bold tracking-tight text-primary/70 line-clamp-2">
                                        {{ $post->title }}
                                    </span>
                                </div>
                            @endif
                            
                            @if($post->category)
                                <span class="absolute top-4 left-4 text-xs font-semibold px-3 py-1.5 bg-white/90 backdrop-blur-sm text-primary rounded-full shadow-sm">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col flex-grow">                            <div class="flex items-center gap-2 text-xs text-on-surface-variant/60 mb-3">
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                <span>•</span>
                                <span>{{ $post->read_time ?? 1 }} min read</span>
                                <span>•</span>
                                <span class="flex items-center gap-0.5">
                                    <span class="material-symbols-outlined text-xs">visibility</span>
                                    {{ number_format($post->views_count) }}
                                </span>
                            </div>
                            <h2 class="text-xl font-bold text-on-surface group-hover:text-primary transition-colors duration-300 mb-3 line-clamp-2">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-on-surface-variant/80 text-sm leading-relaxed mb-6 line-clamp-3">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            @if($post->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach($post->tags->take(3) as $tag)
                                        <span class="text-xs bg-surface-container px-2.5 py-1 rounded-md text-on-surface-variant/80">
                                            #{{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-auto pt-6 border-t border-outline-variant/10 flex items-center justify-between">                                <a href="{{ route('profile.show', $post->user->username ?? 'deleted') }}" 
                                   class="flex items-center gap-3 group/author">
                                    <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr($post->user->name ?? $post->user->email, 0, 2) }}
                                    </div>
                                    <span class="text-sm font-semibold text-on-surface group-hover/author:text-primary transition-colors duration-200">
                                        {{ $post->user->name ?? explode('@', $post->user->email)[0] }}
                                    </span>
                                </a>
                                <div class="flex items-center gap-2" data-post-id="{{ $post->id }}">
                                    @php
                                        $userReactions = auth()->check() 
                                            ? $post->reactions->where('user_id', auth()->id())->pluck('type')->toArray() 
                                            : [];
                                        
                                        $likeCount = $post->reactions->where('type', 'like')->count();
                                        $loveCount = $post->reactions->where('type', 'love')->count();
                                    @endphp
                                                                        <button onclick="reactToPost('{{ $post->id }}', 'like')" 
                                            class="react-btn flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 {{ in_array('like', $userReactions) ? 'bg-red-50 text-red-600 border-red-200' : 'bg-surface hover:bg-surface-container-high border-outline-variant/20 text-on-surface-variant' }}"
                                            data-type="like">
                                        <span class="material-symbols-outlined text-sm {{ in_array('like', $userReactions) ? 'fill-1 text-red-600' : '' }}" style="font-variation-settings: 'FILL' {{ in_array('like', $userReactions) ? 1 : 0 }}">favorite</span>
                                        <span class="count">{{ $likeCount }}</span>
                                    </button>
                                    <button onclick="reactToPost('{{ $post->id }}', 'love')" 
                                            class="react-btn flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 {{ in_array('love', $userReactions) ? 'bg-pink-50 text-pink-600 border-pink-200' : 'bg-surface hover:bg-surface-container-high border-outline-variant/20 text-on-surface-variant' }}"
                                            data-type="love">
                                        <span class="material-symbols-outlined text-sm {{ in_array('love', $userReactions) ? 'fill-1 text-pink-600' : '' }}" style="font-variation-settings: 'FILL' {{ in_array('love', $userReactions) ? 1 : 0 }}">favorite_special</span>
                                        <span class="count">{{ $loveCount }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    </main>

    <script>
        function reactToPost(postId, type) {
            @guest
                window.location.href = "{{ route('signin') }}";
                return;
            @endguest

            const button = document.querySelector(`[data-post-id="${postId}"] [data-type="${type}"]`);
            if (!button) return;

            button.classList.add('scale-90');
            setTimeout(() => button.classList.remove('scale-90'), 150);

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
                                btn.className = "react-btn flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 bg-red-50 text-red-600 border-red-200";
                            } else {
                                btn.className = "react-btn flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 bg-pink-50 text-pink-600 border-pink-200";
                            }
                            iconSpan.style.fontVariationSettings = "'FILL' 1";
                        } else {
                            btn.className = "react-btn flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 bg-surface hover:bg-surface-container-high border-outline-variant/20 text-on-surface-variant";
                            iconSpan.style.fontVariationSettings = "'FILL' 0";
                        }
                    });
                }
            })
            .catch(error => console.error('Error toggling reaction:', error));
        }
    </script>
</x-layouts.app>
