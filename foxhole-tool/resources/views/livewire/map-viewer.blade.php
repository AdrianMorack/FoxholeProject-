<div id="map-root" class="relative w-full max-w-[1000px] mx-auto">
    <!-- Root container: centers map on page, max width 1000px -->

    <!-- Map Container -->
    <div id="map-container" class="relative w-full" style="background: #eee;">
        <!-- Container for the map image and dots. Relative positioning allows dots to be absolutely positioned -->

        <!-- Map Image -->
        <img id="map-image"
             src="{{ asset('images/FoxholeMap.png') }}"
             alt="Foxhole Map"
             class="w-full h-auto object-contain"
             style="user-drag: none; user-select: none; display: block; margin: auto;">
        <!-- The map image itself. 'object-contain' ensures it keeps its aspect ratio. -->

        <!-- Town / Hex Dots -->
        @foreach($towns as $town)
            <div class="map-dot"
                 data-x="{{ $town['x'] }}"
                 data-y="{{ $town['y'] }}"
                 data-team-color="{{ $town['team_color'] }}">
            </div>
        @endforeach
        <!-- Each town/hex becomes a dot. x and y are normalized 0-1 coordinates. -->
    </div>



    
    @push('scripts')
    <script>
        // Function to position dots over the map
        function positionDots() {
            const img = document.getElementById('map-image');
            if (!img) return; // safety check

            // Get the rendered image size and position
            const imgRect = img.getBoundingClientRect();

            document.querySelectorAll('.map-dot').forEach(dot => {
                const x = parseFloat(dot.dataset.x) || 0; // normalized x
                const y = parseFloat(dot.dataset.y) || 0; // normalized y
                const dotSize = 7; // fixed dot size in pixels (change to make bigger/smaller)

                dot.style.position = 'absolute';
                // Position relative to image top-left, including scroll offset
                dot.style.left = imgRect.left + window.scrollX + x * imgRect.width + 'px';
                dot.style.top  = imgRect.top  + window.scrollY + y * imgRect.height + 'px';

                // Dot styling
                dot.style.width = dotSize + 'px';
                dot.style.height = dotSize + 'px';
                dot.style.backgroundColor = dot.dataset.teamColor || '#ff0000';
                dot.style.borderRadius = '50%';
                dot.style.border = '1px solid black';
                dot.style.opacity = '0.8';
                dot.style.transform = 'translate(-50%, -50%)'; // center the dot exactly
                dot.style.zIndex = 10; // ensure dot is above the map
            });
        }

        // Initialize dots when page loads
        function initDots() {
            const img = document.getElementById('map-image');

            // If image already loaded, position dots immediately; otherwise wait for onload
            if (img.complete && img.naturalWidth > 0) {
                positionDots();
            } else {
                img.onload = positionDots;
            }

            // Reposition dots on window resize or scroll
            window.addEventListener('resize', () => requestAnimationFrame(positionDots));
            window.addEventListener('scroll', () => requestAnimationFrame(positionDots));
        }

        // Run when Livewire finishes loading or fallback DOM ready
        document.addEventListener('livewire:load', initDots);
        document.addEventListener('DOMContentLoaded', initDots);

    </script>
    @endpush

    <style>
        .map-dot {
            pointer-events: auto; /* allow clicks later if needed */
        }
    </style>
</div>
