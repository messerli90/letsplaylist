<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'PlaylistController@index');

Route::group(['prefix' => 'playlists'], function ()
{
    Route::get('/', [
        'uses' => 'PlaylistController@index',
        'as' => 'playlists.index'
    ]);

    Route::post('/', [
        'uses' => 'PlaylistController@store',
        'as' => 'playlists.store'
    ]);

    Route::get('create', [
        'uses' => 'PlaylistController@create',
        'as' => 'playlists.create'
    ]);

    Route::get('{playlist}', [
        'uses' => 'PlaylistController@show',
        'as' => 'playlists.show'
    ]);

    Route::get('{playlist}/preview', [
        'uses' => 'PlaylistController@preview',
        'as' => 'playlists.preview'
    ]);

    Route::get('{playlist_id}/videos/{video_id}', [
        'uses' => 'VideoController@show',
        'as' => 'videos.show'
    ]);
});
