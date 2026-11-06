@props([
    'metrics' => [],
    'certifications' => [],
    'sectorDescriptors' => [],
    'isSampleBoilerplate' => true,
])

@php
    $isId = app()->getLocale() === 'id';
@endphp

<section class="border-b border-border-subtle bg-surface-soft py-16 md:py-20 lg:py-[8.25rem]">
    <x-ui.container class="flex flex-col gap-14">
        {{-- Section 1: Koolom-Style Why Choose Us Grid (.section-why / .why-grid) --}}
        <div>
            <div class="flex flex-col gap-2 max-w-2xl mb-10">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-accent">
                    [{{ __('ui.proof.section_code') }}]
                </span>
                <h2 class="font-display text-[length:var(--text-h2)] font-bold tracking-tight text-ink leading-tight">
                    {{ __('ui.proof.heading') }}
                </h2>
                <p class="text-base text-ink-muted leading-relaxed">
                    {{ $isId
                        ? 'Kami menggabungkan keahlian hukum korporasi dengan pendekatan praktis agar bisnis Anda dapat bergerak cepat tanpa hambatan birokrasi.'
                        : 'We combine senior corporate counsel with practical execution so your business can move forward with clarity and confidence.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                {{-- Card 1 --}}
                <div class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 sm:p-8 shadow-sm">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-[var(--radius-button)] bg-secondary-100 text-secondary-800 font-mono text-sm font-bold">
                            01
                        </div>
                        <h3 class="mt-5 font-display text-lg font-bold text-ink">
                            {{ $isId ? 'Estimasi Biaya Tetap & Transparan' : 'Transparent, Fixed-Fee Estimates' }}
                        </h3>
                        <p class="mt-2.5 text-sm leading-relaxed text-ink-muted">
                            {{ $isId
                                ? 'Anda menerima rincian biaya tertulis yang jelas sebelum pekerjaan dimulai. Tanpa biaya tersembunyi atau tagihan tak terduga di akhir.'
                                : 'You receive a clear, written fee estimate upfront before any work begins. No hidden charges and no billing surprises.' }}
                        </p>
                    </div>
                    <div class="mt-6 border-t border-border-subtle pt-4 font-mono text-xs font-semibold text-secondary-700">
                        {{ $isId ? 'Penawaran Tertulis di Muka' : 'Upfront Written Proposals' }}
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 sm:p-8 shadow-sm">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-[var(--radius-button)] bg-secondary-100 text-secondary-800 font-mono text-sm font-bold">
                            02
                        </div>
                        <h3 class="mt-5 font-display text-lg font-bold text-ink">
                            {{ $isId ? 'Konsultan Senior di Setiap Kasus' : 'Senior Advisors on Every Matter' }}
                        </h3>
                        <p class="mt-2.5 text-sm leading-relaxed text-ink-muted">
                            {{ $isId
                                ? 'Setiap proyek perizinan maupun penyusunan kontrak ditangani langsung oleh konsultan berpengalaman dari diskusi awal hingga tuntas.'
                                : 'You work directly with experienced senior counsel from first briefing to completion, never handed off to a rotating cast of juniors.' }}
                        </p>
                    </div>
                    <div class="mt-6 border-t border-border-subtle pt-4 font-mono text-xs font-semibold text-secondary-700">
                        {{ $isId ? 'Pendampingan Langsung Terdedikasi' : 'Direct Senior Representation' }}
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 sm:p-8 shadow-sm">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-[var(--radius-button)] bg-tertiary-100 text-tertiary-800 font-mono text-sm font-bold">
                            03
                        </div>
                        <h3 class="mt-5 font-display text-lg font-bold text-ink">
                            {{ $isId ? 'Layanan Dwibahasa & Responsif' : 'Bilingual & Fast Turnaround' }}
                        </h3>
                        <p class="mt-2.5 text-sm leading-relaxed text-ink-muted">
                            {{ $isId
                                ? 'Seluruh kontrak dan dokumen korporasi dapat disusun dalam Bahasa Indonesia dan Inggris dengan jaminan respon konsultasi di bawah 24 jam kerja.'
                                : 'All contracts and corporate documents are available in Indonesian and English, backed by a < 24 business hour response guarantee.' }}
                        </p>
                    </div>
                    <div class="mt-6 border-t border-border-subtle pt-4 font-mono text-xs font-semibold text-accent">
                        {{ $isId ? 'Respon Cepat < 24 Jam Kerja' : '< 24 Hour Response SLA' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Split Firm Overview & Checkmark Proof (.section-about / .about-row) --}}
        <div class="grid grid-cols-1 gap-10 border-t border-border-subtle pt-12 lg:grid-cols-12 lg:gap-12 items-center">
            <div class="lg:col-span-6 flex flex-col gap-5">
                <span class="font-mono text-xs font-bold uppercase tracking-widest text-secondary-700">
                    [{{ $isId ? 'TENTANG FIRMA KAMI' : 'ABOUT OUR FIRM' }}]
                </span>
                <h3 class="font-display text-2xl sm:text-3xl font-bold tracking-tight text-ink leading-tight">
                    {{ $isId
                        ? 'Pendampingan Hukum dan Bisnis yang Memberikan Kepastian'
                        : 'Trusted Business Counsel, Delivered With Care' }}
                </h3>
                <p class="text-sm leading-relaxed text-ink-muted">
                    {{ $isId
                        ? 'Kami membantu pendiri usaha, direksi, dan investor menavigasi aturan perizinan serta kontrak komersial di Indonesia melalui langkah kerja yang terukur dan mudah dipahami.'
                        : 'We help founders, directors, and investors navigate Indonesian business licensing and commercial contracts through clear, practical steps.' }}
                </p>

                {{-- Checkmark List (.about-check-list) --}}
                <ul class="flex flex-col gap-3.5 pt-2">
                    <li class="flex items-start gap-3">
                        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-100 text-secondary-800 font-bold text-xs">✓</span>
                        <div class="text-xs leading-relaxed text-ink">
                            <strong class="font-semibold text-ink">{{ $isId ? 'Konsultasi Awal Gratis:' : 'Free Initial Consultation:' }}</strong>
                            {{ $isId ? 'Diskusikan kebutuhan bisnis Anda selama 30 menit tanpa biaya dan tanpa ikatan komitmen.' : 'Discuss your business matter for 30 minutes at no cost and with zero obligation.' }}
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-100 text-secondary-800 font-bold text-xs">✓</span>
                        <div class="text-xs leading-relaxed text-ink">
                            <strong class="font-semibold text-ink">{{ $isId ? 'Bahasa yang Jelas & Praktis:' : 'Plain-Language Advice:' }}</strong>
                            {{ $isId ? 'Kami menjelaskan opsi dan risiko hukum dalam bahasa bisnis yang lugas, bukan jargon yang membingungkan.' : 'We explain your legal options and commercial risks in plain language, not confusing jargon.' }}
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-100 text-secondary-800 font-bold text-xs">✓</span>
                        <div class="text-xs leading-relaxed text-ink">
                            <strong class="font-semibold text-ink">{{ $isId ? 'Kerahasiaan Terjamin 100%:' : '100% Strict Confidentiality:' }}</strong>
                            {{ $isId ? 'Seluruh data perusahaan dan rencana transaksi Anda dilindungi perjanjian kerahasiaan sejak hari pertama.' : 'All corporate records and transaction plans are protected under strict professional confidentiality.' }}
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Right Box: Credentials & Client Sectors --}}
            <div class="lg:col-span-6 flex flex-col gap-4">
                <div class="rounded-[var(--radius-card)] border border-border-interactive bg-surface p-7 shadow-sm">
                    <div class="flex items-center justify-between border-b border-border-subtle pb-3">
                        <span class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                            {{ __('ui.proof.certifications_title') }}
                        </span>
                        @if ($isSampleBoilerplate)
                            <span class="font-mono text-[10px] font-bold text-accent">
                                {{ __('ui.proof.seed_badge') }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 flex flex-col gap-3">
                        @foreach ($certifications as $cert)
                            <div class="flex flex-col justify-between rounded-[var(--radius-button)] border border-border-subtle bg-surface-soft p-4 sm:flex-row sm:items-center gap-2">
                                <div>
                                    <span class="font-mono text-sm font-bold text-secondary-700">
                                        {{ $cert->standardCode }}
                                    </span>
                                    <p class="text-xs text-ink-muted mt-0.5">{{ $cert->scope }}</p>
                                </div>
                                <span class="font-mono text-xs font-semibold text-ink tabular-nums">
                                    {{ $cert->referenceNumber }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    @if (count($sectorDescriptors) > 0)
                        <div class="mt-5 border-t border-border-subtle pt-4">
                            <p class="font-mono text-xs font-bold text-ink-muted uppercase">
                                {{ __('ui.proof.client_sectors_title') }}
                            </p>
                            <div class="mt-2.5 flex flex-wrap gap-2">
                                @foreach ($sectorDescriptors as $desc)
                                    <span class="rounded-[var(--radius-tag)] border border-border-subtle bg-surface px-2.5 py-1 text-xs text-ink">
                                        {{ $desc }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-ui.container>
</section>
