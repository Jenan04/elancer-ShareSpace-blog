<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostView;
use App\Models\Blog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function getLatestFeed(int $perPage = 10)
    {
        return Post::where('status', 'published')
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->cursorPaginate($perPage);
    }

    public function getTrendyFeed(int $perPage = 10)
    {
        // 1. Query post_views where created_at >= now()->subDays(3)
        // 2. Group by post_id, order by count DESC, pluck top IDs
        $trendyPostIds = PostView::where('created_at', '>=', now()->subDays(3))
            ->groupBy('post_id')
            ->orderByRaw('COUNT(*) DESC')
            ->pluck('post_id')
            ->toArray();

        $query = Post::where('status', 'published')
            ->with(['user', 'category', 'tags']);

        if (!empty($trendyPostIds)) {
            $query->whereIn('id', $trendyPostIds);

            // Preserving popularity order using database-agnostic CASE WHEN ordering
            $caseStatements = [];
            foreach ($trendyPostIds as $index => $id) {
                $caseStatements[] = "WHEN id = '{$id}' THEN {$index}";
            }
            $orderByCase = 'CASE ' . implode(' ', $caseStatements) . ' ELSE ' . count($trendyPostIds) . ' END';
            $query->orderByRaw($orderByCase);
        } else {
            // Fallback: order by all-time views count if there are no rolling views
            $query->orderBy('views_count', 'desc');
        }

        return $query->cursorPaginate($perPage);
    }

    public function store(array $requestData, User $user): Post
    {
        // 1. File Storage: Image upload if present
        $imagePath = null;
        if (isset($requestData['cover_image']) && $requestData['cover_image']->isValid()) {
            $file = $requestData['cover_image'];
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;
            // Store at storage/app/public/posts/
            $imagePath = $file->storeAs('posts', $filename, 'public');
        }

        // 2. Automated Read-Time Calculation (200 words/minute)
        $wordCount = str_word_count(strip_tags($requestData['content'] ?? ''));
        $readTime = (int) ceil($wordCount / 200);
        if ($readTime < 1) {
            $readTime = 1;
        }

        // 3. Database Insertion: Resolve/Create user blog first
        $blog = $user->blogs()->first();
        if (!$blog) {
            $blogName = $user->name ? $user->name . "'s Space" : "My Space";
            $blog = Blog::create([
                'user_id' => $user->id,
                'name' => $blogName,
                'slug' => Str::slug($blogName) . '-' . Str::random(4),
                'description' => 'A knowledge space on ShareSpace.',
            ]);
        }

        // Create unique slug for post
        $baseSlug = Str::slug($requestData['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Post::where('blog_id', $blog->id)->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $post = Post::create([
            'blog_id' => $blog->id,
            'user_id' => $user->id,
            'category_id' => $requestData['category_id'] ?? null,
            'title' => $requestData['title'],
            'slug' => $slug,
            'content' => $requestData['content'] ?? '',
            'image_path' => $imagePath,
            'cover_image_url' => $imagePath ? Storage::url($imagePath) : null,
            'read_time' => $readTime,
            'status' => $requestData['status'] ?? 'published',
            'views_count' => 0,
            'published_at' => ($requestData['status'] ?? 'published') === 'published' ? now() : null,
        ]);

        // 4. Tag Mapping Sync
        if (!empty($requestData['tags'])) {
            $tagIds = [];
            // Tags can be input as tag names (strings) or UUIDs
            foreach ($requestData['tags'] as $tagInput) {
                if (empty(trim($tagInput))) continue;
                
                $tag = Tag::where('id', $tagInput)->first() 
                       ?? Tag::where('name', $tagInput)->first();
                       
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $tagInput,
                        'slug' => Str::slug($tagInput),
                    ]);
                }
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return $post;
    }
}
