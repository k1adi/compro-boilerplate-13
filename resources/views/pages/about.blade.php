@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $primaryServiceSteps = $services[0]->workflowSteps ?? [];
@endphp

<x-layouts.compro :settings="$settings" :seo="$seo">
    <section class="border-b border-border-subtle bg-surface py-12 md:py-18 lg:py-24">
        <x-ui.container class="flex flex-col gap-8">
            <div class="flex flex-wrap items-center gap-2">
                <x-ui.badge variant="accent">PROFILE // KBLI 43224 &amp; 28193</x-ui.badge>
                <x-ui.badge variant="neutral">EST. {{ $settings->foundingYear }}</x-ui.badge>
            </div>

            <h1 class="max-w-4xl font-display text-[length:var(--text-display-xl)] font-extrabold tracking-tight text-ink leading-[1.08]">
                {{ $isId
                    ? 'Rekayasa Termal Industri, Kepatuhan K3 & Fabrikasi Presisi Sejak ' . $settings->foundingYear
                    : 'Industrial Thermal Engineering, OHS Compliance & Precision Fabrication Since ' . $settings->foundingYear }}
            </h1>

            <p class="max-w-[65ch] text-[length:var(--text-body-lg)] leading-relaxed text-ink-muted">
                {{ $settings->valueProposition }}
            </p>

            <div class="grid grid-cols-1 gap-6 border-t border-border-subtle pt-8 md:grid-cols-2">
                <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-6">
                    <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-accent">
                        [{{ __('ui.rfq.hq_label') }}]
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-ink">
                        {{ $settings->hqAddress }}
                    </p>
                </div>
                @if ($settings->branchAddress)
                    <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-6">
                        <h2 class="font-mono text-xs font-bold uppercase tracking-wider text-accent">
                            [{{ __('ui.rfq.branch_label') }}]
                        </h2>
                        <p class="mt-2 text-sm leading-relaxed text-ink">
                            {{ $settings->branchAddress }}
                        </p>
                    </div>
                @endif
            </div>
        </x-ui.container>
    </section>

    <x-sections.proof-ledger
        :metrics="$settings->metrics"
        :certifications="$settings->certifications"
        :sector-descriptors="$settings->clientSectorDescriptors"
        :is-sample-boilerplate="$settings->isSampleBoilerplate"
    />

    <x-sections.process-timeline
        section-code="02 // ENGINEERING WORKFLOW"
        :heading="$isId ? 'Tahapan Eksekusi Rekayasa & Komisioning Standar' : 'Standard Engineering Execution & Commissioning Stages'"
        :steps="$primaryServiceSteps"
    />

    <x-sections.rfq-cta-banner
        :heading="__('ui.rfq.form_title')"
        :subheadline="$settings->valueProposition"
        :services="$services"
        :contact-settings="$settings"
    />
</x-layouts.compro>

