<div class="container mx-auto px-4 py-8">
    @if($data)
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-white mb-8">Current War Status</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- War ID -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">War Number</div>
                    <div class="text-4xl font-bold text-blue-400">{{ $data['warId'] ?? 'Unknown' }}</div>
                </div>

                <!-- War Duration -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">War Day</div>
                    <div class="text-4xl font-bold text-purple-400">
                        {{ isset($data['warNumber']) ? floor(($data['warNumber'] ?? 0) / (1000 * 60 * 60 * 24)) : 'N/A' }}
                    </div>
                </div>

                <!-- Winner -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">Winner</div>
                    <div class="text-2xl font-bold text-green-400">
                        {{ $data['winner'] ?? 'In Progress' }}
                    </div>
                </div>

                <!-- Conquest Start Time -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm uppercase tracking-wide mb-2">Started</div>
                    <div class="text-xl font-bold text-yellow-400">
                        @if(isset($data['conquestStartTime']))
                            {{ \Carbon\Carbon::parse($data['conquestStartTime'])->diffForHumans() }}
                        @else
                            Unknown
                        @endif
                    </div>
                </div>
            </div>

            <!-- Raw Data Toggle -->
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <details>
                    <summary class="text-white font-semibold cursor-pointer hover:text-blue-400">View Raw API Data</summary>
                    <pre class="mt-4 text-sm text-gray-300 overflow-auto">{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
                </details>
            </div>
        </div>
    @else
        <div class="max-w-2xl mx-auto text-center py-12">
            <div class="bg-red-900 bg-opacity-20 border border-red-500 rounded-lg p-8">
                <h2 class="text-2xl font-bold text-red-400 mb-4">Unable to Load War Status</h2>
                <p class="text-gray-300 mb-4">The Foxhole API is currently unavailable or experiencing issues.</p>
                <p class="text-gray-400 text-sm">This data is cached for 5 minutes. Please try again later.</p>
            </div>
        </div>
    @endif
</div>
