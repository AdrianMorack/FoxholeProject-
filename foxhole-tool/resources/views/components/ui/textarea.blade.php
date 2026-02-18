@props([
    'disabled' => false,
])

<textarea 
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'flex min-h-[80px] w-full rounded-md border-2 border-military-border-green/30 bg-military-bg-secondary px-3 py-2 text-sm text-military-text-primary placeholder:text-military-text-secondary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-military-border-green focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none'
    ]) }}
>{{ $slot }}</textarea>
