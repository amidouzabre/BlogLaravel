<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'user_id',
    ];

    protected $appends = ['is_liked', 'likes_count'];

    protected $with = ['likedBy'];


    // Relations

    /**
     * Get the user that owns the post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the users that liked the post.
     */
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }


    // Getters

    /**
     * Get the is liked attribute.
     */
    public function getIsLikedAttribute(): bool
    {
        return Auth::check() && $this->likedBy->contains(Auth::id());
    }

    /**
     * Get the likes count attribute.
     */
    public function getLikesCountAttribute(): int
    {
        return $this->likedBy->count();
    }
}
