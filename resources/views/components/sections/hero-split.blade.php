@props([
    'sectorCode',
    'headline',
    'subheadline',
    'primaryCta',
    'secondaryCta',
    'heroMedia',
    'specCaption',
])

<section class="relative border-b border-border-subtle bg-surface py-12 md:py-18 lg:py-24">
    <x-ui.container>
        <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
            {{-- Left Column (7 Cols on Desktop): Engineering Value Proposition & Dual CTAs --}}
            <div class="lg:col-span-7 flex flex-col gap-6">
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui.badge variant="accent">{{ $sectorCode }}</x-ui.badge>
                    <x-ui.badge variant="neutral">{{ __('ui.hero.kbli_badge') }}</x-ui.badge>
                </div>

                <h1 class="font-display text-[length:var(--text-display-xl)] font-extrabold tracking-tight text-ink leading-[1.08]">
                    {{ $headline }}
                </h1>

                <p class="max-w-[62ch] text-[length:var(--text-body-lg)] leading-relaxed text-ink-muted">
                    {{ $subheadline }}
                </p>

                <div class="flex flex-col items-stretch gap-3 pt-2 sm:flex-row sm:items-center">
                    <x-ui.button :action="$primaryCta" />
                    <x-ui.button :action="$secondaryCta" />
                </div>

                {{-- Technical Operational Parameter Bar --}}
                <dl class="mt-4 grid grid-cols-1 gap-4 border-t border-border-subtle pt-6 sm:grid-cols-2">
                    <div class="border-l-2 border-accent pl-3.5">
                        <dt class="font-mono text-xs uppercase tracking-wider text-ink-muted">
                            {{ __('ui.hero.sla_label') }}
                        </dt>
                        <dd class="mt-1 font-mono text-sm font-bold text-ink tabular-nums">
                            &lt; 4 Hours On-Site (Jabodetabek &amp; Karawang)
                        </dd>
                    </div>
                    <div class="border-l-2 border-border-interactive pl-3.5">
                        <dt class="font-mono text-xs uppercase tracking-wider text-ink-muted">
                            {{ __('ui.hero.capacity_label') }}
                        </dt>
                        <dd class="mt-1 font-mono text-sm font-bold text-ink tabular-nums">
                            {{ __('ui.hero.capacity_value') }} (-40&deg;C to +18&deg;C)
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Right Column (5 Cols on Desktop): Priority LCP Schematic Asset --}}
            <div class="lg:col-span-5 flex flex-col gap-3">
                <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-2 shadow-sm">
                    <x-ui.image :media="$heroMedia" :priority="true" />
                    @if ($specCaption)
                        <div class="mt-2 flex items-center justify-between gap-2 border-t border-border-subtle px-2 pt-2 font-mono text-[11px] text-ink-muted tabular-nums">
                            <span>{{ $specCaption }}</span>
                            <span class="font-bold text-accent">[P&amp;ID // REV.4]</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-ui.container>
</section>

