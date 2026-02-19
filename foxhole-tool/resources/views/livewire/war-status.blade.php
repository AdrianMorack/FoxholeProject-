<div>
    <!-- Shard Selector -->
    <x-shard-selector />

    <div class="min-h-screen bg-military-bg-primary">
    <!-- Military Header with Diagonal Stripes -->
    <div class="relative bg-gradient-to-r from-military-bg-secondary to-military-bg-primary border-b-4 border-military-border-green">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, #4a7c59 10px, #4a7c59 20px);"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-12">
            <div class="flex items-center gap-4 mb-4">
                <svg class="w-12 h-12 text-military-border-green" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                </svg>
                <h1 class="text-4xl font-bold text-military-text-primary uppercase tracking-wider">Operational Status</h1>
            </div>
            <p class="text-military-text-secondary uppercase text-sm tracking-wide">Live battlefield intelligence • Shard: {{ session('foxhole_shard', 'baker') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
        @if($data)
            <!-- Primary War Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-ui.stat-box 
                    label="War Number" 
                    :value="'#' . ($data['warNumber'] ?? 'Unknown')"
                />

                <x-ui.stat-box 
                    label="War Day" 
                    :value="isset($data['conquestStartTime']) ? floor((now()->timestamp * 1000 - $data['conquestStartTime']) / (1000 * 60 * 60 * 24)) : 'N/A'"
                />

                <x-ui.stat-box label="Status">
                    <x-slot name="value">
                        @if($data['winner'] ?? null)
                            <x-ui.badge variant="success">{{ $data['winner'] }}</x-ui.badge>
                        @else
                            <x-ui.badge variant="warning">Active</x-ui.badge>
                        @endif
                    </x-slot>
                </x-ui.stat-box>

                <x-ui.stat-box 
                    label="War Started" 
                    :value="isset($data['conquestStartTime']) ? \Carbon\Carbon::createFromTimestampMs($data['conquestStartTime'])->format('M d, Y') : 'Unknown'"
                >
                    {{ isset($data['conquestStartTime']) ? \Carbon\Carbon::createFromTimestampMs($data['conquestStartTime'])->diffForHumans() : '' }}
                </x-ui.stat-box>
            </div>

            <!-- Casualties Section -->
            @if($stats)
            <x-ui.card>
                <x-ui.card-header>
                    <x-ui.card-title class="flex items-center gap-3">
                        <svg class="w-7 h-7 text-military-border-green" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        War Statistics
                    </x-ui.card-title>
                    <x-ui.card-description>Battlefield casualties and faction statistics</x-ui.card-description>
                </x-ui.card-header>

                <x-ui.card-content>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-ui.stat-box 
                            label="Total Casualties" 
                            :value="number_format($stats['total_casualties'] ?? 0)"
                            class="border-red-500/30 bg-red-900/10"
                        />

                        <x-ui.stat-box 
                            label="Warden Casualties" 
                            :value="number_format($stats['warden_casualties'] ?? 0)"
                            class="border-blue-500/30 bg-blue-900/10"
                        />

                        <x-ui.stat-box 
                            label="Colonial Casualties" 
                            :value="number_format($stats['colonial_casualties'] ?? 0)"
                            class="border-green-500/30 bg-green-900/10"
                        />
                    </div>

                    <x-ui.separator class="my-6" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-ui.stat-box 
                            label="ctory Points" 
                            :value="$stats['victory_points_warden'] ?? 0"
                            class="border-blue-500/30 bg-blue-900/10"
                        >
                            Structures counting toward victory
                        </x-ui.stat-box>

                        <x-ui.stat-box 
                            label="tory Points" 
                            :value="$stats['victory_points_colonial'] ?? 0"
                            class="border-green-500/30 bg-green-900/10"
                        >
                            Structures counting toward victory
                        </x-ui.stat-box>
                    </div>
                </x-ui.card-content>
            </x-ui.card>
            @endif

            

            <!-- Action Buttons -->
            <div class="flex gap-4 justify-center">
                <x-ui.button href="{{ route('home.page', ['shard' => session('foxhole_shard', 'baker')]) }}" variant="outline">
                    ← Back to Command
                </x-ui.button>
                <x-ui.button wire:click="$refresh">
                    Refresh Data
                </x-ui.button>
            </div>

        @else
            <x-ui.card>
                <x-ui.card-content class="text-center py-12">
                    <p class="text-military-text-secondary text-lg">No war data available for {{ session('foxhole_shard', 'baker') }} shard</p>
                    <x-ui.button wire:click="$refresh" class="mt-4">Try Again</x-ui.button>
                </x-ui.card-content>
            </x-ui.card>
        @endif
    </div>
    </div>
</div>
</div>
