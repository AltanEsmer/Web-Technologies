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
        $playlists = Playlist::where('user_id', auth()->id())->with('songs')->get();
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

            $validated['user_id'] = auth()->id();

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
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }

        $playlist->load('songs');
        return view('playlists.show', compact('playlist'));
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
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('cover_image')) {
                if ($playlist->cover_image) {
                    Storage::disk('public')->delete($playlist->cover_image);
                }
                $image = $request->file('cover_image');
                $imageName = time() . '.' . $image->extension();
                $path = $image->storeAs('playlist-covers', $imageName, 'public');
                $validated['cover_image'] = $path;
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
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to playlist');
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'artist' => 'required|string',
            'album' => 'required|string',
            'cover_art' => 'nullable|url',
            'spotify_id' => 'required|string'
        ]);

        try {
            $song = Song::firstOrCreate(
                ['spotify_id' => $validated['spotify_id']],
                $validated
            );

            if (!$playlist->songs->contains($song->id)) {
                $playlist->songs()->attach($song->id);
            }

            return redirect()->route('playlists.show', $playlist)
                ->with('success', 'Song added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add song: ' . $e->getMessage());
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
}