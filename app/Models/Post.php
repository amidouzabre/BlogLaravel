<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
}
