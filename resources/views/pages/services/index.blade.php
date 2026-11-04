@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    <section class="border-b border-border-subtle bg-surface py-12 md:py-16">
        <x-ui.container class="flex flex-col gap-4">
            <x-ui.badge variant="accent">{{ __('ui.services.section_code') }}</x-ui.badge>
            <h1 class="max-w-4xl font-display text-[length:var(--text-display-xl)] font-extrabold tracking-tight text-ink leading-[1.08]">
                {{ $isId
                    ? 'Matriks Layanan Rekayasa Rantai Dingin, Chiller & Perpipaan Industri'
                    : 'Industrial Cold Chain, Chiller & Process Piping Engineering Matrix' }}
            </h1>
            <p class="max-w-[65ch] text-[length:var(--text-body-lg)] leading-relaxed text-ink-muted">
                {{ $settings->valueProposition }}
            </p>
        </x-ui.container>
    </section>

    <x-sections.service-matrix
        :section-code="__('ui.services.section_code')"
        :heading="$isId ? 'Spesifikasi Teknis & Lingkup Pekerjaan (SRV-01 s/d SRV-04)' : 'Technical Specifications & Engineering Scope (SRV-01 to SRV-04)'"
        :services="$services"
    />

    <x-sections.technical-faq
        :section-code="__('ui.faq.section_code')"
        :heading="$isId ? 'Pertanyaan Teknis & Kualifikasi Pengadaan' : 'Technical & Procurement Qualification FAQ'"
        :faqs="$faqs"
        :contact-settings="$settings"
    />

    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
    />
</x-layouts.compro>

