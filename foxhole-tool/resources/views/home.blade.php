<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foxhole Dashboard</title>
</head>
<body>
    <h1>Welcome to the Foxhole Tool</h1>
    @livewire('home-page')

    <a href="{{ route('WarStatus') }}">
        <button type="button">View War Status</button>
    </a>

</body>
</html>

