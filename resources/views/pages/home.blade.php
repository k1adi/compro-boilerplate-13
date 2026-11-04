<x-layouts.compro :settings="$settings" :seo="$seo">
    {{-- Section 1: Asymmetric 7/5 Engineering Hero & Priority LCP Asset --}}
    <x-sections.hero-split
        :sector-code="$page->sectorCode"
        :headline="$page->headline"
        :subheadline="$page->subheadline"
        :primary-cta="$page->primaryCta"
        :secondary-cta="$page->secondaryCta"
        :hero-media="$page->heroMedia"
        :spec-caption="$page->specCaption"
    />

    {{-- Section 2: Full-Width Dark Tabular Proof Ledger & ISO/SMK3/TKDN Compliance --}}
    <x-sections.proof-ledger
        :metrics="$settings->metrics"
        :certifications="$settings->certifications"
        :sector-descriptors="$settings->clientSectorDescriptors"
        :is-sample-boilerplate="$settings->isSampleBoilerplate"
    />

    {{-- Section 3: 4/8 Sticky Header + Stacked Engineering Capability Matrix (SRV-01..SRV-04) --}}
    <x-sections.service-matrix
        :section-code="__('ui.services.section_code')"
        :heading="$page->servicesHeading"
        :summary="$page->servicesSummary"
        :services="$page->services"
    />

    {{-- Section 4: Commissioned Project Dossiers (CS-2025-01..CS-2024-03) --}}
    <x-sections.case-study-showcase
        :section-code="__('ui.case_studies.section_code')"
        :heading="$page->caseStudiesHeading"
        :summary="$page->caseStudiesSummary"
        :case-studies="$page->caseStudies"
    />

    {{-- Section 5: 5/7 Technical & Procurement FAQ + Direct Engineering Escalation --}}
    <x-sections.technical-faq
        :section-code="__('ui.faq.section_code')"
        :heading="$page->faqHeading"
        :summary="$page->faqSummary"
        :faqs="$page->faqs"
        :contact-settings="$settings"
    />

    {{-- Section 6: 7/5 Interactive 4-State RFQ & Thermal Audit Dispatch --}}
    <x-sections.rfq-cta-banner
        :heading="$page->rfqHeading"
        :subheadline="$page->rfqSubheadline"
        :services="$page->services"
        :contact-settings="$settings"
    />
</x-layouts.compro>

