@props([
    'variant' => 'danger',
    'title',
])

@php
    $variantStyles = match ($variant) {
        'success' => 'border-status-success bg-surface-elevated text-status-success',
        'warning' => 'border-status-warning bg-surface-elevated text-status-warning',
        default => 'border-status-danger bg-surface-elevated text-status-danger',
    };
@endphp

<div role="alert" {{ $attributes->merge(['class' => "rounded-[var(--radius-card)] border-l-4 border p-4 {$variantStyles}"]) }}>
    <div class="flex items-start gap-3">
        <span aria-hidden="true" class="font-mono text-sm font-bold">
            @if ($variant === 'success') [OK] @elseif ($variant === 'warning') [WARN] @else [ERR] @endif
        </span>
        <div class="flex-1 text-sm">
            <p class="font-bold text-ink">{{ $title }}</p>
            <div class="mt-1 text-ink-muted">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

