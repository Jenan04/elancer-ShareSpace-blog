<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Reaction;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $adminRole = Role::create([
            'name' => 'Admin',
            'abilities' => ['manage_users', 'manage_roles', 'delete_any_post']
        ]);

        $authorRole = Role::create([
            'name' => 'Author',
            'abilities' => ['create_post', 'edit_own_post', 'delete_own_post']
        ]);

        $userRole = Role::create([
            'name' => 'User',
            'abilities' => ['view_posts', 'add_reaction']
        ]);
        // 1. Create categories
        $categories = [
            Category::create(['name' => 'Technology', 'slug' => 'technology']),
            Category::create(['name' => 'Design', 'slug' => 'design']),
            Category::create(['name' => 'Software Engineering', 'slug' => 'software-engineering']),
            Category::create(['name' => 'Productivity', 'slug' => 'productivity']),
            Category::create(['name' => 'Career', 'slug' => 'career']),
        ];

        // 2. Create tags
        $tags = [
            Tag::create(['name' => 'Laravel', 'slug' => 'laravel']),
            Tag::create(['name' => 'PHP', 'slug' => 'php']),
            Tag::create(['name' => 'JavaScript', 'slug' => 'javascript']),
            Tag::create(['name' => 'Vue.js', 'slug' => 'vue-js']),
            Tag::create(['name' => 'TailwindCSS', 'slug' => 'tailwindcss']),
            Tag::create(['name' => 'AI', 'slug' => 'ai']),
            Tag::create(['name' => 'SaaS', 'slug' => 'saas']),
        ];

        // 3. Create authors and blogs
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
        ]);
        $user1->roles()->sync([$authorRole->id, $userRole->id]);

        $blog1 = Blog::create([
            'user_id' => $user1->id,
            'name' => "John's Dev Corner",
            'slug' => 'johns-dev-corner',
            'description' => 'A blog about software, tools, and SaaS.',
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'username' => 'janesmith',
        ]);
        $user2->roles()->sync([$userRole->id]);
        
        $blog2 = Blog::create([
            'user_id' => $user2->id,
            'name' => 'Design & Craft',
            'slug' => 'design-and-craft',
            'description' => 'Exploring modern aesthetics, typography, and user experience.',
        ]);

        // 4. Create sample posts
        $post1 = Post::create([
            'blog_id' => $blog1->id,
            'user_id' => $user1->id,
            'category_id' => $categories[2]->id, // Software Engineering
            'title' => 'Mastering Laravel and TailwindCSS in 2026',
            'slug' => 'mastering-laravel-and-tailwindcss-in-2026',
            'content' => "Laravel remains the premier PHP framework for rapid backend development, and paired with TailwindCSS v4, it makes writing UI components faster than ever. In this article, we explore the new Vite bundling pipeline, the advantages of utility-first CSS styling, and how to structure service-layer patterns for larger teams.\n\nFirst, configure your routing and controllers. Next, decouple complex queries from controllers by abstracting them to database-agnostic services. This clean division of responsibility guarantees robust, testable logic.",
            'read_time' => 3,
            'views_count' => 150,
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);
        $post1->tags()->sync([$tags[0]->id, $tags[1]->id, $tags[4]->id]); // laravel, php, tailwindcss

        $post2 = Post::create([
            'blog_id' => $blog2->id,
            'user_id' => $user2->id,
            'category_id' => $categories[1]->id, // Design
            'title' => 'The Rise of Minimalist Glassmorphism in Modern Dashboards',
            'slug' => 'the-rise-of-minimalist-glassmorphism-in-modern-dashboards',
            'content' => "Glassmorphism is a visually striking UI style characterized by background blur, semi-transparent frosted borders, and vibrant backing gradients. In this design essay, we discuss how to apply glassmorphism constraints responsibly so dashboard components remain readable, accessible, and high-performance.\n\nRemember to test contrast ratios under various screen layouts to keep your spaces user-friendly.",
            'read_time' => 2,
            'views_count' => 320,
            'status' => 'published',
            'published_at' => now()->subDays(1),
        ]);
        $post2->tags()->sync([$tags[4]->id, $tags[6]->id]); // tailwindcss, saas

        $post3 = Post::create([
            'blog_id' => $blog1->id,
            'user_id' => $user1->id,
            'category_id' => $categories[0]->id, // Technology
            'title' => 'Building Autonomous AI Agents with Gemini Flash',
            'slug' => 'building-autonomous-ai-agents-with-gemini-flash',
            'content' => "Gemini 1.5 Flash offers extremely low latency, massive context windows, and cost-efficient tokens. We walkthrough setting up a debounced keyword analyzer and AI tag suggestor using Laravel Http client. Debouncing prevents unnecessary API overhead during live text edits, preserving server limits.\n\nSimply poll content and dispatch async requests to generate tags on the fly.",
            'read_time' => 4,
            'views_count' => 85,
            'status' => 'published',
            'published_at' => now(),
        ]);
        $post3->tags()->sync([$tags[2]->id, $tags[5]->id]); // javascript, ai

        // 5. Seed post views to simulate trendy/latest
        // Create views for post2 in last 24 hours
        for ($i = 0; $i < 15; $i++) {
            PostView::create([
                'post_id' => $post2->id,
                'ip_address' => '192.168.1.' . $i,
                'created_at' => now()->subHours($i),
            ]);
        }

        // Create views for post3 in last 2 hours
        for ($i = 0; $i < 5; $i++) {
            PostView::create([
                'post_id' => $post3->id,
                'ip_address' => '10.0.0.' . $i,
                'created_at' => now()->subMinutes($i * 15),
            ]);
        }

        // 6. Seed reactions
        Reaction::create(['user_id' => $user1->id, 'post_id' => $post2->id, 'type' => 'love']);
        Reaction::create(['user_id' => $user2->id, 'post_id' => $post2->id, 'type' => 'like']);
        Reaction::create(['user_id' => $user2->id, 'post_id' => $post3->id, 'type' => 'like']);
    }
}
