<div class="min-h-screen bg-[#1a1f1a] text-[#e8e8d5] relative overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #2a4a2a 0px, #2a4a2a 10px, #1a3a1a 10px, #1a3a1a 20px);"></div>
    
    <!-- Main content -->
    <div class="relative z-10">
        <!-- Header -->
        <header class="border-b-4 border-[#4a7c59] bg-[#0f140f] shadow-2xl">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <!-- Star Icon -->
                        <svg class="w-10 h-10 text-[#ffd700] fill-[#ffd700]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <div>
                            <h1 class="text-3xl font-bold tracking-wider text-[#e8e8d5]">ALLIED COMMAND</h1>
                            <p class="text-sm text-[#8b9d83] tracking-widest">OPERATION HEADQUARTERS</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-[#8b9d83] tracking-wider">CLEARANCE LEVEL</p>
                        <p class="text-xl font-bold text-[#4a7c59]">TOP SECRET</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero section -->
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <div class="inline-block border-4 border-[#4a7c59] bg-[#0f140f] px-8 py-4 mb-8 shadow-xl">
                    <p class="text-sm tracking-[0.3em] text-[#8b9d83]">CLASSIFIED BRIEFING</p>
                    <h2 class="text-5xl font-bold mt-2 text-[#e8e8d5]">STRATEGIC COMMAND CENTER</h2>
                </div>
                <p class="text-xl text-[#a8b8a0] leading-relaxed max-w-2xl mx-auto">
                    Access real-time intelligence reports, tactical assessments, and operational maps. 
                    Your clearance grants you entry to vital strategic information.
                </p>
            </div>

            <!-- Navigation Cards -->
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Status Card -->
                <x-ui.card class="group hover:scale-105 transition-transform duration-300">
                    <x-ui.card-header class="relative">
                        <div class="flex justify-between items-start">
                            <x-ui.card-title class="text-2xl">OPERATIONAL STATUS</x-ui.card-title>
                            <x-ui.badge variant="success">HIGH PRIORITY</x-ui.badge>
                        </div>
                        <x-ui.card-description>
                            Review current force readiness and tactical assessments
                        </x-ui.card-description>
                    </x-ui.card-header>
                    
                    <x-ui.card-content class="flex flex-col items-center py-8">
                        <div class="bg-[#1a4a2a] p-6 rounded-full mb-4 group-hover:bg-[#2a5a3a] transition-colors">
                            <svg class="w-12 h-12 text-[#5a9c69]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <p class="text-center text-sm text-military-text-secondary">
                            Supply lines, territorial control, and battlefield assessments
                        </p>
                    </x-ui.card-content>
                    
                    <x-ui.card-footer class="flex justify-center">
                        <x-ui.button href="{{ route('war.status', ['shard' => session('foxhole_shard', 'baker')]) }}" size="lg" class="w-full">
                            ACCESS REPORT →
                        </x-ui.button>
                    </x-ui.card-footer>
                </x-ui.card>

                <!-- War Map Card -->
                <x-ui.card class="group hover:scale-105 transition-transform duration-300">
                    <x-ui.card-header class="relative">
                        <div class="flex justify-between items-start">
                            <x-ui.card-title class="text-2xl">WAR MAP</x-ui.card-title>
                            <x-ui.badge variant="destructive">CRITICAL</x-ui.badge>
                        </div>
                        <x-ui.card-description>
                            Strategic overview of all theaters of operation
                        </x-ui.card-description>
                    </x-ui.card-header>
                    
                    <x-ui.card-content class="flex flex-col items-center py-8">
                        <div class="bg-[#1a3a4a] p-6 rounded-full mb-4 group-hover:bg-[#2a4a5a] transition-colors">
                            <svg class="w-12 h-12 text-[#4a7a9c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-center text-sm text-military-text-secondary">
                            Track troop movements and territorial control in real-time
                        </p>
                    </x-ui.card-content>
                    
                    <x-ui.card-footer class="flex justify-center">
                        <x-ui.button href="{{ route('map.list', ['shard' => session('foxhole_shard', 'baker')]) }}" variant="secondary" size="lg" class="w-full">
                            VIEW MAP →
                        </x-ui.button>
                    </x-ui.card-footer>
                </x-ui.card>
            </div>

            <!-- Footer notice -->
            <div class="mt-16 max-w-4xl mx-auto">
                <div class="border-l-4 border-[#ffd700] bg-[#0f140f] p-6">
                    <p class="text-sm text-[#8b9d83] leading-relaxed">
                        <span class="font-bold text-[#ffd700]">SECURITY NOTICE:</span> All information contained within this system is classified. 
                        Unauthorized disclosure is prohibited. Report any suspicious activity to Intelligence immediately.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
