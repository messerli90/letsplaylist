<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title', 'summary', 'key', 'image'];

    public function channel ()
    {
        return $this->belongsTo(Channel::class);
    }

    public function playlists ()
    {
        return $this->hasMany(Playlist::class);
    }

    public function getIcon ()
    {
        return "https://images.igdb.com/igdb/image/upload/t_micro/" . $this->image . ".jpg";
    }

    public function getThumbnail ()
    {
        return "https://images.igdb.com/igdb/image/upload/t_cover/" . $this->image . ".jpg";
    }

    public function getBanner ()
    {
        return "https://images.igdb.com/igdb/image/upload/t_screenshot_big/" . $this->image . ".jpg";
    }
}
