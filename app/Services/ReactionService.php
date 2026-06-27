<?php

namespace App\Services;

use App\Models\Reaction;
use App\Models\Post;

class ReactionService
{
    public function toggleReaction(string $userId, string $postId, string $type): array
    {
        $existing = Reaction::where('user_id', $userId)
            ->where('post_id', $postId)
            ->where('type', $type)
            ->first();

        if ($existing) {
            $existing->delete();
            $reacted = false;
        } else {
            Reaction::create([
                'user_id' => $userId,
                'post_id' => $postId,
                'type' => $type,
            ]);
            $reacted = true;
        }

        $stats = Reaction::where('post_id', $postId)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $totalCount = Reaction::where('post_id', $postId)->count();

        $userReactions = Reaction::where('user_id', $userId)
            ->where('post_id', $postId)
            ->pluck('type')
            ->toArray();

        return [
            'success' => true,
            'reacted' => $reacted,
            'type' => $type,
            'stats' => $stats,
            'total_count' => $totalCount,
            'user_reactions' => $userReactions,
        ];
    }
}
