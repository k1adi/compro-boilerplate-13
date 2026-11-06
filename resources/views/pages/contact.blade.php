@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    {{-- Section 1: Koolom Split Contact Banner (.section-banner[variant="split-with-image"] from /contact-v1) --}}
    <section class="border-b border-border-subtle bg-surface pt-6 pb-12 md:pt-10 md:pb-16">
        <x-ui.container>
            <div class="rounded-[var(--radius-tile)] border border-secondary-900 bg-secondary-800 p-7 text-white shadow-sm sm:p-10 lg:p-12">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-secondary-900/60 px-3.5 py-1 text-xs font-semibold text-tertiary-400">
                    {{ __('ui.nav.contact') }}
                </span>
                <h1 class="mt-4 max-w-3xl font-display text-[length:var(--text-hero)] font-bold tracking-tight text-white leading-[1.12]">
                    {{ $isId
                        ? 'Mari Diskusikan Kebutuhan Bisnis Anda'
                        : "Let's Talk About Your Business Matter" }}
                </h1>
                <p class="mt-4 max-w-[62ch] text-base leading-relaxed text-secondary-100 md:text-lg">
                    {{ $isId
                        ? 'Hubungi kami untuk konsultasi awal gratis dan 100% rahasia. Kami merespons setiap permohonan dalam maksimal 1 hari kerja.'
                        : 'Reach out for a free, confidential consultation. We respond to every inquiry within one business day.' }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-2.5 pt-2">
                    <span class="rounded-full border border-white/20 bg-secondary-900/50 px-3.5 py-1 text-xs font-medium text-secondary-100">
                        ✓ {{ $isId ? '100% Rahasia' : '100% Confidential' }}
                    </span>
                    <span class="rounded-full border border-white/20 bg-secondary-900/50 px-3.5 py-1 text-xs font-medium text-secondary-100">
                        ✓ {{ $isId ? 'Konsultasi Awal Gratis' : 'No Obligation' }}
                    </span>
                    <span class="rounded-full border border-white/20 bg-secondary-900/50 px-3.5 py-1 text-xs font-medium text-secondary-100">
                        ✓ {{ $isId ? 'Balasan < 1 Hari Kerja' : 'Reply Within 1 Business Day' }}
                    </span>
                </div>
            </div>
        </x-ui.container>
    </section>

    {{-- Section 2: Two-Column Contact Form & Advisor Card (.section-contact from /contact-v1) --}}
    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
        :selected-service-code="$selectedServiceCode"
    />

    {{-- Section 3: Our Locations Grid (.section-locations from /contact-v1) --}}
    <section class="border-b border-border-subtle bg-surface-soft py-16 md:py-20">
        <x-ui.container class="flex flex-col gap-10">
            <div class="flex flex-col gap-2 max-w-2xl">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                    [{{ $isId ? 'LOKASI KANTOR KAMI' : 'OUR LOCATIONS' }}]
                </span>
                <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
                    {{ $isId ? 'Kantor Konsultasi di Pusat Bisnis Utama' : 'Offices Close to Your Business' }}
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Location 1: Jakarta HQ --}}
                <div class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 shadow-sm">
                    <div>
                        <span class="inline-flex items-center rounded-full bg-secondary-100 px-3 py-1 font-mono text-xs font-bold text-secondary-800">
                            {{ __('ui.rfq.hq_label') }}
                        </span>
                        <h3 class="mt-4 font-display text-xl font-bold text-ink">
                            Jakarta Selatan
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                            {{ $settings->hqAddress }}
                        </p>
                    </div>
                    <div class="mt-6 border-t border-border-subtle pt-4 font-mono text-xs text-ink-muted flex flex-col gap-1">
                        <p><strong class="text-ink">Tel:</strong> {{ $settings->primaryPhone }}</p>
                        <p><strong class="text-ink">Jam:</strong> {{ $settings->officeHours }}</p>
                    </div>
                </div>

                {{-- Location 2: Surabaya Branch --}}
                @if ($settings->branchAddress)
                    <div class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 shadow-sm">
                        <div>
                            <span class="inline-flex items-center rounded-full bg-tertiary-100 px-3 py-1 font-mono text-xs font-bold text-tertiary-800">
                                {{ __('ui.rfq.branch_label') }}
                            </span>
                            <h3 class="mt-4 font-display text-xl font-bold text-ink">
                                Surabaya, Jawa Timur
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                                {{ $settings->branchAddress }}
                            </p>
                        </div>
                        <div class="mt-6 border-t border-border-subtle pt-4 font-mono text-xs text-ink-muted flex flex-col gap-1">
                            <p><strong class="text-ink">WhatsApp:</strong> {{ $settings->whatsappLeadNumber }}</p>
                            <p><strong class="text-ink">Jam:</strong> {{ $settings->officeHours }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </x-ui.container>
    </section>

    {{-- Section 4: Common Questions (.section-faq from /contact-v1) --}}
    @if (! empty($faqs))
        <x-sections.technical-faq
            :section-code="__('ui.faq.section_code')"
            :heading="$isId ? 'Pertanyaan Umum Sebelum Konsultasi' : 'Common Questions'"
            :faqs="$faqs"
            :contact-settings="$settings"
        />
    @endif
</x-layouts.compro>
