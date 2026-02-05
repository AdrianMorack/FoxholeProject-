<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-8">Foxhole War Maps</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($maps as $map)
            <a href="{{ route('map-viewer', ['mapName' => $map['name']]) }}" wire:navigate
               class="block bg-gray-800 hover:bg-gray-700 rounded-lg p-6 transition-colors border border-gray-700 hover:border-blue-500">
                <h2 class="text-xl font-semibold text-white mb-3">{{ $map['display_name'] }}</h2>
                
                <div class="space-y-2 text-sm text-gray-300">
                    <div class="flex items-center justify-between">
                        <span>Icons:</span>
                        <span class="font-medium text-blue-400">{{ $map['icon_count'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Active Teams:</span>
                        <span class="font-medium text-green-400">{{ $map['team_count'] }}</span>
                    </div>
                </div>
                
                <div class="mt-4 text-blue-400 text-sm font-medium">
                    View Map →
                </div>
            </a>
        @endforeach
    </div>
    
    @if(empty($maps))
        <div class="text-center py-12">
            <p class="text-gray-400 text-lg">No maps available. Run <code class="bg-gray-800 px-2 py-1 rounded">php artisan foxhole:sync-dynamic</code> to fetch data.</p>
        </div>
    @endif
</div>
