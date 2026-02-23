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

            <!-- Offline shard notice -->
            @if($shardOffline)
            <div class="flex-shrink-0 max-w-5xl w-full mx-auto px-6 pb-2">
                <div class="flex items-center gap-2 border border-yellow-600/50 bg-yellow-900/20 px-3 py-2">
                    <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <span class="text-xs text-yellow-400 tracking-wide uppercase">
                        Shard <strong>{{ strtoupper(session('foxhole_shard', 'baker')) }}</strong> is currently offline
                    </span>
                </div>
            </div>
            @endif

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
                            @php
                                // Label colours per faction
                                $labelBg = match($town['team_id']) {
                                    'WARDENS'   => '#1a3d5c',
                                    'COLONIALS' => '#3a5c35',
                                    default     => '#888888',
                                };
                                $labelBorder = match($town['team_id']) {
                                    'WARDENS'   => '#4488cc',
                                    'COLONIALS' => '#4a7c59',
                                    default     => '#555555',
                                };
                                $labelText = match($town['team_id']) {
                                    'WARDENS'   => '#ffffff',
                                    'COLONIALS' => '#000000',
                                    default     => '#000000',
                                };
                            @endphp
                            <div class="map-icon"
                                 data-x="{{ $town['x'] }}"
                                 data-y="{{ $town['y'] }}"
                                 data-team-color="{{ $town['team_color'] }}"
                                 data-icon-type="{{ $town['icon_type'] }}"
                                 data-icon-name="{{ $town['icon_name'] }}"
                                 title="{{ $town['icon_name'] }} ({{ $town['type_name'] }}) — {{ $town['team_id'] }}"
                                 style="position: absolute; display: flex; flex-direction: column; align-items: center; cursor: pointer; transition: transform 0.15s; z-index: 999;">
                                <!-- Name label -->
                                <div class="icon-label" style="background: {{ $labelBg }}; border: 1px solid {{ $labelBorder }}; color: {{ $labelText }}; font-size: 9px; font-weight: 700; letter-spacing: 0.05em; white-space: nowrap; padding: 1px 4px; margin-bottom: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.7); pointer-events: none; transition: transform 0.15s;">
                                    {{ $town['icon_name'] }}
                                </div>
                                <!-- Icon dot -->
                                <div class="icon-dot" style="width: 22px; height: 22px; background: {{ $town['team_color'] }}; border: 2px solid rgba(0,0,0,0.9); border-radius: {{ $town['shape'] === 'circle' ? '50%' : '3px' }}; box-shadow: 0 0 6px {{ $town['team_color'] }}55, 0 2px 4px rgba(0,0,0,0.8); flex-shrink: 0;"></div>
                            </div>
                        @endforeach
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
                const dot = icon.querySelector('.icon-dot');
                // Anchor the dot center to the coordinate; label floats above naturally
                const dotHalf = dot ? dot.offsetHeight / 2 : 11;
                const labelH  = dot ? (icon.offsetHeight - dot.offsetHeight) : 0;
                icon.style.left = (offsetLeft + x * imgWidth) + 'px';
                icon.style.top  = (offsetTop + y * imgHeight) + 'px';
                icon.style.transform = `translate(-50%, calc(-${labelH}px - ${dotHalf}px))`;
            });
        }

        window.addEventListener('load', positionMapIcons);
        window.addEventListener('resize', positionMapIcons);

        if (document.getElementById('map-image')?.complete) {
            setTimeout(positionMapIcons, 100);
        }
    </script>

    <style>
        .map-icon:hover .icon-dot {
            transform: scale(1.5);
        }
        .map-icon:hover .icon-label {
            transform: scale(1.1);
        }
        .icon-dot {
            transition: transform 0.15s;
        }
    </style>
</div>
