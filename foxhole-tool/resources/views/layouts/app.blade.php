<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $title ?? 'Foxhole War Tracker' }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: #e2e8f0;
        }
        
        .nav-container {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .nav-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #60a5fa;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo:hover {
            color: #93c5fd;
        }
        
        .nav-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .nav-btn {
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            background: rgba(51, 65, 85, 0.5);
            color: #e2e8f0;
        }
        
        .nav-btn:hover {
            background: rgba(71, 85, 105, 0.7);
            transform: translateY(-1px);
        }
        
        .nav-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        
        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
    </style>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="nav-content">
            <a href="{{ route('home.page') }}" wire:navigate class="logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                </svg>
                Foxhole Tracker
            </a>
            
            <div class="nav-links">
                <a href="{{ route('home.page') }}" wire:navigate class="nav-btn">Home</a>
                <a href="{{ route('war.status') }}" wire:navigate class="nav-btn">War Status</a>
                <a href="{{ route('map.list') }}" wire:navigate class="nav-btn">Maps</a>
                
                <!-- Shard Switcher -->
                <form action="{{ route('shard.toggle') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn" style="background: rgba(34, 197, 94, 0.2); color: #4ade80;">
                        Shard: {{ strtoupper(session('foxhole_shard', 'baker')) }}
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="page-container">
        {{ $slot }}
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
