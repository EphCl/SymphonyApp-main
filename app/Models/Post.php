<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    protected $with = ['user', 'comments', 'song'];

    protected $appends = ['nbLikes', 'nbComments', 'isLiked'];


    public function getIsLikedAttribute()
    {
        return $this->likes->contains('user_id', auth()->id());
    }

    public function getNbLikesAttribute()
    {
        return $this->likes->count();
    }

    public function getNbCommentsAttribute()
    {
        return Comment::where('post_id', $this->id)
            ->whereNull('parent_id')
            ->orWhere(function ($query) {
                $query->where('post_id', $this->id)
                    ->whereNotNull('parent_id');
            })
            ->count();
    }

    public function song()
    {
        return $this->hasOne(Song::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->whereNull('parent_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

}
