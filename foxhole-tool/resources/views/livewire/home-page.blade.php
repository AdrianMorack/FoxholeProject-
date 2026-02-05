<div class="space-y-8">
    <!-- Hero Section -->
    <div class="text-center py-12 mb-8">
        <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Foxhole War Tracker</h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">Real-time war statistics, territory control, and strategic map intelligence</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Current War -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 shadow-xl hover:shadow-2xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">Current War</div>
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-4xl font-bold text-blue-400">#{{ $stats['current_war'] }}</div>
        </div>

        <!-- War Day -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 shadow-xl hover:shadow-2xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">War Day</div>
                <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-4xl font-bold text-purple-400">{{ $stats['war_day'] }}</div>
        </div>

        <!-- Total Maps -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 shadow-xl hover:shadow-2xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">Total Maps</div>
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-4xl font-bold text-green-400">{{ $stats['total_maps'] }}</div>
        </div>

        <!-- Total Structures -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 shadow-xl hover:shadow-2xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-2">
                <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">Town Halls</div>
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-4xl font-bold text-yellow-400">{{ $stats['total_townhalls'] }}</div>
        </div>
    </div>

    <!-- Territory Control -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-8 border border-slate-700 shadow-xl">
        <h2 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
            </svg>
            Territory Control
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Wardens -->
            <div class="text-center p-6 rounded-lg bg-gradient-to-br from-blue-900/20 to-blue-800/10 border border-blue-500/30">
                <div class="text-7xl font-bold mb-3" style="color: #60a5fa;">{{ $stats['warden_townhalls'] }}</div>
                <div class="text-gray-300 text-lg font-semibold uppercase tracking-wide">Warden Town Halls</div>
                <div class="mt-2 h-2 bg-blue-500 rounded-full" style="width: {{ ($stats['total_townhalls'] > 0) ? ($stats['warden_townhalls'] / $stats['total_townhalls'] * 100) : 0 }}%"></div>
            </div>

            <!-- Colonials -->
            <div class="text-center p-6 rounded-lg bg-gradient-to-br from-green-900/20 to-green-800/10 border border-green-500/30">
                <div class="text-7xl font-bold mb-3" style="color: #4ade80;">{{ $stats['colonial_townhalls'] }}</div>
                <div class="text-gray-300 text-lg font-semibold uppercase tracking-wide">Colonial Town Halls</div>
                <div class="mt-2 h-2 bg-green-500 rounded-full" style="width: {{ ($stats['total_townhalls'] > 0) ? ($stats['colonial_townhalls'] / $stats['total_townhalls'] * 100) : 0 }}%"></div>
            </div>

            <!-- Victory Requirement -->
            <div class="text-center p-6 rounded-lg bg-gradient-to-br from-yellow-900/20 to-yellow-800/10 border border-yellow-500/30">
                <div class="text-7xl font-bold mb-3" style="color: #fbbf24;">{{ $stats['townhalls_to_win'] }}</div>
                <div class="text-gray-300 text-lg font-semibold uppercase tracking-wide">To Win</div>
                <div class="mt-2 h-2 bg-yellow-500 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Quick Access Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('war.status') }}" wire:navigate class="group block bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 rounded-xl p-8 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold text-white">War Status</h3>
                <svg class="w-8 h-8 text-blue-200 group-hover:translate-x-2 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-blue-100">View detailed war information, victory points, and real-time statistics</p>
        </a>

        <a href="{{ route('map.list') }}" wire:navigate class="group block bg-gradient-to-br from-green-600 to-green-800 hover:from-green-500 hover:to-green-700 rounded-xl p-8 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold text-white">War Maps</h3>
                <svg class="w-8 h-8 text-green-200 group-hover:translate-x-2 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-green-100">Browse all maps, view structure locations, and analyze territorial control</p>
        </a>
    </div>

    <!-- Footer Info -->
    <div class="text-center text-gray-500 text-sm py-4">
        <p>Last updated: {{ $stats['last_updated'] }}</p>
        <p class="mt-1">Data refreshed every 5 minutes</p>
    </div>
</div>
