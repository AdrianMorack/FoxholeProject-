<!-- ====== Styles for map buttons ====== -->
<style>
    /* Container for all map buttons: flexible row, wrap to new lines, gap between buttons */
    .map-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    /* Individual map button styling */
    .map-button {
        padding: 8px 12px;            /* Space inside the button */
        background-color: #002fff;     /* Blue background */
        border: none;                  /* Remove default button border */
        color: white;                  /* White text */
        border-radius: 4px;            /* Rounded corners */
        cursor: pointer;               /* Pointer cursor on hover */
    }
    
    /* Hover effect for buttons */
    .map-button:hover {
        background-color: #000000;     /* Darken background on hover */
    }
</style>

<!-- ====== Main container that polls Livewire component every 1 second ====== -->
<div wire:poll.1s>

    <!-- Heading for available maps -->
    <h2>Available Maps</h2>

    <!-- Check if mapNames array is not empty -->
    @if (!empty($mapNames))
        <ul>
            <!-- Loop over each map name -->
            @foreach ($mapNames as $map)
                <!-- Button to load map data via Livewire click event -->
                <button type="button" wire:click="loadMapData('{{ $map }}')" class="map-button">
                    {{ $map }} <!-- Display the map name on the button -->
                </button>
            @endforeach
        </ul>
    @else
        <!-- Show loading message if mapNames is empty -->
        <p>Loading maps...</p>
    @endif

</div>