<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\Transformers\GameTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class GameController extends Controller
{
    public function index ()
    {
        $games = Game::orderBy('title', 'desc')
            ->where(function($q) {
                if (request()->has('title')) {
                    $q->where('title', 'LIKE', '%' . request()->title . '%');
                }
            })
            ->paginate(10);

        $playlistCollection = $games->getCollection();

        return fractal()->collection($playlistCollection)
            ->transformWith(new GameTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($games))
            ->toArray();
    }

    public function show ($id)
    {
        $game = Game::find($id);

        return response()->json($game);
    }
}
