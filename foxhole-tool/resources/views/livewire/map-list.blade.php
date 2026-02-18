<div class="min-h-screen bg-[#1a1f1a] text-[#e8e8d5]">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>

    <div class="relative z-10">
        <!-- Header -->
        <header class="border-b-4 border-[#3a5a7c] bg-[#0f140f] shadow-2xl sticky top-0 z-20">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <x-ui.button href="{{ route('home.page', ['shard' => session('foxhole_shard', 'baker')]) }}" variant="ghost" class="gap-2">
                        <!-- ArrowLeft Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        RETURN TO HQ
                    </x-ui.button>
                    <h1 class="text-2xl font-bold tracking-wider">TACTICAL WAR MAP</h1>
                    <div class="flex items-center gap-2">
                        <x-ui.badge variant="outline" class="gap-1">
                            <!-- Layers Icon -->
                            <svg class="w-5 h-5 text-[#3a5a7c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            LIVE VIEW
                        </x-ui.badge>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <!-- Map Display -->
            <x-ui.card class="border-[#3a5a7c] mb-8">
                <x-ui.card-header>
                    <div class="flex items-center justify-between">
                        <x-ui.card-title class="tracking-wider">THEATER OF OPERATIONS</x-ui.card-title>
                        <x-ui.badge variant="outline" class="tracking-wider">
                            REGIONS: {{ count($maps) }}
                        </x-ui.badge>
                    </div>
                </x-ui.card-header>

                <x-ui.card-content>
                    <!-- Map Container -->
                    <div class="relative bg-[#1a2520] border-4 border-[#2a3a2a] overflow-hidden">
                        <!-- World Map Image -->
                        <img
                            src="{{ asset('images/WorldMap.webp') }}"
                            alt="World Map"
                            class="w-full h-auto object-contain block opacity-80"
                            onerror="this.onerror=null; this.src='{{ asset('images/FoxholeMap.png') }}'"
                        >
                        
                        <!-- Grid Overlay -->
                        <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(rgba(74, 124, 89, 0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(74, 124, 89, 0.2) 1px, transparent 1px); background-size: 50px 50px;"></div>
                        
                        @include('partials.world-map-svg-overlay')
                    </div>
                </x-ui.card-content>
            </x-ui.card>

            <style>
                .hex-link {
                    cursor: pointer;
                }

                .hex-region {
                    fill: rgba(74, 124, 89, 0.25);
                    stroke: rgba(74, 124, 89, 0.8);
                    stroke-width: 3;
                    transition: all 0.2s ease;
                }

                .hex-link:hover .hex-region {
                    fill: rgba(74, 124, 89, 0.45);
                    stroke: rgba(90, 156, 105, 1);
                    stroke-width: 4;
                }
            </style>
            
            <!-- Region List -->
            <x-ui.card class="border-[#4a7c59]">
                <x-ui.card-header>
                    <x-ui.card-title class="tracking-wider">OPERATIONAL REGIONS</x-ui.card-title>
                </x-ui.card-header>

                <x-ui.card-content>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                        @foreach($maps as $map)
                            <x-ui.button 
                                href="{{ route('map-viewer', ['shard' => session('foxhole_shard', 'baker'), 'mapName' => $map['name']]) }}" 
                                variant="outline"
                                class="h-auto py-3 px-3 block text-left group hover:scale-105"
                            >
                                <div class="flex items-start justify-between mb-2">
                                    <h2 class="text-xs font-bold text-[#e8e8d5] group-hover:text-[#5a9c69] transition-colors leading-tight tracking-wider">{{ $map['display_name'] }}</h2>
                                    <svg class="w-3 h-3 text-[#8b9d83] group-hover:text-[#5a9c69] flex-shrink-0 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-[#8b9d83]">STRUCTURES</span>
                                        <x-ui.badge variant="success" class="text-xs">{{ $map['icon_count'] }}</x-ui.badge>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-[#8b9d83]">FACTIONS</span>
                                        <x-ui.badge variant="secondary" class="text-xs">{{ $map['team_count'] }}</x-ui.badge>
                                    </div>
                                </div>
                            </x-ui.button>
                        @endforeach
                    </div>
                    
                    @if(empty($maps))
                        <div class="text-center py-12">
                            <div class="inline-block border-4 border-[#7c6a3a] bg-[#0f140f] p-8">
                                <svg class="w-16 h-16 text-[#7c6a3a] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-[#e8e8d5] text-lg mb-2 font-bold tracking-wider">NO OPERATIONAL DATA</p>
                                <p class="text-[#8b9d83] text-sm">Execute sync command to retrieve intelligence</p>
                            </div>
                        </div>
                    @endif
                </x-ui.card-content>
            </x-ui.card>
        </div>
    </div>
</div>
</div>
