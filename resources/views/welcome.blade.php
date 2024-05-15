@extends('layouts.app')

@section('content')
    <canvas id="canvas" width="320" height="480"></canvas>
@endsection

@section('scripts')
    <script src="{{ asset('js/game.js') }}"></script>
@endsection
