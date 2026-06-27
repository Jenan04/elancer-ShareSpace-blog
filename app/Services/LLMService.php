<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LLMService
{
    public function suggestTags(string $content): array
    {
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        if ($apiKey) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Analyze the following technical content and return a JSON array containing between 3 and 5 highly relevant technical tags (single words or short phrases, lowercase, alphanumeric and hyphens only). Do not return any other text, markdown formatting, or explanation. Only return the JSON array.\n\nContent:\n{$content}"]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $result = $response->json();
                    $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    
                    // Clean up any potential markdown code fence surrounding the JSON output
                    $cleaned = trim($text);
                    if (str_starts_with($cleaned, '```')) {
                        $cleaned = preg_replace('/^```(?:json)?|```$/i', '', $cleaned);
                        $cleaned = trim($cleaned);
                    }

                    $tags = json_decode($cleaned, true);
                    if (is_array($tags)) {
                        return array_slice(array_map(fn($t) => strtolower(trim($t)), $tags), 0, 5);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Gemini API call failed: ' . $e->getMessage());
            }
        }

        return $this->getFallbackTags($content);
    }

    protected function getFallbackTags(string $content): array
    {
        $keywords = [
            'laravel' => 'Laravel',
            'php' => 'PHP',
            'javascript' => 'JavaScript',
            'js' => 'JavaScript',
            'vue' => 'Vue.js',
            'react' => 'React',
            'inertia' => 'Inertia.js',
            'livewire' => 'Livewire',
            'tailwind' => 'TailwindCSS',
            'css' => 'CSS',
            'html' => 'HTML',
            'typescript' => 'TypeScript',
            'node' => 'Node.js',
            'express' => 'Express',
            'postgres' => 'PostgreSQL',
            'mysql' => 'MySQL',
            'sqlite' => 'SQLite',
            'redis' => 'Redis',
            'docker' => 'Docker',
            'aws' => 'AWS',
            'git' => 'Git',
            'api' => 'API',
            'rest' => 'REST',
            'graphql' => 'GraphQL',
            'jwt' => 'JWT',
            'testing' => 'Testing',
            'phpunit' => 'PHPUnit',
            'pest' => 'Pest',
            'saas' => 'SaaS',
            'ai' => 'AI',
            'gemini' => 'Gemini',
            'database' => 'Database',
            'security' => 'Security',
            'auth' => 'Authentication',
        ];

        $matchedTags = [];
        $lowerContent = strtolower($content);

        foreach ($keywords as $key => $display) {
            if (preg_match('/\b' . preg_quote($key, '/') . '\b/i', $lowerContent)) {
                $matchedTags[] = $display;
            }
        }

        if (empty($matchedTags)) {
            $matchedTags = ['General', 'Writing', 'Tech'];
        }

        return array_slice($matchedTags, 0, 5);
    }
}
