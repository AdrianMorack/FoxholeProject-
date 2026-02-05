<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">Foxhole War Tracker</h1>
        <p class="text-gray-400 text-lg">Real-time war statistics and map control tracking</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Current War -->
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">Current War</div>
            <div class="text-3xl font-bold text-blue-400">{{ $stats['current_war'] }}</div>
        </div>

        <!-- War Day -->
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">War Day</div>
            <div class="text-3xl font-bold text-purple-400">{{ $stats['war_day'] }}</div>
        </div>

        <!-- Total Maps -->
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">Total Maps</div>
            <div class="text-3xl font-bold text-green-400">{{ $stats['total_maps'] }}</div>
        </div>

        <!-- Total Structures -->
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">Total Structures</div>
            <div class="text-3xl font-bold text-yellow-400">{{ $stats['total_icons'] }}</div>
        </div>
    </div>

    <!-- Team Control Stats -->
    <div class="bg-gray-800 rounded-lg p-8 border border-gray-700 mb-8">
        <h2 class="text-2xl font-bold text-white mb-6">Territory Control</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Wardens -->
            <div class="text-center">
                <div class="text-6xl font-bold mb-2" style="color: #0000ff;">{{ $stats['warden_icons'] }}</div>
                <div class="text-gray-300 text-lg">Warden Structures</div>
            </div>

            <!-- Colonials -->
            <div class="text-center">
                <div class="text-6xl font-bold mb-2" style="color: #00ff00;">{{ $stats['colonial_icons'] }}</div>
                <div class="text-gray-300 text-lg">Colonial Structures</div>
            </div>

            <!-- Neutral -->
            <div class="text-center">
                <div class="text-6xl font-bold text-gray-400 mb-2">{{ $stats['neutral_icons'] }}</div>
                <div class="text-gray-300 text-lg">Neutral Structures</div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('war.status') }}" wire:navigate class="block bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 rounded-lg p-8 transition-all">
            <h3 class="text-2xl font-bold text-white mb-2">War Status</h3>
            <p class="text-blue-100">View detailed war information and statistics</p>
        </a>

        <a href="{{ route('map.list') }}" wire:navigate class="block bg-gradient-to-r from-green-600 to-green-800 hover:from-green-700 hover:to-green-900 rounded-lg p-8 transition-all">
            <h3 class="text-2xl font-bold text-white mb-2">War Maps</h3>
            <p class="text-green-100">Browse all maps and view structure locations</p>
        </a>
    </div>

    <div class="text-center text-gray-500 text-sm mt-8">
        Last updated: {{ $stats['last_updated'] }}
    </div>
</div>
