@props([
    'sectionCode' => '03 // TECHNICAL & PROCUREMENT FAQ',
    'heading',
    'summary' => null,
    'faqs' => [],
    'contactSettings',
])

@php
    $waNumber = preg_replace('/[^0-9]/', '', $contactSettings->whatsappLeadNumber);
    $firstFaqId = $faqs[0]->id ?? '';
@endphp

<section class="border-b border-border-subtle bg-surface py-14 md:py-20 lg:py-24">
    <x-ui.container>
        <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
            {{-- Left Column (5 Cols on Desktop): Section Header & Direct Engineering Escalation Card --}}
            <div class="lg:col-span-5 flex flex-col gap-6">
                <x-ui.section-header
                    :code="$sectionCode"
                    :heading="$heading"
                    :summary="$summary"
                />

                <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated p-6">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-accent">
                        [DIRECT APPLICATION ENGINEERING DESK]
                    </p>
                    <h3 class="mt-2 font-display text-lg font-bold text-ink">
                        {{ __('ui.faq.direct_desk_title') }}
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                        {{ __('ui.faq.direct_desk_body') }}
                    </p>
                    <div class="mt-5 flex flex-col gap-3">
                        <x-ui.button
                            :href="'https://wa.me/' . $waNumber"
                            variant="primary"
                            icon="external"
                            :external="true"
                            class="w-full"
                        >
                            {{ __('ui.faq.whatsapp_cta') }} ({{ $contactSettings->whatsappLeadNumber }})
                        </x-ui.button>
                        <x-ui.button
                            :href="'mailto:' . $contactSettings->engineeringEmail"
                            variant="outline"
                            icon="arrow-right"
                            class="w-full"
                        >
                            {{ __('ui.faq.email_cta') }} ({{ $contactSettings->engineeringEmail }})
                        </x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Right Column (7 Cols on Desktop): Accessible Technical FAQ Accordion --}}
            @if (count($faqs) > 0)
                <div
                    x-data="{ activeFaq: '{{ $firstFaqId }}' }"
                    class="lg:col-span-7 flex flex-col divide-y divide-border-subtle rounded-[var(--radius-card)] border border-border-interactive bg-surface-elevated"
                >
                    @foreach ($faqs as $faq)
                        @php
                            $panelId = 'faq-panel-' . $faq->id;
                            $triggerId = 'faq-trigger-' . $faq->id;
                        @endphp
                        <div>
                            <h3>
                                <button
                                    id="{{ $triggerId }}"
                                    type="button"
                                    @click="activeFaq = (activeFaq === '{{ $faq->id }}' ? '' : '{{ $faq->id }}')"
                                    :aria-expanded="(activeFaq === '{{ $faq->id }}').toString()"
                                    aria-controls="{{ $panelId }}"
                                    class="flex min-h-14 w-full items-start justify-between gap-4 px-5 py-4 text-left transition-colors hover:bg-surface"
                                >
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="font-mono text-xs font-bold text-accent">[{{ $faq->id }}]</span>
                                            <x-ui.badge variant="neutral">{{ $faq->category }}</x-ui.badge>
                                            @if ($faq->relatedServiceCode)
                                                <span class="font-mono text-[11px] text-ink-muted">{{ $faq->relatedServiceCode }}</span>
                                            @endif
                                        </div>
                                        <span class="font-display text-base font-bold text-ink">
                                            {{ $faq->question }}
                                        </span>
                                    </div>
                                    <span
                                        aria-hidden="true"
                                        class="mt-1 inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-[var(--radius-tag)] border border-border-interactive font-mono text-sm font-bold text-ink"
                                        x-text="activeFaq === '{{ $faq->id }}' ? '-' : '+'"
                                    >+</span>
                                </button>
                            </h3>
                            <div
                                id="{{ $panelId }}"
                                role="region"
                                aria-labelledby="{{ $triggerId }}"
                                x-show="activeFaq === '{{ $faq->id }}'"
                                x-collapse
                                x-cloak
                            >
                                <div class="border-t border-border-subtle bg-surface px-5 py-4 text-sm leading-relaxed text-ink-muted">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </x-ui.container>
</section>

