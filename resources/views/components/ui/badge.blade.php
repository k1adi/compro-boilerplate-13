@props([
    'variant' => 'neutral',
])

@php
    $variantClasses = match ($variant) {
        'accent' => 'border-accent/40 bg-surface-elevated text-accent',
        'inverse' => 'border-zinc-700 bg-zinc-900 text-zinc-100',
        'warning' => 'border-status-warning/40 bg-surface-elevated text-status-warning',
        default => 'border-border-subtle bg-surface-elevated text-ink-muted',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center border px-2 py-0.5 font-mono text-xs font-medium tracking-tight rounded-[var(--radius-tag)] {$variantClasses}"]) }}>
    {{ $slot }}
</span>

