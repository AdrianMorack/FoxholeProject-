<div class="space-y-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">War Maps</h1>
            <p class="text-sm text-gray-400">Select a map to view structure locations</p>
        </div>
        <div class="text-right">
            <div class="text-2xl font-bold text-blue-400">{{ count($maps) }}</div>
            <div class="text-xs text-gray-400">Available</div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg p-4 border border-slate-700 shadow-lg">
        <h2 class="text-lg font-semibold text-white mb-1">World Map</h2>
        <p class="text-sm text-gray-400 mb-4">Click a hex to open that region map</p>

        <div class="relative w-full max-w-5xl mx-auto rounded-lg overflow-hidden border border-slate-700 bg-slate-900">
            <!-- World Map Image -->
            <img
                src="{{ asset('images/WorldMap.webp') }}"
                alt="World Map"
                class="w-full h-auto object-contain block"
                onerror="this.onerror=null; this.src='{{ asset('images/FoxholeMap.png') }}'"
            >
            
            <!-- SVG Overlay for Interactive Hexes -->
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 2560 1554" preserveAspectRatio="xMidYMid meet" style="z-index: 10;">
                <!-- ReachingTrailHex -->
                <a href="{{ route('map-viewer', ['shard' => session('foxhole_shard', 'baker'), 'mapName' => 'ReachingTrailHex']) }}" 
                   class="hex-link">
                    <path
                       class="hex-region"
                       d="m 1299.4177,287.716 -36.925,63.95594 h -73.8499 l -36.925,-63.95594 36.925,-63.95593 73.8499,0 z"
                       transform="matrix(1.7312139,0,0,1.7475518,-841.29828,-168.97976)"
                    >
                        <title>Reaching Trail</title>
                    </path>
                </a>
                
                <!-- HowlCountyHex -->
                <a href="{{ route('map-viewer', ['shard' => session('foxhole_shard', 'baker'), 'mapName' => 'HowlCountyHex']) }}" 
                   class="hex-link">
                    <path
                       class="hex-region"
                       d="m 1299.4177,287.716 -36.925,63.95594 h -73.8499 l -36.925,-63.95594 36.925,-63.95593 73.8499,0 z"
                       transform="matrix(1.7312139,0,0,1.7475518,-649.52202,-280.5699)"
                    >
                        <title>Howl County</title>
                    </path>
                </a>
            </svg>
        </div>
    </div>

    <style>
        .hex-link {
            cursor: pointer;
        }

        .hex-region {
            fill: rgba(59, 130, 246, 0.25);
            stroke: rgba(96, 165, 250, 0.8);
            stroke-width: 3;
            transition: all 0.2s ease;
        }

        .hex-link:hover .hex-region {
            fill: rgba(59, 130, 246, 0.45);
            stroke: rgba(96, 165, 250, 1);
            stroke-width: 4;
        }
    </style>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-3">
        @foreach($maps as $map)
            <a href="{{ route('map-viewer', ['shard' => session('foxhole_shard', 'baker'), 'mapName' => $map['name']]) }}" wire:navigate
               class="group block bg-gradient-to-br from-slate-800 to-slate-900 hover:from-slate-700 hover:to-slate-800 rounded-lg p-4 transition-all border border-slate-700 hover:border-blue-500 shadow-lg hover:shadow-xl hover:scale-105">
                <div class="flex items-start justify-between mb-3">
                    <h2 class="text-sm font-semibold text-white group-hover:text-blue-400 transition-colors leading-tight">{{ $map['display_name'] }}</h2>
                    <svg class="w-3 h-3 text-gray-400 group-hover:text-blue-400 flex-shrink-0 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-400">Structures</span>
                        <span class="font-bold text-blue-400">{{ $map['icon_count'] }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-400">Teams</span>
                        <span class="font-bold text-green-400">{{ $map['team_count'] }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    
    @if(empty($maps))
        <div class="text-center py-16">
            <div class="inline-block p-8 bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl border border-slate-700 shadow-xl">
                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 text-lg mb-4">No maps available</p>
                <p class="text-gray-500 text-sm">Run <code class="bg-slate-800 px-2 py-1 rounded text-blue-400">php artisan foxhole:sync-dynamic</code> to fetch data</p>
            </div>
        </div>
    @endif
</div>
