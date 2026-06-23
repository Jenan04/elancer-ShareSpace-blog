<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
            'status' => 'nullable|in:draft,published,archived',
        ];
    }
}
