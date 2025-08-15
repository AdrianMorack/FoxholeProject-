<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Foxhole Tool' }}</title>

    @livewireStyles
</head>
<body>
    <!-- TITLE HANDLER -->
    <h1>{{ $title ?? 'Foxhole Tool' }}</h1>
    
    <!-- BUTTONS -->
    <a href="{{ route('home.page') }}">
        <button type="button">Home Page</button>
    </a>
    <a href="{{ route('war.status') }}">
        <button type="button">View War Status</button>
    </a>
    <a href="{{ route('war.map') }}">
        <button type="button">View War Map</button>
    </a>
    {{ $slot }}

    @livewireScripts
</body>
</html>
