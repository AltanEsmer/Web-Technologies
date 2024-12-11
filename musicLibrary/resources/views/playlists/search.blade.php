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

        <form action="{{ route('playlists.searchSpotify', $playlist) }}" 
              method="GET" 
              class="mb-8">
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
            <div class="grid gap-4 bg-transparent">
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

@push('scripts')
<script>
document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const query = this.querySelector('input[name="query"]').value;
    const url = new URL(this.action);
    url.searchParams.set('query', query);
    
    // Show loading state without progress bar
    const button = this.querySelector('button');
    const originalText = button.textContent;
    button.disabled = true;
    button.textContent = 'Searching...';

    // Use fetch instead of window.location to prevent browser loading indicators
    fetch(url)
        .then(response => response.text())
        .then(html => {
            // Replace the current page content
            document.documentElement.innerHTML = html;
            // Update the URL without triggering a page load
            history.pushState({}, '', url);
        })
        .catch(error => {
            console.error('Search failed:', error);
            // Fallback to regular navigation if fetch fails
            window.location.href = url;
        })
        .finally(() => {
            button.disabled = false;
            button.textContent = originalText;
        });
});

function handleAddSong(event) {
    event.preventDefault();
    const form = event.target;
    const button = form.querySelector('button');
    const originalText = button.textContent;

    // Debug: Log the form data
    console.log('Form action:', form.action);
    console.log('CSRF token:', document.querySelector('meta[name="csrf-token"]').content);
    const formData = new FormData(form);
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Disable button and show loading state
    button.disabled = true;
    button.textContent = 'Adding...';

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        // Debug: Log the response
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.text().then(text => {
            try {
                // Try to parse as JSON
                return JSON.parse(text);
            } catch (e) {
                // If not JSON, log the raw response
                console.error('Raw response:', text);
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        console.log('Success data:', data);
        if (data.success) {
            // Show success state
            button.textContent = 'Added!';
            button.classList.add('bg-green-500', 'text-white', 'border-green-500');
            button.disabled = true;
        } else {
            throw new Error(data.message || 'Failed to add song');
        }
    })
    .catch(error => {
        // Reset button state
        console.error('Error details:', error);
        button.textContent = originalText;
        button.disabled = false;
        alert(error.message || 'Failed to add song');
    });

    return false;
}
</script>
@endpush
@endsection

@section('head')
<style>
    /* Hide the yellow progress bar */
    #nprogress {
        display: none !important;
    }
    
    #nprogress .bar {
        display: none !important;
    }
    
    /* Hide any browser default progress indicators */
    ::-webkit-progress-bar,
    ::-webkit-progress-value,
    ::-moz-progress-bar,
    progress {
        display: none !important;
    }
    
    /* Remove any loading animations */
    .loading-bar,
    .progress-bar {
        display: none !important;
    }
    
    /* Ensure no yellow backgrounds on containers */
    .container,
    .grid,
    .max-w-2xl {
        background: transparent !important;
    }
</style>
@endsection