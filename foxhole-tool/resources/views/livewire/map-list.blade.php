<div>
    <!-- Shard Selector -->
    <x-shard-selector />
    <x-back-button />
    
    <div class="min-h-screen bg-[#1a1f1a] text-[#e8e8d5]">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>

    <div class="relative z-10">
        <!-- Header -->
        <header class="border-b-4 border-[#3a5a7c] bg-[#0f140f] shadow-2xl sticky top-0 z-20">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <x-ui.button href="{{ route('home.page', ['shard' => session('foxhole_shard', 'baker')]) }}" variant="ghost" class="gap-2">
                            <!-- ArrowLeft Icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            RETURN TO HQ
                        </x-ui.button>
                    </div>
                    <h1 class="text-2xl font-bold tracking-wider">TACTICAL WAR MAP</h1>
                    <div class="flex-1 flex items-center justify-end gap-2">
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
            
            
        </div>
    </div>
    </div>
</div>
</div>
