<?php

namespace App\Transformers;

use App\Game;
use League\Fractal\TransformerAbstract;

class GameTransformer extends TransformerAbstract
{
    public function transform(Game $game)
    {
        return [
            'id' => $game->id,
            'title' => $game->title,
            'image' => $game->image,
        ];
    }
}