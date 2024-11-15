<!-- resources/views/spotify/search.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Search Spotify for Songs</h1>
    
    <form action="{{ route('spotify.search') }}" method="GET">
        <input type="text" name="query" placeholder="Enter song name" required>
        <button type="submit">Search</button>
    </form>

    @if(isset($spotifySongs) && count($spotifySongs) > 0)
        <h2>Spotify Search Results</h2>
        <ul>
            @foreach ($spotifySongs as $spotifySong)
                <li>
                    <img src="{{ $spotifySong['album']['images'][0]['url'] ?? '' }}" alt="Album Art" style="width:50px;">
                    <p>{{ $spotifySong['name'] }} by {{ $spotifySong['artists'][0]['name'] }}</p>
                    <p>Album: {{ $spotifySong['album']['name'] }}</p>
                </li>
            @endforeach
        </ul>
    @elseif(isset($spotifySongs))
        <p>No Spotify songs found.</p>
    @endif
@endsection
