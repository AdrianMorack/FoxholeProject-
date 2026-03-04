<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white">
        <div class="p-4 text-xl font-bold border-b border-gray-700">
            Foxhole Tool
        </div>
        <nav class="mt-4 space-y-2 px-4">
            <a href="{{ route('WarStatus') }}" class="block py-2 px-3 rounded hover:bg-gray-700">War Status</a>
            <a href="{{ url('/map') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Map</a>
            <a href="{{ url('/stats') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Statistics</a>
            <a href="{{ url('/resources') }}" class="block py-2 px-3 rounded hover:bg-gray-700">Resources</a>
        </nav>
        <div class="mt-auto p-4 border-t border-gray-700 text-sm">
            <a href="https://github.com/yourrepo" class="hover:underline">GitHub</a> | 
            <a href="{{ url('/about') }}" class="hover:underline">About</a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 bg-gray-100 p-6">
        {{ $slot }}
    </main>
</div>
