<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlaylistController extends Controller
{
    public function index()
    {
        // Get user's own playlists
        $userPlaylists = Playlist::where('user_id', Auth::id())
            ->with('songs')
            ->get();

        // Get public playlists from other users
        $publicPlaylists = Playlist::where('user_id', '!=', Auth::id())
            ->where('is_public', true)
            ->with(['songs', 'user'])
            ->get();

        return view('playlists.index', compact('userPlaylists', 'publicPlaylists'));
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
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_public' => 'boolean'
            ]);

            $validated['user_id'] = Auth::id();
            $validated['is_public'] = $request->has('is_public');

            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '.' . $image->extension();
                $path = $image->storeAs('playlist-covers', $imageName, 'public');
                $validated['cover_image'] = $path;
            }

            $playlist = Playlist::create($validated);

            return redirect()->route('playlists.show', $playlist)
                ->with('success', 'Playlist created successfully!');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create playlist: ' . $e->getMessage());
        }
    }

    public function show(Playlist $playlist)
    {
        // Load the playlist with its songs and user
        $playlist->load(['songs', 'user']);
        
        // Get user's playlists for the sidebar
        $playlists = auth()->user()->playlists;
        
        return view('playlists.show', compact('playlist', 'playlists'));
    }
    
    public function edit(Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }
        return view('playlists.edit', compact('playlist'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }

        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable|string',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_public' => 'nullable|boolean'
            ]);

            $validated['is_public'] = $request->has('is_public');

            if ($request->hasFile('cover_image')) {
                // Delete old image if it exists
                if ($playlist->cover_image) {
                    Storage::disk('public')->delete($playlist->cover_image);
                }
                
                $image = $request->file('cover_image');
                $imageName = time() . '.' . $image->extension();
                $path = $image->storeAs('playlist-covers', $imageName, 'public');
                $validated['cover_image'] = 'playlist-covers/' . $imageName;
            }

            $playlist->update($validated);

            return redirect()->route('playlists.show', $playlist)
                ->with('success', 'Playlist updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update playlist: ' . $e->getMessage());
        }
    }

    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }

        try {
            if ($playlist->cover_image) {
                Storage::disk('public')->delete($playlist->cover_image);
            }
            
            $playlist->delete();
            return redirect()->route('playlists.index')
                ->with('success', 'Playlist deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete playlist: ' . $e->getMessage());
        }
    }

    public function searchSpotify(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }

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
        try {
            if ($playlist->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to playlist'
                ], 403);
            }

            // Debug: Log the incoming request
            \Log::info('AddSong Request:', [
                'request' => $request->all(),
                'user_id' => auth()->id(),
                'playlist_id' => $playlist->id
            ]);

            $validated = $request->validate([
                'title' => 'required|string',
                'artist' => 'required|string',
                'album' => 'required|string',
                'cover_art' => 'nullable|url',
                'spotify_id' => 'required|string',
                'duration_ms' => 'nullable|integer'
            ]);

            // Debug: Log validated data
            \Log::info('Validated data:', $validated);

            // Get the current maximum position
            $maxPosition = $playlist->songs()->max('position') ?? -1;

            $song = Song::firstOrCreate(
                ['spotify_id' => $validated['spotify_id']],
                [
                    'title' => $validated['title'],
                    'artist' => $validated['artist'],
                    'album' => $validated['album'],
                    'cover_art' => $validated['cover_art'],
                    'duration_ms' => $validated['duration_ms']
                ]
            );

            // Debug: Log song creation
            \Log::info('Song created/found:', ['song_id' => $song->id]);

            if (!$playlist->songs->contains($song->id)) {
                $playlist->songs()->attach($song->id, ['position' => $maxPosition + 1]);
                return response()->json([
                    'success' => true,
                    'message' => 'Song added successfully!'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Song is already in the playlist.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error adding song:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to add song: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeSong(Playlist $playlist, Song $song)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }

        try {
            $playlist->songs()->detach($song->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reorderSongs(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            $songs = $request->input('songs');
            
            // Begin transaction to ensure all updates succeed or none do
            \DB::beginTransaction();
            
            foreach ($songs as $song) {
                $playlist->songs()->updateExistingPivot($song['id'], [
                    'position' => $song['position']
                ]);
            }
            
            \DB::commit();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update song order: ' . $e->getMessage()
            ], 500);
        }
    }
}