@extends('layouts.app')

@section('content')
    <playlist-item v-for="video in {{ json_encode($playlistItems['results']) }}" :video-item="video"></playlist-item>
@endsection
