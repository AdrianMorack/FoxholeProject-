<div id="map-root" class="relative w-full max-w-[1000px] mx-auto">
    <!-- Root container: centers map on page, max width 1000px -->

    <!-- Map Container -->
    <div id="map-container" class="relative w-full" style="background: #eee;">
        <!-- Container for the map image and icons. Relative positioning allows icons to be absolutely positioned -->

        <!-- Map Image -->
        <img id="map-image"
             src="{{ asset('images/FoxholeMap.png') }}"
             alt="Foxhole Map"
             class="w-full h-auto object-contain"
             style="user-drag: none; user-select: none; display: block; margin: auto;">
        <!-- The map image itself. 'object-contain' ensures it keeps its aspect ratio. -->

        <!-- Town / Hex Icons -->
        @foreach($towns as $town)
            <div class="map-icon"
                 data-x="{{ $town['x'] }}"
                 data-y="{{ $town['y'] }}"
                 data-team-color="{{ $town['team_color'] }}"
                 data-icon-type="{{ $town['icon_type'] }}"
                 data-icon-name="{{ $town['icon_name'] }}"
                 title="{{ $town['icon_name'] }} - {{ $town['team_id'] }}">
            </div>
        @endforeach
        <!-- Each town/hex becomes an icon. x and y are normalized 0-1 coordinates. -->
    </div>



    @push('scripts')
    <script>
        // Function to create icon SVG based on type
        function createIconSVG(iconType, teamColor) {
            const size = 20;
            let svg = `<svg width="${size}" height="${size}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">`;
            
            // Different icons for different types
            if (iconType == 56) { // Town Hall
                svg += `<rect x="4" y="8" width="16" height="14" fill="${teamColor}" stroke="black" stroke-width="1.5"/>
                        <polygon points="12,2 4,8 20,8" fill="${teamColor}" stroke="black" stroke-width="1.5"/>
                        <rect x="10" y="15" width="4" height="7" fill="#654321"/>`;
            } else if (iconType == 57) { // Relic Base
                svg += `<circle cx="12" cy="12" r="8" fill="${teamColor}" stroke="black" stroke-width="2"/>
                        <path d="M12 6 L15 10 L12 14 L9 10 Z" fill="gold" stroke="black" stroke-width="1"/>`;
            } else if (iconType == 58) { // Keep
                svg += `<rect x="6" y="8" width="12" height="12" fill="${teamColor}" stroke="black" stroke-width="2"/>
                        <rect x="4" y="6" width="4" height="6" fill="${teamColor}" stroke="black" stroke-width="1.5"/>
                        <rect x="16" y="6" width="4" height="6" fill="${teamColor}" stroke="black" stroke-width="1.5"/>`;
            } else {
                // Default icon
                svg += `<circle cx="12" cy="12" r="6" fill="${teamColor}" stroke="black" stroke-width="2"/>`;
            }
            
            svg += '</svg>';
            return svg;
        }

        // Function to position icons over the map
        function positionIcons() {
            const img = document.getElementById('map-image');
            const container = document.getElementById('map-container');
            
            if (!img || !container) {
                console.error('Missing img or container');
                return;
            }

            // Get the actual image position and size
            const imgRect = img.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            
            // Calculate offset from container to image
            const offsetLeft = imgRect.left - containerRect.left;
            const offsetTop = imgRect.top - containerRect.top;
            
            const imgWidth = img.offsetWidth;
            const imgHeight = img.offsetHeight;
            
            console.log('Image:', imgWidth, 'x', imgHeight);
            console.log('Offset:', offsetLeft, offsetTop);

            const icons = document.querySelectorAll('.map-icon');
            console.log('Found', icons.length, 'icons');

            icons.forEach((icon, idx) => {
                const x = parseFloat(icon.dataset.x) || 0;
                const y = parseFloat(icon.dataset.y) || 0;
                const iconType = parseInt(icon.dataset.iconType) || 0;
                const teamColor = icon.dataset.teamColor || '#ff0000';

                icon.style.position = 'absolute';
                icon.style.left = (offsetLeft + x * imgWidth) + 'px';
                icon.style.top  = (offsetTop + y * imgHeight) + 'px';
                icon.style.transform = 'translate(-50%, -50%)';
                icon.style.zIndex = '999';
                icon.style.cursor = 'pointer';
                icon.style.width = '30px';
                icon.style.height = '30px';
                icon.style.background = teamColor;
                icon.style.border = '2px solid black';
                icon.style.borderRadius = '4px';
                icon.style.display = 'block';
            });
            
            console.log('Positioning complete');
        }

        // Initialize icons when page loads
        function initIcons() {
            const img = document.getElementById('map-image');

            if (img.complete && img.naturalWidth > 0) {
                positionIcons();
            } else {
                img.onload = positionIcons;
            }

            window.addEventListener('resize', () => requestAnimationFrame(positionIcons));
            window.addEventListener('scroll', () => requestAnimationFrame(positionIcons));
        }

        // Run when Livewire finishes loading or fallback DOM ready
        document.addEventListener('livewire:load', initIcons);
        document.addEventListener('DOMContentLoaded', initIcons);

    </script>
    @endpush

    <style>
        .map-icon {
            pointer-events: auto;
            transition: transform 0.2s;
        }
        .map-icon:hover {
            transform: translate(-50%, -50%) scale(1.3) !important;
            z-index: 20 !important;
        }
    </style>
</div>
