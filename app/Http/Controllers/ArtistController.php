<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\Datatable\LengthRequest;
use Illuminate\Http\Request;
use DataTables;

class ArtistController extends Controller
{
    public function index(LengthRequest $request)
    {
        if (!request()->ajax()) {
            return view('artists.index');
        }

        $query = Artist::withCount([
            'albums',
            'songs',
            'songsWithLyrics',
            'songsWithoutLyrics',
        ]);

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Artist $artist) => [
                'albums' => route('artists.albums.index', $artist),
                'songs' => route('artists.songs.index', $artist),
                // 'edit' => route('artists.edit', $artist),
                // 'destroy' => route('artists.destroy', $artist),
            ])
            ->make(true);
    }
}
