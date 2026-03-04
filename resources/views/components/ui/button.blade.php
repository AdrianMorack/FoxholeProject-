@props([
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-offset-2';

$variants = [
    'default' => 'bg-military-border-green text-military-text-primary hover:bg-military-accent-green border-2 border-military-accent-green/50',
    'destructive' => 'bg-red-700 text-white hover:bg-red-800 border-2 border-red-600',
    'outline' => 'border-2 border-military-border-green bg-transparent text-military-text-primary hover:bg-military-border-green/10',
    'secondary' => 'bg-military-border-blue text-military-text-primary hover:bg-military-accent-blue border-2 border-military-accent-blue/50',
    'ghost' => 'hover:bg-military-border-green/10 text-military-text-primary',
    'link' => 'text-military-border-green underline-offset-4 hover:underline',
];

$sizes = [
    'default' => 'h-10 px-4 py-2',
    'sm' => 'h-8 px-3 text-xs',
    'lg' => 'h-12 px-6 text-base',
    'icon' => 'h-10 w-10',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['default']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
