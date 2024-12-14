<div class="flex items-center gap-4 p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100">
    <img src="{{ $song['album']['images'][0]['url'] ?? asset('images/default-album.png') }}" 
         alt="Album artwork for {{ $song['name'] }}" 
         class="w-16 h-16 object-cover rounded-lg shadow-sm"
         loading="lazy">
    
    <div class="flex-1">
        <h3 class="font-semibold text-gray-900">{{ $song['name'] }}</h3>
        <p class="text-gray-700">{{ $song['artists'][0]['name'] }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $song['album']['name'] }}</p>
    </div>
    
    @include('playlists.partials.add-song-form', [
        'song' => $song,
        'playlist' => $playlist
    ])
</div> 