<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use DataTables;

class SongController extends Controller
{
    public function index()
    {
        if (!request()->ajax()) {
            return view('songs.index');
        }

        $query = Song::with('album.artist');

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Song $song) => [
                // 'show' => route('song.show', $song),
            ])
            ->make(true);
    }
}
