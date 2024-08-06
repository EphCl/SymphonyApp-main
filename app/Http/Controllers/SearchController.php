<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        // Recherche les utilisateurs par leur nom d'utilisateur ou leur nom

        if (empty($search)) {
            $searchResults = null;
        }else{
            $searchResults = User::query()
                ->where('username', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->get();
            if ($searchResults->isEmpty()) {
                $searchResults = null;
            }
        }

        $trendingUsers = $trendingUsers = User::withCount('followers')
            ->where('id', '!=', auth()->id())
            ->orderByDesc('followers_count') // Trier par le plus grand nombre de followers
            ->take(10) // Limiter à 10 résultats
            ->get();

        // Passe les résultats de la recherche à la vue
        return Inertia::render('Search', [
            'searchResults' => $searchResults,
            'trendingUsers' => $trendingUsers,
        ]);
    }
}
