@extends('layouts.app')

@section('content')
    <h1>Spotify Song Search</h1>
    <form action="{{ route('spotify.search') }}" method="GET">
        <input type="text" name="query" placeholder="Enter song name" required>
        <button type="submit">Search</button>
    </form>

    @if(isset($spotifySongs) && count($spotifySongs) > 0)
        <h2>Spotify Search Results</h2>
        <ul>
            @foreach ($spotifySongs as $song)
                <li>
                    <img src="{{ $song['album']['images'][0]['url'] ?? '' }}" alt="Album Art" style="width: 50px;">
                    <p>{{ $song['name'] }} by {{ $song['artists'][0]['name'] }}</p>
                    <p>Album: {{ $song['album']['name'] }}</p>
                </li>
            @endforeach
        </ul>
    @elseif(isset($spotifySongs))
        <p>No songs found.</p>
    @endif
@endsection
