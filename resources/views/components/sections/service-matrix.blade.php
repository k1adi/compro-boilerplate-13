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

<section id="service-matrix" class="border-b border-border-subtle bg-surface py-14 md:py-20 lg:py-24">
    <x-ui.container>
        @if (count($services) === 0)
            <x-ui.empty-state
                :title="__('ui.services.empty_title')"
                :description="__('ui.services.empty_body')"
            />
        @else
            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
                {{-- Left Column (4 Cols on Desktop): Sticky Section Coordinate & Index Link --}}
                <div class="lg:col-span-4 lg:sticky lg:top-24 flex flex-col gap-6">
                    <x-ui.section-header
                        :code="$sectionCode"
                        :heading="$heading"
                        :summary="$summary"
                    />
                    <div>
                        <x-ui.button :href="$allServicesUrl" variant="outline" icon="arrow-right">
                            {{ __('ui.services.all_services_cta') }}
                        </x-ui.button>
                    </div>
                </div>

                {{-- Right Column (8 Cols on Desktop): Stacked Engineering Specification Cards --}}
                <div class="lg:col-span-8 flex flex-col gap-8">
                    @foreach ($services as $service)
                        @php
                            $detailUrl = route($isId ? 'compro.services.show.id' : 'compro.services.show.en', [
                                'locale' => $locale,
                                'slug' => $service->slug,
                            ]);
                        @endphp
                        <article class="rounded-[var(--radius-card)] border border-border-subtle bg-surface-elevated p-6 transition-colors hover:border-border-interactive md:p-8">
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-border-subtle pb-4">
                                <x-ui.badge variant="accent">{{ $service->code }}</x-ui.badge>
                                <span class="font-mono text-xs text-ink-muted">
                                    {{ __('ui.services.target_segment') }}: <strong class="text-ink">{{ $service->targetSegment }}</strong>
                                </span>
                            </div>

                            <h3 class="mt-4 font-display text-[length:var(--text-heading-lg)] font-bold tracking-tight text-ink">
                                <a href="{{ $detailUrl }}" class="hover:text-accent transition-colors">
                                    {{ $service->title }}
                                </a>
                            </h3>

                            <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                                {{ $service->problemSolved }}
                            </p>

                            {{-- Quantified Deliverables & Technical Parameters Grid --}}
                            <div class="mt-6 grid grid-cols-1 gap-6 border-t border-border-subtle pt-5 md:grid-cols-2">
                                <div>
                                    <h4 class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                                        {{ __('ui.services.deliverables_title') }}
                                    </h4>
                                    <ul class="mt-3 flex flex-col gap-2 text-xs leading-relaxed text-ink-muted">
                                        @foreach ($service->deliverables as $deliverable)
                                            <li class="flex items-start gap-2">
                                                <span aria-hidden="true" class="font-mono font-bold text-accent">+</span>
                                                <span>{{ $deliverable }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                                        {{ __('ui.services.specs_table_title') }}
                                    </h4>
                                    <dl class="mt-3 divide-y divide-border-subtle border border-border-subtle bg-surface text-xs">
                                        @foreach ($service->technicalSpecs as $spec)
                                            <div class="grid grid-cols-2 gap-2 px-3 py-2">
                                                <dt class="font-medium text-ink-muted">{{ $spec['parameter'] }}</dt>
                                                <dd class="font-mono font-semibold text-ink tabular-nums text-right">{{ $spec['value'] }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            </div>

                            {{-- Card Action Bar --}}
                            <div class="mt-6 flex flex-col items-stretch justify-between gap-3 border-t border-border-subtle pt-5 sm:flex-row sm:items-center">
                                <x-ui.button :href="$detailUrl" variant="outline" icon="arrow-right">
                                    {{ __('ui.services.view_detail') }} ({{ $service->code }})
                                </x-ui.button>
                                <x-ui.button :action="$service->primaryCta" />
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </x-ui.container>
</section>
