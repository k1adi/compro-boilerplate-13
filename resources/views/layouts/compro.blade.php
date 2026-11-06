@props([
    'settings',
    'seo',
])

@php
    $locale = app()->getLocale();
    $isId = $locale === 'id';
    $homeUrl = route('compro.home', ['locale' => $locale]);
    $aboutUrl = route($isId ? 'compro.about.id' : 'compro.about.en', ['locale' => $locale]);
    $servicesUrl = route($isId ? 'compro.services.index.id' : 'compro.services.index.en', ['locale' => $locale]);
    $caseStudiesUrl = route($isId ? 'compro.case_studies.index.id' : 'compro.case_studies.index.en', ['locale' => $locale]);
    $contactUrl = route($isId ? 'compro.contact.id' : 'compro.contact.en', ['locale' => $locale]);

    $altIdUrl = ! empty($seo->alternates['id']) ? $seo->alternates['id'] : route('compro.home', ['locale' => 'id']);
    $altEnUrl = ! empty($seo->alternates['en']) ? $seo->alternates['en'] : route('compro.home', ['locale' => 'en']);
    $waClean = preg_replace('/[^0-9]/', '', $settings->whatsappLeadNumber);
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

    {{-- Koolom-Style Top Utility Bar (.topbar): Secondary-900 Deep Royal Navy --}}
    <div class="border-b border-white/10 bg-surface-topbar text-xs text-white">
        <x-ui.container class="flex h-10 items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="inline-block h-2 w-2 rounded-full bg-accent-tile" aria-hidden="true"></span>
                <span class="text-white text-xs font-medium">
                    {{ $settings->emergencySlaHours }}
                </span>
            </div>

            <div class="hidden items-center gap-4 text-xs text-secondary-100 md:flex">
                <span>{{ $settings->officeHours }}</span>
                <span aria-hidden="true" class="text-white/25">|</span>
                <a href="tel:{{ $settings->primaryPhone }}" class="hover:text-tertiary-400 transition-colors font-mono tabular-nums">
                    {{ $settings->primaryPhone }}
                </a>
            </div>
        </x-ui.container>
    </div>

    {{-- Main Sticky Header (.nav_wrap): Simple Brand & Simple Text Menu List Matching koolom.webflow.io --}}
    <header
        :class="scrolled ? 'bg-surface/95 backdrop-blur-md shadow-sm border-border-subtle' : 'bg-surface border-border-subtle'"
        class="sticky top-0 z-40 border-b transition-colors duration-150"
    >
        <x-ui.container class="flex min-h-20 items-center justify-between gap-4 py-2">
            {{-- Clean Single-Line Brand Mark --}}
            <a
                href="{{ $homeUrl }}"
                class="group flex min-h-11 items-center gap-2.5 py-1"
            >
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-[var(--radius-button)] bg-secondary-800 font-display text-base font-extrabold text-white">
                    K
                </span>
                <span class="font-display text-lg font-bold tracking-tight text-ink group-hover:text-secondary-700 transition-colors">
                    {{ $settings->brandName }}
                </span>
            </a>

            {{-- Simple Text Desktop Navigation (.nav_menu) --}}
            <nav aria-label="{{ __('ui.nav.main_label') }}" class="hidden lg:flex lg:items-center lg:gap-2">
                <a
                    href="{{ $homeUrl }}"
                    @if (request()->url() === $homeUrl) aria-current="page" @endif
                    class="group relative inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors {{ request()->url() === $homeUrl ? 'text-secondary-700 font-semibold' : 'text-ink hover:text-secondary-700' }}"
                >
                    <span>{{ __('ui.nav.home') }}</span>
                    <span class="absolute bottom-1.5 left-3 right-3 h-0.5 rounded-full bg-secondary-700 transition-transform duration-200 {{ request()->url() === $homeUrl ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
                <a
                    href="{{ $aboutUrl }}"
                    @if (str_contains(request()->path(), 'tentang-kami') || str_contains(request()->path(), 'about')) aria-current="page" @endif
                    class="group relative inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors {{ (str_contains(request()->path(), 'tentang-kami') || str_contains(request()->path(), 'about')) ? 'text-secondary-700 font-semibold' : 'text-ink hover:text-secondary-700' }}"
                >
                    <span>{{ __('ui.nav.about') }}</span>
                    <span class="absolute bottom-1.5 left-3 right-3 h-0.5 rounded-full bg-secondary-700 transition-transform duration-200 {{ (str_contains(request()->path(), 'tentang-kami') || str_contains(request()->path(), 'about')) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
                <a
                    href="{{ $servicesUrl }}"
                    @if (str_contains(request()->path(), 'layanan') || str_contains(request()->path(), 'services')) aria-current="page" @endif
                    class="group relative inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors {{ (str_contains(request()->path(), 'layanan') || str_contains(request()->path(), 'services')) ? 'text-secondary-700 font-semibold' : 'text-ink hover:text-secondary-700' }}"
                >
                    <span>{{ __('ui.nav.services') }}</span>
                    <span class="absolute bottom-1.5 left-3 right-3 h-0.5 rounded-full bg-secondary-700 transition-transform duration-200 {{ (str_contains(request()->path(), 'layanan') || str_contains(request()->path(), 'services')) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
                <a
                    href="{{ $caseStudiesUrl }}"
                    @if (str_contains(request()->path(), 'studi-kasus') || str_contains(request()->path(), 'case-studies')) aria-current="page" @endif
                    class="group relative inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors {{ (str_contains(request()->path(), 'studi-kasus') || str_contains(request()->path(), 'case-studies')) ? 'text-secondary-700 font-semibold' : 'text-ink hover:text-secondary-700' }}"
                >
                    <span>{{ __('ui.nav.case_studies') }}</span>
                    <span class="absolute bottom-1.5 left-3 right-3 h-0.5 rounded-full bg-secondary-700 transition-transform duration-200 {{ (str_contains(request()->path(), 'studi-kasus') || str_contains(request()->path(), 'case-studies')) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
                <a
                    href="{{ $contactUrl }}"
                    @if (str_contains(request()->path(), 'hubungi-kami') || str_contains(request()->path(), 'contact')) aria-current="page" @endif
                    class="group relative inline-flex min-h-11 items-center px-3 py-2 text-sm font-medium transition-colors {{ (str_contains(request()->path(), 'hubungi-kami') || str_contains(request()->path(), 'contact')) ? 'text-secondary-700 font-semibold' : 'text-ink hover:text-secondary-700' }}"
                >
                    <span>{{ __('ui.nav.contact') }}</span>
                    <span class="absolute bottom-1.5 left-3 right-3 h-0.5 rounded-full bg-secondary-700 transition-transform duration-200 {{ (str_contains(request()->path(), 'hubungi-kami') || str_contains(request()->path(), 'contact')) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
            </nav>

            {{-- Controls: Language Switcher, Theme Toggle, Desktop CTA, & Mobile Menu Button --}}
            <div class="flex items-center gap-2.5">
                {{-- Bilingual Switcher (ID / EN) --}}
                <div
                    role="group"
                    aria-label="{{ __('ui.nav.language_switcher') }}"
                    class="inline-flex items-center rounded-[var(--radius-button)] border border-border-interactive bg-surface-soft p-0.5 font-mono text-xs"
                >
                    <a
                        href="{{ $altIdUrl }}"
                        hreflang="id"
                        lang="id"
                        @if ($isId) aria-current="true" @endif
                        class="inline-flex min-h-8 min-w-8 items-center justify-center rounded-[var(--radius-tag)] px-2 font-bold transition-colors {{ $isId ? 'bg-secondary-800 text-white' : 'text-ink-muted hover:text-ink' }}"
                    >
                        ID
                    </a>
                    <a
                        href="{{ $altEnUrl }}"
                        hreflang="en"
                        lang="en"
                        @if (! $isId) aria-current="true" @endif
                        class="inline-flex min-h-8 min-w-8 items-center justify-center rounded-[var(--radius-tag)] px-2 font-bold transition-colors {{ ! $isId ? 'bg-secondary-800 text-white' : 'text-ink-muted hover:text-ink' }}"
                    >
                        EN
                    </a>
                </div>

                {{-- Working Light/Dark Mode Toggle --}}
                <button
                    type="button"
                    @click="toggleTheme()"
                    :aria-label="darkMode ? '{{ __('ui.nav.theme_toggle_light') }}' : '{{ __('ui.nav.theme_toggle_dark') }}'"
                    class="inline-flex min-h-11 items-center gap-1.5 rounded-[var(--radius-button)] border border-border-interactive bg-surface-soft px-3 py-2 text-xs font-medium text-ink hover:border-secondary-700 transition-colors"
                >
                    <span aria-hidden="true" x-text="darkMode ? '☀' : '☾'">☾</span>
                    <span class="hidden sm:inline" x-text="darkMode ? '{{ __('ui.nav.theme_label_light') }}' : '{{ __('ui.nav.theme_label_dark') }}'">
                        {{ __('ui.nav.theme_label_dark') }}
                    </span>
                </button>

                {{-- Desktop Primary CTA in Tertiary Orange --}}
                <div class="hidden xl:block">
                    <x-ui.button :href="$contactUrl" variant="primary" icon="arrow-right">
                        {{ __('ui.nav.cta_audit') }}
                    </x-ui.button>
                </div>

                {{-- Mobile Menu Button --}}
                <button
                    type="button"
                    @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    aria-controls="mobile-nav-drawer"
                    class="inline-flex min-h-11 items-center gap-2 rounded-[var(--radius-button)] border border-border-interactive bg-surface-soft px-3.5 py-2 text-xs font-semibold text-ink hover:border-secondary-700 lg:hidden"
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

        {{-- Simple Mobile Navigation Drawer --}}
        <div
            id="mobile-nav-drawer"
            x-show="mobileOpen"
            x-trap.noscroll="mobileOpen"
            x-cloak
            class="border-t border-border-interactive bg-surface-elevated shadow-xl lg:hidden"
        >
            <x-ui.container class="flex flex-col gap-1 py-4">
                <a
                    href="{{ $homeUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center border-b border-border-subtle px-2 py-2.5 text-base font-medium text-ink hover:text-secondary-700"
                >
                    {{ __('ui.nav.home') }}
                </a>
                <a
                    href="{{ $aboutUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center border-b border-border-subtle px-2 py-2.5 text-base font-medium text-ink hover:text-secondary-700"
                >
                    {{ __('ui.nav.about') }}
                </a>
                <a
                    href="{{ $servicesUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center border-b border-border-subtle px-2 py-2.5 text-base font-medium text-ink hover:text-secondary-700"
                >
                    {{ __('ui.nav.services') }}
                </a>
                <a
                    href="{{ $caseStudiesUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center border-b border-border-subtle px-2 py-2.5 text-base font-medium text-ink hover:text-secondary-700"
                >
                    {{ __('ui.nav.case_studies') }}
                </a>
                <a
                    href="{{ $contactUrl }}"
                    @click="closeMobileMenu()"
                    class="flex min-h-11 items-center border-b border-border-subtle px-2 py-2.5 text-base font-medium text-ink hover:text-secondary-700"
                >
                    {{ __('ui.nav.contact') }}
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

    {{-- Dark Architectural Footer (.section-footer.background-color-dark): Midnight Navy (#0B1528) --}}
    <footer class="border-t-4 border-tertiary-600 bg-surface-inverse text-sm text-ink-inverse">
        <x-ui.container class="py-14 md:py-20">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-6 lg:grid-cols-12">
                {{-- Column 1: Entity Identity --}}
                <div class="md:col-span-6 lg:col-span-5 flex flex-col gap-4">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-[var(--radius-button)] bg-secondary-800 font-display text-sm font-extrabold text-white">
                            K
                        </span>
                        <div>
                            <p class="font-display text-base font-bold text-white">{{ $settings->brandName }}</p>
                            <p class="font-mono text-xs text-secondary-100">{{ $settings->legalName }} (Est. {{ $settings->foundingYear }})</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-300">
                        {{ $settings->valueProposition }}
                    </p>
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach ($settings->certifications as $cert)
                            <x-ui.badge variant="inverse">{{ $cert->standardCode }}</x-ui.badge>
                        @endforeach
                    </div>
                </div>

                {{-- Column 2: Simple Navigation --}}
                <div class="md:col-span-3 lg:col-span-3 flex flex-col gap-3">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-tertiary-400">
                        {{ __('ui.footer.navigation') }}
                    </p>
                    <ul class="flex flex-col gap-1.5 text-slate-300">
                        <li>
                            <a href="{{ $homeUrl }}" class="inline-flex min-h-10 items-center hover:text-white transition-colors">
                                {{ __('ui.nav.home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $aboutUrl }}" class="inline-flex min-h-10 items-center hover:text-white transition-colors">
                                {{ __('ui.nav.about') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $servicesUrl }}" class="inline-flex min-h-10 items-center hover:text-white transition-colors">
                                {{ __('ui.nav.services') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $caseStudiesUrl }}" class="inline-flex min-h-10 items-center hover:text-white transition-colors">
                                {{ __('ui.nav.case_studies') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $contactUrl }}" class="inline-flex min-h-10 items-center hover:text-white transition-colors">
                                {{ __('ui.nav.contact') }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Offices & Contact --}}
                <div class="md:col-span-3 lg:col-span-4 flex flex-col gap-3">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-tertiary-400">
                        {{ __('ui.footer.contact_heading') }}
                    </p>
                    <dl class="flex flex-col gap-2.5 text-xs text-slate-300">
                        <div>
                            <dt class="font-semibold text-white">{{ __('ui.rfq.hq_label') }}</dt>
                            <dd class="mt-0.5 leading-relaxed">{{ $settings->hqAddress }}</dd>
                        </div>
                        @if ($settings->branchAddress)
                            <div>
                                <dt class="font-semibold text-white">{{ __('ui.rfq.branch_label') }}</dt>
                                <dd class="mt-0.5 leading-relaxed">{{ $settings->branchAddress }}</dd>
                            </div>
                        @endif
                        <div class="pt-2 font-mono tabular-nums">
                            <p><strong class="text-white">Tel:</strong> <a href="tel:{{ $settings->primaryPhone }}" class="hover:text-tertiary-400 underline">{{ $settings->primaryPhone }}</a></p>
                            <p class="mt-1"><strong class="text-white">WhatsApp:</strong> <a href="https://wa.me/{{ $waClean }}" target="_blank" rel="noopener noreferrer" class="hover:text-tertiary-400 underline">{{ $settings->whatsappLeadNumber }}</a></p>
                            <p class="mt-1"><strong class="text-white">Email:</strong> <a href="mailto:{{ $settings->engineeringEmail }}" class="hover:text-tertiary-400 underline">{{ $settings->engineeringEmail }}</a></p>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-12 flex flex-col items-start justify-between gap-4 border-t border-white/10 pt-6 text-xs text-slate-400 sm:flex-row sm:items-center">
                <p>
                    &copy; {{ date('Y') }} {{ $settings->legalName }}. {{ __('ui.footer.copyright') }}
                </p>
                <div class="flex items-center gap-4 font-mono">
                    <a href="{{ route('compro.sitemap') }}" class="inline-flex min-h-10 items-center hover:text-white underline">
                        {{ __('ui.footer.sitemap') }}
                    </a>
                </div>
            </div>
        </x-ui.container>
    </footer>
</body>
</html>
