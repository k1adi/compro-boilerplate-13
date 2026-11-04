@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    <section class="border-b border-border-subtle bg-surface py-12 md:py-16">
        <x-ui.container class="flex flex-col gap-4">
            <x-ui.badge variant="accent">{{ __('ui.case_studies.section_code') }}</x-ui.badge>
            <h1 class="max-w-4xl font-display text-[length:var(--text-display-xl)] font-extrabold tracking-tight text-ink leading-[1.08]">
                {{ $isId
                    ? 'Arsip Komisioning Proyek Cold Storage, Chiller & Perpipaan'
                    : 'Commissioned Cold Storage, Chiller & Process Piping Project Dossiers' }}
            </h1>
            <p class="max-w-[65ch] text-[length:var(--text-body-lg)] leading-relaxed text-ink-muted">
                {{ $settings->valueProposition }}
            </p>
        </x-ui.container>
    </section>

    <x-sections.case-study-showcase
        :section-code="__('ui.case_studies.section_code')"
        :heading="$isId ? 'Rekam Jejak Implementasi & Pengukuran Komisioning' : 'Implementation Track Record & Measured Commissioning Outcomes'"
        :case-studies="$caseStudies"
    />

    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
    />
</x-layouts.compro>

