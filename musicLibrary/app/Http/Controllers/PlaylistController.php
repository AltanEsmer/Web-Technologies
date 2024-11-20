<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::with('songs')->get();
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable|string',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $validated['user_id'] = auth()->id() ?? 1;

            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                
                // Debug information
                \Log::info('Image details', [
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'error' => $image->getError()
                ]);

                $imageName = time() . '.' . $image->extension();
                
                // Store the file directly in public disk
                $path = $image->storeAs('playlist-covers', $imageName, 'public');
                
                if (!$path) {
                    throw new \Exception('Failed to store image');
                }

                // Verify the file exists
                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('Stored file not found');
                }

                $validated['cover_image'] = $path;
                
                \Log::info('Image stored successfully', [
                    'path' => $path,
                    'url' => Storage::url($path)
                ]);
            }

            $playlist = Playlist::create($validated);

            \Log::info('Playlist created', [
                'id' => $playlist->id,
                'cover_image' => $playlist->cover_image,
                'storage_path' => $playlist->cover_image ? Storage::url($playlist->cover_image) : null
            ]);

            return redirect()->route('playlists.show', $playlist)
                ->with('success', 'Playlist created successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Playlist creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create playlist: ' . $e->getMessage());
        }
    }

    public function show(Playlist $playlist)
    {
        $playlist->load('songs');
        return view('playlists.show', compact('playlist'));
    }

    public function searchSpotify(Request $request, Playlist $playlist)
    {
        $spotifyService = new SpotifyService();
        $query = $request->input('query');
        $message = '';
        $spotifySongs = [];

        if ($query) {
            $spotifySongs = $spotifyService->searchTracks($query);
            if ($spotifySongs === null) {
                $message = 'Failed to fetch songs from Spotify';
            }
        }

        return view('playlists.search', compact('playlist', 'spotifySongs', 'query', 'message'));
    }

    public function addSong(Request $request, Playlist $playlist)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'artist' => 'required|string',
            'album' => 'required|string',
            'cover_art' => 'nullable|url',
            'spotify_id' => 'required|string'  // Add this validation
        ]);

        $song = Song::firstOrCreate(
            [
                'spotify_id' => $validated['spotify_id']  // Use spotify_id as part of the unique identifier
            ],
            [
                'title' => $validated['title'],
                'artist' => $validated['artist'],
                'album' => $validated['album'],
                'cover_art' => $validated['cover_art'] ?? null
            ]
        );

        $playlist->songs()->attach($song->id);

        return back()->with('success', 'Song added to playlist successfully!');
    }

    public function edit(Playlist $playlist)
    {
        $playlist->load('songs');
        return view('playlists.edit', compact('playlist'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable|string',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'song_order' => 'array'
            ]);

            if ($request->hasFile('cover_image')) {
                // Delete old image if exists
                if ($playlist->cover_image) {
                    Storage::disk('public')->delete($playlist->cover_image);
                }

                $image = $request->file('cover_image');
                $imageName = time() . '.' . $image->extension();
                $path = $image->storeAs('playlist-covers', $imageName, 'public');
                $playlist->cover_image = $path;
            }

            $playlist->name = $validated['name'];
            $playlist->description = $validated['description'];
            $playlist->save();

            // Update song order if provided
            if (isset($validated['song_order'])) {
                foreach ($validated['song_order'] as $index => $songId) {
                    $playlist->songs()->updateExistingPivot($songId, ['order' => $index]);
                }
            }

            return redirect()->route('playlists.show', $playlist)
                ->with('success', 'Playlist updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update playlist: ' . $e->getMessage());
        }
    }

    public function removeSong(Playlist $playlist, Song $song)
    {
        $playlist->songs()->detach($song->id);
        return response()->json(['success' => true]);
    }
}