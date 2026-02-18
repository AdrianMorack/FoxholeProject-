@props([
    'label' => '',
    'value' => '',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'bg-military-bg-secondary border-2 border-military-border-green/30 rounded-lg p-6']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-military-text-secondary uppercase tracking-wide">
                {{ $label }}
            </p>
            <p class="mt-2 text-3xl font-bold text-military-text-primary">
                {{ $value }}
            </p>
            @if($slot->isNotEmpty())
                <div class="mt-2 text-sm text-military-text-secondary">
                    {{ $slot }}
                </div>
            @endif
        </div>
        @if($icon)
            <div class="ml-4 text-military-border-green">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
