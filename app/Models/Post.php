<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'blog_id',
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'cover_image_url', // fallback/legacy
        'image_path',
        'read_time',
        'status',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'read_time' => 'integer',
        'views_count' => 'integer',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function blogs(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }
}
