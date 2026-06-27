<x-layouts.app>
    <x-slot:title>{{ $user->name ?? explode('@', $user->email)[0] }}'s Space - ShareSpace</x-slot>

    <x-navbar />

    <main class="min-h-screen bg-surface pt-32 pb-24 px-6 md:px-12 max-w-7xl mx-auto font-sans relative z-10">
        <div class="bg-white rounded-3xl p-8 md:p-12 border border-outline-variant/20 shadow-sm mb-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-3xl uppercase shadow-inner border border-primary/20">
                        {{ substr($user->name ?? $user->email, 0, 2) }}
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-on-surface tracking-tight">
                            {{ $user->name ?? explode('@', $user->email)[0] }}
                        </h1>
                        <p class="text-sm text-on-surface-variant/70 mt-1">
                            @ {{ $user->username }}
                        </p>
                        <p class="text-xs text-on-surface-variant/50 mt-1">
                            Member since {{ $user->created_at->format('F Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="bg-surface-container-low border border-outline-variant/10 rounded-2xl px-6 py-4 text-center min-w-[120px] transition-all hover:shadow-md">
                        <span class="block text-2xl font-bold text-primary">{{ number_format($counters['posts_count']) }}</span>
                        <span class="text-xs font-semibold text-on-surface-variant/80 uppercase tracking-wide">Total Posts</span>
                    </div>
                    <div class="bg-surface-container-low border border-outline-variant/10 rounded-2xl px-6 py-4 text-center min-w-[120px] transition-all hover:shadow-md">
                        <span class="block text-2xl font-bold text-primary">{{ number_format($counters['views_count']) }}</span>
                        <span class="text-xs font-semibold text-on-surface-variant/80 uppercase tracking-wide">Total Views</span>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-on-surface mb-8 border-b border-outline-variant/10 pb-4">
            Published Articles
        </h2>

        @if($userPosts->isEmpty())
            <div class="text-center py-16 bg-surface-container-low rounded-3xl border border-outline-variant/10">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-3">
                    history_edu
                </span>
                <h3 class="text-lg font-semibold text-on-surface mb-1">No articles published yet</h3>
                <p class="text-on-surface-variant/70 text-sm max-w-sm mx-auto">
                    This author hasn't shared any posts on ShareSpace yet.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($userPosts as $post)
                    <article class="group bg-surface-container-lowest rounded-3xl overflow-hidden border border-outline-variant/20 hover:border-primary/30 transition-all duration-400 hover:shadow-lg flex flex-col hover:-translate-y-0.5">
                        <div class="flex flex-col sm:flex-row h-full">
                            <a href="{{ route('posts.show', $post->slug) }}" class="block sm:w-1/3 aspect-video sm:aspect-auto overflow-hidden bg-surface-container relative">
                                @if($post->image_path)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image_path) }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-primary/5 via-tertiary/5 to-accent-purple/5 flex items-center justify-center p-4 text-center group-hover:scale-105 transition-transform duration-500">
                                        <span class="text-sm font-bold text-primary/60 line-clamp-2">
                                            {{ $post->title }}
                                        </span>
                                    </div>
                                @endif
                            </a>

                            <div class="p-6 sm:w-2/3 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 text-xs text-on-surface-variant/60 mb-2">
                                        @if($post->category)
                                            <span class="font-bold text-primary">{{ $post->category->name }}</span>
                                            <span>•</span>
                                        @endif
                                        <span>{{ $post->read_time }} min read</span>
                                        <span>•</span>
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[10px]">visibility</span>
                                            {{ number_format($post->views_count) }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors duration-300 line-clamp-2 mb-2">
                                        <a href="{{ route('posts.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    <p class="text-on-surface-variant/80 text-xs leading-relaxed line-clamp-2 mb-4">
                                        {{ Str::limit(strip_tags($post->content), 80) }}
                                    </p>
                                </div>

                                @if($post->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mt-auto">
                                        @foreach($post->tags->take(2) as $tag)
                                            <span class="text-[10px] bg-surface-container px-2 py-0.5 rounded text-on-surface-variant/70">
                                                #{{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $userPosts->links() }}
            </div>
        @endif
    </main>
</x-layouts.app>
