@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            @if($playlist->cover_image)
                <img src="{{ Storage::url($playlist->cover_image) }}" 
                     alt="Playlist cover" 
                     class="w-full h-64 object-cover">
            @endif
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl font-bold">{{ $playlist->name }}</h1>
                    <a href="{{ route('playlists.edit', $playlist) }}" 
                       class="px-4 py-2 bg-[#006D77] text-white rounded-lg hover:bg-opacity-90">
                        Edit Playlist
                    </a>
                    <a href="{{ route('playlists.searchSpotify', $playlist) }}" 
                        class="px-4 py-2 bg-[#006D77] text-white rounded-lg hover:bg-opacity-90">
                        Add Songs
                    </a>
                </div>
                @if($playlist->description)
                    <p class="text-gray-600">{{ $playlist->description }}</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            @if($playlist->songs->count() > 0)
                <div class="divide-y">
                    @foreach($playlist->songs as $song)
                        <div class="flex items-center gap-4 p-4">
                            @if($song->cover_art)
                                <img src="{{ $song->cover_art }}" 
                                     alt="Album artwork" 
                                     class="w-16 h-16 object-cover rounded">
                            @endif
                            <div>
                                <h3 class="font-semibold">{{ $song->title }}</h3>
                                <p class="text-gray-600">{{ $song->artist }}</p>
                                <p class="text-sm text-gray-500">{{ $song->album }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    No songs in this playlist yet.
                    <a href="{{ route('playlists.searchSpotify', $playlist) }}" 
                       class="text-[#006D77] hover:underline">
                        Add some songs
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection