<div id="map-root" class="relative w-full max-w-[1000px] mx-auto">
    <!-- Root container for the map. Centers map on page, max width 1000px. -->
    
    <!-- Map Container -->
    <div id="map-container" class="relative w-full" style="background: #eee;">
        <!-- Container for the map image and the dots. Relative positioning is needed so dots can be absolutely positioned inside -->

        <!-- Map Image -->
        <img id="map-image"
             src="{{ asset('images/FoxholeMap.png') }}"
             alt="Foxhole Map"
             class="w-full h-auto object-contain"
             style="user-drag: none; user-select: none; display: block; margin: auto;">
        <!-- Map image itself, scaled to container width. "object-contain" keeps aspect ratio, centered horizontally -->

        <!-- Town / Hex Dots -->
        @foreach($towns as $town)
            <div class="map-dot"
                 data-x="{{ $town['x'] }}"
                 data-y="{{ $town['y'] }}">
            </div>
        @endforeach
        <!-- Create a dot for each town. x and y are normalized 0-1 positions relative to the map. No fixed size yet, handled in JS -->
    </div>

    @push('scripts')
    <script>
        function positionDots() {
            // Grab the map image
            const img = document.getElementById('map-image');
            if (!img) return; // safety check

            // Get image position and size on the page
            const imgRect = img.getBoundingClientRect();

            // Loop over all dots and position them
            document.querySelectorAll('.map-dot').forEach(dot => {
                const x = parseFloat(dot.dataset.x) || 0; // fallback to 0
                const y = parseFloat(dot.dataset.y) || 0; // fallback to 0

                const dotSize = 10; // fixed dot size in pixels, change this to make dots bigger/smaller

                // Absolute positioning relative to image
                dot.style.position = 'absolute';
                dot.style.left = imgRect.left + window.scrollX + x * img.width + 'px';
                dot.style.top  = imgRect.top  + window.scrollY + y * img.height + 'px';
                dot.style.width = dotSize + 'px';
                dot.style.height = dotSize + 'px';

                // Dot styling
                dot.style.backgroundColor = 'red'; // can change color later
                dot.style.borderRadius = '50%'; // make circle
                dot.style.border = '1px solid black';
                dot.style.opacity = '0.8';
                dot.style.transform = 'translate(-50%, -50%)'; // center the dot exactly at x,y
                dot.style.zIndex = 10; // above map image
            });
        }

        function initDots() {
            // Grab map image
            const img = document.getElementById('map-image');

            // If image already loaded, position dots immediately, otherwise wait for onload
            if (img.complete && img.naturalWidth > 0) {
                positionDots();
            } else {
                img.onload = positionDots;
            }

            // Reposition dots if window resized or scrolled
            window.addEventListener('resize', () => requestAnimationFrame(positionDots));
            window.addEventListener('scroll', () => requestAnimationFrame(positionDots));
        }

        // Run initDots when Livewire finishes loading or as fallback when DOM ready
        document.addEventListener('livewire:load', initDots);
        document.addEventListener('DOMContentLoaded', initDots); 
    </script>
    @endpush

    <style>
        .map-dot {
            pointer-events: auto; /* so dots can receive clicks later if needed */
        }
    </style>
</div>
