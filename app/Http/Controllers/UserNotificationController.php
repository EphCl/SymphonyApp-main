<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserNotificationController extends Controller
{
    //
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        auth()->user()->unreadNotifications->markAsRead();

        $trendingUsers = User::withCount('followers')
            ->where('id', '!=', auth()->id())
            ->orderByDesc('followers_count') // Trier par le plus grand nombre de followers
            ->take(10) // Limiter à 10 résultats
            ->get();


        return Inertia::render('Notification', [
            'notifications' => $notifications,
            'trendingUsers' => $trendingUsers
        ]);
    }
}
