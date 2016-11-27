<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/playlists', 'Api\PlaylistController@index');

Route::get('/games', 'Api\GameController@index');
Route::get('/games/{id}', 'Api\GameController@show');


Route::get('test/playlist', 'Api\TestController@playlist');
Route::get('test/playlist-items', 'Api\TestController@playlistItems');
Route::get('test/video', 'Api\TestController@video');