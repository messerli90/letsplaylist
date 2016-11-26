<?php

namespace App\Http\Controllers\Api;

use App\Playlist;
use App\Transformers\PlaylistTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PlaylistController extends Controller
{
    public function index ()
    {
        $playlists = Playlist::orderBy('created_at', 'desc')
            ->where(function($q) {
                if (request()->has('game')) {
                    $q->where('game_id', request()->game);
                }
                if (request()->has('search')) {
                    $q->where('title', 'LIKE', '%' . request()->search . '%');
                }
            })
            ->paginate(10);

        $playlistCollection = $playlists->getCollection();

        return fractal()->collection($playlistCollection)
            ->transformWith(new PlaylistTransformer())
            ->parseIncludes(['channel', 'game'])
            ->paginateWith(new IlluminatePaginatorAdapter($playlists))
            ->toArray();
    }
}
