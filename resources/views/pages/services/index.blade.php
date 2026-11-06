@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    {{-- Section 1: Koolom Practice Areas Banner (.section-banner[variant="full-bleed-image"] from /services-v3) --}}
    <section class="border-b border-border-subtle bg-surface pt-6 pb-12 md:pt-10 md:pb-16">
        <x-ui.container>
            <div class="rounded-[var(--radius-tile)] border border-secondary-900 bg-secondary-800 p-7 text-white shadow-sm sm:p-10 lg:p-12">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-secondary-900/60 px-3.5 py-1 text-xs font-semibold text-tertiary-400">
                    {{ __('ui.services.section_code') }}
                </span>
                <h1 class="mt-4 max-w-3xl font-display text-[length:var(--text-hero)] font-bold tracking-tight text-white leading-[1.12]">
                    {{ $isId
                        ? 'Layanan Hukum & Perizinan Bisnis untuk Setiap Kebutuhan Usaha'
                        : 'Comprehensive Business & Legal Services for Every Matter' }}
                </h1>
                <p class="mt-4 max-w-[62ch] text-base leading-relaxed text-secondary-100 md:text-lg">
                    {{ $settings->valueProposition }}
                </p>
            </div>
        </x-ui.container>
    </section>

    {{-- Section 2: Practice Areas Grid (.section-service from /services-v3) --}}
    <x-sections.service-matrix
        :section-code="__('ui.services.section_code')"
        :heading="$isId ? 'Bagaimana Kami Membantu Bisnis Anda' : 'How We Can Help You'"
        :services="$services"
    />

    {{-- Section 3: Common Questions (.section-faq from /services-v3) --}}
    <x-sections.technical-faq
        :section-code="__('ui.faq.section_code')"
        :heading="$isId ? 'Pertanyaan Umum Seputar Layanan & Biaya' : 'Common Questions About Our Services'"
        :faqs="$faqs"
        :contact-settings="$settings"
    />

    {{-- Section 4: Conversion CTA (.section-cta from /services-v3) --}}
    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
    />
</x-layouts.compro>
