<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Blog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'title',
        'description',
    ];

    
    //  Relationship Architecture (One-to-Many):
    //  In UML design, this is represented as (User [1] ----> [*] Blogs/Posts).
     
    //  - This model is the Child (Infinity side), so it holds the Foreign Key.
    //  - belongsTo() means this record belongs strictly to one specific User.
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship Architecture (One-to-Many):
    //   Blog [1] --------> [*] Posts
    //   - This model is the Parent [1], it remains clean of post IDs.
    //   - The `posts` table will hold the `blog_id` foreign key

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

}
