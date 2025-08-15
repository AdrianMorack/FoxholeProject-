<style>
    .map-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .map-button {
        padding: 8px 12px;
        background-color: #002fff;
        border: none;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .map-button:hover {
        background-color: #000000;
    }
    </style>




<div wire:poll.1s>
    <h2>Available Maps</h2>

    @if (!empty($mapNames))
        <ul>
            @foreach ($mapNames as $map)
                <button 
                type="button" 
                wire:click="loadMapData('{{ $map }}')"
                class="map-button"
            >
                {{ $map }}
            </button>
            @endforeach
        </ul>
    @else
        <p>Loading maps...</p>
    @endif


</div>
