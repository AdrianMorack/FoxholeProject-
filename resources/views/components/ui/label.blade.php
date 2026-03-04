@props([
    'for' => null,
    'required' => false,
])

<label 
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 text-sm font-medium leading-none text-military-text-primary peer-disabled:cursor-not-allowed peer-disabled:opacity-50'
    ]) }}
>
    {{ $slot }}
    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>
