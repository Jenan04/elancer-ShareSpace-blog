<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\ReactionService;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    protected $postService;
    protected $reactionService;

    public function __construct(PostService $postService, ReactionService $reactionService)
    {
        $this->postService = $postService;
        $this->reactionService = $reactionService;
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'latest');
        $posts = $tab === 'trendy'
            ? $this->postService->getTrendyFeed(10)
            : $this->postService->getLatestFeed(10);

        return view('feed.index', compact('posts', 'tab'));
    }

    public function react(Request $request, string $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please sign in to react to posts.'
            ], 401);
        }

        $type = $request->input('type', 'like');
        $result = $this->reactionService->toggleReaction(auth()->id(), $id, $type);

        return response()->json($result);
    }
}
