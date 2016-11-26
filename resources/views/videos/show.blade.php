@extends('layouts.app')

@section('content')
    <div class="embed-responsive embed-responsive-16by9">
        {!! $video->player->embedHtml !!}
    </div>
@endsection
