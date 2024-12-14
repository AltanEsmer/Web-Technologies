@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16 mt-12">
    <div class="max-w-2xl mx-auto">
        {{-- Header Section --}}
        @include('playlists.partials.search-header', ['playlist' => $playlist])

        {{-- Search Form --}}
        @include('playlists.partials.search-form', ['query' => $query ?? ''])

        {{-- Search Results --}}
        @if(!empty($spotifySongs))
            <div class="grid gap-4 bg-transparent">
                @foreach($spotifySongs as $song)
                    @include('playlists.partials.song-card', [
                        'song' => $song,
                        'playlist' => $playlist
                    ])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/search.js') }}"></script>
@endpush

@section('head')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection