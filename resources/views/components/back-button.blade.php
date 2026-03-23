@props(['position' => 'bottom-left'])

@php
    $positionClasses = match($position) {
        'top-right' => 'fixed top-3 right-3 sm:top-6 sm:right-6 z-[9999]',
        'top-left' => 'fixed top-3 left-3 sm:top-6 sm:left-6 z-[9999]',
        'bottom-right' => 'fixed bottom-3 right-3 sm:bottom-6 sm:right-6 z-[9999]',
        'bottom-left' => 'fixed bottom-3 left-3 sm:bottom-6 sm:left-6 z-[9999]',
        'inline' => '',
        default => 'fixed bottom-3 left-3 sm:bottom-6 sm:left-6 z-[9999]',
    };
    
    $positionStyle = match($position) {
        'top-right' => 'position: fixed !important; top: 0.75rem !important; right: 0.75rem !important; z-index: 9999 !important;',
        'top-left' => 'position: fixed !important; top: 0.75rem !important; left: 0.75rem !important; z-index: 9999 !important;',
        'bottom-right' => 'position: fixed !important; bottom: 0.75rem !important; right: 0.75rem !important; z-index: 9999 !important;',
        'bottom-left' => 'position: fixed !important; bottom: 0.75rem !important; left: 0.75rem !important; z-index: 9999 !important;',
        'inline' => '',
        default => 'position: fixed !important; bottom: 0.75rem !important; left: 0.75rem !important; z-index: 9999 !important;',
    };
@endphp
<button 
    onclick="history.back()"
    style="{{ $positionStyle }}"
    class="{{ $positionClasses }} flex items-center gap-1.5 sm:gap-2 bg-military-bg-secondary/95 backdrop-blur-sm border-2 border-military-border-green rounded-lg px-2.5 sm:px-4 py-1.5 sm:py-2.5 shadow-lg hover:border-military-text-primary transition-colors cursor-pointer"
>
    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-military-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span class="text-military-text-primary font-medium text-[10px] sm:text-sm tracking-wide">BACK</span>
</button>
