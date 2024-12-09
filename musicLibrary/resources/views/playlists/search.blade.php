@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16 mt-12">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('playlists.show', $playlist) }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i> Back to Playlist
            </a>
            <h1 class="text-3xl font-bold">Add Songs to {{ $playlist->name }}</h1>
        </div>

        <form action="{{ route('playlists.searchSpotify', $playlist) }}" method="GET" class="mb-8">
            <div class="flex gap-4">
                <input 
                    type="text" 
                    name="query" 
                    value="{{ $query ?? '' }}"
                    placeholder="Search for songs" 
                    class="flex-1 p-3 border rounded-lg"
                    required
                >
                <button type="submit" class="px-6 py-3 bg-white text-[#006D77] border border-[#006D77] rounded-lg hover:bg-[#006D77] hover:text-white">
                    Search
                </button>
            </div>
        </form>

        @if(isset($message))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                {{ $message }}
            </div>
        @endif

        @if(!empty($spotifySongs))
            <div class="grid gap-4">
                @foreach($spotifySongs as $song)
                    <div class="flex items-center gap-4 p-4 bg-white rounded-lg shadow">
                        <img 
                            src="{{ $song['album']['images'][0]['url'] ?? '' }}" 
                            alt="Album artwork" 
                            class="w-16 h-16 object-cover rounded"
                        >
                        <div class="flex-1">
                            <h3 class="font-semibold">{{ $song['name'] }}</h3>
                            <p class="text-gray-600">{{ $song['artists'][0]['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $song['album']['name'] }}</p>
                        </div>
                        <form action="{{ route('playlists.addSong', $playlist) }}" method="POST">
                            @csrf
                            <input type="hidden" name="title" value="{{ $song['name'] }}">
                            <input type="hidden" name="artist" value="{{ $song['artists'][0]['name'] }}">
                            <input type="hidden" name="album" value="{{ $song['album']['name'] }}">
                            <input type="hidden" name="cover_art" value="{{ $song['album']['images'][0]['url'] ?? '' }}">
                            <input type="hidden" name="spotify_id" value="{{ $song['id'] }}">
                            <input type="hidden" name="duration_ms" value="{{ $song['duration_ms'] }}">
                            <button type="submit" class="px-4 py-2 bg-white text-[#006D77] border border-[#006D77] rounded-lg hover:bg-[#006D77] hover:text-white">
                                Add to Playlist
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection