<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show ($playlist_id, $video_id)
    {
        $video = Youtube::getVideoInfo($video_id);

        return response()->json($video);
        return view('videos.show', compact('video'));
    }
}
