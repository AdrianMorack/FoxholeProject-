<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $title ?? 'Foxhole Tool' }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background-color: #ffffff;
        }
        h1 {
            color: #000000;
            margin: 10px;
        }
        button {
            margin: 0 5px 10px 0;
            padding: 5px 10px;
            cursor: pointer;
        }

        
    </style>

    @livewireStyles
</head>
<body>
    <!-- TITLE -->
    <h1>{{ $title ?? 'Foxhole Tool' }}</h1>

    <!-- NAVIGATION -->
    <a href="{{ route('home.page') }}" wire:navigate><button>Home Page</button></a>
    <a href="{{ route('war.status') }}" wire:navigate><button>View War Status</button></a>
    <a href="{{ route('map.list') }}" wire:navigate><button>View War Maps</button></a>

    <!-- Livewire component output -->
    {{ $slot }}

    @livewireScripts
    @stack('scripts')
</body>
</html>
