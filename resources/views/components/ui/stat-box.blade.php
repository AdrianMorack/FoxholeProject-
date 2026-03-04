@props([
    'label' => '',
    'value' => '',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'bg-military-bg-secondary border-2 border-military-border-green/30 rounded-lg p-4']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-xs font-medium text-military-text-secondary uppercase tracking-wide">
                {{ $label }}
            </p>
            <p class="mt-1 text-2xl font-bold text-military-text-primary">
                {{ $value }}
            </p>
            @if($slot->isNotEmpty())
                <div class="mt-1 text-xs text-military-text-secondary">
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
