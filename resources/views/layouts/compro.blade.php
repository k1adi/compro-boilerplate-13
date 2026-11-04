@props([
    'settings',
    'seo',
])

@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $homeUrl = route('compro.home', ['locale' => $locale]);
    $servicesUrl = route($isId ? 'compro.services.index.id' : 'compro.services.index.en', ['locale' => $locale]);
    $caseStudiesUrl = route($isId ? 'compro.case_studies.index.id' : 'compro.case_studies.index.en', ['locale' => $locale]);
    $aboutUrl = route($isId ? 'compro.about.id' : 'compro.about.en', ['locale' => $locale]);
    $contactUrl = route($isId ? 'compro.contact.id' : 'compro.contact.en', ['locale' => $locale]);

    $altIdUrl = ! empty($seo->alternates['id']) ? $seo->alternates['id'] : route('compro.home', ['locale' => 'id']);
    $altEnUrl = ! empty($seo->alternates['en']) ? $seo->alternates['en'] : route('compro.home', ['locale' => 'en']);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo.meta :meta="$seo" />

    <script>
        (function () {
            try {
                if (localStorage.getItem('compro_theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/compro.css', 'resources/js/compro.js'])
    @stack('schema')
</head>
<body
    x-data="comproShell()"
    @keydown.escape.window="closeMobileMenu()"
    class="min-h-dvh flex flex-col bg-surface text-ink antialiased selection:bg-accent selection:text-accent-ink"
>
    {{-- R-32: Skip to main content link for keyboard navigation --}}
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-[var(--radius-button)] focus:bg-accent focus:px-4 focus:py-2.5 focus:font-mono focus:text-sm focus:font-bold focus:text-accent-ink"
    >
        {{ __('ui.skip_to_content') }}
    </a>

    {{-- R-17, R-23, R-38: Honest Boilerplate Seed Notice Banner --}}
    @if ($settings->isSampleBoilerplate)
        <div class="border-b border-border-subtle bg-surface-elevated py-2 text-xs">
            <x-ui.container class="flex flex-wrap items-center justify-between gap-2">
                <p class="text-ink-muted">
                    <span class="font-mono font-bold text-accent">{{ __('ui.boilerplate_banner_tag') }}</span>
                    <span class="ml-1.5">{{ __('ui.boilerplate_banner_text') }}</span>
                </p>
                <span class="font-mono text-[11px] text-ink-muted tabular-nums">
                    SLA 24/7: {{ $settings->primaryPhone }}
                </span>
            </x-ui.container>
        </div>
    @endif

    {{-- R-10: Sticky header is the single element permitted to use backdrop-blur on scroll --}}
    <header
        :class="scrolled ? 'bg-surface/95 backdrop-blur-md border-border-interactive/40' : 'bg-surface border-border-subtle'"
        class="sticky top-0 z-40 border-b transition-colors duration-150"
    >
        <x-ui.container class="flex min-h-16 items-center justify-between gap-4 py-2">
            {{-- R-23: Typographic brand mark instead of assumed AI logo --}}
            <a
                href="{{ $homeUrl }}"
                class="group flex min-h-11 items-center gap-3 py-1"
            >
                <span class="inline-flex h-9 items-center border border-border-interactive bg-primary px-2.5 font-mono text-xs font-bold tracking-wider text-ink-inverse rounded-[var(--radius-tag)]">
                    GT // 12
                </span>
                <div class="flex flex-col">
                    <span class="font-display text-base font-bold tracking-tight text-ink group-hover:text-accent transition-colors">
                        {{ $settings->brandName }}
                    </span>
                    <span class="font-mono text-[11px] text-ink-muted">
                        {{ $settings->legalName }}
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation (State 3: >= 1024px) --}}
            <nav aria-label="{{ __('ui.nav.main_label') }}" class="hidden lg:flex lg:items-center lg:gap-1">
                <a
                    href="{{ $homeUrl }}"
                    @if (request()->url() === $homeUrl) aria-current="page" @endif
                    class="inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors rounded-[var(--radius-button)] {{ request()->url() === $homeUrl ? 'text-accent font-semibold bg-surface-elevated' : 'text-ink hover:text-accent hover:bg-surface-elevated' }}"
                >
                    {{ __('ui.nav.home') }}
                </a>
                <a
                    href="{{ $servicesUrl }}"
                    @if (str_contains(request()->path(), 'layanan') || str_contains(request()->path(), 'services')) aria-current="page" @endif
                    class="inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors rounded-[var(--radius-button)] {{ (str_contains(request()->path(), 'layanan') || str_contains(request()->path(), 'services')) ? 'text-accent font-semibold bg-surface-elevated' : 'text-ink hover:text-accent hover:bg-surface-elevated' }}"
                >
                    {{ __('ui.nav.services') }}
                </a>
                <a
                    href="{{ $caseStudiesUrl }}"
                    @if (str_contains(request()->path(), 'studi-kasus') || str_contains(request()->path(), 'case-studies')) aria-current="page" @endif
                    class="inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors rounded-[var(--radius-button)] {{ (str_contains(request()->path(), 'studi-kasus') || str_contains(request()->path(), 'case-studies')) ? 'text-accent font-semibold bg-surface-elevated' : 'text-ink hover:text-accent hover:bg-surface-elevated' }}"
                >
                    {{ __('ui.nav.case_studies') }}
                </a>
                <a
                    href="{{ $aboutUrl }}"
                    @if (str_contains(request()->path(), 'tentang-kami') || str_contains(request()->path(), 'about')) aria-current="page" @endif
                    class="inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors rounded-[var(--radius-button)] {{ (str_contains(request()->path(), 'tentang-kami') || str_contains(request()->path(), 'about')) ? 'text-accent font-semibold bg-surface-elevated' : 'text-ink hover:text-accent hover:bg-surface-elevated' }}"
                >
                    {{ __('ui.nav.about') }}
                </a>
                <a
                    href="{{ $contactUrl }}"
                    @if (str_contains(request()->path(), 'hubungi-kami') || str_contains(request()->path(), 'contact')) aria-current="page" @endif
                    class="inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors rounded-[var(--radius-button)] {{ (str_contains(request()->path(), 'hubungi-kami') || str_contains(request()->path(), 'contact')) ? 'text-accent font-semibold bg-surface-elevated' : 'text-ink hover:text-accent hover:bg-surface-elevated' }}"
                >
                    {{ __('ui.nav.contact') }}
                </a>
            </nav>

            {{-- Controls: Language Switcher, Theme Toggle, Desktop CTA, & Mobile Menu Button --}}
            <div class="flex items-center gap-2">
                {{-- Bilingual Switcher (ID / EN) --}}
                <div
                    role="group"
                    aria-label="{{ __('ui.nav.language_switcher') }}"
                    class="inline-flex items-center rounded-[var(--radius-button)] border border-border-interactive bg-surface-elevated p-0.5 font-mono text-xs"
                >
                    <a
                        href="{{ $altIdUrl }}"
                        hreflang="id"
                        lang="id"
                        @if ($isId) aria-current="true" @endif
                        class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-[var(--radius-tag)] px-2 font-bold transition-colors {{ $isId ? 'bg-accent text-accent-ink' : 'text-ink-muted hover:text-ink' }}"
                    >
                        ID
                    </a>
                    <a
                        href="{{ $altEnUrl }}"
                        hreflang="en"
                        lang="en"
                        @if (! $isId) aria-current="true" @endif
                        class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-[var(--radius-tag)] px-2 font-bold transition-colors {{ ! $isId ? 'bg-accent text-accent-ink' : 'text-ink-muted hover:text-ink' }}"
                    >
                        EN
                    </a>
                </div>

                {{-- R-21 & R-34: Working Light/Dark Mode Toggle --}}
                <button
                    type="button"
                    @click="toggleTheme()"
                    :aria-label="darkMode ? '{{ __('ui.nav.theme_toggle_light') }}' : '{{ __('ui.nav.theme_toggle_dark') }}'"
                    class="inline-flex min-h-11 items-center gap-1.5 rounded-[var(--radius-button)] border border-border-interactive bg-surface-elevated px-3 py-2 font-mono text-xs font-medium text-ink hover:border-ink transition-colors"
                >
                    <span aria-hidden="true" x-text="darkMode ? '☀' : '☾'">☾</span>
                    <span class="hidden sm:inline" x-text="darkMode ? '{{ __('ui.nav.theme_label_light') }}' : '{{ __('ui.nav.theme_label_dark') }}'">
                        {{ __('ui.nav.theme_label_dark') }}
                    </span>
                </button>

                {{-- Desktop Primary CTA --}}
                <div class="hidden xl:block">
                    <x-ui.button :href="$contactUrl" variant="primary" icon="arrow-right">
                        {{ __('ui.nav.cta_audit') }}
                    </x-ui.button>
                </div>

                {{-- R-03 & antislop-layoutmobile: Mobile Menu Button with visible "Menu" text label (never a bare hamburger) --}}
                <button
                    type="button"
                    @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    aria-controls="mobile-nav-drawer"
                    class="inline-flex min-h-11 items-center gap-2 rounded-[var(--radius-button)] border border-border-interactive bg-surface-elevated px-3.5 py-2 font-mono text-xs font-bold text-ink hover:border-ink lg:hidden"
                >
                    <span x-text="mobileOpen ? '{{ __('ui.nav.close_menu') }}' : '{{ __('ui.nav.menu_button') }}'">
                        {{ __('ui.nav.menu_button') }}
                    </span>
                    <svg class="h-4 w-4 shrink-0" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                        <path x-show="!mobileOpen" fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Zm0 5.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        <path x-show="mobileOpen" x-cloak fill-rule="evenodd" d="M4.293 4.293a1 1 0 0 1 1.414 0L10 8.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </x-ui.container>

        {{-- Mobile Navigation Drawer (Focus trapped & Escape closable per R-32) --}}
        <div
            id="mobile-nav-drawer"
            x-show="mobileOpen"
            x-trap.noscroll="mobileOpen"
            x-cloak
            class="border-t border-border-interactive bg-surface-elevated shadow-lg lg:hidden"
        >
            <x-ui.container class="flex flex-col gap-2 py-4">
                <a
                    href="{{ $homeUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center justify-between border-b border-border-subtle px-2 py-2.5 text-base font-semibold text-ink hover:text-accent"
                >
                    <span>{{ __('ui.nav.home') }}</span>
                    <span aria-hidden="true" class="font-mono text-xs text-ink-muted">[01]</span>
                </a>
                <a
                    href="{{ $servicesUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center justify-between border-b border-border-subtle px-2 py-2.5 text-base font-semibold text-ink hover:text-accent"
                >
                    <span>{{ __('ui.nav.services') }}</span>
                    <span aria-hidden="true" class="font-mono text-xs text-ink-muted">[02]</span>
                </a>
                <a
                    href="{{ $caseStudiesUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center justify-between border-b border-border-subtle px-2 py-2.5 text-base font-semibold text-ink hover:text-accent"
                >
                    <span>{{ __('ui.nav.case_studies') }}</span>
                    <span aria-hidden="true" class="font-mono text-xs text-ink-muted">[03]</span>
                </a>
                <a
                    href="{{ $aboutUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center justify-between border-b border-border-subtle px-2 py-2.5 text-base font-semibold text-ink hover:text-accent"
                >
                    <span>{{ __('ui.nav.about') }}</span>
                    <span aria-hidden="true" class="font-mono text-xs text-ink-muted">[04]</span>
                </a>
                <a
                    href="{{ $contactUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center justify-between border-b border-border-subtle px-2 py-2.5 text-base font-semibold text-ink hover:text-accent"
                >
                    <span>{{ __('ui.nav.contact') }}</span>
                    <span aria-hidden="true" class="font-mono text-xs text-ink-muted">[05]</span>
                </a>

                <div class="mt-3 flex flex-col gap-2">
                    <x-ui.button :href="$contactUrl" variant="primary" icon="arrow-right" class="w-full">
                        {{ __('ui.nav.cta_audit') }}
                    </x-ui.button>
                </div>
            </x-ui.container>
        </div>
    </header>

    {{-- Main Landmark --}}
    <main id="main-content" class="flex-1">
        {{ $slot }}
    </main>

    {{-- Architectural Engineering Footer (Structured around real destinations per R-05 & R-24) --}}
    <footer class="border-t border-border-subtle bg-surface-elevated text-sm">
        <x-ui.container class="py-12 md:py-16">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-6 lg:grid-cols-12">
                {{-- Column 1: Entity Identity & KBLI --}}
                <div class="md:col-span-6 lg:col-span-5 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-8 items-center border border-border-interactive bg-primary px-2 font-mono text-xs font-bold text-ink-inverse rounded-[var(--radius-tag)]">
                            GT // 12
                        </span>
                        <div>
                            <p class="font-display text-base font-bold text-ink">{{ $settings->brandName }}</p>
                            <p class="font-mono text-xs text-ink-muted">{{ $settings->legalName }} (Est. {{ $settings->foundingYear }})</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-ink-muted">
                        {{ $settings->valueProposition }}
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($settings->kbliCodes as $kbli)
                            <x-ui.badge variant="neutral">KBLI {{ $kbli }}</x-ui.badge>
                        @endforeach
                        @foreach ($settings->certifications as $cert)
                            <x-ui.badge variant="neutral">{{ $cert->standardCode }}</x-ui.badge>
                        @endforeach
                    </div>
                </div>

                {{-- Column 2: Navigation --}}
                <div class="md:col-span-3 lg:col-span-3 flex flex-col gap-3">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                        [{{ __('ui.footer.navigation') }}]
                    </p>
                    <ul class="flex flex-col gap-1.5">
                        <li>
                            <a href="{{ $homeUrl }}" class="inline-flex min-h-11 items-center text-ink-muted hover:text-accent">
                                {{ __('ui.nav.home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $servicesUrl }}" class="inline-flex min-h-11 items-center text-ink-muted hover:text-accent">
                                {{ __('ui.nav.services') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $caseStudiesUrl }}" class="inline-flex min-h-11 items-center text-ink-muted hover:text-accent">
                                {{ __('ui.nav.case_studies') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $aboutUrl }}" class="inline-flex min-h-11 items-center text-ink-muted hover:text-accent">
                                {{ __('ui.nav.about') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $contactUrl }}" class="inline-flex min-h-11 items-center text-ink-muted hover:text-accent">
                                {{ __('ui.nav.contact') }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Workshop & SLA Dispatch --}}
                <div class="md:col-span-3 lg:col-span-4 flex flex-col gap-3">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-ink">
                        [{{ __('ui.footer.contact_heading') }}]
                    </p>
                    <dl class="flex flex-col gap-2.5 text-xs text-ink-muted">
                        <div>
                            <dt class="font-semibold text-ink">{{ __('ui.rfq.hq_label') }}</dt>
                            <dd class="mt-0.5 leading-relaxed">{{ $settings->hqAddress }}</dd>
                        </div>
                        @if ($settings->branchAddress)
                            <div>
                                <dt class="font-semibold text-ink">{{ __('ui.rfq.branch_label') }}</dt>
                                <dd class="mt-0.5 leading-relaxed">{{ $settings->branchAddress }}</dd>
                            </div>
                        @endif
                        <div class="pt-1 font-mono tabular-nums">
                            <p><strong class="text-ink">Tel:</strong> <a href="tel:{{ $settings->primaryPhone }}" class="hover:text-accent underline">{{ $settings->primaryPhone }}</a></p>
                            <p class="mt-1"><strong class="text-ink">WhatsApp RFQ:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsappLeadNumber) }}" target="_blank" rel="noopener noreferrer" class="hover:text-accent underline">{{ $settings->whatsappLeadNumber }}</a></p>
                            <p class="mt-1"><strong class="text-ink">Email:</strong> <a href="mailto:{{ $settings->engineeringEmail }}" class="hover:text-accent underline">{{ $settings->engineeringEmail }}</a></p>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-10 flex flex-col items-start justify-between gap-4 border-t border-border-subtle pt-6 text-xs text-ink-muted sm:flex-row sm:items-center">
                <p>
                    &copy; {{ date('Y') }} {{ $settings->legalName }}. {{ __('ui.footer.copyright') }}
                </p>
                <div class="flex items-center gap-4 font-mono">
                    <a href="{{ route('compro.sitemap') }}" class="inline-flex min-h-11 items-center hover:text-accent underline">
                        {{ __('ui.footer.sitemap') }}
                    </a>
                </div>
            </div>
        </x-ui.container>
    </footer>
</body>
</html>

