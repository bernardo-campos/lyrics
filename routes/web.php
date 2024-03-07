<?php

use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'as'            => 'artists.',
    'prefix'        => 'artists',
    'controller'    => ArtistController::class,
], function () {
    Route::get('/','index')->name('index');
});