<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('playlists.show', $playlist) }}" 
       class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
        <i class="fas fa-arrow-left"></i> Back to Playlist
    </a>
    <h1 class="text-3xl font-bold text-[#006D77]">
        Add Songs to {{ $playlist->name }}
    </h1>
</div> 