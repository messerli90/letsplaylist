<?php

namespace App\Transformers;

use App\Channel;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
    public function transform(Channel $channel)
    {
        return [
            'key' => $channel->key,
            'name' => $channel->title,
            'image' => $channel->image,
            'slug' => $channel->custom_url
        ];
    }
}