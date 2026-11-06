@props([
    'heading',
    'subheadline',
    'services' => [],
    'contactSettings',
    'selectedServiceCode' => 'SRV-01',
])

@php
    $locale = app()->getLocale();
    $submitUrl = route('compro.inquiries.store', ['locale' => $locale]);
    $sessionSuccess = session('rfq_success');
    $waNumber = preg_replace('/[^0-9]/', '', $contactSettings->whatsappLeadNumber);
@endphp

{{-- Full-Width High-Contrast Conversion CTA Banner (.section-cta): Secondary-800 Cobalt Blue Background --}}
<section id="rfq-form" class="border-b border-secondary-900 bg-secondary-800 py-16 text-white md:py-20 lg:py-24">
    <x-ui.container>
        <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
            {{-- Left Column (7 Cols on Desktop): Crisp White RFQ & Audit Form Card (.cta-sec-grid left) --}}
            <div
                x-data="rfqForm({
                    submitUrl: '{{ $submitUrl }}',
                    initialService: '{{ old('service_code', $selectedServiceCode) }}'
                })"
                class="lg:col-span-7 rounded-[var(--radius-tile)] border border-border-subtle bg-surface p-6 text-ink shadow-xl md:p-8"
            >
                <div class="border-b border-border-subtle pb-5">
                    <p class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                        [{{ __('ui.rfq.section_code') }}]
                    </p>
                    <h2 class="mt-2 font-display text-2xl font-bold tracking-tight text-ink md:text-3xl">
                        {{ $heading }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                        {{ $subheadline }}
                    </p>
                </div>

                {{-- Server-side Flash Success State --}}
                @if (is_array($sessionSuccess))
                    <div role="status" class="mt-6 rounded-[var(--radius-card)] border-2 border-status-ok bg-surface-soft p-6">
                        <p class="font-mono text-xs font-bold uppercase tracking-wider text-status-ok">
                            [STATUS: 201 CREATED // {{ __('ui.rfq.reference_label') }} {{ $sessionSuccess['reference_code'] ?? '' }}]
                        </p>
                        <h3 class="mt-2 font-display text-lg font-bold text-ink">
                            {{ __('ui.rfq.success_title') }}
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                            {{ $sessionSuccess['message'] ?? '' }}
                        </p>
                    </div>
                @endif

                {{-- Alpine Dynamic Success State --}}
                <div
                    x-show="state === 'success'"
                    x-cloak
                    role="status"
                    aria-live="polite"
                    class="mt-6 rounded-[var(--radius-card)] border-2 border-status-ok bg-surface-soft p-6"
                >
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-border-subtle pb-3">
                        <span class="font-mono text-xs font-bold uppercase text-status-ok">
                            [DISPATCH TICKET LOGGED]
                        </span>
                        <span class="font-mono text-sm font-extrabold text-ink tabular-nums" x-text="referenceCode"></span>
                    </div>
                    <h3 class="mt-3 font-display text-lg font-bold text-ink">
                        {{ __('ui.rfq.success_title') }}
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-muted" x-text="responseMessage"></p>
                    <div class="mt-5">
                        <button
                            type="button"
                            @click="resetForm()"
                            class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-button)] border border-border-interactive bg-surface px-4 py-2 text-xs font-semibold text-ink hover:border-secondary-700"
                        >
                            {{ __('ui.rfq.reset_button') }}
                        </button>
                    </div>
                </div>

                {{-- Server-side Validation Error Summary --}}
                @if ($errors->any())
                    <div class="mt-6">
                        <x-ui.alert variant="danger" :title="__('ui.rfq.error_summary_title')">
                            <ul class="mt-1 list-disc pl-5 text-xs">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </x-ui.alert>
                    </div>
                @endif

                {{-- Alpine Dynamic Error Summary --}}
                <div
                    x-show="state === 'error' && errorSummary"
                    x-cloak
                    role="alert"
                    class="mt-6 rounded-[var(--radius-card)] border border-status-danger bg-surface-soft p-4 text-sm text-status-danger"
                >
                    <p class="font-bold">{{ __('ui.rfq.error_summary_title') }}</p>
                    <p class="mt-1 text-xs text-ink" x-text="errorSummary"></p>
                </div>

                {{-- Interactive Form --}}
                <form
                    method="POST"
                    action="{{ $submitUrl }}"
                    @submit.prevent="submitForm($event)"
                    x-show="state !== 'success'"
                    novalidate
                    class="mt-6 flex flex-col gap-5"
                >
                    @csrf

                    <p class="font-mono text-xs text-ink-muted">
                        {{ __('ui.rfq.required_note') }}
                    </p>

                    {{-- Honeypot --}}
                    <div class="sr-only" aria-hidden="true">
                        <label for="rfq-company-website-hp">Company Website (Leave empty)</label>
                        <input
                            id="rfq-company-website-hp"
                            type="text"
                            name="company_website_hp"
                            x-model="form.company_website_hp"
                            tabindex="-1"
                            autocomplete="off"
                        >
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        {{-- Full Name --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="rfq-full-name" class="text-xs font-bold text-ink">
                                {{ __('ui.rfq.full_name') }}
                            </label>
                            <input
                                id="rfq-full-name"
                                type="text"
                                name="full_name"
                                required
                                value="{{ old('full_name') }}"
                                x-model="form.full_name"
                                placeholder="{{ __('ui.rfq.full_name_placeholder') }}"
                                :aria-invalid="hasError('full_name') ? 'true' : 'false'"
                                aria-describedby="err-full_name"
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                            >
                            @error('full_name')
                                <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                            @enderror
                            <p
                                id="err-full_name"
                                x-show="hasError('full_name')"
                                x-cloak
                                class="text-xs font-semibold text-status-danger"
                                x-text="'! ' + getError('full_name')"
                            ></p>
                        </div>

                        {{-- Company Name --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="rfq-company-name" class="text-xs font-bold text-ink">
                                {{ __('ui.rfq.company_name') }}
                            </label>
                            <input
                                id="rfq-company-name"
                                type="text"
                                name="company_name"
                                required
                                value="{{ old('company_name') }}"
                                x-model="form.company_name"
                                placeholder="{{ __('ui.rfq.company_name_placeholder') }}"
                                :aria-invalid="hasError('company_name') ? 'true' : 'false'"
                                aria-describedby="err-company_name"
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                            >
                            @error('company_name')
                                <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                            @enderror
                            <p
                                id="err-company_name"
                                x-show="hasError('company_name')"
                                x-cloak
                                class="text-xs font-semibold text-status-danger"
                                x-text="'! ' + getError('company_name')"
                            ></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        {{-- Work Email --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="rfq-work-email" class="text-xs font-bold text-ink">
                                {{ __('ui.rfq.work_email') }}
                            </label>
                            <input
                                id="rfq-work-email"
                                type="email"
                                name="work_email"
                                required
                                value="{{ old('work_email') }}"
                                x-model="form.work_email"
                                placeholder="{{ __('ui.rfq.work_email_placeholder') }}"
                                :aria-invalid="hasError('work_email') ? 'true' : 'false'"
                                aria-describedby="err-work_email"
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                            >
                            @error('work_email')
                                <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                            @enderror
                            <p
                                id="err-work_email"
                                x-show="hasError('work_email')"
                                x-cloak
                                class="text-xs font-semibold text-status-danger"
                                x-text="'! ' + getError('work_email')"
                            ></p>
                        </div>

                        {{-- Phone / WhatsApp --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="rfq-phone-whatsapp" class="text-xs font-bold text-ink">
                                {{ __('ui.rfq.phone_whatsapp') }}
                            </label>
                            <input
                                id="rfq-phone-whatsapp"
                                type="tel"
                                name="phone_whatsapp"
                                required
                                value="{{ old('phone_whatsapp') }}"
                                x-model="form.phone_whatsapp"
                                placeholder="{{ __('ui.rfq.phone_whatsapp_placeholder') }}"
                                :aria-invalid="hasError('phone_whatsapp') ? 'true' : 'false'"
                                aria-describedby="err-phone_whatsapp"
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 font-mono text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                            >
                            @error('phone_whatsapp')
                                <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                            @enderror
                            <p
                                id="err-phone_whatsapp"
                                x-show="hasError('phone_whatsapp')"
                                x-cloak
                                class="text-xs font-semibold text-status-danger"
                                x-text="'! ' + getError('phone_whatsapp')"
                            ></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        {{-- Service Code --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="rfq-service-code" class="text-xs font-bold text-ink">
                                {{ __('ui.rfq.service_code') }}
                            </label>
                            <select
                                id="rfq-service-code"
                                name="service_code"
                                required
                                x-model="form.service_code"
                                :aria-invalid="hasError('service_code') ? 'true' : 'false'"
                                aria-describedby="err-service_code"
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink focus:border-secondary-700"
                            >
                                @foreach ($services as $srv)
                                    <option value="{{ $srv->code }}">
                                        [{{ $srv->code }}] {{ $srv->title }}
                                    </option>
                                @endforeach
                                @if (count($services) === 0)
                                    <option value="SRV-01">[SRV-01] Pendirian Badan Usaha &amp; Perizinan OSS</option>
                                    <option value="SRV-02">[SRV-02] Penyusunan Kontrak Bisnis &amp; Perjanjian</option>
                                    <option value="SRV-03">[SRV-03] Kepatuhan Regulasi &amp; Retainer Korporasi</option>
                                    <option value="SRV-04">[SRV-04] Transaksi Bisnis, Akuisisi &amp; Uji Tuntas</option>
                                @endif
                                <option value="OTHER">{{ __('ui.rfq.service_other') }}</option>
                            </select>
                            @error('service_code')
                                <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                            @enderror
                            <p
                                id="err-service_code"
                                x-show="hasError('service_code')"
                                x-cloak
                                class="text-xs font-semibold text-status-danger"
                                x-text="'! ' + getError('service_code')"
                            ></p>
                        </div>

                        {{-- Facility Location --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="rfq-facility-location" class="text-xs font-bold text-ink">
                                {{ __('ui.rfq.facility_location') }}
                            </label>
                            <input
                                id="rfq-facility-location"
                                type="text"
                                name="facility_location"
                                required
                                value="{{ old('facility_location') }}"
                                x-model="form.facility_location"
                                placeholder="{{ __('ui.rfq.facility_location_placeholder') }}"
                                :aria-invalid="hasError('facility_location') ? 'true' : 'false'"
                                aria-describedby="err-facility_location"
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                            >
                            @error('facility_location')
                                <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                            @enderror
                            <p
                                id="err-facility_location"
                                x-show="hasError('facility_location')"
                                x-cloak
                                class="text-xs font-semibold text-status-danger"
                                x-text="'! ' + getError('facility_location')"
                            ></p>
                        </div>
                    </div>

                    {{-- Estimated Capacity --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="rfq-estimated-capacity" class="text-xs font-bold text-ink">
                            {{ __('ui.rfq.estimated_capacity') }}
                        </label>
                        <input
                            id="rfq-estimated-capacity"
                            type="text"
                            name="estimated_capacity"
                            value="{{ old('estimated_capacity') }}"
                            x-model="form.estimated_capacity"
                            placeholder="{{ __('ui.rfq.estimated_capacity_placeholder') }}"
                            class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 font-mono text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                        >
                    </div>

                    {{-- Technical Scope Brief --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="rfq-project-brief" class="text-xs font-bold text-ink">
                            {{ __('ui.rfq.project_brief') }}
                        </label>
                        <textarea
                            id="rfq-project-brief"
                            name="project_brief"
                            rows="4"
                            required
                            x-model="form.project_brief"
                            placeholder="{{ __('ui.rfq.project_brief_placeholder') }}"
                            :aria-invalid="hasError('project_brief') ? 'true' : 'false'"
                            aria-describedby="err-project_brief"
                            class="rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-secondary-700"
                        >{{ old('project_brief') }}</textarea>
                        @error('project_brief')
                            <p class="text-xs font-semibold text-status-danger">! {{ $message }}</p>
                        @enderror
                        <p
                            id="err-project_brief"
                            x-show="hasError('project_brief')"
                            x-cloak
                            class="text-xs font-semibold text-status-danger"
                            x-text="'! ' + getError('project_brief')"
                        ></p>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            :disabled="state === 'submitting'"
                            :aria-busy="(state === 'submitting').toString()"
                            class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-[var(--radius-button)] border border-transparent bg-accent px-6 py-3 font-display text-sm font-bold text-accent-ink transition-colors hover:bg-accent-hover shadow-md disabled:opacity-60 sm:w-auto"
                        >
                            <span x-text="state === 'submitting' ? '{{ __('ui.rfq.submitting_button') }}' : '{{ __('ui.rfq.submit_button') }}'">
                                {{ __('ui.rfq.submit_button') }}
                            </span>
                            <span aria-hidden="true" class="font-mono text-base leading-none">&rarr;</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right Column (5 Cols on Desktop): Deep Navy Dispatch Card (.cta-sec-actions) --}}
            <aside class="lg:col-span-5 flex flex-col gap-6 rounded-[var(--radius-tile)] border border-white/15 bg-secondary-900 p-7 text-white shadow-xl md:p-8">
                <div>
                    <span class="font-mono text-xs font-bold uppercase tracking-wider text-tertiary-400">
                        [SLA DISPATCH &amp; WORKSHOPS]
                    </span>
                    <h3 class="mt-2 font-display text-xl sm:text-2xl font-bold text-white">
                        {{ __('ui.rfq.dispatch_card_title') }}
                    </h3>
                </div>

                <dl class="flex flex-col gap-4 border-t border-white/10 pt-4 text-xs leading-relaxed text-slate-300">
                    <div>
                        <dt class="font-mono font-bold uppercase text-white">{{ __('ui.rfq.hq_label') }}</dt>
                        <dd class="mt-1">{{ $contactSettings->hqAddress }}</dd>
                    </div>

                    @if ($contactSettings->branchAddress)
                        <div>
                            <dt class="font-mono font-bold uppercase text-white">{{ __('ui.rfq.branch_label') }}</dt>
                            <dd class="mt-1">{{ $contactSettings->branchAddress }}</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="font-mono font-bold uppercase text-white">{{ __('ui.rfq.hours_label') }}</dt>
                        <dd class="mt-1 font-mono text-secondary-100 tabular-nums">{{ $contactSettings->officeHours }}</dd>
                    </div>

                    <div class="rounded-[var(--radius-button)] border border-white/10 bg-white/5 p-4">
                        <dt class="font-mono font-bold uppercase text-tertiary-400">{{ __('ui.rfq.sla_hours_label') }}</dt>
                        <dd class="mt-1 font-mono font-bold text-white text-sm tabular-nums">{{ $contactSettings->emergencySlaHours }}</dd>
                    </div>
                </dl>

                <div class="flex flex-col gap-3 border-t border-white/10 pt-5 font-mono text-xs tabular-nums">
                    <a
                        href="tel:{{ $contactSettings->primaryPhone }}"
                        class="flex min-h-11 items-center justify-between rounded-[var(--radius-button)] border border-white/20 bg-white/10 px-4 py-2.5 font-bold text-white transition-colors hover:bg-white hover:text-secondary-950"
                    >
                        <span>Tel Dispatch:</span>
                        <span class="text-tertiary-400">{{ $contactSettings->primaryPhone }}</span>
                    </a>
                    <a
                        href="https://wa.me/{{ $waNumber }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex min-h-11 items-center justify-between rounded-[var(--radius-button)] border border-white/20 bg-white/10 px-4 py-2.5 font-bold text-white transition-colors hover:bg-white hover:text-secondary-950"
                    >
                        <span>WhatsApp RFQ:</span>
                        <span class="text-tertiary-400">{{ $contactSettings->whatsappLeadNumber }}</span>
                    </a>
                    <a
                        href="mailto:{{ $contactSettings->engineeringEmail }}"
                        class="flex min-h-11 items-center justify-between rounded-[var(--radius-button)] border border-white/20 bg-white/10 px-4 py-2.5 font-bold text-white transition-colors hover:bg-white hover:text-secondary-950"
                    >
                        <span>Engineering Desk:</span>
                        <span class="text-tertiary-400">{{ $contactSettings->engineeringEmail }}</span>
                    </a>
                </div>
            </aside>
        </div>
    </x-ui.container>
</section>
