@props([
    'type' => 'text',
    'disabled' => false,
])

<input 
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'flex h-10 w-full rounded-md border-2 border-military-border-green/30 bg-military-bg-secondary px-3 py-2 text-sm text-military-text-primary placeholder:text-military-text-secondary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-military-border-green focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50'
    ]) }}
>
