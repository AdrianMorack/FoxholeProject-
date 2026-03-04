@props(['position' => 'bottom-left'])

@php
    $currentShard = session('foxhole_shard', 'baker');
    $shardName = strtoupper($currentShard);
    $positionClasses = match($position) {
        'top-right' => 'fixed top-6 right-6 z-[9999]',
        'top-left' => 'fixed top-6 left-6 z-[9999]',
        'bottom-right' => 'fixed bottom-6 right-6 z-[9999]',
        'bottom-left' => 'fixed bottom-6 left-6 z-[9999]',
        'inline' => '',
        default => 'fixed bottom-6 right-6 z-[9999]',
    };
@endphp

<form action="{{ route('shard.toggle') }}" method="POST" style="position: fixed !important; bottom: 1.5rem !important; right: 1.5rem !important; z-index: 9999 !important;" class="{{ $positionClasses }} flex items-center gap-2 bg-military-bg-secondary/95 backdrop-blur-sm border-2 border-military-border-green rounded-lg px-4 py-2.5 shadow-lg hover:border-military-text-primary transition-colors">
    @csrf

    <!-- Toggle Switch -->
    <button 
        type="submit"
        class="relative z-10 inline-flex h-7 w-14 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-military-border-green focus:ring-offset-2 focus:ring-offset-military-bg-primary cursor-pointer {{ $currentShard === 'able' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}"
        title="Switch to {{ $currentShard === 'able' ? 'Baker' : 'Able' }} shard"
    >
        <span class="sr-only">Toggle shard</span>
        <span class="{{ $currentShard === 'able' ? 'translate-x-7' : 'translate-x-1' }} inline-block h-5 w-5 transform rounded-full bg-white transition-transform shadow-md pointer-events-none">
        </span>
    </button>

    <!-- Current Shard Label -->
    <div class="flex items-center gap-1.5 pointer-events-none select-none">
        <span class="text-military-text-primary font-mono text-xs tracking-widest">{{ $shardName }}</span>
        <div class="w-2 h-2 rounded-full {{ $currentShard === 'able' ? 'bg-blue-500' : 'bg-green-500' }} animate-pulse"></div>
    </div>
</form>
