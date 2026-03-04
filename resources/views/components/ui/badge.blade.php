@props([
    'variant' => 'default',
])

@php
$baseClasses = 'inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap gap-1 transition-colors';

$variants = [
    'default' => 'border-transparent bg-military-border-green text-military-text-primary',
    'secondary' => 'border-transparent bg-military-border-blue text-military-text-primary',
    'destructive' => 'border-transparent bg-red-700 text-white',
    'outline' => 'text-military-text-primary border-military-border-green',
    'success' => 'border-transparent bg-green-700 text-white',
    'warning' => 'border-transparent bg-yellow-700 text-white',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
