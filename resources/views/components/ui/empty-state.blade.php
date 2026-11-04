@props([
    'code' => 'STATUS // EMPTY',
    'title',
    'description',
    'actionLabel' => null,
    'actionUrl' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-[var(--radius-card)] border border-dashed border-border-interactive bg-surface-elevated p-8 text-left']) }}>
    <div class="font-mono text-xs font-medium text-accent">[{{ $code }}]</div>
    <h3 class="mt-2 font-display text-lg font-bold text-ink">{{ $title }}</h3>
    <p class="mt-1 max-w-xl text-sm leading-relaxed text-ink-muted">{{ $description }}</p>
    @if ($actionLabel && $actionUrl)
        <div class="mt-5">
            <x-ui.button :href="$actionUrl" variant="outline" icon="arrow-right">
                {{ $actionLabel }}
            </x-ui.button>
        </div>
    @endif
</div>

