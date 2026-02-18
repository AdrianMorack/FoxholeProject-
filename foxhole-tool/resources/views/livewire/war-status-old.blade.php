<div class="max-w-5xl mx-auto space-y-8">
    @if($data)
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent mb-3">Current War Status</h1>
            <p class="text-gray-400">Live battlefield intelligence and war statistics</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- War ID -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-8 border border-slate-700 shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">War Number</div>
                </div>
                <div class="text-5xl font-bold text-blue-400">#{{ $data['warNumber'] ?? 'Unknown' }}</div>
            </div>

            <!-- War Duration -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-8 border border-slate-700 shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">War Day</div>
                </div>
                <div class="text-5xl font-bold text-purple-400">
                    @if(isset($data['conquestStartTime']))
                        {{ floor((now()->timestamp * 1000 - $data['conquestStartTime']) / (1000 * 60 * 60 * 24)) }}
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <!-- Winner -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-8 border border-slate-700 shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">Status</div>
                </div>
                <div class="text-3xl font-bold text-green-400">
                    {{ $data['winner'] ?? 'In Progress' }}
                </div>
            </div>

            <!-- Conquest Start Time -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-8 border border-slate-700 shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-gray-400 text-sm uppercase tracking-wide font-semibold">Started</div>
                </div>
                <div class="text-2xl font-bold text-yellow-400">
                    @if(isset($data['conquestStartTime']))
                        {{ \Carbon\Carbon::createFromTimestampMs($data['conquestStartTime'])->diffForHumans() }}
                    @else
                        Unknown
                    @endif
                </div>
            </div>
        </div>

        <!-- Casualties and Stats -->
        @if($stats)
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-8 border border-slate-700 shadow-xl mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <svg class="w-7 h-7 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                War Statistics
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Casualties -->
                <div class="text-center p-6 rounded-lg bg-gradient-to-br from-red-900/20 to-red-800/10 border border-red-500/30">
                    <div class="text-6xl font-bold text-red-400 mb-2">{{ number_format($stats['total_casualties']) }}</div>
                    <div class="text-gray-300 text-sm font-semibold uppercase tracking-wide">Total Casualties</div>
                </div>

                <!-- Warden Casualties -->
                <div class="text-center p-6 rounded-lg bg-gradient-to-br from-blue-900/20 to-blue-800/10 border border-blue-500/30">
                    <div class="text-6xl font-bold" style="color: #60a5fa;">{{ number_format($stats['warden_casualties']) }}</div>
                    <div class="text-gray-300 text-sm font-semibold uppercase tracking-wide">Warden Casualties</div>
                </div>

                <!-- Colonial Casualties -->
                <div class="text-center p-6 rounded-lg bg-gradient-to-br from-green-900/20 to-green-800/10 border border-green-500/30">
                    <div class="text-6xl font-bold" style="color: #4ade80;">{{ number_format($stats['colonial_casualties']) }}</div>
                    <div class="text-gray-300 text-sm font-semibold uppercase tracking-wide">Colonial Casualties</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Victory Progress -->
                <div class="text-center p-6 rounded-lg bg-gradient-to-br from-yellow-900/20 to-yellow-800/10 border border-yellow-500/30">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">
                        {{ $stats['victory_points_warden'] }} / {{ $stats['victory_points_colonial'] }}
                    </div>
                    <div class="text-gray-300 text-sm font-semibold uppercase tracking-wide">Victory Points (W/C)</div>
                    <div class="text-xs text-gray-400 mt-1">Need {{ $data['requiredVictoryTowns'] ?? 32 }} to win</div>
                </div>

                <!-- Total Enlistments -->
                <div class="text-center p-6 rounded-lg bg-gradient-to-br from-purple-900/20 to-purple-800/10 border border-purple-500/30">
                    <div class="text-4xl font-bold text-purple-400 mb-2">{{ number_format($stats['total_enlistments']) }}</div>
                    <div class="text-gray-300 text-sm font-semibold uppercase tracking-wide">Total Enlistments</div>
                    <div class="text-xs text-gray-400 mt-1">Across {{ $stats['active_maps'] }} active maps</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Raw Data Toggle -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 shadow-xl">
            <details class="group">
                <summary class="text-white font-semibold cursor-pointer hover:text-blue-400 flex items-center justify-between transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        View Raw API Data
                    </span>
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </summary>
                <pre class="mt-4 p-4 bg-slate-950 rounded-lg text-sm text-gray-300 overflow-auto border border-slate-700">{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
            </details>
        </div>
    @else
        <div class="max-w-2xl mx-auto text-center py-16">
            <div class="bg-gradient-to-br from-red-900/20 to-red-800/10 border border-red-500/30 rounded-xl p-12 shadow-xl">
                <svg class="w-16 h-16 text-red-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h2 class="text-3xl font-bold text-red-400 mb-4">Unable to Load War Status</h2>
                <p class="text-gray-300 mb-2">The Foxhole API is currently unavailable or experiencing issues.</p>
                <p class="text-gray-400 text-sm mt-4">This data is cached for 5 minutes. Please try again later.</p>
            </div>
        </div>
    @endif
</div>
