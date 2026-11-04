@props([
    'action' => null,
    'href' => null,
    'variant' => 'primary',
    'icon' => 'none',
    'type' => 'button',
    'isExternal' => false,
    'external' => false,
])

@php
    $resolvedHref = $action?->url ?? $href;
    $resolvedVariant = $action?->variant ?? $variant;
    $resolvedIcon = $action?->icon ?? $icon;
    $resolvedExternal = $action?->isExternal ?? ($isExternal || $external);
    $resolvedAriaLabel = $action?->ariaLabel ?? null;

    $baseClasses = 'inline-flex min-h-11 items-center justify-center gap-2.5 rounded-[var(--radius-button)] px-5 py-2.5 text-sm font-semibold transition-colors duration-150 select-none';

    $variantClasses = match ($resolvedVariant) {
        'primary' => 'bg-accent text-accent-ink hover:bg-accent-hover active:translate-y-px border border-transparent',
        'secondary' => 'bg-primary text-ink-inverse hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-950 dark:hover:bg-zinc-200 active:translate-y-px border border-transparent',
        'outline' => 'border border-border-interactive bg-surface-elevated text-ink hover:border-ink hover:bg-surface active:translate-y-px',
        'ghost' => 'border border-transparent bg-transparent text-ink hover:bg-surface-elevated hover:border-border-subtle active:translate-y-px',
        default => 'bg-accent text-accent-ink hover:bg-accent-hover active:translate-y-px border border-transparent',
    };
@endphp

@if ($resolvedHref)
    <a
        href="{{ $resolvedHref }}"
        @if ($resolvedExternal) target="_blank" rel="noopener noreferrer" @endif
        @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
        {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses}"]) }}
    >
        <span>{{ $action ? $action->label : $slot }}</span>
        @if ($resolvedIcon === 'arrow-right')
            <span aria-hidden="true" class="font-mono text-base leading-none">&rarr;</span>
        @elseif ($resolvedIcon === 'download')
            <svg class="h-4 w-4 shrink-0" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                <path d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
            </svg>
        @elseif ($resolvedIcon === 'external')
            <span aria-hidden="true" class="font-mono text-sm leading-none">&#8599;</span>
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
        {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses}"]) }}
    >
        <span>{{ $action ? $action->label : $slot }}</span>
        @if ($resolvedIcon === 'arrow-right')
            <span aria-hidden="true" class="font-mono text-base leading-none">&rarr;</span>
        @endif
    </button>
@endif
