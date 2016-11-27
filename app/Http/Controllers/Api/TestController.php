<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function playlist ($playlist_id = 'PLwH1xJhcXG0dPGmbx35nhuzEacgKdjCUo')
    {
        $playlist = Youtube::getPlaylistById($playlist_id, ['id', 'snippet', 'status']);

        return response()->json($playlist);
    }

    public function playlistItems ($playlist_id = 'PLwH1xJhcXG0dPGmbx35nhuzEacgKdjCUo')
    {
        $playlistItems = Youtube::getPlaylistItemsByPlaylistId($playlist_id);

        return response()->json($playlistItems);
    }

    public function video ($video_id = 'A2Ig-XLl8JY')
    {
        $video = Youtube::getVideoInfo($video_id);

        return response()->json($video);
    }
}
