@props([
    'orientation' => 'horizontal',
])

@php
$classes = 'shrink-0 bg-military-border-green/30';
$classes .= $orientation === 'horizontal' ? ' h-[2px] w-full' : ' w-[2px] h-full';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}></div>
