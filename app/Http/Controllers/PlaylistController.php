<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Game;
use App\Http\Requests\PlaylistStoreRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Playlist;
use Carbon\Carbon;

use Alaouy\Youtube\Facades\Youtube;

class PlaylistController extends Controller
{
    public function index ()
    {
        $games = Game::orderBy('created_at', 'asc')->get()->toJson();

        return view('playlists.index', compact('games'));
    }

    public function create ()
    {
        return view('playlists.create');
    }

    public function store (PlaylistStoreRequest $request)
    {
        $youtube_playlist = Youtube::getPlaylistById($request->playlist_key);

        if (! $youtube_playlist) {
            return redirect()->back();
        }

        $youtube_channel = Youtube::getChannelById($youtube_playlist->snippet->channelId);

        if (! $youtube_channel) {
            return redirect()->back();
        }

        $client = new Client();

        $game_url = 'https://igdbcom-internet-game-database-v1.p.mashape.com/games/'. $request->game_key .'?fields=name,summary,first_release_date,cover,developers';

        try {
            $res = $client->request('GET', $game_url, [
                'headers' => [
                    'X-Mashape-Key' => env('IGDB_KEY', ''),
                    'Accept' => 'application/json'
                ]
            ]);
        } catch (BadResponseException $e)
        {
            return redirect()->back();
        }

        $body = json_decode($res->getBody()->getContents(), true)[0];

        if ($body['id'] != $request->game_key) {
            return redirect()->back();
        }

        $game = Game::firstOrNew(['key' => $body['id']]);
        $game->title = $body['name'];
        $game->summary = $body['summary'];
        $game->image = isset($body['cover']) ? $body['cover']['cloudinary_id'] : null;
        $game->save();

        $channel = Channel::firstOrNew(['key' => $youtube_channel->id]);
        $channel->title = $youtube_channel->snippet->title;
        $channel->description = $youtube_channel->snippet->description;
        $channel->image = $youtube_channel->snippet->thumbnails->default->url;
        $channel->custom_url = $youtube_channel->snippet->customUrl;
        $channel->video_count = $youtube_channel->statistics->videoCount;
        $channel->save();

        $playlist = Playlist::create([
            'key' => $youtube_playlist->id,
            'title' => $youtube_playlist->snippet->title,
            'description' => $youtube_playlist->snippet->description,
            'image' => $youtube_playlist->snippet->thumbnails->default->url,
            'channel_key' => $youtube_playlist->snippet->channelId,
            'published_at' => new Carbon($youtube_playlist->snippet->publishedAt),
            'game_id' => $game->id
        ]);

        return redirect()->route('playlists.index');
    }

    public function show (Playlist $playlist)
    {
        $playlistItems = Youtube::getPlaylistItemsByPlaylistId($playlist->key);

        return view('playlists.show', compact('playlistItems'));
    }

    public function preview (Playlist $playlist)
    {
        $playlistItems = Youtube::getPlaylistItemsByPlaylistId($playlist->key, '', 1);

        return response()->json($playlistItems);
    }
}
