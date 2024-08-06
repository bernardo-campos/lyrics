<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ArtistAlbumController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::get('healthcheck', function () {
    return response()->json(['message' => 'OK']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'as'            => 'search.',
    'prefix'        => 'search',
    'controller'    => SearchController::class,
], function () {
    Route::get('/', 'index')->name('index');
});

Route::group([
    'as'            => 'artists.',
    'prefix'        => 'artists',
    'controller'    => ArtistController::class,
], function () {
    Route::get('/','index')->name('index');

    Route::group([
        'as'            => 'albums.',
        'prefix'        => '{artist:slug}',
        'controller'    => ArtistAlbumController::class,
    ], function () {
        Route::get('albums', 'index')->name('index');
        Route::get('albums/{album}', 'show')->name('show');
    });
});

Route::group([
    'as'            => 'albums.',
    'prefix'        => 'albums',
    'controller'    => AlbumController::class,
], function () {
    Route::get('/','index')->name('index');
});

Route::group([
    'as'            => 'songs.',
    'prefix'        => 'songs',
    'controller'    => SongController::class,
], function () {
    Route::get('/','index')->name('index');
    Route::get('/{song}','show')->name('show');
});