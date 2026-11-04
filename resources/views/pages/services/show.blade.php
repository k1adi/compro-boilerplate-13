@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $servicesIndexUrl = route($isId ? 'compro.services.index.id' : 'compro.services.index.en', ['locale' => $locale]);
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    <section class="border-b border-border-subtle bg-surface py-12 md:py-18 lg:py-24">
        <x-ui.container>
            <div class="mb-6 flex flex-wrap items-center gap-2 font-mono text-xs text-ink-muted">
                <a href="{{ $servicesIndexUrl }}" class="hover:text-accent underline">
                    {{ __('ui.nav.services') }}
                </a>
                <span aria-hidden="true">/</span>
                <span class="font-bold text-accent">{{ $service->code }}</span>
            </div>

            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-ui.badge variant="accent">{{ $service->code }}</x-ui.badge>
                        <x-ui.badge variant="neutral">{{ $service->targetSegment }}</x-ui.badge>
                    </div>

                    <h1 class="font-display text-[length:var(--text-display-xl)] font-extrabold tracking-tight text-ink leading-[1.08]">
                        {{ $service->title }}
                    </h1>

                    <p class="max-w-[62ch] text-[length:var(--text-body-lg)] leading-relaxed text-ink-muted">
                        {{ $service->problemSolved }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <x-ui.button :action="$service->primaryCta" />
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-6 border-t border-border-subtle pt-6 md:grid-cols-2">
                        <div>
                            <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                                {{ __('ui.services.deliverables_title') }}
                            </h2>
                            <ul class="mt-3 flex flex-col gap-2.5 text-sm leading-relaxed text-ink-muted">
                                @foreach ($service->deliverables as $deliverable)
                                    <li class="flex items-start gap-2">
                                        <span aria-hidden="true" class="font-mono font-bold text-accent">+</span>
                                        <span>{{ $deliverable }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                                {{ __('ui.services.specs_table_title') }}
                            </h2>
                            <dl class="mt-3 divide-y divide-border-subtle border border-border-interactive bg-surface-elevated text-xs">
                                @foreach ($service->technicalSpecs as $spec)
                                    <div class="grid grid-cols-2 gap-2 px-3.5 py-2.5">
                                        <dt class="font-medium text-ink-muted">{{ $spec['parameter'] }}</dt>
                                        <dd class="font-mono font-semibold text-ink tabular-nums text-right">{{ $spec['value'] }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-2">
                        <x-ui.image :media="$service->heroImage" :priority="true" />
                    </div>
                </div>
            </div>
        </x-ui.container>
    </section>

    <x-sections.process-timeline
        :section-code="$service->code . ' // WORKFLOW'"
        :heading="__('ui.services.workflow_title')"
        :steps="$service->workflowSteps"
    />

    @if (count($relatedStudies) > 0)
        <x-sections.case-study-showcase
            :section-code="__('ui.case_studies.section_code')"
            :heading="$isId ? 'Referensi Proyek Terkait (' . $service->code . ')' : 'Related Commissioned Projects (' . $service->code . ')'"
            :case-studies="$relatedStudies"
        />
    @endif

    <x-sections.technical-faq
        :section-code="__('ui.faq.section_code')"
        :heading="$isId ? 'Pertanyaan Teknis Seputar ' . $service->code : 'Technical FAQ for ' . $service->code"
        :faqs="$relatedFaqs"
        :contact-settings="$settings"
    />

    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$service->problemSolved"
        :services="$allServices"
        :contact-settings="$settings"
        :selected-service-code="$service->code"
    />
</x-layouts.compro>

