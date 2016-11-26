@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <playlist-filter :games="{{ $games }}"></playlist-filter>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <playlist-index></playlist-index>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    $('select').select2({
        theme: 'bootstrap'
    });
    </script>
@endsection
