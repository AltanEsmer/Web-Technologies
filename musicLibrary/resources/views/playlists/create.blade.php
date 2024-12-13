@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto">
        <a href="{{ url()->previous() }}" class="inline-flex items-center mb-6 text-[#006D77] hover:text-opacity-80" style="margin-top: 50px;">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>

        <h1 class="text-3xl font-bold mb-6">Create New Playlist</h1>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required 
                    value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#006D77] focus:ring-[#006D77]">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#006D77] focus:ring-[#006D77]">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center">
                <label for="is_public" class="block text-sm font-medium text-gray-700 mr-3">Playlist Visibility</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_public" id="is_public" 
                    class="sr-only peer" value="1" 
                    {{ auth()->user()->isCurator() ? (old('is_public', true) ? 'checked' : '') : '' }}
                    {{ !auth()->user()->isCurator() ? 'disabled' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#006D77]/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006D77]"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700 peer-checked:text-gray-700">
                        {{ auth()->user()->isCurator() ? 'Public' : 'Only Curators can make it public' }}
                    </span>
                </label>
            </div>
            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-[#006D77] file:text-white
                    hover:file:bg-opacity-90">
                <!-- Image Preview -->
                <div id="image-preview" class="mt-4">
                    <img id="preview" src="" alt="Image Preview" class="hidden w-40 h-40 object-cover rounded-md border" />
                </div>
            </div>

            <button type="submit" class="w-full bg-[#006D77] text-white py-2 px-4 rounded-md hover:bg-opacity-90">
                Create Playlist
            </button>
        </form>
    </div>
</div>

<!-- Image preview -->
<script src="{{ asset('js/imagePreview.js') }}"></script>
@endsection
