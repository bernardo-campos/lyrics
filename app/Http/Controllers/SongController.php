<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Http\Requests\Datatable\LengthRequest;
use Illuminate\Http\Request;
use DataTables;

class SongController extends Controller
{
    public function index(LengthRequest $request)
    {
        if (!request()->ajax()) {
            return view('songs.index');
        }

        $query = Song::with('album.artist');

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Song $song) => [
                'show' => route('songs.show', $song),
            ])
            ->make(true);
    }

    public function show(Song $song)
    {
        return view('songs.show', [
            'song' => $song->load('album.artist'),
        ]);
    }
}
