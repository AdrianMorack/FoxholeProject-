# UI Components Usage Examples

## Button Component

```blade
{{-- Default button --}}
<x-ui.button>Click me</x-ui.button>

{{-- Button variants --}}
<x-ui.button variant="default">Default Button</x-ui.button>
<x-ui.button variant="destructive">Delete</x-ui.button>
<x-ui.button variant="outline">Outline</x-ui.button>
<x-ui.button variant="secondary">Secondary</x-ui.button>
<x-ui.button variant="ghost">Ghost</x-ui.button>
<x-ui.button variant="link">Link Style</x-ui.button>

{{-- Button sizes --}}
<x-ui.button size="sm">Small</x-ui.button>
<x-ui.button size="default">Default</x-ui.button>
<x-ui.button size="lg">Large</x-ui.button>
<x-ui.button size="icon">
    <svg>...</svg>
</x-ui.button>

{{-- As link --}}
<x-ui.button href="/maps">Go to Maps</x-ui.button>

{{-- With wire:click --}}
<x-ui.button wire:click="submit">Submit</x-ui.button>
```

## Card Components

```blade
<x-ui.card>
    <x-ui.card-header>
        <x-ui.card-title>Card Title</x-ui.card-title>
        <x-ui.card-description>This is a description</x-ui.card-description>
    </x-ui.card-header>
    
    <x-ui.card-content>
        <p>Your content goes here</p>
    </x-ui.card-content>
    
    <x-ui.card-footer>
        <x-ui.button>Action</x-ui.button>
    </x-ui.card-footer>
</x-ui.card>
```

## Badge Component

```blade
{{-- Badge variants --}}
<x-ui.badge>Default</x-ui.badge>
<x-ui.badge variant="secondary">Secondary</x-ui.badge>
<x-ui.badge variant="destructive">Destructive</x-ui.badge>
<x-ui.badge variant="outline">Outline</x-ui.badge>
<x-ui.badge variant="success">Success</x-ui.badge>
<x-ui.badge variant="warning">Warning</x-ui.badge>
```

## Input & Label Components

```blade
<div>
    <x-ui.label for="email" required>Email Address</x-ui.label>
    <x-ui.input 
        id="email" 
        type="email" 
        placeholder="Enter your email"
        wire:model="email"
    />
</div>
```

## Stat Box Component

```blade
{{-- Simple stat box --}}
<x-ui.stat-box 
    label="Active Maps" 
    value="32"
/>

{{-- With additional content --}}
<x-ui.stat-box 
    label="Total Structures" 
    value="1,234"
>
    +12% from last hour
</x-ui.stat-box>

{{-- With icon --}}
<x-ui.stat-box 
    label="Victory Points" 
    value="150"
    :icon="'<svg class=\'w-8 h-8\'>...</svg>'"
/>
```

## Example: War Status Page Refactored

```blade
<div class="container mx-auto p-6 space-y-6">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-ui.stat-box label="Active Maps" :value="$activeMaps" />
        <x-ui.stat-box label="Total Structures" :value="number_format($totalStructures)" />
        <x-ui.stat-box label="Victory Points" :value="$victoryPoints" />
    </div>

    {{-- War Info Card --}}
    <x-ui.card>
        <x-ui.card-header>
            <x-ui.card-title>War Information</x-ui.card-title>
            <x-ui.card-description>Current war status and details</x-ui.card-description>
        </x-ui.card-header>
        
        <x-ui.card-content>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-military-text-secondary">War Number:</span>
                    <span class="ml-2 font-bold">#{{ $warNumber }}</span>
                </div>
                <div>
                    <span class="text-sm text-military-text-secondary">Status:</span>
                    <x-ui.badge variant="success" class="ml-2">Active</x-ui.badge>
                </div>
            </div>
        </x-ui.card-content>
        
        <x-ui.card-footer>
            <x-ui.button href="{{ route('map.list', ['shard' => session('shard', 'able')]) }}">
                View Maps
            </x-ui.button>
        </x-ui.card-footer>
    </x-ui.card>
</div>
```
