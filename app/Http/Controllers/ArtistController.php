<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use DataTables;

class ArtistController extends Controller
{
    public function index()
    {
        if (!request()->ajax()) {
            return view('artists.index');
        }

        $query = Artist::withCount('albums');

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Artist $artist) => [
                'albums' => route('artists.albums.index', $artist),
                // 'edit' => route('artists.edit', $artist),
                // 'destroy' => route('artists.destroy', $artist),
            ])
            ->make(true);
    }
}
