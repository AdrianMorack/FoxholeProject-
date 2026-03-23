<div>
    <!-- Shard Selector + Back Button -->
    <x-shard-selector />

    <!-- Full-viewport wrapper, no scrolling -->
    <div class="bg-[#1a1f1a] text-[#e8e8d5] flex flex-col overflow-hidden relative"
         style="height: 100vh; height: 100dvh;">

        <!-- Background -->
        <div class="absolute inset-0 opacity-10 pointer-events-none"
             style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>

        <!-- Compact header -->
        <header class="flex-shrink-0 relative z-10 border-b border-[#4a7c59]/30 bg-[#0f140f]/90">
            <div class="max-w-5xl mx-auto px-3 sm:px-6 py-1.5 sm:py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="border border-[#4a7c59] px-1.5 sm:px-2 py-0.5">
                        <span class="text-[9px] sm:text-[10px] font-bold tracking-[0.2em] text-[#4a7c59] uppercase">Classified</span>
                    </div>
                    <span class="hidden sm:inline text-[10px] text-[#4a7c59]/60 tracking-widest uppercase">theater overview</span>
                </div>
                <h1 class="text-sm sm:text-xl font-black tracking-[0.15em] text-[#e8e8d5] uppercase">Tactical War Map</h1>
                <span class="text-[9px] sm:text-[10px] text-[#8b9d83] tracking-widest uppercase">
                    {{ strtoupper(session('foxhole_shard', 'baker')) }}
                </span>
            </div>
        </header>

        <!-- Mobile hint bar -->
        <div class="sm:hidden flex-shrink-0 relative z-10 flex items-center justify-center gap-2 bg-[#0f140f]/60 py-1 border-b border-[#4a7c59]/20">
            <svg class="w-3 h-3 text-[#4a7c59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
            </svg>
            <span class="text-[10px] tracking-widest text-[#4a7c59] uppercase">Pinch to zoom · Tap a sector</span>
        </div>

        <!-- Map section: fills all remaining height -->
        <div id="map-section" class="flex-1 min-h-0 relative z-10 overflow-hidden">

            <!-- Clipping container; touch-action:none so we own all gestures -->
            <div id="map-container" class="absolute inset-0 overflow-hidden bg-[#050a05]"
                 style="touch-action: none;">

                <!-- Scanline overlay -->
                <div class="absolute inset-0 pointer-events-none"
                     style="z-index: 20; background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0,0,0,0.05) 3px, rgba(0,0,0,0.05) 4px);"></div>

                <!-- Pannable / zoomable inner — image + SVG move together -->
                <div id="map-inner"
                     style="position: absolute; top: 0; left: 0; width: 100%; transform-origin: 0 0; z-index: 5;">

                    <img id="map-image"
                         src="{{ asset('images/WorldMap.webp') }}"
                         alt="World Map"
                         class="w-full h-auto block"
                         style="opacity: 0.82; user-select: none; -webkit-user-select: none; pointer-events: none; display: block;"
                         onerror="this.onerror=null; this.src='{{ asset('images/FoxholeMap.png') }}'">

                    @include('partials.world-map-svg-overlay')
                </div>
            </div>

            <!-- Legend (bottom-center, desktop only) -->
            <div class="hidden sm:flex absolute bottom-3 left-1/2 -translate-x-1/2 items-center gap-4
                        bg-[#0f140f]/80 border border-[#4a7c59]/30 px-4 py-1.5 rounded"
                 style="z-index: 30;">
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-3 h-3 rounded-sm" style="background:rgba(30,64,175,0.6); border:1px solid rgba(59,130,246,0.8);"></span>
                    <span class="text-[10px] tracking-widest text-[#8b9d83] uppercase">Wardens</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-3 h-3 rounded-sm" style="background:rgba(22,101,52,0.6); border:1px solid rgba(34,197,94,0.8);"></span>
                    <span class="text-[10px] tracking-widest text-[#8b9d83] uppercase">Colonials</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-3 h-3 rounded-sm" style="background:rgba(156,163,175,0.25); border:1px solid rgba(74,124,89,0.7);"></span>
                    <span class="text-[10px] tracking-widest text-[#8b9d83] uppercase">Contested</span>
                </span>
            </div>
        </div><!-- /map-section -->

    </div><!-- /page wrapper -->

    <style>
        .hex-link { cursor: pointer; }
        .hex-region { transition: fill 0.15s, filter 0.15s; }
        .hex-link:hover .hex-region,
        .hex-link:active .hex-region {
            filter: brightness(1.5) drop-shadow(0 0 4px rgba(255,255,255,0.3));
            stroke-width: 5 !important;
        }
    </style>

    <script>
        // ── Pan / zoom state ─────────────────────────────────────────────
        let mapScale = 1, mapPanX = 0, mapPanY = 0;
        let isPanning = false, panStartX = 0, panStartY = 0;
        let lastPinchDist = 0, lastTapTime = 0;
        let touchMoved = false, touchStartX = 0, touchStartY = 0;

        const container = document.getElementById('map-container');
        const inner     = document.getElementById('map-inner');

        function applyTransform() {
            inner.style.transform = `translate(${mapPanX}px, ${mapPanY}px) scale(${mapScale})`;
        }

        function resetTransform() {
            mapScale = 1; mapPanX = 0; mapPanY = 0;
            applyTransform();
        }

        function pinchDist(t) {
            const dx = t[0].clientX - t[1].clientX;
            const dy = t[0].clientY - t[1].clientY;
            return Math.sqrt(dx * dx + dy * dy);
        }

        container.addEventListener('touchstart', (e) => {
            e.preventDefault();
            touchMoved = false;
            if (e.touches.length === 2) {
                lastPinchDist = pinchDist(e.touches);
                isPanning = false;
            } else if (e.touches.length === 1) {
                const now = Date.now();
                if (now - lastTapTime < 300) resetTransform();
                lastTapTime  = now;
                isPanning    = true;
                touchStartX  = e.touches[0].clientX;
                touchStartY  = e.touches[0].clientY;
                panStartX    = e.touches[0].clientX - mapPanX;
                panStartY    = e.touches[0].clientY - mapPanY;
            }
        }, { passive: false });

        container.addEventListener('touchmove', (e) => {
            e.preventDefault();
            if (e.touches.length === 2) {
                touchMoved = true;
                const dist  = pinchDist(e.touches);
                if (lastPinchDist > 0) {
                    const ratio = dist / lastPinchDist;
                    const midX  = (e.touches[0].clientX + e.touches[1].clientX) / 2;
                    const midY  = (e.touches[0].clientY + e.touches[1].clientY) / 2;
                    const cr    = container.getBoundingClientRect();
                    const cx    = (midX - cr.left - mapPanX) / mapScale;
                    const cy    = (midY - cr.top  - mapPanY) / mapScale;
                    mapScale    = Math.min(10, Math.max(0.8, mapScale * ratio));
                    mapPanX     = (midX - cr.left) - cx * mapScale;
                    mapPanY     = (midY - cr.top)  - cy * mapScale;
                }
                lastPinchDist = dist;
                applyTransform();
            } else if (e.touches.length === 1 && isPanning) {
                const dx = e.touches[0].clientX - touchStartX;
                const dy = e.touches[0].clientY - touchStartY;
                if (Math.abs(dx) > 6 || Math.abs(dy) > 6) touchMoved = true;
                mapPanX = e.touches[0].clientX - panStartX;
                mapPanY = e.touches[0].clientY - panStartY;
                applyTransform();
            }
        }, { passive: false });

        container.addEventListener('touchend', (e) => {
            // If the user just tapped (didn't pan), forward a synthetic click to the SVG element
            if (!touchMoved && e.changedTouches.length === 1) {
                const t    = e.changedTouches[0];
                const el   = document.elementFromPoint(t.clientX, t.clientY);
                if (el) {
                    const link = el.closest('a');
                    if (link) {
                        // SVG <a> elements have href as SVGAnimatedString, not a plain string
                        const href = link.getAttribute('href');
                        if (href) window.location.href = href;
                    }
                }
            }
            if (e.touches.length < 2) lastPinchDist = 0;
            if (e.touches.length === 0) isPanning = false;
        });

        // Mouse wheel zoom (desktop)
        container.addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = e.deltaY > 0 ? 0.9 : 1.1;
            const cr  = container.getBoundingClientRect();
            const cx  = (e.clientX - cr.left - mapPanX) / mapScale;
            const cy  = (e.clientY - cr.top  - mapPanY) / mapScale;
            mapScale  = Math.min(10, Math.max(0.8, mapScale * delta));
            mapPanX   = (e.clientX - cr.left) - cx * mapScale;
            mapPanY   = (e.clientY - cr.top)  - cy * mapScale;
            applyTransform();
        }, { passive: false });
    </script>
</div>
