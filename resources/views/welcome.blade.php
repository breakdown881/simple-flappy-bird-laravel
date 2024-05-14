@extends('layouts.app')

@section('content')
    <form id="startForm">
        <label for="player_name">Name:</label>
        <input type="text" id="player_name" name="player_name" required>
        <br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required>
        <br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <br>
        <button type="submit">Start Game</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/start.js') }}"></script>
@endsection
