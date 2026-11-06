@props([
    'sectionCode' => '01 // CAPABILITIES',
    'heading',
    'summary' => null,
    'services' => [],
])

@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $allServicesUrl = route($isId ? 'compro.services.index.id' : 'compro.services.index.en', ['locale' => $locale]);
@endphp

<section id="service-matrix" class="border-b border-border-subtle bg-surface py-16 md:py-20 lg:py-[8.25rem]">
    <x-ui.container>
        @if (count($services) === 0)
            <x-ui.empty-state
                :title="__('ui.services.empty_title')"
                :description="__('ui.services.empty_body')"
            />
        @else
            {{-- Koolom-Style Split Practice Header (.practice-head) --}}
            <div class="flex flex-col items-start justify-between gap-6 border-b border-border-subtle pb-8 lg:flex-row lg:items-end mb-12">
                <div class="flex flex-col gap-2.5 max-w-3xl">
                    <span class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                        [{{ $sectionCode }}]
                    </span>
                    <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
                        {{ $heading }}
                    </h2>
                    @if ($summary)
                        <p class="text-base leading-relaxed text-ink-muted">
                            {{ $summary }}
                        </p>
                    @endif
                </div>

                <div class="shrink-0">
                    <x-ui.button :href="$allServicesUrl" variant="outline" icon="arrow-right">
                        {{ __('ui.services.all_services_cta') }}
                    </x-ui.button>
                </div>
            </div>

            {{-- Numbered Service Grid (Koolom .services-secondary-wrap / .service-card pattern) --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach ($services as $service)
                    @php
                        $detailUrl = route($isId ? 'compro.services.show.id' : 'compro.services.show.en', [
                            'locale' => $locale,
                            'slug' => $service->slug,
                        ]);
                    @endphp
                    <article class="group flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 sm:p-8 transition-all hover:border-secondary-700 hover:shadow-md">
                        <div>
                            {{-- Numbered Index Badge in Tertiary-700 Orange + Target Segment Chip --}}
                            <div class="flex items-center justify-between gap-3 border-b border-border-subtle pb-4">
                                <span class="font-mono text-xl font-extrabold text-accent">
                                    0{{ $loop->iteration }}
                                </span>
                                <span class="rounded-full border border-secondary-700/20 bg-secondary-100 px-3 py-1 font-mono text-xs font-bold text-secondary-800">
                                    {{ $service->code }} &middot; {{ $service->targetSegment }}
                                </span>
                            </div>

                            <h3 class="mt-5 font-display text-xl sm:text-2xl font-bold tracking-tight text-ink group-hover:text-secondary-700 transition-colors">
                                <a href="{{ $detailUrl }}">
                                    {{ $service->title }}
                                </a>
                            </h3>

                            <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                                {{ $service->problemSolved }}
                            </p>

                            {{-- Technical Parameter Snapshot --}}
                            <div class="mt-6 rounded-[var(--radius-card)] border border-border-subtle bg-surface-soft p-4">
                                <p class="font-mono text-xs font-bold uppercase tracking-wider text-ink mb-2">
                                    {{ __('ui.services.specs_table_title') }}
                                </p>
                                <dl class="grid grid-cols-2 gap-2 text-xs">
                                    @foreach (array_slice($service->technicalSpecs, 0, 4) as $spec)
                                        <div class="border-b border-border-subtle/60 pb-1">
                                            <dt class="text-ink-muted">{{ $spec['parameter'] }}</dt>
                                            <dd class="font-mono font-bold text-ink tabular-nums">{{ $spec['value'] }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>

                        {{-- Card Action Footer --}}
                        <div class="mt-6 flex flex-col items-stretch justify-between gap-3 border-t border-border-subtle pt-5 sm:flex-row sm:items-center">
                            <a
                                href="{{ $detailUrl }}"
                                class="inline-flex min-h-11 items-center gap-1.5 font-mono text-xs font-bold text-secondary-700 hover:text-secondary-800 transition-colors"
                            >
                                <span>{{ __('ui.services.view_detail') }}</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <x-ui.button :action="$service->primaryCta" />
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </x-ui.container>
</section>
