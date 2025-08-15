<style>
    /* ====== Container for map buttons ====== */
    .map-buttons {
        display: flex;       /* Use flexbox to line up buttons */
        flex-wrap: wrap;     /* Allow buttons to move to next line if needed */
        gap: 8px;            /* Space between buttons */
    }
    
    /* ====== Individual map button styling ====== */
    .map-button {
        padding: 8px 12px;   /* Add vertical + horizontal padding */
        background-color: #002fff; /* Blue background */
        border: none;        /* Remove default button border */
        color: white;        /* White text */
        border-radius: 4px;  /* Rounded corners */
        cursor: pointer;     /* Show pointer cursor on hover */
    }
    
    /* ====== Hover state ====== */
    .map-button:hover {
        background-color: #000000; /* Darken on hover */
    }
</style>

<div wire:poll.1s> <!-- ====== Livewire auto-refresh every 1 second ====== -->

    <h2>Available Maps</h2> <!-- Title -->

    @if (!empty($mapNames))
        <!-- ====== Display a list of maps as buttons ====== -->
        <ul class="map-buttons">
            @foreach ($mapNames as $map)
                <button 
                    type="button" 
                    wire:click="loadMapData('{{ $map }}')" <!-- Trigger Livewire method to load map data -->
                    class="map-button"                     <!-- Apply button styling -->
                >
                    {{ $map }} <!-- Display map name -->
                </button>
            @endforeach
        </ul>
    @else
        <!-- ====== Loading state if maps are not yet loaded ====== -->
        <p>Loading maps...</p>
    @endif

</div>
