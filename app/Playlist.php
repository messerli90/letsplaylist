<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Playlist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key', 'title', 'description', 'image',
        'channel_key', 'published_at', 'game_id'
    ];

    public $dates = ['created_at', 'updated_at', 'published_at'];

    public function channel ()
    {
        return $this->belongsTo(Channel::class, 'channel_key', 'key');
    }

    public function game ()
    {
        return $this->belongsTo(Game::class);
    }

    public function getThumbnail ()
    {
        return $this->image;
    }

    public function getUrl ()
    {
        return "https://www.youtube.com/playlist?list=" . $this->key;
    }
}
