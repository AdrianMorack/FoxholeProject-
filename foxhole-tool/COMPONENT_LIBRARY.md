# Blade UI Component Library
## Converted from Figma React Components

This library provides reusable Blade components styled with your military theme. All components support attributes merging and work seamlessly with Livewire.

---

## 📦 Available Components

### Layout Components
- `x-ui.card` - Container card
- `x-ui.card-header` - Card header section
- `x-ui.card-title` - Card title
- `x-ui.card-description` - Card description text
- `x-ui.card-content` - Main card content area
- `x-ui.card-footer` - Card footer with actions

### Form Components
- `x-ui.button` - Buttons with multiple variants
- `x-ui.input` - Text inputs
- `x-ui.textarea` - Multi-line text input
- `x-ui.label` - Form labels with required indicator

### Data Display
- `x-ui.badge` - Status badges and tags
- `x-ui.stat-box` - Statistics display box (custom for military theme)
- `x-ui.table` - Table wrapper
- `x-ui.table-header` - Table header
- `x-ui.table-body` - Table body
- `x-ui.table-row` - Table row
- `x-ui.table-head` - Table header cell
- `x-ui.table-cell` - Table data cell

### Utility Components
- `x-ui.separator` - Horizontal or vertical divider

---

## 🎨 Component Reference

### Button

**Props:**
- `variant`: default | destructive | outline | secondary | ghost | link
- `size`: default | sm | lg | icon
- `type`: button | submit | reset
- `href`: Makes button render as link

**Examples:**
```blade
{{-- Default button --}}
<x-ui.button>Click me</x-ui.button>

{{-- Variants --}}
<x-ui.button variant="destructive">Delete</x-ui.button>
<x-ui.button variant="outline">Cancel</x-ui.button>
<x-ui.button variant="secondary">Secondary Action</x-ui.button>
<x-ui.button variant="ghost">Ghost Button</x-ui.button>
<x-ui.button variant="link">Link Style</x-ui.button>

{{-- Sizes --}}
<x-ui.button size="sm">Small</x-ui.button>
<x-ui.button size="lg">Large</x-ui.button>
<x-ui.button size="icon">
    <svg>...</svg>
</x-ui.button>

{{-- As link --}}
<x-ui.button href="/dashboard">Go to Dashboard</x-ui.button>

{{-- With Livewire --}}
<x-ui.button wire:click="save">Save Changes</x-ui.button>

{{-- Disabled --}}
<x-ui.button disabled>Disabled</x-ui.button>
```

---

### Card Components

**Usage:**
```blade
<x-ui.card>
    <x-ui.card-header>
        <x-ui.card-title>Card Title</x-ui.card-title>
        <x-ui.card-description>Optional description text</x-ui.card-description>
    </x-ui.card-header>
    
    <x-ui.card-content>
        <p>Your main content goes here</p>
    </x-ui.card-content>
    
    <x-ui.card-footer>
        <x-ui.button>Action Button</x-ui.button>
    </x-ui.card-footer>
</x-ui.card>

{{-- Minimal card --}}
<x-ui.card>
    <x-ui.card-content>
        Simple content without header/footer
    </x-ui.card-content>
</x-ui.card>

{{-- Custom styling --}}
<x-ui.card class="border-red-500">
    <x-ui.card-content>
        Custom border color
    </x-ui.card-content>
</x-ui.card>
```

---

### Badge

**Props:**
- `variant`: default | secondary | destructive | outline | success | warning

**Examples:**
```blade
<x-ui.badge>Default</x-ui.badge>
<x-ui.badge variant="secondary">Secondary</x-ui.badge>
<x-ui.badge variant="destructive">Error</x-ui.badge>
<x-ui.badge variant="outline">Outline</x-ui.badge>
<x-ui.badge variant="success">Success</x-ui.badge>
<x-ui.badge variant="warning">Warning</x-ui.badge>

{{-- With icons --}}
<x-ui.badge>
    <svg class="w-3 h-3">...</svg>
    Active
</x-ui.badge>

{{-- Custom classes --}}
<x-ui.badge class="text-lg">Large Badge</x-ui.badge>
```

---

### Input & Label

**Input Props:**
- `type`: text | email | password | number | etc.
- `disabled`: boolean

**Label Props:**
- `for`: input id to associate with
- `required`: boolean (adds red asterisk)

**Examples:**
```blade
{{-- Basic form field --}}
<div class="space-y-2">
    <x-ui.label for="email" required>Email Address</x-ui.label>
    <x-ui.input 
        id="email" 
        type="email" 
        placeholder="Enter your email"
    />
</div>

{{-- With Livewire --}}
<div class="space-y-2">
    <x-ui.label for="name">Username</x-ui.label>
    <x-ui.input 
        id="name" 
        wire:model="username"
        placeholder="Choose a username"
    />
</div>

{{-- Disabled input --}}
<x-ui.input disabled value="Read only" />
```

---

### Textarea

**Props:**
- `disabled`: boolean

**Examples:**
```blade
<div class="space-y-2">
    <x-ui.label for="message">Message</x-ui.label>
    <x-ui.textarea 
        id="message" 
        rows="4"
        placeholder="Enter your message..."
    />
</div>

{{-- With Livewire --}}
<x-ui.textarea wire:model="notes" />

{{-- Pre-filled content --}}
<x-ui.textarea>{{ $existingContent }}</x-ui.textarea>
```

---

### Stat Box (Custom Military Component)

**Props:**
- `label`: String - The stat label
- `value`: String - The stat value
- `icon`: HTML string - Optional SVG icon

