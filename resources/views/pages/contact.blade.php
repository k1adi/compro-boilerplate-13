@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    <section class="border-b border-border-subtle bg-surface py-12 md:py-16">
        <x-ui.container class="flex flex-col gap-4">
            <x-ui.badge variant="accent">{{ __('ui.rfq.section_code') }}</x-ui.badge>
            <h1 class="max-w-4xl font-display text-[length:var(--text-display-xl)] font-extrabold tracking-tight text-ink leading-[1.08]">
                {{ $isId
                    ? 'Jadwalkan Audit Termal Lapangan & Permintaan BoQ Teknis'
                    : 'Schedule an On-Site Thermal Audit & Technical BoQ Request' }}
            </h1>
            <p class="max-w-[65ch] text-[length:var(--text-body-lg)] leading-relaxed text-ink-muted">
                {{ $settings->valueProposition }}
            </p>
        </x-ui.container>
    </section>

    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
        :selected-service-code="$selectedServiceCode"
    />

    <x-sections.proof-ledger
        :metrics="$settings->metrics"
        :certifications="$settings->certifications"
        :sector-descriptors="$settings->clientSectorDescriptors"
        :is-sample-boilerplate="$settings->isSampleBoilerplate"
    />
</x-layouts.compro>

