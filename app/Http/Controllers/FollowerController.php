<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FollowerController extends Controller
{
    public function follow(Request $request){
        $request->validate([
            'following_id' => 'required | exists:users,id'
        ]);

        if(Follower::where('user_id', $request->following_id)
            ->where('follower_id', auth()->id())
            ->exists()){
            request()->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Vous suivez déjà cet utilisateur.',
            ]);
            return redirect()->back();
        }else {
            Follower::create([
                'user_id' => $request->following_id,
                'follower_id' => auth()->id()
            ]);
            $following = User::find($request->following_id);

            $user = auth()->user()->select('id', 'name', 'profile_photo_path', 'username')->first();
            $following->notify(new FollowNotification($user, 'vous suit désormais.'));

            request()->session()->flash('alert', [
                'type' => 'success',
                'message' => 'Vous suivez cet utilisateur.',
            ]);

            return redirect()->back();
        }
    }

    public function unfollow(Request $request){
        $request->validate([
            'following_id' => 'required | exists:users,id'
        ]);
        $follower = Follower::where('user_id', $request->following_id)
            ->where('follower_id', auth()->id());

        if(!$follower){
            request()->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Vous ne suivez pas cet utilisateur.',
            ]);
            return redirect()->back();
        }else {
            $follower->delete();

            $following = User::find($request->following_id);

            $user = auth()->user()->select('id', 'name', 'profile_photo_path', 'username')->first();
            $following->notify(new FollowNotification($user, 'ne vous suit plus.'));

            request()->session()->flash('alert', [
                'type' => 'success',
                'message' => 'Vous ne suivez plus cet utilisateur.',
            ]);

            return redirect()->back();
        }
    }
}
