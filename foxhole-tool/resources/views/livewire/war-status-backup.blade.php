<div class="min-h-screen bg-[#1a1f1a] text-[#e8e8d5]">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>

    <div class="relative z-10">
        <!-- Header -->
        <header class="border-b-4 border-[#4a7c59] bg-[#0f140f] shadow-2xl sticky top-0 z-20">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home.page', ['shard' => session('foxhole_shard', 'baker')]) }}" wire:navigate class="flex items-center gap-2 hover:text-[#4a7c59] transition-colors">
                        <!-- ArrowLeft Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="tracking-wider font-bold">RETURN TO HQ</span>
                    </a>
                    <h1 class="text-2xl font-bold tracking-wider">OPERATIONAL STATUS</h1>
                    <div class="text-right">
                        <p class="text-xs text-[#8b9d83]">LAST UPDATE</p>
                        <p class="text-sm font-bold text-[#4a7c59]">{{ now()->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <!-- Status Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Active Maps -->
                <div class="border-4 bg-[#0f140f] p-6 relative" style="border-color: #4a7c59;">
                    <div class="absolute top-0 right-0 px-2 py-1" style="background-color: #4a7c59;">
                        <!-- CheckCircle Icon -->
                        <svg class="w-4 h-4 text-[#e8e8d5]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="mt-4">
                        <div class="p-4 rounded-full inline-block mb-3" style="background-color: #1a4a2a;">
                            <!-- Users Icon -->
                            <svg class="w-8 h-8" style="color: #4a7c59;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs tracking-widest text-[#8b9d83] mb-2">ACTIVE MAPS</p>
                        <p class="text-3xl font-bold" style="color: #4a7c59;">{{ $stats['active_maps'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Total Structures -->
                <div class="border-4 bg-[#0f140f] p-6 relative" style="border-color: #4a7c59;">
                    <div class="absolute top-0 right-0 px-2 py-1" style="background-color: #4a7c59;">
                        <svg class="w-4 h-4 text-[#e8e8d5]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="mt-4">
                        <div class="p-4 rounded-full inline-block mb-3" style="background-color: #1a4a2a;">
                            <!-- Package Icon -->
                            <svg class="w-8 h-8" style="color: #4a7c59;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p class="text-xs tracking-widest text-[#8b9d83] mb-2">TOTAL STRUCTURES</p>
                        <p class="text-3xl font-bold" style="color: #4a7c59;">{{ $stats['total_structures'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Victory Points Warden -->
                <div class="border-4 bg-[#0f140f] p-6 relative" style="border-color: #3a5a7c;">
                    <div class="absolute top-0 right-0 px-2 py-1" style="background-color: #3a5a7c;">
                        <svg class="w-4 h-4 text-[#e8e8d5]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="mt-4">
                        <div class="p-4 rounded-full inline-block mb-3" style="background-color: #1a3a4a;">
                            <!-- Shield Icon -->
                            <svg class="w-8 h-8" style="color: #3a5a7c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <p class="text-xs tracking-widest text-[#8b9d83] mb-2">WARDEN VP</p>
                        <p class="text-3xl font-bold" style="color: #3a5a7c;">{{ $stats['victory_points_warden'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Victory Points Colonial -->
                <div class="border-4 bg-[#0f140f] p-6 relative" style="border-color: #7c6a3a;">
                    <div class="absolute top-0 right-0 px-2 py-1" style="background-color: #7c6a3a;">
                        <svg class="w-4 h-4 text-[#e8e8d5]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="mt-4">
                        <div class="p-4 rounded-full inline-block mb-3" style="background-color: #4a3a1a;">
                            <!-- AlertTriangle Icon -->
                            <svg class="w-8 h-8" style="color: #7c6a3a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <p class="text-xs tracking-widest text-[#8b9d83] mb-2">COLONIAL VP</p>
                        <p class="text-3xl font-bold" style="color: #7c6a3a;">{{ $stats['victory_points_colonial'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- War Information -->
            @if($data)
            <div class="border-4 border-[#4a7c59] bg-[#0f140f] p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold tracking-wider">WAR INFORMATION</h2>
                    <div class="border-2 border-[#4a7c59] px-4 py-1">
                        <span class="text-xs tracking-wider">WAR #{{ $data['warNumber'] ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="border-l-4 border-[#4a7c59] bg-[#141914] p-4">
                            <p class="text-xs tracking-widest text-[#8b9d83] mb-2">REQUIRED VICTORY TOWNS</p>
                            <p class="text-2xl font-bold text-[#4a7c59]">{{ $data['requiredVictoryTowns'] ?? 'Unknown' }}</p>
                        </div>
                        <div class="border-l-4 border-[#4a7c59] bg-[#141914] p-4">
                            <p class="text-xs tracking-widest text-[#8b9d83] mb-2">WAR STATUS</p>
                            <p class="text-2xl font-bold text-[#4a7c59]">{{ strtoupper($data['winner'] ?? 'ONGOING') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="border-l-4 border-[#3a5a7c] bg-[#141914] p-4">
                            <p class="text-xs tracking-widest text-[#8b9d83] mb-2">TOTAL CASUALTIES</p>
                            <p class="text-2xl font-bold text-[#3a5a7c]">{{ number_format($stats['total_casualties'] ?? 0) }}</p>
                        </div>
                        <div class="border-l-4 border-[#3a5a7c] bg-[#141914] p-4">
                            <p class="text-xs tracking-widest text-[#8b9d83] mb-2">TOTAL ENLISTMENTS</p>
                            <p class="text-2xl font-bold text-[#3a5a7c]">{{ number_format($stats['total_enlistments'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Faction Statistics -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="border-4 border-[#3a5a7c] bg-[#0f140f] p-6">
                    <h3 class="text-xl font-bold mb-4 tracking-wider flex items-center gap-2">
                        <div class="w-4 h-4 bg-[#3a5a7c] rounded-full"></div>
                        WARDEN STATISTICS
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-[#141914] p-3 border-l-2 border-[#3a5a7c]">
                            <span class="text-sm text-[#8b9d83]">Victory Points</span>
                            <span class="text-xl font-bold text-[#3a5a7c]">{{ $stats['victory_points_warden'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-[#141914] p-3 border-l-2 border-[#3a5a7c]">
                            <span class="text-sm text-[#8b9d83]">Casualties</span>
                            <span class="text-xl font-bold text-[#3a5a7c]">{{ number_format($stats['warden_casualties'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-4 border-[#4a7c59] bg-[#0f140f] p-6">
                    <h3 class="text-xl font-bold mb-4 tracking-wider flex items-center gap-2">
                        <div class="w-4 h-4 bg-[#4a7c59] rounded-full"></div>
                        COLONIAL STATISTICS
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                            <span class="text-sm text-[#8b9d83]">Victory Points</span>
                            <span class="text-xl font-bold text-[#4a7c59]">{{ $stats['victory_points_colonial'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                            <span class="text-sm text-[#8b9d83]">Casualties</span>
                            <span class="text-xl font-bold text-[#4a7c59]">{{ number_format($stats['colonial_casualties'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
