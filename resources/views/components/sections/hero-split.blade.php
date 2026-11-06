@props([
    'sectorCode',
    'headline',
    'subheadline',
    'primaryCta',
    'secondaryCta',
    'heroMedia',
    'specCaption',
])

@php
    $isId = app()->getLocale() === 'id';
@endphp

<section class="relative border-b border-border-subtle bg-surface pt-6 pb-16 md:pt-10 md:pb-20 lg:pt-12 lg:pb-24">
    <x-ui.container class="flex flex-col gap-4">
        {{-- Row 1: Asymmetric Bento Grid Hero Split (7/5 on Desktop / 58% vs 42%) --}}
        <div class="grid grid-cols-1 items-stretch gap-4 lg:grid-cols-12">
            {{-- Left Bento Card: Secondary-800 Cobalt Blue Tile (.bento-tile-main) --}}
            <div class="lg:col-span-7 flex flex-col justify-between rounded-[var(--radius-tile)] border border-secondary-900 bg-secondary-800 p-7 text-white shadow-sm sm:p-10 lg:p-12">
                <div class="flex flex-col gap-6">
                    {{-- Status Indicator Dot + Eyebrow (.bento-status) --}}
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-secondary-900/60 px-3.5 py-1 text-xs font-semibold text-secondary-100">
                            <span class="h-2 w-2 rounded-full bg-tertiary-400" aria-hidden="true"></span>
                            <span>{{ $sectorCode }}</span>
                        </span>
                    </div>

                    {{-- Main Headline --}}
                    <h1 class="font-display text-[length:var(--text-hero)] font-bold tracking-tight text-white leading-[1.12]">
                        {{ $headline }}
                    </h1>

                    {{-- Subheadline --}}
                    <p class="max-w-[56ch] text-base leading-relaxed text-secondary-100 md:text-lg">
                        {{ $subheadline }}
                    </p>
                </div>

                {{-- Action Row & Bottom Practice Area Chips --}}
                <div class="mt-8 flex flex-col gap-6 border-t border-white/15 pt-6">
                    <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center">
                        <x-ui.button :action="$primaryCta" />
                        @if ($secondaryCta)
                            <a
                                href="{{ $secondaryCta->url }}"
                                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-button)] border border-white/30 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-white hover:text-secondary-950"
                            >
                                <span>{{ $secondaryCta->label }}</span>
                                <span aria-hidden="true" class="font-mono text-base leading-none">&rarr;</span>
                            </a>
                        @endif
                    </div>

                    {{-- Bottom Practice Area Chips (.bento-chips) --}}
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="rounded-full border border-white/15 bg-secondary-900/50 px-3.5 py-1 text-xs text-secondary-100">
                            {{ $isId ? 'Pendirian PT & PMA' : 'Company Formation' }}
                        </span>
                        <span class="rounded-full border border-white/15 bg-secondary-900/50 px-3.5 py-1 text-xs text-secondary-100">
                            {{ $isId ? 'Kontrak Bisnis' : 'Commercial Contracts' }}
                        </span>
                        <span class="rounded-full border border-white/15 bg-secondary-900/50 px-3.5 py-1 text-xs text-secondary-100">
                            {{ $isId ? 'Kepatuhan & Retainer' : 'Compliance & Retainer' }}
                        </span>
                        <span class="rounded-full border border-white/15 bg-secondary-900/50 px-3.5 py-1 text-xs text-secondary-100">
                            {{ $isId ? 'Transaksi & Akuisisi' : 'M&A & Due Diligence' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Right Bento Card: Priority LCP Visual Tile (.bento-img-tile) --}}
            <div class="lg:col-span-5 relative flex flex-col justify-between overflow-hidden rounded-[var(--radius-tile)] border border-border-subtle bg-surface-soft min-h-[22rem] lg:min-h-[32rem]">
                <div class="h-full w-full">
                    <x-ui.image :media="$heroMedia" :priority="true" class="h-full w-full object-cover" />
                </div>

                {{-- Bottom Trust Overlay Caption (.bento-rating) --}}
                <div class="absolute bottom-3 left-3 right-3 rounded-[var(--radius-card)] border border-white/15 bg-secondary-950/90 p-4 text-white sm:bottom-4 sm:left-4 sm:right-4">
                    <div class="flex items-center justify-between gap-2 text-xs text-secondary-100">
                        <span class="font-semibold text-tertiary-400">{{ $isId ? 'Konsultasi Awal Gratis' : 'Free Initial Consultation' }}</span>
                        <span class="font-mono">ISO 9001:2015</span>
                    </div>
                    <p class="mt-1 text-xs font-medium text-white">
                        {{ $specCaption ?? __('ui.hero.capacity_value') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Row 2: 4-Tile Bento Metric Strip (.bento-stats-row) --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Tile 1: Tertiary Orange Highlighted Stat (.bento-stat-accent) --}}
            <div class="flex flex-col justify-between rounded-[var(--radius-tile)] border border-tertiary-600 bg-accent-tile p-6 text-secondary-950 shadow-sm sm:p-7">
                <div class="flex items-center justify-between gap-2 font-mono text-xs font-bold uppercase tracking-wider">
                    <span>[01]</span>
                    <span class="rounded-[var(--radius-tag)] bg-secondary-950 px-2 py-0.5 text-[10px] text-white">SLA</span>
                </div>
                <div class="mt-4">
                    <p class="font-mono text-3xl font-extrabold tracking-tight tabular-nums sm:text-4xl text-secondary-950">
                        {{ $isId ? '< 24 Jam' : '< 24 Hours' }}
                    </p>
                    <p class="mt-1 font-display text-sm font-bold text-secondary-950">
                        {{ $isId ? 'Respon Konsultasi' : 'Consultation Reply' }}
                    </p>
                </div>
                <p class="mt-4 border-t border-secondary-950/20 pt-3 text-xs font-medium text-secondary-950/90">
                    {{ $isId ? 'Waktu tanggap tertulis untuk setiap permohonan konsultasi baru.' : 'Guaranteed written response for every new client inquiry.' }}
                </p>
            </div>

            {{-- Tile 2: Primary-100 Tinted Stat (.bento-stat) --}}
            <div class="flex flex-col justify-between rounded-[var(--radius-tile)] border border-border-subtle bg-surface-tinted p-6 shadow-sm sm:p-7">
                <span class="font-mono text-xs font-bold uppercase tracking-wider text-secondary-700">[02]</span>
                <div class="mt-4">
                    <p class="font-mono text-3xl font-extrabold tracking-tight text-ink tabular-nums sm:text-4xl">
                        {{ $isId ? '450+ Klien' : '450+ Clients' }}
                    </p>
                    <p class="mt-1 font-display text-sm font-bold text-ink">
                        {{ $isId ? 'Perusahaan Terbantu' : 'Businesses Advised' }}
                    </p>
                </div>
                <p class="mt-4 border-t border-border-subtle pt-3 text-xs text-ink-muted">
                    {{ $isId ? 'Perusahaan lokal dan PMA yang didampingi sejak tahun 2014.' : 'Local and foreign-invested companies supported since 2014.' }}
                </p>
            </div>

            {{-- Tile 3: Primary-100 Tinted Stat (.bento-stat) --}}
            <div class="flex flex-col justify-between rounded-[var(--radius-tile)] border border-border-subtle bg-surface-tinted p-6 shadow-sm sm:p-7">
                <span class="font-mono text-xs font-bold uppercase tracking-wider text-secondary-700">[03]</span>
                <div class="mt-4">
                    <p class="font-mono text-3xl font-extrabold tracking-tight text-ink tabular-nums sm:text-4xl">
                        {{ $isId ? '12 Tahun' : '12 Years' }}
                    </p>
                    <p class="mt-1 font-display text-sm font-bold text-ink">
                        {{ $isId ? 'Pengalaman Praktik' : 'Years of Practice' }}
                    </p>
                </div>
                <p class="mt-4 border-t border-border-subtle pt-3 text-xs text-ink-muted">
                    {{ $isId ? 'Mendampingi perizinan usaha, kontrak komersial, dan kepatuhan bisnis.' : 'Dedicated corporate licensing, contracts, and compliance practice.' }}
                </p>
            </div>

            {{-- Tile 4: Primary-100 Tinted Stat (.bento-stat) --}}
            <div class="flex flex-col justify-between rounded-[var(--radius-tile)] border border-border-subtle bg-surface-tinted p-6 shadow-sm sm:p-7">
                <span class="font-mono text-xs font-bold uppercase tracking-wider text-secondary-700">[04]</span>
                <div class="mt-4">
                    <p class="font-mono text-3xl font-extrabold tracking-tight text-ink tabular-nums sm:text-4xl">
                        {{ $isId ? '1.200+' : '1,200+' }}
                    </p>
                    <p class="mt-1 font-display text-sm font-bold text-ink">
                        {{ $isId ? 'Dokumen & Proyek Selesai' : 'Matters Completed' }}
                    </p>
                </div>
                <p class="mt-4 border-t border-border-subtle pt-3 text-xs text-ink-muted">
                    {{ $isId ? 'Akta perusahaan, izin OSS RBA, kontrak bisnis, dan uji tuntas M&A.' : 'Company deeds, OSS RBA permits, commercial contracts, and M&A deals.' }}
                </p>
            </div>
        </div>
    </x-ui.container>
</section>
