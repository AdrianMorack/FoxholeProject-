<div>
    <!-- Shard Selector + Back Button (fixed, don't affect layout) -->
    <x-shard-selector />
    <x-back-button />

    <!-- Page wrapper: matches other pages -->
    <div class="min-h-screen bg-[#1a1f1a] text-[#e8e8d5] relative">

        <!-- Diagonal stripe background (same as home/war-status) -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>

        <div class="relative z-10 flex flex-col" style="min-height: 100vh;">

            <!-- Title bar -->
            <div class="flex-shrink-0 border-b border-[#4a7c59]/30 bg-[#0f140f]/80">
                <div class="max-w-5xl mx-auto px-6 py-2 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="border border-[#4a7c59] px-2 py-0.5">
                            <span class="text-[10px] font-bold tracking-[0.25em] text-[#4a7c59] uppercase">Classified</span>
                        </div>
                        <span class="text-[10px] text-[#4a7c59]/60 tracking-widest uppercase">intel brief · sector</span>
                    </div>
                    <span class="text-[10px] text-[#8b9d83] tracking-widest uppercase">
                        Shard — {{ strtoupper(session('foxhole_shard', 'baker')) }}
                    </span>
                </div>
            </div>

            <!-- Sector name -->
            <div class="flex-shrink-0 max-w-5xl w-full mx-auto px-6 pt-3 pb-2">
                <h1 class="text-2xl font-black tracking-[0.15em] text-[#e8e8d5] uppercase leading-none">
                    {{ str_replace('Hex', '', $selectedMap) }}
                </h1>
                <div class="flex items-center gap-3 mt-1">
                    <div class="h-px flex-1 bg-gradient-to-r from-[#4a7c59] to-transparent"></div>
                    <span class="text-[10px] tracking-[0.3em] text-[#4a7c59] uppercase">Tactical Sector Map</span>
                    <div class="h-px w-8 bg-[#4a7c59]/30"></div>
                </div>
            </div>

            <!-- Map: fixed height so it never causes scrolling -->
            <!-- Title bar ~37px + sector name ~52px + top/bottom padding ~32px = ~121px -->
            <div class="flex-shrink-0 flex items-center justify-center px-6 pb-4" style="height: calc(100vh - 121px);">
                <div class="relative" style="height: 100%; max-width: min(100%, calc((100vh - 121px)));  box-shadow: 0 0 0 2px #1a2a1a, 0 0 0 4px #2a4a2a, 0 0 40px rgba(74,124,89,0.12);">

                    <!-- Map container -->
                    <div id="map-container" class="relative" style="height: 100%; background: #050a05; overflow: hidden;">

                        <!-- Scanline overlay -->
                        <div class="absolute inset-0 pointer-events-none z-10" style="background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0,0,0,0.06) 3px, rgba(0,0,0,0.06) 4px);"></div>

                        @php
                            $imageNameMap = [
                                'TheFingersHex' => 'FingersHex',
                                'MooringCountyHex' => 'MoorsHex',
                                'OarbreakerHex' => 'OarbreakerIslesHex',
                                'MarbanHollow' => 'MarbanHollowHex',
                            ];

                            if (str_starts_with($selectedMap, 'HomeRegion')) {
                                $imageMapName = $selectedMap;
                            } elseif (isset($imageNameMap[$selectedMap])) {
                                $imageMapName = $imageNameMap[$selectedMap];
                            } else {
                                $imageMapName = str_ends_with($selectedMap, 'Hex') ? $selectedMap : $selectedMap . 'Hex';
                            }
                        @endphp

                        <img id="map-image"
                             src="{{ asset('images/Map' . $imageMapName . '.png') }}"
                             alt="{{ $selectedMap }}"
                             style="display: block; height: 100%; width: auto; max-width: 100%; object-fit: contain; user-select: none;"
                             onload="positionMapIcons()"
                             onerror="this.onerror=null; this.src='{{ asset('images/Map' . $imageMapName . '.webp') }}'">

                        <!-- Map icons -->
                        @foreach($towns as $town)
                            <div class="map-icon"
                                 data-x="{{ $town['x'] }}"
                                 data-y="{{ $town['y'] }}"
                                 data-team-color="{{ $town['team_color'] }}"
                                 data-icon-type="{{ $town['icon_type'] }}"
                                 data-icon-name="{{ $town['icon_name'] }}"
                                 title="{{ $town['icon_name'] }} — {{ $town['team_id'] }}"
                                 style="position: absolute; width: 22px; height: 22px; background: {{ $town['team_color'] }}; border: 2px solid rgba(0,0,0,0.9); border-radius: {{ $town['shape'] === 'circle' ? '50%' : '3px' }}; cursor: pointer; transition: transform 0.15s; z-index: 999; box-shadow: 0 0 6px {{ $town['team_color'] }}55, 0 2px 4px rgba(0,0,0,0.8);">
                            </div>
                        @endforeach

                        <!-- HUD: bottom-left legend -->
                        <div class="absolute bottom-0 left-0 z-20 m-3 bg-[#0f140f]/85 backdrop-blur-sm border border-[#4a7c59]/40 px-3 py-2">
                            <p class="text-[9px] tracking-[0.25em] text-[#4a7c59] uppercase mb-1.5">Legend</p>
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-sm flex-shrink-0" style="background:#4488cc; box-shadow: 0 0 4px #4488cc88;"></span>
                                    <span class="text-[10px] text-[#a8b8a0] tracking-wide uppercase">Warden</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-sm flex-shrink-0" style="background:#cc5544; box-shadow: 0 0 4px #cc554488;"></span>
                                    <span class="text-[10px] text-[#a8b8a0] tracking-wide uppercase">Colonial</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:#666; box-shadow: 0 0 4px #66666655;"></span>
                                    <span class="text-[10px] text-[#a8b8a0] tracking-wide uppercase">Neutral</span>
                                </div>
                            </div>
                        </div>

                        <!-- HUD: top-right live indicator -->
                        <div class="absolute top-0 right-0 z-20 m-3 flex items-center gap-1.5 bg-[#0f140f]/85 backdrop-blur-sm border border-[#4a7c59]/40 px-2.5 py-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#4a7c59] animate-pulse"></span>
                            <span class="text-[9px] tracking-[0.2em] text-[#4a7c59] uppercase">Live</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function positionMapIcons() {
            const img = document.getElementById('map-image');
            const container = document.getElementById('map-container');

            if (!img || !container) return;

            const imgRect = img.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            const offsetLeft = imgRect.left - containerRect.left;
            const offsetTop = imgRect.top - containerRect.top;

            const imgWidth = img.offsetWidth;
            const imgHeight = img.offsetHeight;

            document.querySelectorAll('.map-icon').forEach((icon) => {
                const x = parseFloat(icon.dataset.x) || 0;
                const y = parseFloat(icon.dataset.y) || 0;
                icon.style.left = (offsetLeft + x * imgWidth) + 'px';
                icon.style.top  = (offsetTop + y * imgHeight) + 'px';
                icon.style.transform = 'translate(-50%, -50%)';
            });
        }

        window.addEventListener('load', positionMapIcons);
        window.addEventListener('resize', positionMapIcons);

        if (document.getElementById('map-image')?.complete) {
            setTimeout(positionMapIcons, 100);
        }
    </script>

    <style>
        .map-icon:hover {
            transform: translate(-50%, -50%) scale(1.5) !important;
            z-index: 1000 !important;
        }
    </style>
</div>
