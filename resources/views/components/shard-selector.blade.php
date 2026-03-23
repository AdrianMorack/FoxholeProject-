@props(['position' => 'bottom-right'])

@php
    $currentShard = session('foxhole_shard', 'baker');
    $shardName = strtoupper($currentShard);
    $positionClasses = match($position) {
        'top-right' => 'fixed top-3 right-3 sm:top-6 sm:right-6 z-[9999]',
        'top-left' => 'fixed top-3 left-3 sm:top-6 sm:left-6 z-[9999]',
        'bottom-right' => 'fixed bottom-3 right-3 sm:bottom-6 sm:right-6 z-[9999]',
        'bottom-left' => 'fixed bottom-3 left-3 sm:bottom-6 sm:left-6 z-[9999]',
        'inline' => '',
        default => 'fixed bottom-3 right-3 sm:bottom-6 sm:right-6 z-[9999]',
    };
@endphp

<form action="{{ route('shard.toggle') }}" method="POST" class="{{ $positionClasses }} flex items-center gap-1.5 sm:gap-2 bg-military-bg-secondary/95 backdrop-blur-sm border-2 border-military-border-green rounded-lg px-2.5 sm:px-4 py-1.5 sm:py-2.5 shadow-lg hover:border-military-text-primary transition-colors">
    @csrf

    <!-- Toggle Switch -->
    <button 
        type="submit"
        class="relative z-10 inline-flex h-6 w-11 sm:h-7 sm:w-14 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-military-border-green focus:ring-offset-2 focus:ring-offset-military-bg-primary cursor-pointer {{ $currentShard === 'able' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}"
        title="Switch to {{ $currentShard === 'able' ? 'Baker' : 'Able' }} shard"
    >
        <span class="sr-only">Toggle shard</span>
        <span class="{{ $currentShard === 'able' ? 'translate-x-5 sm:translate-x-7' : 'translate-x-1' }} inline-block h-4 w-4 sm:h-5 sm:w-5 transform rounded-full bg-white transition-transform shadow-md pointer-events-none">
        </span>
    </button>

    <!-- Current Shard Label -->
    <div class="flex items-center gap-1 sm:gap-1.5 pointer-events-none select-none">
        <span class="text-military-text-primary font-mono text-[10px] sm:text-xs tracking-widest">{{ $shardName }}</span>
        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full {{ $currentShard === 'able' ? 'bg-blue-500' : 'bg-green-500' }} animate-pulse"></div>
    </div>
</form>
