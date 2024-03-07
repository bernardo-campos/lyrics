<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use DataTables;

class AlbumController extends Controller
{
    public function index()
    {
        if (!request()->ajax()) {
            return view('albums.index');
        }

        $query = Album::with('artist');

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Album $album) => [
                // 'edit' => route('albums.edit', $album),
                // 'destroy' => route('albums.destroy', $album),
            ])
            ->make(true);
    }
}
