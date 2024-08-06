<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    //
    public function store(Request $request)
    {
        $song = new Song;
        $song->title = $request->title;
        $song->artist = $request->artist;
        $song->album = $request->album;
        $song->year = $request->release_date;
        $song->genre = $request->genre;
        $song->duration = $request->duration;
        $song->path = $request->file;
        $song->save();
    }
}
