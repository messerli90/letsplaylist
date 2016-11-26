<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'key', 'title', 'description', 'image',
        'view_count', 'like_count', 'dislike_count',
        'comment_count'
    ];

    public function playlist ()
    {
        return $this->belongsTo(Playlist::class);
    }
}