**Examples:**
```blade
{{-- Simple stat --}}
<x-ui.stat-box 
    label="Total Users" 
    value="1,234"
/>

{{-- With additional info in slot --}}
<x-ui.stat-box 
    label="Active Maps" 
    value="32"
>
    +5 from last hour
</x-ui.stat-box>

{{-- With icon --}}
<x-ui.stat-box 
    label="Victory Points" 
    value="150"
    :icon="'<svg class=\'w-8 h-8\' fill=\'currentColor\'>...</svg>'"
/>

{{-- Custom styling --}}
<x-ui.stat-box 
    label="Casualties" 
    value="999"
    class="border-red-500 bg-red-900/10"
/>

{{-- Grid of stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-ui.stat-box label="Metric 1" value="100" />
    <x-ui.stat-box label="Metric 2" value="200" />
    <x-ui.stat-box label="Metric 3" value="300" />
</div>
```

---

### Table Components

**Examples:**
```blade
<x-ui.table>
    <x-ui.table-header>
        <x-ui.table-row>
            <x-ui.table-head>Name</x-ui.table-head>
            <x-ui.table-head>Status</x-ui.table-head>
            <x-ui.table-head class="text-right">Count</x-ui.table-head>
        </x-ui.table-row>
    </x-ui.table-header>
    
    <x-ui.table-body>
        @foreach($items as $item)
        <x-ui.table-row>
            <x-ui.table-cell class="font-medium">{{ $item->name }}</x-ui.table-cell>
            <x-ui.table-cell>
                <x-ui.badge variant="success">Active</x-ui.badge>
            </x-ui.table-cell>
            <x-ui.table-cell class="text-right">{{ $item->count }}</x-ui.table-cell>
        </x-ui.table-row>
        @endforeach
    </x-ui.table-body>
</x-ui.table>

{{-- Empty state --}}
<x-ui.table>
    <x-ui.table-body>
        @forelse($items as $item)
            <x-ui.table-row>
                <x-ui.table-cell>{{ $item->name }}</x-ui.table-cell>
            </x-ui.table-row>
        @empty
            <x-ui.table-row>
                <x-ui.table-cell colspan="3" class="text-center">
                    No data available
                </x-ui.table-cell>
            </x-ui.table-row>
        @endforelse
    </x-ui.table-body>
</x-ui.table>
```

---

### Separator

**Props:**
- `orientation`: horizontal | vertical (default: horizontal)

**Examples:**
```blade
{{-- Horizontal separator --}}
<div>Section 1</div>
<x-ui.separator />
<div>Section 2</div>

{{-- Vertical separator --}}
<div class="flex items-center gap-4">
    <span>Item 1</span>
    <x-ui.separator orientation="vertical" class="h-8" />
    <span>Item 2</span>
</div>

{{-- With spacing --}}
<x-ui.separator class="my-8" />
```

---

## 🎯 Complete Example Page

```blade
<div class="container mx-auto p-6 space-y-8">
    {{-- Header --}}
    <div>
        <h1 class="text-4xl font-bold text-military-text-primary">Dashboard</h1>
        <p class="text-military-text-secondary mt-2">Welcome to the command center</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <x-ui.stat-box label="Total Maps" value="32" />
        <x-ui.stat-box label="Active Wars" value="1" />
        <x-ui.stat-box label="Structures" value="1,234" />
        <x-ui.stat-box label="Players" value="850" />
    </div>

    {{-- Main Content Card --}}
    <x-ui.card>
        <x-ui.card-header>
            <x-ui.card-title>Recent Activity</x-ui.card-title>
            <x-ui.card-description>Latest updates from the battlefield</x-ui.card-description>
        </x-ui.card-header>

        <x-ui.card-content>
            <x-ui.table>
                <x-ui.table-header>
                    <x-ui.table-row>
                        <x-ui.table-head>Map</x-ui.table-head>
                        <x-ui.table-head>Status</x-ui.table-head>
                        <x-ui.table-head>Control</x-ui.table-head>
                    </x-ui.table-row>
                </x-ui.table-header>
                <x-ui.table-body>
                    @foreach($maps as $map)
                    <x-ui.table-row>
                        <x-ui.table-cell>{{ $map->name }}</x-ui.table-cell>
                        <x-ui.table-cell>
                            <x-ui.badge variant="success">Active</x-ui.badge>
                        </x-ui.table-cell>
                        <x-ui.table-cell>{{ $map->control }}</x-ui.table-cell>
                    </x-ui.table-row>
                    @endforeach
                </x-ui.table-body>
            </x-ui.table>
        </x-ui.card-content>

        <x-ui.card-footer class="justify-between">
            <x-ui.button variant="outline">Refresh</x-ui.button>
            <x-ui.button>View All Maps</x-ui.button>
        </x-ui.card-footer>
    </x-ui.card>

    {{-- Actions --}}
    <div class="flex gap-4">
        <x-ui.button>Primary Action</x-ui.button>
        <x-ui.button variant="secondary">Secondary</x-ui.button>
        <x-ui.button variant="outline">Cancel</x-ui.button>
    </div>
</div>
```

---

## 🔧 Customization

All components accept additional classes via the `class` attribute:

```blade
<x-ui.button class="w-full">Full Width Button</x-ui.button>
<x-ui.card class="shadow-2xl">Card with extra shadow</x-ui.card>
<x-ui.badge class="text-lg px-4">Larger badge</x-ui.badge>
```

All components merge your custom classes with the default classes, so you can override or extend styling as needed.

---

## 🚀 Next Steps

1. Replace existing UI elements with these components
2. Create additional custom components as needed
3. Extend variants for specific use cases
4. Build complex layouts by composing these base components

See `war-status-new-components.blade.php` for a complete real-world example!
