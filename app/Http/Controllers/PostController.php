<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use App\Services\PostService;
use App\Services\LLMService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $llmService;

    public function __construct(PostService $postService, LLMService $llmService)
    {
        $this->postService = $postService;
        $this->llmService = $llmService;
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(CreatePostRequest $request)
    {
        $post = $this->postService->store($request->validated(), auth()->user());
        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Article published successfully!');
    }

    public function show(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['user', 'category', 'tags'])
            ->firstOrFail();

        // Prevent refresh-inflated views
        $identifier = auth()->check() ? (string) auth()->id() : $request->ip();

        $recentView = PostView::where('post_id', $post->id)
            ->where('ip_address', $identifier)
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        if (!$recentView) {
            PostView::create([
                'post_id' => $post->id,
                'ip_address' => $identifier,
                'created_at' => now(),
            ]);

            $post->increment('views_count');
        }

        $totalReactions = $post->reactions()->count();
        $userReactions = auth()->check()
            ? $post->reactions()->where('user_id', auth()->id())->pluck('type')->toArray()
            : [];

        return view('posts.show', compact('post', 'totalReactions', 'userReactions'));
    }

    public function suggestTags(Request $request)
    {
        $content = $request->input('content', '');

        if (empty(trim($content))) {
            return response()->json([]);
        }

        $tags = $this->llmService->suggestTags($content);
        return response()->json($tags);
    }
}
