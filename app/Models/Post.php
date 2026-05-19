<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'blog_id',
        'category_id',
        'title',
        'slug',
        'content',
        'cover_image_url',
        'status',
        'views_count',
        'published_at',
    ];
    
    public function blogs(): belongsTo {
    return $this->belongsTo(Blog::class);
   }

   public function tags(): belongsToMany {
    return $this->belongsToMany(Tag::class);
}

}
