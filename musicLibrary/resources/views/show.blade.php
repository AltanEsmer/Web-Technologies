<!-- resources/views/playlist/show.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $playlist->name }}</title>
</head>
<body>
    <h1>{{ $playlist->name }}</h1>
    <p>{{ $playlist->description }}</p>
</body>
</html>

