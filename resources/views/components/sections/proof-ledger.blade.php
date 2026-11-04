@props([
    'metrics' => [],
    'certifications' => [],
    'sectorDescriptors' => [],
    'isSampleBoilerplate' => true,
])

@if (count($metrics) > 0 || count($certifications) > 0)
    <section class="border-b border-border-interactive bg-surface-inverse py-14 text-ink-inverse md:py-20">
        <x-ui.container class="flex flex-col gap-10">
            {{-- Header & Honest Boilerplate Seed Notice (R-17, R-36, R-38) --}}
            <div class="flex flex-col items-start justify-between gap-4 border-b border-zinc-800 pb-6 lg:flex-row lg:items-end">
                <div class="flex flex-col gap-2">
                    <p class="font-mono text-xs font-semibold uppercase tracking-widest text-amber-400">
                        [{{ __('ui.proof.section_code') }}]
                    </p>
                    <h2 class="font-display text-2xl font-bold tracking-tight text-white md:text-3xl">
                        {{ __('ui.proof.heading') }}
                    </h2>
                </div>
                @if ($isSampleBoilerplate)
                    <span class="inline-flex items-center rounded-[var(--radius-tag)] border border-amber-400/50 bg-amber-950/60 px-3 py-1.5 font-mono text-xs font-semibold text-amber-300">
                        {{ __('ui.proof.seed_badge') }}
                    </span>
                @endif
            </div>

            {{-- Verified Metrics Tabular Grid --}}
            @if (count($metrics) > 0)
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($metrics as $metric)
                        <article class="flex flex-col justify-between rounded-[var(--radius-card)] border border-zinc-700 bg-zinc-900/90 p-5">
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-mono text-xs font-bold text-amber-400">
                                        [{{ $metric->id }}]
                                    </span>
                                    @if ($metric->isSamplePlaceholder)
                                        <span class="font-mono text-[11px] text-zinc-400">SEED</span>
                                    @endif
                                </div>
                                <p class="mt-3 font-mono text-3xl font-extrabold tracking-tight text-white tabular-nums md:text-4xl">
                                    {{ $metric->exactFigure }}
                                </p>
                                <h3 class="mt-2 font-display text-sm font-bold text-zinc-100">
                                    {{ $metric->label }}
                                </h3>
                            </div>
                            <p class="mt-4 border-t border-zinc-800 pt-3 text-xs leading-relaxed text-zinc-300">
                                {{ $metric->contextNote }}
                            </p>
                        </article>
                    @endforeach
                </div>
            @endif

            {{-- Registered Certifications & TKDN Compliance Cards --}}
            @if (count($certifications) > 0)
                <div class="flex flex-col gap-4">
                    <h3 class="font-mono text-xs font-bold uppercase tracking-wider text-zinc-300">
                        {{ __('ui.proof.certifications_title') }}
                    </h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        @foreach ($certifications as $cert)
                            <div class="rounded-[var(--radius-card)] border border-zinc-700 bg-zinc-900/60 p-5">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-mono text-sm font-bold text-amber-400">
                                        {{ $cert->standardCode }}
                                    </span>
                                    <span class="font-mono text-xs text-zinc-300 tabular-nums">
                                        {{ $cert->issuingBody }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm font-medium text-zinc-100">
                                    {{ $cert->scope }}
                                </p>
                                <p class="mt-3 font-mono text-xs text-zinc-300 tabular-nums">
                                    {{ __('ui.proof.ref_label') }} {{ $cert->referenceNumber }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Sector-Based Client Descriptors (R-16: Never fabricate client logos) --}}
            @if (count($sectorDescriptors) > 0)
                <div class="border-t border-zinc-800 pt-6">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-zinc-300">
                        {{ __('ui.proof.client_sectors_title') }}
                    </p>
                    <ul class="mt-3 grid grid-cols-1 gap-2.5 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($sectorDescriptors as $descriptor)
                            <li class="flex items-start gap-2 rounded-[var(--radius-tag)] border border-zinc-800 bg-zinc-900/40 px-3 py-2 text-xs text-zinc-200">
                                <span aria-hidden="true" class="font-mono font-bold text-amber-400">&gt;</span>
                                <span>{{ $descriptor }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </x-ui.container>
    </section>
@endif

