@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $studiesIndexUrl = route($isId ? 'compro.case_studies.index.id' : 'compro.case_studies.index.en', ['locale' => $locale]);
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    <section class="border-b border-border-subtle bg-surface py-12 md:py-18 lg:py-24">
        <x-ui.container>
            <div class="mb-6 flex flex-wrap items-center gap-2 font-mono text-xs text-ink-muted">
                <a href="{{ $studiesIndexUrl }}" class="hover:text-accent underline">
                    {{ __('ui.nav.case_studies') }}
                </a>
                <span aria-hidden="true">/</span>
                <span class="font-bold text-accent">{{ $study->code }}</span>
            </div>

            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-ui.badge variant="accent">{{ $study->code }}</x-ui.badge>
                        <x-ui.badge variant="neutral">{{ $study->relatedServiceCode }}</x-ui.badge>
                        @if ($study->isSamplePlaceholder)
                            <x-ui.badge variant="warning">{{ __('ui.case_studies.seed_note') }}</x-ui.badge>
                        @endif
                    </div>

                    <h1 class="font-display text-[length:var(--text-hero)] font-bold tracking-tight text-ink leading-[1.12]">
                        {{ $study->title }}
                    </h1>

                    <dl class="grid grid-cols-1 gap-4 rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-5 font-mono text-xs sm:grid-cols-2">
                        <div>
                            <dt class="text-ink-muted">{{ __('ui.case_studies.location_year') }}</dt>
                            <dd class="mt-1 font-bold text-ink">{{ $study->location }} ({{ $study->completionYear }})</dd>
                        </div>
                        <div>
                            <dt class="text-ink-muted">{{ __('ui.case_studies.capacity_label') }}</dt>
                            <dd class="mt-1 font-bold text-accent tabular-nums">{{ $study->installedCapacity }}</dd>
                        </div>
                    </dl>

                    <div class="flex flex-col gap-6 pt-2">
                        <div>
                            <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                                {{ __('ui.case_studies.challenge_label') }}
                            </h2>
                            <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                                {{ $study->engineeringChallenge }}
                            </p>
                        </div>

                        <div>
                            <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                                {{ __('ui.case_studies.solution_label') }}
                            </h2>
                            <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                                {{ $study->technicalSolution }}
                            </p>
                        </div>

                        <div class="rounded-[var(--radius-card)] border-l-4 border-accent bg-surface-elevated p-5">
                            <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-accent">
                                {{ __('ui.case_studies.outcome_label') }}
                            </h2>
                            <p class="mt-2 text-sm font-semibold leading-relaxed text-ink">
                                {{ $study->measurableOutcome }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-2">
                        <x-ui.image :media="$study->heroImage" :priority="true" />
                    </div>
                </div>
            </div>
        </x-ui.container>
    </section>

    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$study->measurableOutcome"
        :services="$services"
        :contact-settings="$settings"
        :selected-service-code="$study->relatedServiceCode"
    />
</x-layouts.compro>

