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

<section class="border-b border-border-subtle bg-surface-soft py-16 md:py-20 lg:py-[8.25rem]">
    <x-ui.container>
        <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
            {{-- Left Column (5 Cols on Desktop): Section Header & Deep Navy Escalation Card --}}
            <div class="lg:col-span-5 flex flex-col gap-6 lg:sticky lg:top-28">
                <div class="flex flex-col gap-2.5">
                    <span class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                        [{{ $sectionCode }}]
                    </span>
                    <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
                        {{ $heading }}
                    </h2>
                    @if ($summary)
                        <p class="text-base text-ink-muted leading-relaxed">
                            {{ $summary }}
                        </p>
                    @endif
                </div>

                <div class="rounded-[var(--radius-card)] border border-white/10 bg-secondary-900 p-7 text-white shadow-md">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-tertiary-400">
                        [DIRECT APPLICATION ENGINEERING DESK]
                    </p>
                    <h3 class="mt-2 font-display text-lg font-bold text-white">
                        {{ __('ui.faq.direct_desk_title') }}
                    </h3>
                    <p class="mt-2 text-xs leading-relaxed text-secondary-100">
                        {{ __('ui.faq.direct_desk_body') }}
                    </p>
                    <div class="mt-6 flex flex-col gap-3">
                        <x-ui.button
                            :href="'https://wa.me/' . $waNumber"
                            variant="primary"
                            icon="external"
                            :external="true"
                            class="w-full"
                        >
                            {{ __('ui.faq.whatsapp_cta') }}
                        </x-ui.button>
                        <a
                            href="mailto:{{ $contactSettings->engineeringEmail }}"
                            class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-button)] border border-white/20 bg-white/10 px-4 py-2.5 font-mono text-xs font-semibold text-white transition-colors hover:bg-white hover:text-secondary-950"
                        >
                            {{ __('ui.faq.email_cta') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column (7 Cols on Desktop): Clean White FAQ Cards --}}
            @if (count($faqs) > 0)
                <div
                    x-data="{ activeFaq: '{{ $firstFaqId }}' }"
                    class="lg:col-span-7 flex flex-col gap-3.5"
                >
                    @foreach ($faqs as $faq)
                        @php
                            $panelId = 'faq-panel-' . $faq->id;
                            $triggerId = 'faq-trigger-' . $faq->id;
                        @endphp
                        <div class="rounded-[var(--radius-card)] border border-border-subtle bg-surface shadow-sm overflow-hidden transition-colors hover:border-secondary-700">
                            <h3>
                                <button
                                    id="{{ $triggerId }}"
                                    type="button"
                                    @click="activeFaq = (activeFaq === '{{ $faq->id }}' ? '' : '{{ $faq->id }}')"
                                    :aria-expanded="(activeFaq === '{{ $faq->id }}').toString()"
                                    aria-controls="{{ $panelId }}"
                                    class="flex min-h-16 w-full items-start justify-between gap-4 px-6 py-5 text-left transition-colors"
                                >
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="font-mono text-xs font-bold text-accent">[{{ $faq->id }}]</span>
                                            <span class="rounded-full bg-secondary-100 px-2.5 py-0.5 font-mono text-[11px] font-bold text-secondary-800">
                                                {{ $faq->category }}
                                            </span>
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
                                        class="mt-1 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-[var(--radius-button)] border border-border-interactive bg-surface-soft font-mono text-base font-bold text-ink"
                                        x-text="activeFaq === '{{ $faq->id }}' ? '−' : '+'"
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
                                <div class="border-t border-border-subtle bg-surface-soft px-6 py-5 text-sm leading-relaxed text-ink-muted">
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
