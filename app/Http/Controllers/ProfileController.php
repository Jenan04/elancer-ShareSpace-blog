<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        // Cached profile counters (Total Posts, Total Views)
        $counters = Cache::remember("profile:{$user->id}:counters", 600, function () use ($user) {
            return [
                'posts_count' => $user->posts()->where('status', 'published')->count(),
                'views_count' => (int) $user->posts()->where('status', 'published')->sum('views_count'),
            ];
        });

        // Post archive fetched as an independent paginated sub-query
        $userPosts = $user->posts()
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->latest()
            ->cursorPaginate(10);

        return view('profile.show', compact('user', 'counters', 'userPosts'));
    }
}
