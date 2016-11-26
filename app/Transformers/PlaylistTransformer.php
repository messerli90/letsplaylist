<?php

namespace App\Transformers;

use App\Playlist;
use League\Fractal\TransformerAbstract;

class PlaylistTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['channel', 'game'];


    public function transform(Playlist $playlist)
    {
        return [
            'id' => $playlist->id,
            'key' => $playlist->key,
            'title' => $playlist->title,
            'description' => $playlist->description,
            'image' => $playlist->image,
            'created_at_human' => $playlist->created_at->diffForHumans(),
        ];
    }

    public function includeChannel(Playlist $playlist)
    {
        return $this->item($playlist->channel, new ChannelTransformer());
    }

    public function includeGame(Playlist $playlist)
    {
        return $this->item($playlist->game, new GameTransformer());
    }
}