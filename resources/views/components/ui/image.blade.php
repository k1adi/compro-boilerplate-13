@props([
    'media',
    'priority' => false,
])

<figure {{ $attributes->merge(['class' => 'overflow-hidden rounded-[var(--radius-card)] border border-border-subtle bg-surface-elevated']) }}>
    <div class="relative w-full" style="aspect-ratio: {{ $media->aspectRatio }};">
        <img
            src="{{ $media->url }}"
            alt="{{ $media->alt }}"
            width="{{ $media->width }}"
            height="{{ $media->height }}"
            @if ($priority)
                fetchpriority="high"
                loading="eager"
            @else
                loading="lazy"
                decoding="async"
            @endif
            class="h-full w-full object-cover"
        >
        @if ($media->isPlaceholder && $media->placeholderLabel)
            <div class="border-t border-border-subtle bg-surface-elevated/95 px-3 py-1.5 font-mono text-[11px] font-medium text-accent">
                {{ $media->placeholderLabel }}
            </div>
        @endif
    </div>
    @if ($media->caption)
        <figcaption class="border-t border-border-subtle bg-surface px-4 py-2.5 font-mono text-xs text-ink-muted tabular-nums">
            {{ $media->caption }}
        </figcaption>
    @endif
</figure>

