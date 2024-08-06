<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    //
    public function index()
    {


    }
    public function store(Request $request)
    {
        request()->validate([
            'content' => 'required | string | max:255',
            'post_id' => 'required | exists:posts,id',
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $request->post_id;
        $comment->save();
        request()->session()->flash('alert', [
            'type' => 'success',
            'message' => 'Commentaire ajouté avec succès',
        ]);
    }

    public function reply(Request $request)
    {
        request()->validate([
            'content' => 'required | string | max:255',
            'post_id' => 'required | exists:posts,id',
            'parent_id' => 'required | exists:comments,id',
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $request->post_id;
        $comment->parent_id = $request->parent_id;
        $comment->save();
        request()->session()->flash('alert', [
            'type' => 'success',
            'message' => 'Commentaire ajouté avec succès',
        ]);
    }
}
