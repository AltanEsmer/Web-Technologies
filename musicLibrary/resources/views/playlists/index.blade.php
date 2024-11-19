@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Your Playlists</h1>
        <a href="{{ route('playlists.create') }}" class="px-4 py-2 bg-[#006D77] text-white rounded-lg hover:bg-opacity-90">
            Create New Playlist
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($playlists as $playlist)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($playlist->cover_image)
                    <img src="{{ Storage::url($playlist->cover_image) }}" 
                         alt="Playlist cover" 
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $playlist->name }}</h2>
                    @if($playlist->description)
                        <p class="text-gray-600 mb-4">{{ $playlist->description }}</p>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ $playlist->songs->count() }} songs</span>
                        <a href="{{ route('playlists.show', $playlist) }}" class="text-[#006D77] hover:underline">
                            View Playlist
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8 text-gray-500">
                No playlists yet. Create your first playlist!
            </div>
        @endforelse
    </div>
</div>
@endsection