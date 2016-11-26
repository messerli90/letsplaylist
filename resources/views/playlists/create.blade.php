@extends('layouts.app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add a new Playlist</h3>
                </div>
                <div class="panel-body">
                    <playlist-store csrf-token="{{ csrf_token() }}"></playlist-store>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>

@endsection
