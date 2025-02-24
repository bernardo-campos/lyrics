<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Http\Request;
use DataTables;

class ArtistSongController extends Controller
{
    public function index(Artist $artist)
    {
        if (!request()->ajax()) {
            return view('artists.songs.index');
        }

        $query = Song::with('album')
            ->where('songs.artist_id', $artist->id)
            ->select('songs.*');

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Song $song) => [
                'show' => route('songs.show', $song),
            ])
            ->make(true);
    }
}
