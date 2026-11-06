@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    {{-- Section 1: Koolom Left-Aligned Editorial Banner (.section-banner[variant="left-aligned-text"] from /blog) --}}
    <section class="border-b border-border-subtle bg-surface pt-6 pb-12 md:pt-10 md:pb-16">
        <x-ui.container>
            <div class="rounded-[var(--radius-tile)] border border-secondary-900 bg-secondary-800 p-7 text-white shadow-sm sm:p-10 lg:p-12">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-secondary-900/60 px-3.5 py-1 text-xs font-semibold text-tertiary-400">
                    {{ __('ui.case_studies.section_code') }}
                </span>
                <h1 class="mt-4 max-w-3xl font-display text-[length:var(--text-hero)] font-bold tracking-tight text-white leading-[1.12]">
                    {{ $isId
                        ? 'Studi Kasus & Solusi Bisnis Klien'
                        : 'Client Matters, Insights & Practical Outcomes' }}
                </h1>
                <p class="mt-4 max-w-[62ch] text-base leading-relaxed text-secondary-100 md:text-lg">
                    {{ $settings->valueProposition }}
                </p>
            </div>
        </x-ui.container>
    </section>

    {{-- Section 2: Featured Main Card + 2-Column Case Study Grid (.section-blog-single from /blog) --}}
    <x-sections.case-study-showcase
        :section-code="__('ui.case_studies.section_code')"
        :heading="$isId ? 'Rekam Jejak Pendampingan Perizinan, Kontrak & Transaksi' : 'Selected Client Matters & Advisory Results'"
        :case-studies="$caseStudies"
    />

    {{-- Section 3: Conversion CTA (.section-cta from /blog) --}}
    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
    />
</x-layouts.compro>
