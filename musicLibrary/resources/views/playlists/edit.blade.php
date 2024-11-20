@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('playlists.show', $playlist) }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i> Back to Playlist
            </a>
            <h1 class="text-3xl font-bold">Edit Playlist</h1>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('playlists.update', $playlist) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required 
                    value="{{ old('name', $playlist->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#006D77] focus:ring-[#006D77]">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#006D77] focus:ring-[#006D77]">{{ old('description', $playlist->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Current Cover Image</label>
                @if($playlist->cover_image)
                    <img src="{{ Storage::url($playlist->cover_image) }}" 
                         alt="Current cover" 
                         class="mt-2 w-32 h-32 object-cover rounded">
                @endif
            </div>

            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700">Change Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-[#006D77] file:text-white
                    hover:file:bg-opacity-90">
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Songs</label>
                <div class="space-y-2" id="songList">
                    @foreach($playlist->songs as $song)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-lg shadow" data-song-id="{{ $song->id }}">
                            <button type="button" class="cursor-move text-gray-400 hover:text-gray-600">
                                <i class="fas fa-grip-vertical"></i>
                            </button>
                            @if($song->cover_art)
                                <img src="{{ $song->cover_art }}" alt="Album artwork" class="w-12 h-12 object-cover rounded">
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold">{{ $song->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $song->artist }}</p>
                            </div>
                            <button type="button" 
                                    onclick="removeSong({{ $song->id }})"
                                    class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="hidden" name="song_order[]" value="{{ $song->id }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-[#006D77] text-white py-2 px-4 rounded-md hover:bg-opacity-90">
                Save Changes
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
new Sortable(document.getElementById('songList'), {
    handle: '.cursor-move',
    animation: 150,
    onEnd: function() {
        updateSongOrder();
    }
});

function updateSongOrder() {
    const songInputs = document.querySelectorAll('input[name="song_order[]"]');
    songInputs.forEach((input, index) => {
        input.value = input.closest('[data-song-id]').dataset.songId;
    });
}

function removeSong(songId) {
    if (confirm('Are you sure you want to remove this song from the playlist?')) {
        fetch(`/playlists/{{ $playlist->id }}/songs/${songId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`[data-song-id="${songId}"]`).remove();
            }
        });
    }
}
</script>
@endsection