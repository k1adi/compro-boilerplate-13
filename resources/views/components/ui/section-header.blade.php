@props([
    'sectionCode' => null,
    'code' => null,
    'heading',
    'summary' => null,
])

@php
    $resolvedCode = $sectionCode ?? $code ?? '00 // SECTION';
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col gap-3']) }}>
    <div class="font-mono text-xs font-medium tracking-wider text-accent uppercase">
        [{{ $resolvedCode }}]
    </div>
    <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
        {{ $heading }}
    </h2>
    @if ($summary)
        <p class="max-w-2xl text-base leading-relaxed text-ink-muted">
            {{ $summary }}
        </p>
    @endif
</div>
