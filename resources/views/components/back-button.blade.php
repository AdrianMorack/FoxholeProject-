@props(['position' => 'bottom-left'])

@php
    $positionClasses = match($position) {
        'top-right' => 'fixed top-6 right-6 z-[9999]',
        'top-left' => 'fixed top-6 left-6 z-[9999]',
        'bottom-right' => 'fixed bottom-6 right-6 z-[9999]',
        'bottom-left' => 'fixed bottom-6 left-6 z-[9999]',
        'inline' => '',
        default => 'fixed bottom-6 left-6 z-[9999]',
    };
    
    $positionStyle = match($position) {
        'top-right' => 'position: fixed !important; top: 1.5rem !important; right: 1.5rem !important; z-index: 9999 !important;',
        'top-left' => 'position: fixed !important; top: 1.5rem !important; left: 1.5rem !important; z-index: 9999 !important;',
        'bottom-right' => 'position: fixed !important; bottom: 1.5rem !important; right: 1.5rem !important; z-index: 9999 !important;',
        'bottom-left' => 'position: fixed !important; bottom: 1.5rem !important; left: 1.5rem !important; z-index: 9999 !important;',
        'inline' => '',
        default => 'position: fixed !important; bottom: 1.5rem !important; left: 1.5rem !important; z-index: 9999 !important;',
    };
@endphp
<button 
    onclick="history.back()"
    style="{{ $positionStyle }}"
    class="{{ $positionClasses }} flex items-center gap-2 bg-military-bg-secondary/95 backdrop-blur-sm border-2 border-military-border-green rounded-lg px-4 py-2.5 shadow-lg hover:border-military-text-primary transition-colors cursor-pointer"
>
    <svg class="w-5 h-5 text-military-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span class="text-military-text-primary font-medium text-sm tracking-wide">BACK</span>
</button>
