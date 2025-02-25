<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Http\Request;
use DataTables;
use DB;

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

    public function unique(Artist $artist)
    {
        if (!request()->ajax()) {
            return view('artists.songs.unique.index');
        }

        $query = Song::where('songs.artist_id', $artist->id)
            ->groupBy('songs.name')
            ->select([
                'songs.name',
                DB::raw('COUNT(*) as count'),
                DB::raw('CASE WHEN COUNT(*) = 1 THEN MIN(songs.id) ELSE NULL END as id'),
            ]);

        return DataTables::eloquent($query)
            // ->blacklist(['count'])
            ->addColumn('urls', fn(Song $song) => [
                'show' => $song->id ? route('songs.show', $song) : null,
            ])
            ->make(true);
    }
}
