<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArtistAlbumController extends Controller
{
    public function index(Artist $artist)
    {
        $artist->load([
            'albums' => function (Builder $query) {
                $query
                ->select(['id', 'name', 'year', 'artist_id'])
                ->withCount('songs')
                ->with([
                    'image' => function (Builder $query1) {
                        $query1
                        ->select(['url', 'imageable_id'])
                        ->where('type', 'cover');
                    }
                ]);
            }
        ]);

        // dd($artist->toArray());

        return view('artists.albums.index', [
            'artist' => $artist,
        ]);
    }

    public function show(Artist $artist, Album $album)
    {
        $album->load('songs');

        return view('artists.albums.show', [
            'artist' => $artist,
            'album' => $album,
        ]);
    }
}
