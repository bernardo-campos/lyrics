<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Requests\Datatable\LengthRequest;
use Illuminate\Http\Request;
use DataTables;

class AlbumController extends Controller
{
    public function index(LengthRequest $request)
    {
        if (!request()->ajax()) {
            return view('albums.index');
        }

        $query = Album::with([
                'artist',
                'image'
            ])
            ->withCount('songs');

        return DataTables::eloquent($query)
            ->addColumn('urls', fn(Album $album) => [
                // 'edit' => route('albums.edit', $album),
                // 'destroy' => route('albums.destroy', $album),
            ])
            ->make(true);
    }
}
