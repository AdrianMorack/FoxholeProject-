<div class="space-y-4">
    <!-- Header with Back Button -->
    <div class="flex items-center gap-3">
        <a href="{{ route('map.list', ['shard' => session('foxhole_shard', 'baker')]) }}" wire:navigate class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white text-sm rounded-lg transition-colors border border-slate-700">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
            </svg>
            Back
        </a>
        <h1 class="text-xl font-bold text-white">{{ str_replace('Hex', ' Hex', $selectedMap) }}</h1>
    </div>

    <!-- Map Container with proper background -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg p-6 border border-slate-700 shadow-xl">
        <div id="map-root" class="relative w-full mx-auto" style="max-width: 800px;">
            <!-- Root container: centers map on page, max width 800px -->

            <!-- Map Container -->
            <div id="map-container" class="relative w-full" style="background: #1e293b; border-radius: 8px; overflow: hidden;">
                <!-- Container for the map image and icons. Relative positioning allows icons to be absolutely positioned -->

                <!-- Map Image -->
                @php
                    // HomeRegion files don't have 'Hex' suffix, others do
                    if (str_starts_with($selectedMap, 'HomeRegion')) {
                        $imageMapName = $selectedMap;
                    } else {
                        $imageMapName = str_ends_with($selectedMap, 'Hex') ? $selectedMap : $selectedMap . 'Hex';
                    }
                @endphp
                <img id="map-image"
                     src="{{ asset('images/Map' . $imageMapName . '.png') }}"
                     alt="{{ $selectedMap }}"
                     class="w-full h-auto object-contain"
                     style="user-drag: none; user-select: none; display: block; margin: 0 auto;"
                     onload="positionMapIcons()"
                     onerror="this.onerror=null; this.src='{{ asset('images/Map' . $imageMapName . '.webp') }}'">
                <!-- The map image itself. Will try .png first, fallback to .webp if not found -->

                <!-- Town / Hex Icons -->
                @foreach($towns as $town)
                    <div class="map-icon"
                         data-x="{{ $town['x'] }}"
                         data-y="{{ $town['y'] }}"
                         data-team-color="{{ $town['team_color'] }}"
                         data-icon-type="{{ $town['icon_type'] }}"
                         data-icon-name="{{ $town['icon_name'] }}"
                         title="{{ $town['icon_name'] }} - {{ $town['team_id'] }}"
                         style="position: absolute; width: 24px; height: 24px; background: {{ $town['team_color'] }}; border: 3px solid rgba(0,0,0,0.8); border-radius: 4px; cursor: pointer; transition: transform 0.2s; z-index: 999; box-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    </div>
                @endforeach
                <!-- Each town/hex becomes an icon. x and y are normalized 0-1 coordinates. -->
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

            const icons = document.querySelectorAll('.map-icon');

            icons.forEach((icon) => {
                const x = parseFloat(icon.dataset.x) || 0;
                const y = parseFloat(icon.dataset.y) || 0;

                icon.style.left = (offsetLeft + x * imgWidth) + 'px';
                icon.style.top  = (offsetTop + y * imgHeight) + 'px';
                icon.style.transform = 'translate(-50%, -50%)';
            });
        }

        // Run on load and resize
        window.addEventListener('load', positionMapIcons);
        window.addEventListener('resize', positionMapIcons);
        
        // Run immediately in case image is cached
        if (document.getElementById('map-image')?.complete) {
            setTimeout(positionMapIcons, 100);
        }
    </script>

    <style>
        .map-icon:hover {
            transform: translate(-50%, -50%) scale(1.4) !important;
            z-index: 1000 !important;
        }
    </style>
</div>
