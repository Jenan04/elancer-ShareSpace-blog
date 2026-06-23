<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'username',
        'email',
        'password',
        'google_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->slug)) {
                $user->slug = Str::slug($user->name ?? explode('@', $user->email)[0]) . '-' . Str::random(5);
            }
            if (empty($user->username)) {
                $base = Str::slug($user->name ?? explode('@', $user->email)[0], '');
                if (empty($base)) {
                    $base = 'user';
                }
                // Ensure unique username
                $username = $base . rand(100, 999);
                while (static::where('username', $username)->exists()) {
                    $username = $base . rand(1000, 9999);
                }
                $user->username = $username;
            }
        });
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
