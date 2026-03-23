<div>
    <!-- Shard Selector + Back Button (fixed, don't affect layout) -->
    <x-shard-selector />


    <!-- Page wrapper: full viewport height, flex column — no scrolling -->
    <div class="bg-[#1a1f1a] text-[#e8e8d5] flex flex-col overflow-hidden relative"
         style="height: 100vh; height: 100dvh;">

        <!-- Diagonal stripe background -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>

        <!-- Title bar (compact on mobile) -->
        <div class="flex-shrink-0 relative z-10 border-b border-[#4a7c59]/30 bg-[#0f140f]/80">
            <div class="max-w-5xl mx-auto px-3 sm:px-6 py-1.5 sm:py-2 flex items-center justify-between">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="border border-[#4a7c59] px-1.5 sm:px-2 py-0.5">
                        <span class="text-[9px] sm:text-[10px] font-bold tracking-[0.2em] sm:tracking-[0.25em] text-[#4a7c59] uppercase">Classified</span>
                    </div>
                    <span class="hidden sm:inline text-[10px] text-[#4a7c59]/60 tracking-widest uppercase">intel brief · sector</span>
                </div>
                <span class="text-[9px] sm:text-[10px] text-[#8b9d83] tracking-widest uppercase">
                    Shard — {{ strtoupper(session('foxhole_shard', 'baker')) }}
                </span>
            </div>
        </div>

        <!-- Sector name (compact on mobile) -->
        <div class="flex-shrink-0 relative z-10 max-w-5xl w-full mx-auto px-3 sm:px-6 pt-2 sm:pt-3 pb-1 sm:pb-2">
            <h1 class="text-base sm:text-2xl font-black tracking-[0.15em] text-[#e8e8d5] uppercase leading-none">
                {{ str_replace('Hex', '', $selectedMap) }}
            </h1>
            <div class="flex items-center gap-3 mt-0.5 sm:mt-1">
                <div class="h-px flex-1 bg-gradient-to-r from-[#4a7c59] to-transparent"></div>
                <span class="text-[9px] sm:text-[10px] tracking-[0.3em] text-[#4a7c59] uppercase">Tactical Sector Map</span>
                <div class="h-px w-8 bg-[#4a7c59]/30"></div>
            </div>
        </div>

        <!-- Offline shard notice -->
        @if($shardOffline)
        <div class="flex-shrink-0 relative z-10 max-w-5xl w-full mx-auto px-3 sm:px-6 pb-1 sm:pb-2">
            <div class="flex items-center gap-2 border border-yellow-600/50 bg-yellow-900/20 px-3 py-1.5 sm:py-2">
                <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <span class="text-[10px] sm:text-xs text-yellow-400 tracking-wide uppercase">
                    Shard <strong>{{ strtoupper(session('foxhole_shard', 'baker')) }}</strong> is currently offline
                </span>
            </div>
        </div>
        @endif

        <!-- Map section: grows to fill all remaining height -->
        <div id="map-section" class="flex-1 min-h-0 relative z-10 flex items-center justify-center p-0 sm:p-4">
            <!-- map-wrapper is sized to the largest square that fits by JS -->
            <div id="map-wrapper" class="relative flex-shrink-0 sm-map-border">

                <!-- Map container: touch-action none so we own all touch gestures -->
                <div id="map-container" class="relative overflow-hidden"
                     style="width: 100%; height: 100%; background: #050a05; touch-action: none;">

                    <!-- Scanline overlay (fixed, outside map-inner so it doesn't scale) -->
                    <div class="absolute inset-0 pointer-events-none"
                         style="z-index: 20; background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0,0,0,0.06) 3px, rgba(0,0,0,0.06) 4px);"></div>

                    @php
                        $imageNameMap = [
                            'TheFingersHex' => 'FingersHex',
                            'MooringCountyHex' => 'MoorsHex',
                            'OarbreakerHex' => 'OarbreakerIslesHex',
                            'MarbanHollow' => 'MarbanHollowHex',
                            'DeadLandsHex' => 'DeadlandsHex',
                        ];

                        if (str_starts_with($selectedMap, 'HomeRegion')) {
                            $imageMapName = $selectedMap;
                        } elseif (isset($imageNameMap[$selectedMap])) {
                            $imageMapName = $imageNameMap[$selectedMap];
                        } else {
                            $imageMapName = str_ends_with($selectedMap, 'Hex') ? $selectedMap : $selectedMap . 'Hex';
                        }
                    @endphp

                    <!-- Inner div: receives pan/zoom CSS transform -->
                    <div id="map-inner"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; transform-origin: 0 0; z-index: 5;">

                        <img id="map-image"
                             src="{{ asset('images/Map' . $imageMapName . '.png') }}"
                             alt="{{ $selectedMap }}"
                             style="display: block; height: 100%; width: auto; max-width: 100%; object-fit: contain; user-select: none; -webkit-user-select: none; pointer-events: none;"
                             onerror="this.onerror=null; this.src='{{ asset('images/Map' . $imageMapName . '.webp') }}'">

                        <!-- Map icons (inside map-inner so they pan/zoom together with the image) -->
                        @foreach($towns as $town)
                            @php
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
                                 style="position: absolute; display: flex; flex-direction: column; align-items: center; cursor: pointer; z-index: 10;">
                                <!-- Name label -->
                                <div class="icon-label" style="background: {{ $labelBg }}; border: 1px solid {{ $labelBorder }}; color: {{ $labelText }}; font-size: 9px; font-weight: 700; letter-spacing: 0.05em; white-space: nowrap; padding: 1px 4px; margin-bottom: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.7); pointer-events: none; transition: transform 0.15s;">
                                    {{ $town['icon_name'] }}
                                </div>
                                <!-- Icon dot -->
                                <div class="icon-dot" style="width: 22px; height: 22px; background: {{ $town['team_color'] }}; border: 2px solid rgba(0,0,0,0.9); border-radius: {{ $town['shape'] === 'circle' ? '50%' : '3px' }}; box-shadow: 0 0 6px {{ $town['team_color'] }}55, 0 2px 4px rgba(0,0,0,0.8); flex-shrink: 0;"></div>
                            </div>
                        @endforeach

                    </div><!-- /map-inner -->
                </div><!-- /map-container -->
            </div><!-- /map-wrapper -->

            <!-- Zoom hint (mobile only, fades after first touch) -->
            <div id="zoom-hint" class="sm:hidden absolute bottom-16 left-1/2 -translate-x-1/2 pointer-events-none
                 flex items-center gap-1.5 bg-black/60 border border-[#4a7c59]/40 px-3 py-1.5 rounded-full
                 transition-opacity duration-500"
                 style="z-index: 50;">
                <svg class="w-3.5 h-3.5 text-[#4a7c59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                </svg>
                <span class="text-[10px] text-[#8b9d83] tracking-widest uppercase">Pinch to zoom · Double-tap to reset</span>
            </div>
        </div><!-- /map-section -->

    </div><!-- /page wrapper -->

    <script>
        // ── Pan / zoom state ────────────────────────────────────────────────
        let mapScale = 1, mapPanX = 0, mapPanY = 0;
        let isPanning = false;
        let panStartX = 0, panStartY = 0;
        let lastPinchDist = 0;
        let lastTapTime = 0;
        let hintDismissed = false;

        function applyMapTransform() {
            const inner = document.getElementById('map-inner');
            if (inner) {
                inner.style.transform = `translate(${mapPanX}px, ${mapPanY}px) scale(${mapScale})`;
            }
        }

        function resetMapTransform() {
            mapScale = 1; mapPanX = 0; mapPanY = 0;
            applyMapTransform();
        }

        function getTouchDist(touches) {
            const dx = touches[0].clientX - touches[1].clientX;
            const dy = touches[0].clientY - touches[1].clientY;
            return Math.sqrt(dx * dx + dy * dy);
        }

        function dismissHint() {
            if (hintDismissed) return;
            hintDismissed = true;
            const hint = document.getElementById('zoom-hint');
            if (hint) hint.style.opacity = '0';
        }

        // ── Size map-wrapper to the largest square fitting in map-section ──
        function sizeMapWrapper() {
            const section = document.getElementById('map-section');
            const wrapper = document.getElementById('map-wrapper');
            if (!section || !wrapper) return;

            const rect   = section.getBoundingClientRect();
            const isMob  = window.innerWidth < 640;
            const pad    = isMob ? 0 : 16;
            const size   = Math.max(0, Math.min(rect.width - pad * 2, rect.height - pad * 2));

            wrapper.style.width  = size + 'px';
            wrapper.style.height = size + 'px';
        }

        // ── Position map icons using image rect relative to map-inner ──────
        function positionMapIcons() {
            const img   = document.getElementById('map-image');
            const inner = document.getElementById('map-inner');
            if (!img || !inner) return;

            // Temporarily clear transform so getBoundingClientRect reflects true layout
            const saved = inner.style.transform;
            inner.style.transform = 'none';

            // Reading layout forces a synchronous reflow — values are accurate
            const imgRect   = img.getBoundingClientRect();
            const innerRect = inner.getBoundingClientRect();

            inner.style.transform = saved;

            const offsetLeft = imgRect.left - innerRect.left;
            const offsetTop  = imgRect.top  - innerRect.top;
            const imgWidth   = img.offsetWidth;
            const imgHeight  = img.offsetHeight;

            document.querySelectorAll('.map-icon').forEach((icon) => {
                const x       = parseFloat(icon.dataset.x) || 0;
                const y       = parseFloat(icon.dataset.y) || 0;
                const dot     = icon.querySelector('.icon-dot');
                const dotHalf = dot ? dot.offsetHeight / 2 : 11;
                const labelH  = dot ? (icon.offsetHeight - dot.offsetHeight) : 0;
                icon.style.left      = (offsetLeft + x * imgWidth) + 'px';
                icon.style.top       = (offsetTop  + y * imgHeight) + 'px';
                icon.style.transform = `translate(-50%, calc(-${labelH}px - ${dotHalf}px))`;
            });
        }

        // ── Touch events: pinch-to-zoom + drag-to-pan + double-tap reset ──
        const container = document.getElementById('map-container');

        container.addEventListener('touchstart', (e) => {
            e.preventDefault();
            dismissHint();

            if (e.touches.length === 2) {
                lastPinchDist = getTouchDist(e.touches);
                isPanning = false;
            } else if (e.touches.length === 1) {
                const now = Date.now();
                if (now - lastTapTime < 300) {
                    // Double-tap → reset zoom
                    resetMapTransform();
                }
                lastTapTime = now;
                isPanning  = true;
                panStartX  = e.touches[0].clientX - mapPanX;
                panStartY  = e.touches[0].clientY - mapPanY;
            }
        }, { passive: false });

        container.addEventListener('touchmove', (e) => {
            e.preventDefault();

            if (e.touches.length === 2) {
                const dist = getTouchDist(e.touches);
                if (lastPinchDist > 0) {
                    const delta = dist / lastPinchDist;
                    const midX  = (e.touches[0].clientX + e.touches[1].clientX) / 2;
                    const midY  = (e.touches[0].clientY + e.touches[1].clientY) / 2;
                    const cRect = container.getBoundingClientRect();

                    // Content coordinates under the pinch midpoint
                    const cx = (midX - cRect.left - mapPanX) / mapScale;
                    const cy = (midY - cRect.top  - mapPanY) / mapScale;

                    mapScale = Math.min(8, Math.max(0.8, mapScale * delta));

                    // Keep the pinch midpoint stationary
                    mapPanX = (midX - cRect.left) - cx * mapScale;
                    mapPanY = (midY - cRect.top)  - cy * mapScale;
                }
                lastPinchDist = dist;
                applyMapTransform();

            } else if (e.touches.length === 1 && isPanning) {
                mapPanX = e.touches[0].clientX - panStartX;
                mapPanY = e.touches[0].clientY - panStartY;
                applyMapTransform();
            }
        }, { passive: false });

        container.addEventListener('touchend', (e) => {
            if (e.touches.length < 2) lastPinchDist = 0;
            if (e.touches.length === 0) isPanning = false;
        });

        // ── Mouse wheel zoom (desktop bonus) ───────────────────────────────
        container.addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = e.deltaY > 0 ? 0.9 : 1.1;
            const cRect = container.getBoundingClientRect();
            const cx    = (e.clientX - cRect.left - mapPanX) / mapScale;
            const cy    = (e.clientY - cRect.top  - mapPanY) / mapScale;
            mapScale    = Math.min(8, Math.max(0.8, mapScale * delta));
            mapPanX     = (e.clientX - cRect.left) - cx * mapScale;
            mapPanY     = (e.clientY - cRect.top)  - cy * mapScale;
            applyMapTransform();
        }, { passive: false });

        // ── Init & responsive handlers ──────────────────────────────────────
        function initMap() {
            sizeMapWrapper();
            positionMapIcons();
        }

        document.getElementById('map-image').addEventListener('load', initMap);

        window.addEventListener('load', initMap);
        window.addEventListener('resize', () => {
            sizeMapWrapper();
            resetMapTransform();
            positionMapIcons();
        });

        if (document.getElementById('map-image')?.complete) {
            setTimeout(initMap, 50);
        }
    </script>

    <style>
        @media (min-width: 640px) {
            .sm-map-border {
                box-shadow: 0 0 0 2px #1a2a1a, 0 0 0 4px #2a4a2a, 0 0 40px rgba(74,124,89,0.12);
            }
        }
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
