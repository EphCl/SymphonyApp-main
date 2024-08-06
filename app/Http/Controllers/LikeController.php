<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Notifications\LikePostNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LikeController extends Controller
{
    //
    public function likePost(Post $post)
    {
        //check if the user has already liked the post
        $like = Like::where('user_id', auth()->user()->id)
            ->where('likeable_id', $post->id)
            ->where('likeable_type', Post::class)
            ->first();

        if (!$like) {
            $like = new Like();
            $like->user_id = auth()->user()->id;
            $like->likeable_id = $post->id;
            $like->likeable_type = Post::class;
            $like->save();
        }

        if($post->user->id != auth()->user()->id) {
            $user = auth()->user()->select('id', 'name', 'profile_photo_path', 'username')->first();
            $post->user->notify(new LikePostNotification($post->content, $user, 'A aimé votre publication.'));
        }

        return redirect()->back();
    }

    public function unlikePost(Post $post)
    {
        $like = Like::where('user_id', auth()->user()->id)
            ->where('likeable_id', $post->id)
            ->where('likeable_type', Post::class);

        if ($like->exists()) {
            $like->delete();
        }

        return redirect()->back();
    }

    public function likeComment($id)
    {
        //check if the user has already liked the post
        $like = Like::where('user_id', auth()->user()->id)
            ->where('likeable_id', $id)
            ->where('likeable_type', Comment::class)
            ->first();

        if (!$like) {
            $like = new Like();
            $like->user_id = auth()->user()->id;
            $like->likeable_id = $id;
            $like->likeable_type = Comment::class;
            $like->save();
        }
        return redirect()->back();
    }

    public function unlikeComment($id)
    {
        $like = Like::where('user_id', auth()->user()->id)
            ->where('likeable_id', $id)
            ->where('likeable_type', Comment::class)
            ->first();

        if ($like->exists()) {
            $like->delete();
        }
        return redirect()->back();
    }
}
