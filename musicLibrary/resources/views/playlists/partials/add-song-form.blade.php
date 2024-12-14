<form action="{{ route('playlists.addSong', $playlist) }}" 
      method="POST" 
      class="add-song-form"
      onsubmit="return handleAddSong(event)">
    @csrf
    <input type="hidden" name="title" value="{{ $song['name'] }}">
    <input type="hidden" name="artist" value="{{ $song['artists'][0]['name'] }}">
    <input type="hidden" name="album" value="{{ $song['album']['name'] }}">
    <input type="hidden" name="cover_art" value="{{ $song['album']['images'][0]['url'] ?? '' }}">
    <input type="hidden" name="spotify_id" value="{{ $song['id'] }}">
    <input type="hidden" name="duration_ms" value="{{ $song['duration_ms'] }}">
    
    <button type="submit" 
            class="px-4 py-2 bg-white text-[#006D77] border border-[#006D77] rounded-lg hover:bg-[#006D77] hover:text-white transition-all duration-200 hover:shadow-sm">
        <span class="button-text">Add to Playlist</span>
        <span class="loading-text hidden">
            <i class="fas fa-spinner fa-spin mr-2"></i>Adding...
        </span>
    </button>
</form> 