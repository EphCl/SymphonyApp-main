<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'follower_id'];
    protected $appends = ['nbFollower', 'nbFollowing', 'isFollowed'];

    public function getIsFollowedAttribute()
    {
        return $this->follower->contains('following_id', auth()->id());
    }

    public function getNbFollowerAttribute()
    {
        return $this->follower->count();
    }

    public function getNbFollowingAttribute()
    {
        return $this->following->count();
    }
}
