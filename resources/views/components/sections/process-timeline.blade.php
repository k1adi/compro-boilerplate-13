@props([
    'sectionCode' => '02 // METHODOLOGY',
    'heading',
    'summary' => null,
    'steps' => [],
])

@if (count($steps) > 0)
    <section class="border-b border-border-subtle bg-surface-elevated py-14 md:py-20">
        <x-ui.container class="flex flex-col gap-10">
            <x-ui.section-header
                :code="$sectionCode"
                :heading="$heading"
                :summary="$summary"
            />

            @php
                $gridClass = match (count($steps)) {
                    1, 2 => 'lg:grid-cols-2',
                    3 => 'lg:grid-cols-3',
                    4 => 'lg:grid-cols-4',
                    default => 'lg:grid-cols-5',
                };
            @endphp

            {{-- R-05: Dynamic stage list adapting to actual stage count (4 or 5 stages) instead of forced 3-column card grid --}}
            <ol class="grid grid-cols-1 gap-4 md:grid-cols-2 {{ $gridClass }}">
                @foreach ($steps as $step)
                    <li class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-interactive bg-surface p-5">
                        <div>
                            <div class="flex items-center justify-between gap-2 border-b border-border-subtle pb-3">
                                <span class="font-mono text-xs font-bold uppercase tracking-wider text-accent tabular-nums">
                                    STEP {{ str_pad((string) ($step['stepNumber'] ?? $loop->iteration), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="font-mono text-[11px] text-ink-muted tabular-nums">
                                    {{ $loop->iteration }} / {{ count($steps) }}
                                </span>
                            </div>
                            <h3 class="mt-4 font-display text-base font-bold text-ink">
                                {{ $step['title'] }}
                            </h3>
                            <p class="mt-2 text-xs leading-relaxed text-ink-muted">
                                {{ $step['description'] }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </x-ui.container>
    </section>
@endif
