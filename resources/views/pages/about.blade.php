@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $primaryServiceSteps = $services[0]->workflowSteps ?? [];
    $contactUrl = route($isId ? 'compro.contact.id' : 'compro.contact.en', ['locale' => $locale]);
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    {{-- Section 1: Koolom Split Banner (.section-banner[variant="split-with-image"] from /about-us) --}}
    <section class="border-b border-border-subtle bg-surface pt-6 pb-16 md:pt-10 md:pb-20">
        <x-ui.container>
            <div class="grid grid-cols-1 items-center gap-8 rounded-[var(--radius-tile)] border border-secondary-900 bg-secondary-800 p-7 text-white shadow-sm sm:p-10 lg:grid-cols-12 lg:p-12">
                <div class="lg:col-span-7 flex flex-col gap-5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-secondary-900/60 px-3.5 py-1 text-xs font-semibold text-tertiary-400">
                            {{ __('ui.nav.about') }}
                        </span>
                        <span class="rounded-full border border-white/20 bg-secondary-900/40 px-3 py-1 font-mono text-xs text-secondary-100">
                            Est. {{ $settings->foundingYear }}
                        </span>
                    </div>

                    <h1 class="font-display text-[length:var(--text-hero)] font-bold tracking-tight text-white leading-[1.12]">
                        {{ $isId
                            ? 'Pendamping Hukum dan Perizinan Bisnis untuk Perusahaan Anda'
                            : 'Trusted Legal and Business Counsel for Growing Companies' }}
                    </h1>

                    <p class="max-w-[60ch] text-base leading-relaxed text-secondary-100 md:text-lg">
                        {{ $settings->valueProposition }}
                    </p>

                    <div class="pt-2">
                        <x-ui.button :href="$contactUrl" variant="primary" icon="arrow-right">
                            {{ __('ui.nav.cta_audit') }}
                        </x-ui.button>
                    </div>
                </div>

                {{-- Right Summary Card inside Split Banner --}}
                <div class="lg:col-span-5 flex flex-col gap-4 rounded-[var(--radius-card)] border border-white/15 bg-secondary-900/80 p-6 sm:p-7">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-tertiary-400">
                        {{ $isId ? 'PROFIL FIRMA' : 'FIRM SNAPSHOT' }}
                    </p>
                    <p class="font-display text-lg font-bold text-white">
                        {{ $settings->legalName }}
                    </p>
                    <p class="text-xs leading-relaxed text-secondary-100">
                        {{ $isId
                            ? 'Melayani pendirian badan usaha (PT & PT PMA), penyusunan kontrak komersial, kepatuhan regulasi, dan transaksi bisnis di Jakarta serta Surabaya.'
                            : 'Advising on company formation (PT & PT PMA), commercial contracts, regulatory compliance, and M&A transactions across Jakarta and Surabaya.' }}
                    </p>
                    <div class="grid grid-cols-2 gap-3 border-t border-white/15 pt-4 font-mono">
                        <div>
                            <p class="text-2xl font-extrabold text-white tabular-nums">450+</p>
                            <p class="text-[11px] text-secondary-100">{{ $isId ? 'Klien Korporasi' : 'Corporate Clients' }}</p>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-tertiary-400 tabular-nums">12+</p>
                            <p class="text-[11px] text-secondary-100">{{ $isId ? 'Tahun Praktik' : 'Years of Practice' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.container>
    </section>

    {{-- Section 2: Managing Partner Commitment (.section-founder[variant="quote-led-portrait"] from /about-us) --}}
    <section class="border-b border-border-subtle bg-surface py-16 md:py-20">
        <x-ui.container>
            <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-12 lg:gap-12">
                <div class="lg:col-span-5 rounded-[var(--radius-tile)] border border-border-subtle bg-surface-tinted p-8">
                    <span class="font-mono text-xs font-bold uppercase tracking-wider text-secondary-700">
                        [{{ $isId ? 'KOMITMEN KAMI' : 'OUR COMMITMENT' }}]
                    </span>
                    <p class="mt-4 font-display text-xl font-bold leading-snug text-ink sm:text-2xl">
                        {{ $isId
                            ? '"Pendampingan hukum dan perizinan bisnis seharusnya terasa jelas, praktis, dan memberikan kepastian bagi setiap pengambil keputusan."'
                            : '"Strong legal and business counsel should feel approachable, transparent, and practical for every decision-maker."' }}
                    </p>
                    <div class="mt-6 border-t border-border-subtle pt-4">
                        <p class="font-display text-sm font-bold text-ink">Koolom Partners Advisory Board</p>
                        <p class="font-mono text-xs text-ink-muted">Jakarta &amp; Surabaya</p>
                    </div>
                </div>

                <div class="lg:col-span-7 flex flex-col gap-5">
                    <span class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                        [{{ $isId ? 'VISI & STANDAR KERJA' : 'VISION & PRACTICE STANDARDS' }}]
                    </span>
                    <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
                        {{ $isId
                            ? 'Dibangun di Atas Kejelasan Biaya dan Ketepatan Waktu'
                            : 'Built on Fee Transparency and Timely Execution' }}
                    </h2>
                    <p class="text-base leading-relaxed text-ink-muted">
                        {{ $isId
                            ? 'Banyak pemilik bisnis menunda konsultasi hukum karena khawatir dengan prosedur yang rumit dan biaya yang tidak pasti. Di Koolom Partners, kami menyederhanakan setiap langkah perizinan maupun penyusunan kontrak dengan estimasi biaya tertulis di muka.'
                            : 'Many business owners delay seeking legal advice because they worry about complex jargon and unpredictable billing. At Koolom Partners, we simplify every licensing and contract matter with clear timelines and upfront fixed-fee quotes.' }}
                    </p>
                </div>
            </div>
        </x-ui.container>
    </section>

    {{-- Section 3: Why Choose Us & Credentials (.section-about + .section-why from /about-us) --}}
    <x-sections.proof-ledger
        :metrics="$settings->metrics"
        :certifications="$settings->certifications"
        :sector-descriptors="$settings->clientSectorDescriptors"
        :is-sample-boilerplate="$settings->isSampleBoilerplate"
    />

    {{-- Section 4: How It Works Timeline (.section-timeline from /about-us) --}}
    <x-sections.process-timeline
        section-code="02 // HOW IT WORKS"
        :heading="$isId ? 'Langkah Jelas dari Diskusi Pertama hingga Selesai' : 'A Clear Path From First Call to Resolution'"
        :steps="$primaryServiceSteps"
    />

    {{-- Section 5: Conversion CTA (.section-cta) --}}
    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
    />
</x-layouts.compro>
