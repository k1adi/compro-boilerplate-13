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

<section id="rfq-form" class="bg-surface-elevated py-14 md:py-20 lg:py-24">
    <x-ui.container>
        <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-12">
            {{-- Left Column (7 Cols on Desktop): 4-State Technical RFQ & Audit Form --}}
            <div
                x-data="rfqForm({
                    submitUrl: '{{ $submitUrl }}',
                    initialService: '{{ old('service_code', $selectedServiceCode) }}'
                })"
                class="lg:col-span-7 rounded-[var(--radius-card)] border border-border-interactive bg-surface p-6 shadow-sm md:p-8"
            >
                <div class="border-b border-border-subtle pb-5">
                    <p class="font-mono text-xs font-semibold uppercase tracking-widest text-accent">
                        [{{ __('ui.rfq.section_code') }}]
                    </p>
                    <h2 class="mt-2 font-display text-2xl font-bold tracking-tight text-ink md:text-3xl">
                        {{ $heading }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                        {{ $subheadline }}
                    </p>
                </div>

                {{-- Server-side Flash Success State (Fallback when JS is disabled) --}}
                @if (is_array($sessionSuccess))
                    <div role="status" class="mt-6 rounded-[var(--radius-card)] border-2 border-status-ok bg-surface-elevated p-6">
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

                {{-- Alpine Dynamic Success State (State 4: success) --}}
                <div
                    x-show="state === 'success'"
                    x-cloak
                    role="status"
                    aria-live="polite"
                    class="mt-6 rounded-[var(--radius-card)] border-2 border-status-ok bg-surface-elevated p-6"
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
                            class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-button)] border border-border-interactive bg-surface px-4 py-2 text-xs font-semibold text-ink hover:border-ink"
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

                {{-- Alpine Dynamic Error Summary (State 3: error) --}}
                <div
                    x-show="state === 'error' && errorSummary"
                    x-cloak
                    role="alert"
                    class="mt-6 rounded-[var(--radius-card)] border border-status-danger bg-surface-elevated p-4 text-sm text-status-danger"
                >
                    <p class="font-bold">{{ __('ui.rfq.error_summary_title') }}</p>
                    <p class="mt-1 text-xs text-ink" x-text="errorSummary"></p>
                </div>

                {{-- Interactive Form (States 1, 2, 3: idle, submitting, error) --}}
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

                    {{-- Anti-Spam Honeypot Field (Prohibited in StoreInquiryRequest) --}}
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
                        {{-- 1. Full Name & Title --}}
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
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
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

                        {{-- 2. Company Name --}}
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
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
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
                        {{-- 3. Corporate Work Email --}}
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
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
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

                        {{-- 4. Active Phone / WhatsApp --}}
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
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 font-mono text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
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
                        {{-- 5. Technical Service Category --}}
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
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink focus:border-accent"
                            >
                                @foreach ($services as $srv)
                                    <option value="{{ $srv->code }}">
                                        [{{ $srv->code }}] {{ $srv->title }}
                                    </option>
                                @endforeach
                                @if (count($services) === 0)
                                    <option value="SRV-01">[SRV-01] Cold Chain &amp; Cold Storage</option>
                                    <option value="SRV-02">[SRV-02] Preventive HVAC-R Maintenance SLA</option>
                                    <option value="SRV-03">[SRV-03] Industrial Process Piping &amp; Skid</option>
                                    <option value="SRV-04">[SRV-04] Chiller Retrofit &amp; PLC/SCADA BMS</option>
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

                        {{-- 6. Plant / Industrial Estate Location --}}
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
                                class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
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

                    {{-- 7. Estimated Capacity (Optional) --}}
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
                            class="min-h-11 rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 font-mono text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
                        >
                    </div>

                    {{-- 8. Technical Scope & Operating Brief --}}
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
                            class="rounded-[var(--radius-button)] border border-border-interactive bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-ink-muted/70 focus:border-accent"
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
                            class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-[var(--radius-button)] border border-transparent bg-accent px-6 py-3 font-display text-sm font-bold text-accent-ink transition-colors hover:bg-accent-hover disabled:opacity-60 sm:w-auto"
                        >
                            <span x-text="state === 'submitting' ? '{{ __('ui.rfq.submitting_button') }}' : '{{ __('ui.rfq.submit_button') }}'">
                                {{ __('ui.rfq.submit_button') }}
                            </span>
                            <svg aria-hidden="true" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right Column (5 Cols on Desktop): SLA Dispatch & Workshop Coordinates Dossier --}}
            <aside class="lg:col-span-5 flex flex-col gap-6 rounded-[var(--radius-card)] border border-border-interactive bg-surface p-6 md:p-8">
                <div>
                    <span class="font-mono text-xs font-bold uppercase tracking-wider text-accent">
                        [SLA DISPATCH &amp; WORKSHOPS]
                    </span>
                    <h3 class="mt-2 font-display text-xl font-bold text-ink">
                        {{ __('ui.rfq.dispatch_card_title') }}
                    </h3>
                </div>

                <dl class="flex flex-col gap-4 border-t border-border-subtle pt-4 text-xs leading-relaxed">
                    <div>
                        <dt class="font-mono font-bold uppercase text-ink">{{ __('ui.rfq.hq_label') }}</dt>
                        <dd class="mt-1 text-ink-muted">{{ $contactSettings->hqAddress }}</dd>
                    </div>

                    @if ($contactSettings->branchAddress)
                        <div>
                            <dt class="font-mono font-bold uppercase text-ink">{{ __('ui.rfq.branch_label') }}</dt>
                            <dd class="mt-1 text-ink-muted">{{ $contactSettings->branchAddress }}</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="font-mono font-bold uppercase text-ink">{{ __('ui.rfq.hours_label') }}</dt>
                        <dd class="mt-1 font-mono text-ink-muted tabular-nums">{{ $contactSettings->officeHours }}</dd>
                    </div>

                    <div class="rounded-[var(--radius-tag)] border-l-4 border-accent bg-surface-elevated p-3">
                        <dt class="font-mono font-bold uppercase text-accent">{{ __('ui.rfq.sla_hours_label') }}</dt>
                        <dd class="mt-1 font-mono font-semibold text-ink tabular-nums">{{ $contactSettings->emergencySlaHours }}</dd>
                    </div>
                </dl>

                <div class="flex flex-col gap-3 border-t border-border-subtle pt-4 font-mono text-xs tabular-nums">
                    <a
                        href="tel:{{ $contactSettings->primaryPhone }}"
                        class="flex min-h-11 items-center justify-between rounded-[var(--radius-button)] border border-border-interactive bg-surface-elevated px-4 py-2.5 font-bold text-ink hover:border-accent"
                    >
                        <span>Tel Dispatch:</span>
                        <span class="text-accent">{{ $contactSettings->primaryPhone }}</span>
                    </a>
                    <a
                        href="https://wa.me/{{ $waNumber }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex min-h-11 items-center justify-between rounded-[var(--radius-button)] border border-border-interactive bg-surface-elevated px-4 py-2.5 font-bold text-ink hover:border-accent"
                    >
                        <span>WhatsApp RFQ:</span>
                        <span class="text-accent">{{ $contactSettings->whatsappLeadNumber }}</span>
                    </a>
                    <a
                        href="mailto:{{ $contactSettings->engineeringEmail }}"
                        class="flex min-h-11 items-center justify-between rounded-[var(--radius-button)] border border-border-interactive bg-surface-elevated px-4 py-2.5 font-bold text-ink hover:border-accent"
                    >
                        <span>Engineering Desk:</span>
                        <span class="text-accent">{{ $contactSettings->engineeringEmail }}</span>
                    </a>
                </div>
            </aside>
        </div>
    </x-ui.container>
</section>
