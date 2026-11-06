@props([
    'sectionCode' => '02 // COMMISSIONED PROJECT DOSSIERS',
    'heading',
    'summary' => null,
    'caseStudies' => [],
])

@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $allStudiesUrl = route($isId ? 'compro.case_studies.index.id' : 'compro.case_studies.index.en', ['locale' => $locale]);
@endphp

<section class="border-b border-border-subtle bg-surface py-16 md:py-20 lg:py-[8.25rem]">
    <x-ui.container class="flex flex-col gap-12">
        <div class="flex flex-col items-start justify-between gap-6 border-b border-border-subtle pb-8 lg:flex-row lg:items-end">
            <div class="flex flex-col gap-2.5 max-w-2xl">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                    [{{ $sectionCode }}]
                </span>
                <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
                    {{ $heading }}
                </h2>
                @if ($summary)
                    <p class="text-base text-ink-muted leading-relaxed">
                        {{ $summary }}
                    </p>
                @endif
            </div>

            <div class="shrink-0">
                <x-ui.button :href="$allStudiesUrl" variant="outline" icon="arrow-right">
                    {{ __('ui.case_studies.all_studies_cta') }}
                </x-ui.button>
            </div>
        </div>

        @if (count($caseStudies) === 0)
            <x-ui.empty-state
                :title="__('ui.case_studies.empty_title')"
                :description="__('ui.case_studies.empty_body')"
            />
        @else
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                @foreach ($caseStudies as $study)
                    @php
                        $studyUrl = route($isId ? 'compro.case_studies.show.id' : 'compro.case_studies.show.en', [
                            'locale' => $locale,
                            'slug' => $study->slug,
                        ]);
                    @endphp
                    <article class="{{ $loop->first && count($caseStudies) === 3 ? 'lg:col-span-12' : 'lg:col-span-6' }} flex flex-col justify-between rounded-[var(--radius-tile)] border border-border-subtle bg-surface-soft p-6 transition-all hover:border-secondary-700 hover:shadow-md md:p-8">
                        <div class="grid grid-cols-1 gap-8 {{ $loop->first && count($caseStudies) === 3 ? 'lg:grid-cols-12 items-start' : '' }}">
                            <div class="{{ $loop->first && count($caseStudies) === 3 ? 'lg:col-span-5' : '' }} overflow-hidden rounded-[var(--radius-card)] border border-border-subtle bg-surface">
                                <x-ui.image :media="$study->heroImage" class="w-full object-cover" />
                            </div>

                            <div class="{{ $loop->first && count($caseStudies) === 3 ? 'lg:col-span-7' : '' }} flex flex-col gap-4">
                                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-border-subtle pb-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="rounded-full border border-secondary-700/20 bg-secondary-100 px-3 py-0.5 font-mono text-xs font-bold text-secondary-800">
                                            {{ $study->code }}
                                        </span>
                                        <x-ui.badge variant="neutral">{{ $study->relatedServiceCode }}</x-ui.badge>
                                    </div>
                                    @if ($study->isSamplePlaceholder)
                                        <span class="font-mono text-[11px] font-bold text-accent">
                                            {{ __('ui.case_studies.seed_note') }}
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <p class="font-mono text-xs text-ink-muted">
                                        {{ $study->clientDescriptor }} &middot; {{ $study->location }} ({{ $study->completionYear }})
                                    </p>
                                    <h3 class="mt-1.5 font-display text-xl font-bold tracking-tight text-ink md:text-2xl">
                                        <a href="{{ $studyUrl }}" class="hover:text-secondary-700 transition-colors">
                                            {{ $study->title }}
                                        </a>
                                    </h3>
                                </div>

                                <div class="rounded-[var(--radius-button)] border border-border-subtle bg-surface px-3.5 py-2 font-mono text-xs tabular-nums">
                                    <span class="text-ink-muted">{{ __('ui.case_studies.capacity_label') }}:</span>
                                    <strong class="ml-1 text-ink">{{ $study->installedCapacity }}</strong>
                                </div>

                                <dl class="grid grid-cols-1 gap-3 text-xs leading-relaxed">
                                    <div>
                                        <dt class="font-mono font-bold uppercase text-ink">{{ __('ui.case_studies.challenge_label') }}</dt>
                                        <dd class="mt-1 text-ink-muted">{{ $study->engineeringChallenge }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-mono font-bold uppercase text-ink">{{ __('ui.case_studies.solution_label') }}</dt>
                                        <dd class="mt-1 text-ink-muted">{{ $study->technicalSolution }}</dd>
                                    </div>
                                    <div class="rounded-[var(--radius-card)] border-l-4 border-accent bg-surface p-3.5">
                                        <dt class="font-mono font-bold uppercase text-accent">{{ __('ui.case_studies.outcome_label') }}</dt>
                                        <dd class="mt-1 font-semibold text-ink">{{ $study->measurableOutcome }}</dd>
                                    </div>
                                </dl>

                                <div class="pt-2">
                                    <x-ui.button :href="$studyUrl" variant="outline" icon="arrow-right">
                                        {{ __('ui.case_studies.view_dossier') }} ({{ $study->code }})
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </x-ui.container>
</section>
