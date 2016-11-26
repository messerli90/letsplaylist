<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'key', 'title', 'description', 'thumbnail',
        'custom_url', 'subscriber_count', 'video_count'
    ];

    public function playlists ()
    {
        return $this->hasMany(Playlist::class);
    }

    public function getThumbnail ()
    {
        return $this->image;
    }

}
