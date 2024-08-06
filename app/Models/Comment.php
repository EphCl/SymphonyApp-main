<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    protected $with = ['user', 'reply'];

    protected $appends = ['nbLikes', 'isLiked', 'nbReplies'];

    public function getIsLikedAttribute()
    {
        return $this->likes->contains('user_id', auth()->id());
    }

    public function getNbLikesAttribute()
    {
        return $this->likes->count();
    }

    public function getNbRepliesAttribute()
    {
        return $this->reply->count();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reply()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

}
