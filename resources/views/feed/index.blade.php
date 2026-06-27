<x-layouts.app>
    <x-slot:title>Feed - ShareSpace</x-slot>

    <x-navbar />

    <div class="min-h-screen bg-[#f3f2ef] pt-24 pb-12 px-4 font-sans mt-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
            
            <aside class="col-span-1 lg:col-span-3 sticky top-24 hidden lg:block">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                  <div class="h-16 bg-gradient-to-r from-[#264D09] to-[#E0E0C8]"></div>
                    <div class="p-4 text-center -mt-10 border-b border-gray-100 pb-4">
                        <div class="w-16 h-16 rounded-full bg-slate-200 border-2 border-white mx-auto flex items-center justify-center font-bold text-slate-700 text-lg uppercase shadow-sm">
                            @auth
                                {{ substr(auth()->user()->name ?? auth()->user()->email, 0, 2) }}
                            @else
                                SS
                            @endauth
                        </div>
                        <h3 class="font-semibold text-gray-900 text-base mt-3 leading-snug">
                            @auth {{ auth()->user()->name }} @else Welcome, Guest! @endauth
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            @auth {{ '@' . auth()->user()->username }} @else Sign in to contribute @endauth
                        </p>
                    </div>

                    <!-- <div class="p-3 text-xs text-gray-500 space-y-2">
                        <div class="flex justify-between items-center px-2 py-1 hover:bg-gray-50 rounded cursor-pointer">
                            <span>Search appearances</span>
                            <span class="font-semibold text-blue-600">42</span>
                        </div>
                        <div class="flex justify-between items-center px-2 py-1 hover:bg-gray-50 rounded cursor-pointer">
                            <span>Post impressions</span>
                            <span class="font-semibold text-blue-600">1.2k</span>
                        </div>
                    </div> -->
                </div>
            </aside>

            <main class="col-span-1 lg:col-span-6 space-y-3">
                
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-lg font-bold text-gray-900 tracking-tight">Explore Stories</h1>
                        <p class="text-xs text-gray-500">Discover deep tech insights and engineering essays.</p>
                    </div>
                    
                    <div class="flex bg-gray-100 p-1 rounded-lg border border-gray-200 self-start sm:self-auto">
                        <a href="{{ route('feed', ['tab' => 'latest']) }}" 
                           class="px-4 py-1.5 rounded-md text-xs font-semibold transition-all {{ $tab === 'latest' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                            Latest
                        </a>
                        <a href="{{ route('feed', ['tab' => 'trendy']) }}" 
                           class="px-4 py-1.5 rounded-md text-xs font-semibold transition-all {{ $tab === 'trendy' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                            Trending
                        </a>
                    </div>
                </div>

                @if($posts->isEmpty())
                    <div class="bg-white p-12 rounded-xl border border-gray-200 text-center shadow-sm">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">article</span>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">No articles found</h3>
                        <p class="text-xs text-gray-500 max-w-xs mx-auto mb-4">Be the first to share your knowledge with the community!</p>
                        <a href="{{ route('posts.create') }}" class="inline-flex justify-center items-center px-4 py-2 border border-blue-600 rounded-full text-xs font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
                            Publish an Article
                        </a>
                    </div>
                @else
                    @foreach($posts as $post)
                        <article class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-200">
                            
                            <div class="p-4 flex items-start justify-between">
                                <a href="{{ route('profile.show', $post->user->username ?? 'deleted') }}" class="flex items-center gap-3 group">
                                    <div class="w-11 h-11 rounded-full bg-slate-100 border border-gray-100 flex items-center justify-center font-bold text-slate-700 text-xs uppercase flex-shrink-0">
                                        {{ substr($post->user->name ?? $post->user->email, 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-xs leading-snug group-hover:text-blue-600 group-hover:underline transition-all">
                                            {{ $post->user->name ?? explode('@', $post->user->email)[0] }}
                                        </h4>
                                        <p class="text-[11px] text-gray-500 leading-none mt-0.5">@ {{ $post->user->username ?? 'author' }}</p>
                                        <p class="text-[10px] text-gray-400 flex items-center gap-1 mt-1">
                                            <span>{{ $post->published_at ? $post->published_at->diffForHumans() : $post->created_at->diffForHumans() }}</span>
                                            <span>•</span>
                                            <span class="material-symbols-outlined text-[11px]">public</span>
                                        </p>
                                    </div>
                                </a>

                                @if($post->category)
                                    <span class="text-[10px] font-medium px-2.5 py-1 bg-slate-50 text-slate-600 rounded-full border border-gray-200">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="px-4 pb-3">
                                <a href="{{ route('posts.show', $post->slug) }}" class="block group">
                                    <h2 class="font-semibold text-gray-900 text-sm mb-1 group-hover:text-blue-600 transition-colors">
                                        {{ $post->title }}
                                    </h2>
                                    <p class="text-gray-600 text-xs leading-relaxed line-clamp-3">
                                        {{ strip_tags($post->content) }}
                                    </p>
                                </a>

                                @if($post->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($post->tags->take(3) as $tag)
                                            <span class="text-[11px] text-blue-600 font-medium hover:underline cursor-pointer">
                                                #{{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if($post->image_path)
                                <a href="{{ route('posts.show', $post->slug) }}" class="block border-y border-gray-100 bg-slate-50 max-h-80 overflow-hidden">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image_path) }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover max-h-80 transition-transform duration-300 hover:scale-[1.01]" 
                                         loading="lazy" />
                                </a>
                            @endif

                            <div class="px-4 py-2 flex items-center justify-between text-[11px] text-gray-500 border-b border-gray-100">
                                <div class="flex items-center gap-1">
                                    <div class="flex -space-x-1">
                                        <span class="w-3.5 h-3.5 rounded-full bg-blue-500 flex items-center justify-center text-[8px] text-white">👍</span>
                                        <span class="w-3.5 h-3.5 rounded-full bg-pink-500 flex items-center justify-center text-[8px] text-white">❤️</span>
                                    </div>
                                    <span class="hover:underline cursor-pointer">
                                        {{ number_format($post->reactions->count()) }} reactions
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span>{{ number_format($post->views_count) }} views</span>
                                    <span>•</span>
                                    <span>{{ $post->read_time ?? 1 }} min read</span>
                                </div>
                            </div>

                            <div class="px-2 py-0.5 flex items-center justify-between gap-1" data-post-id="{{ $post->id }}">
                                @php
                                    $userReactions = auth()->check() 
                                        ? $post->reactions->where('user_id', auth()->id())->pluck('type')->toArray() 
                                        : [];
                                    $isLiked = in_array('like', $userReactions);
                                    $isLoved = in_array('love', $userReactions);
                                @endphp

                                <!-- <button onclick="reactToPost('{{ $post->id }}', 'like')" 
                                        class="react-btn flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors duration-150 {{ $isLiked ? 'text-blue-600' : '' }}"
                                        data-type="like">
                                    <span class="material-symbols-outlined text-lg {{ $isLiked ? 'fill-1 text-blue-600' : '' }}" style="font-variation-settings: 'FILL' {{ $isLiked ? 1 : 0 }}">thumb_up</span>
                                    <span>Like</span>
                                </button> -->

                                <button onclick="reactToPost('{{ $post->id }}', 'love')" 
                                        class="react-btn flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors duration-150 {{ $isLoved ? 'text-pink-600' : '' }}"
                                        data-type="love">
                                    <span class="material-symbols-outlined text-lg {{ $isLoved ? 'fill-1 text-pink-600' : '' }}" style="font-variation-settings: 'FILL' {{ $isLoved ? 1 : 0 }}">favorite</span>
                                    <span>Love</span>
                                </button>

                                <button onclick="navigator.clipboard.writeText('{{ route('posts.show', $post->slug) }}'); alert('Link copied!');" 
                                        class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                                    <span class="material-symbols-outlined text-lg">share</span>
                                    <span>Share</span>
                                </button>
                            </div>

                        </article>
                    @endforeach

                    <div class="pt-4">
                        {{ $posts->links() }}
                    </div>
                @endif
            </main>

            <aside class="col-span-1 lg:col-span-3 sticky top-24 hidden lg:block">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                    <h3 class="font-semibold text-gray-900 text-sm mb-3 flex items-center justify-between">
                        <span>Trending News</span>
                        <span class="material-symbols-outlined text-base text-gray-400">info</span>
                    </h3>
                    
                    <ul class="space-y-3">
                        <li class="group cursor-pointer">
                            <h4 class="text-xs font-medium text-gray-800 group-hover:text-blue-600 group-hover:underline line-clamp-1">The evolution of Laravel 11 architecture</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">2d ago • 1,420 readers</p>
                        </li>
                        <li class="group cursor-pointer">
                            <h4 class="text-xs font-medium text-gray-800 group-hover:text-blue-600 group-hover:underline line-clamp-1">Why Tailwind CSS remains unbeatable</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">1w ago • 932 readers</p>
                        </li>
                        <li class="group cursor-pointer">
                            <h4 class="text-xs font-medium text-gray-800 group-hover:text-blue-600 group-hover:underline line-clamp-1">Remote work trends in 2026</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">3d ago • 540 readers</p>
                        </li>
                    </ul>

                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <p class="text-[10px] text-gray-400 text-center">ShareSpace Corporation © 2026</p>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <script>
        function reactToPost(postId, type) {
            @guest
                window.location.href = "{{ route('signin') }}";
                return;
            @endguest

            fetch(`/posts/${postId}/react`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container = document.querySelector(`[data-post-id="${postId}"]`);
                    
                    ['like', 'love'].forEach(t => {
                        const btn = container.querySelector(`[data-type="${t}"]`);
                        const iconSpan = btn.querySelector('.material-symbols-outlined');
                        const isReacted = data.user_reactions.includes(t);
                        
                        if (isReacted) {
                            if (t === 'like') {
                                btn.className = "react-btn flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold text-blue-600 hover:bg-gray-100 transition-colors duration-150";
                                iconSpan.style.fontVariationSettings = "'FILL' 1";
                            } else {
                                btn.className = "react-btn flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold text-pink-600 hover:bg-gray-100 transition-colors duration-150";
                                iconSpan.style.fontVariationSettings = "'FILL' 1";
                            }
                        } else {
                            btn.className = "react-btn flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors duration-150";
                            iconSpan.style.fontVariationSettings = "'FILL' 0";
                        }
                    });
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</x-layouts.app>