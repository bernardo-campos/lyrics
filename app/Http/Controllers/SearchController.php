<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    public function index(SearchRequest $request)
    {
        if (!$request->ajax()) {
            return view('search.index');
        }

        // return response()->json(['msg' => $request->input('artists')]);

        return Song::take(10)->get();
    }
}
