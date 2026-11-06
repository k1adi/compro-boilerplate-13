@props([
    'sectionCode' => '02 // METHODOLOGY',
    'heading',
    'summary' => null,
    'steps' => [],
])

@php
    $isId = app()->getLocale() === 'id';
@endphp

@if (count($steps) > 0)
    <section class="border-b border-border-subtle bg-surface-tinted py-16 md:py-20 lg:py-24">
        <x-ui.container class="flex flex-col gap-10">
            {{-- Centered Header (.timeline-head-center) --}}
            <div class="flex flex-col items-center text-center max-w-2xl mx-auto gap-2.5">
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

            @php
                $gridClass = match (count($steps)) {
                    1, 2 => 'lg:grid-cols-2',
                    3 => 'lg:grid-cols-3',
                    4 => 'lg:grid-cols-4',
                    default => 'lg:grid-cols-5',
                };
            @endphp

            {{-- 4-Step Card Grid (Koolom .steps-grid-1 / .step-card-1) --}}
            <ol class="grid grid-cols-1 gap-5 sm:grid-cols-2 {{ $gridClass }}">
                @foreach ($steps as $step)
                    <li class="flex flex-col justify-between rounded-[var(--radius-card)] border border-border-subtle bg-surface p-7 shadow-sm transition-all hover:border-secondary-700">
                        <div>
                            {{-- Step Number Badge in Soft Apricot Tint (.step-num-1) --}}
                            <div class="flex items-center justify-between border-b border-border-subtle pb-4">
                                <span class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-button)] bg-tertiary-100 font-mono text-base font-extrabold text-tertiary-800 tabular-nums">
                                    0{{ $step['stepNumber'] ?? $loop->iteration }}
                                </span>
                                <span class="font-mono text-xs font-bold text-secondary-700 uppercase">
                                    {{ $isId ? 'TAHAP' : 'STEP' }} {{ $loop->iteration }}
                                </span>
                            </div>

                            <h3 class="mt-4 font-display text-lg font-bold text-ink">
                                {{ $step['title'] }}
                            </h3>
                            <p class="mt-2 text-xs leading-relaxed text-ink-muted">
                                {{ $step['description'] }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ol>

            {{-- Bottom Transparent Fee Guarantee Note (.fee-note-1 from koolom.webflow.io) --}}
            <div class="rounded-[var(--radius-card)] border-l-4 border-accent-tile bg-tertiary-50 p-4 text-xs text-tertiary-800">
                <span class="font-bold">{{ $isId ? 'TANPA BIAYA KEJUTAN:' : 'NO BILLING SURPRISES:' }}</span>
                {{ $isId
                    ? 'Anda selalu menerima estimasi biaya tertulis dan jadwal pengerjaan yang transparan sebelum pekerjaan dimulai.'
                    : 'You always receive a clear, written fee estimate and timeline upfront before any work begins.' }}
            </div>
        </x-ui.container>
    </section>
@endif
