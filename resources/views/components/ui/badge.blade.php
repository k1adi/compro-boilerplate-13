@props([
    'variant' => 'neutral',
])

@php
    $variantClasses = match ($variant) {
        'accent' => 'border-tertiary-700/40 bg-tertiary-50 text-tertiary-800 dark:bg-tertiary-950/40 dark:text-tertiary-400',
        'secondary' => 'border-secondary-700/30 bg-secondary-100 text-secondary-800 dark:bg-secondary-900 dark:text-secondary-100',
        'inverse' => 'border-white/15 bg-white/10 text-white',
        'warning' => 'border-status-warning/40 bg-surface-elevated text-status-warning',
        default => 'border-border-subtle bg-surface-soft text-ink-muted',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center border px-2 py-0.5 font-mono text-xs font-semibold tracking-tight rounded-[var(--radius-tag)] {$variantClasses}"]) }}>
    {{ $slot }}
</span>
