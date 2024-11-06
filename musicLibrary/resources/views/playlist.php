<?php
// playlist.php

// Database connection (adjust parameters as needed)
$host = 'localhost';
$db = 'music_library';
$user = 'yourusername';
$pass = 'yourpassword';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Check if a playlist ID is provided
if (isset($_GET['playlist_id'])) {
    $playlistId = $_GET['playlist_id'];

    // Fetch the playlist data from the database
    $stmt = $conn->prepare("SELECT * FROM playlists WHERE id = ?");
    $stmt->execute([$playlistId]);
    $playlist = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($playlist) {
        // Return playlist data as JSON
        echo json_encode($playlist);
    } else {
        echo json_encode(['error' => 'Playlist not found']);
    }
} else {
    echo json_encode(['error' => 'No playlist ID provided']);
}
