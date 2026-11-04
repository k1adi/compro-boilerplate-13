# SOP: AI-Driven Compro & CMS Development Workflow (`docs/workflow.md`)

> **Source-of-Truth Mandate:** This document defines the standard operating procedure (SOP), architectural boundaries, and phase gates for building and maintaining this application. Whenever build pipelines, directory structures, localization strategies, or verification commands change, update this document in the same changeset.

**Core Tech Stack:** PHP 8.5, Laravel 13, Tailwind CSS v4, Vite 8, Pest 5  
**Architecture Pattern:** Dual-Entry Monolith  
- **Public Compro Entry (`compro.js` & `compro.css`):** Pure Laravel 13 Blade Components (`<x-*>`) + Alpine.js v3 (zero React overhead, server-rendered HTML, native SEO & AMP, Core Web Vitals mechanisms per R-40)  
- **Admin CMS Entry (`cms.jsx` & `cms.css`):** Inertia.js v2 + React 19 (`.jsx`) (authenticated back-office SPA mounted exclusively under `/cms/*`)

---

## PHASE 0: Boilerplate Initialization & Source-of-Truth Governance

*Rule: Complete and verify all foundational markdown files before generating application code, migrations, or Blade views.*

### Step 0.1: Canonical Six-File Documentation Architecture
Each markdown file owns a strict boundary and acts as a living contract:
1. **[`AGENTS.md`](../AGENTS.md):** Root orchestration constitution, Laravel Boost guidelines, specialist agent personas (`@Architect-DTO`, `@Compro-Blade-Crafter`, `@SEO-AMP-Auditor`, `@CMS-Inertia-Builder`, `@Template-Handoff-Cleaner`), CLI verification commands, and the Antislop skill pointer block.
2. **[`docs/knowledge-base.md`](knowledge-base.md):** Sole factual repository for legal identity, contact channels, verified metrics, certifications, bilingual (`id`/`en`) service specifications, project case studies, technical FAQ bank, and 301 redirect mappings.
3. **[`docs/workflow.md`](workflow.md):** Master phase-by-phase execution order, component hierarchy, localization rules, and pre-ship Delivery Gate requirements.
4. **[`docs/design.md`](design.md):** Antislop Design Read, liveliness dials (`ENERGY / RHYTHM / MOTION`), one-line purpose justifications (R-31), verified WCAG 2.2 AA contrast pairings (R-25), Tailwind CSS v4 `@theme` tokens, 3-state responsive reflow rules (R-03), and page-by-page section blueprints.
5. **[`docs/data-contracts.md`](data-contracts.md):** Strict 1:1 schema contracts binding PHP 8.5 `readonly` DTOs (`app/Data/`), Public Blade `@props`, Eloquent JSON columns, and Admin Inertia `.jsx` CMS forms.
6. **[`docs/guideline.md`](guideline.md):** Developer onboarding recap. Explains the project map, request flow, implementation status, daily commands, and the change-to-document sync matrix. It links to the five files above and never owns facts, tokens, or schemas itself.

### Step 0.2: Antislop Mode Resolution & Skill Activation
Before touching UI, copy, accessibility, responsive layout, or code comments, load the matching skills from `.agents/skills/`:
- Always load core filter: `.agents/skills/antislop/SKILL.md`
- UI & visual work: `.agents/skills/antislop-ui/SKILL.md` + `.agents/skills/tailwindcss-development/SKILL.md`
- Copywriting & bilingual prose: `.agents/skills/antislop-copywriting/SKILL.md`
- Accessibility & contrast math: `.agents/skills/antislop-human/SKILL.md`
- Responsive breakpoints & mobile reflow: `.agents/skills/antislop-layoutmobile/SKILL.md`
- Code comment hygiene: `.agents/skills/antislop-code/SKILL.md`
- Backend PHP & tests: `.agents/skills/laravel-best-practices/SKILL.md` + `.agents/skills/testing-best-practices/SKILL.md`

### Step 0.3: Client Onboarding Checklist (Forking the Boilerplate)
When adapting this boilerplate for a specific service company client:
1. Replace all `[BOILERPLATE SEED: REPLACE WITH REAL CLIENT DATA]` records in `docs/knowledge-base.md` with audited client facts.
2. If the client lacks real testimonials, certifications, or client logo permissions, set those collections to empty arrays (`[]`) in the DTO seeders so the UI omits those blocks cleanly (R-17, R-18, R-23, R-38).
3. Update brand tokens in `docs/design.md`, verify every text and border pairing with `python .agents/skills/antislop-human/contrast-check.py`, and record one-line reasons for any visual adjustments (R-25, R-31).
4. Sync any custom service attributes or inquiry form fields in `docs/data-contracts.md` before modifying `app/Data/` DTOs.
5. Once the real business facts are recorded, invoke `@Template-Handoff-Cleaner` (defined in `AGENTS.md` Section 3) to remove seed data, placeholder media, sample copy, unused pages, and framework leftovers. It requires an approved dry run and a zero-hit leftover scan before handoff.

### Step 0.4: Tech Stack, Package Compatibility & Lightweight Dependency Matrix

Because this project runs on bleeding-edge **PHP 8.5.12**, **Laravel 13.39+**, **Tailwind CSS v4.0+**, and **Vite 8.0+**, third-party packages must be audited for version-constraint compatibility, maintenance activity, and bundle weight before installation.

#### A. Pre-Installed Core Stack (Verified Compatible)
| Layer | Package / Runtime | Installed Version | License & Maintenance | Role in Architecture |
| :--- | :--- | :--- | :--- | :--- |
| **PHP Runtime** | PHP CLI / FPM (NTS) | `8.5.12` | PHP License (Active LTS) | Native `readonly` classes, typed properties, and native HTML5 `Dom\HTMLDocument` parser |
| **Backend Framework** | `laravel/framework` | `^13.17` (`13.39.0`) | MIT (Official Laravel LTS) | Routing, Blade `<x-*>` components, `FormRequest` validation, `RateLimiter`, caching |
| **CSS Engine** | `tailwindcss` + `@tailwindcss/vite` | `^4.0.0` | MIT (Official Tailwind Labs) | Rust/Oxide zero-config CSS engine using CSS-first `@theme` tokens |
| **Asset Bundler** | `vite` + `laravel-vite-plugin` | `^8.0.0` / `^3.1.0` | MIT (Official Vite & Laravel) | Dual-entry bundling (`compro.js` vs `cms.jsx`) + built-in `laravel-vite-plugin/fonts` (Bunny Fonts) |
| **Testing & Quality** | `pestphp/pest` + `laravel/pint` | `^5.3` / `^1.27` | MIT (Official Laravel/Pest) | Feature/Unit testing (`php artisan test --compact`) and PSR-12/Laravel code formatting |

#### B. Phase 2 to Phase 4 Public Compro Stack (Lightweight & Zero Composer Bloat)
To avoid `illuminate/support` version locks on Laravel 13 and keep TTFB near zero, **zero additional Composer packages are required for Phases 2, 3, and 4**. Only three lightweight Alpine.js NPM packages are added for accessible UI interactivity:

| Capability | Heavy / Legacy Package (Avoided in Phase 2-4) | Compatibility / Bloat Issue on Laravel 13 + PHP 8.5 | Approved Lightweight Solution (Phase 2-4) | Footprint & Status |
| :--- | :--- | :--- | :--- | :--- |
| **DTO & ViewModel Layer** | `spatie/laravel-data` | Heavy reflection pipeline and mapper overhead not needed for read-only Compro views | **Native PHP 8.5 `readonly class` DTOs** (`app/Data/*Data.php`) | `0 KB` (Built into PHP 8.5) |
| **Bilingual Routing (`id` / `en`)** | `mcamara/laravel-localization` | Legacy route-caching hooks frequently lag behind new major Laravel releases (`^13.0`) | **Native Laravel 13 Prefix Group (`/{locale}`)** + custom 25-line `SetLocaleMiddleware` + `lang/{locale}/ui.php` | `0 KB` (100% `route:cache` safe) |
| **On-Page SEO & `hreflang`** | `artesaos/seotools` | Global singleton facade state; lags behind `illuminate/support: ^13.0` constraints | **Native `<x-seo.meta :meta="$page->seo" />` Blade Component** driven by `SeoMetaData` | `0 KB` (Pure Blade + DTO) |
| **JSON-LD Schema `@graph`** | Unstructured raw Blade arrays | Error-prone if scattered across views | **`App\Services\SchemaGraphBuilder`** service (pure PHP deterministic `@graph` builder; optionally compatible with `spatie/schema-org` which has zero Laravel version lock) | `0 KB` (Native PHP 8.5 service) |
| **XML Sitemap (`/sitemap.xml`)** | `spatie/laravel-sitemap` | Pulls in `spatie/crawler`, Guzzle, and headless Chromium (`browsershot`) dependencies | **`App\Services\SitemapGenerator`** + cached XML Blade view (`resources/views/seo/sitemap.blade.php`) | `0 KB` (Generates in `< 2ms`) |
| **Form Spam & Bot Protection** | `spatie/laravel-honeypot` | Extra middleware/config overhead for a single RFQ form | **Native Laravel 13 `RateLimiter` (`throttle:10,1` on `POST /{locale}/inquiries`)** + hidden honeypot field (`company_website_hp => prohibited`) in `StoreInquiryRequest` | `0 KB` (Built into Laravel 13) |
| **AMP HTML5 Sanitizer** | `lliure/amp` | Unmaintained on PHP 8.4/8.5 and triggers deprecation notices | **Native PHP 8.5 `Dom\HTMLDocument` (`ext-dom`)** inside `App\Services\AmpSanitizer` | `0 KB` (Native C-level HTML5 parser in PHP 8.5) |
| **Web Fonts (`Plus Jakarta Sans` & `JetBrains Mono`)** | External Google Fonts render-blocking `<link>` | Violates Antislop **R-40** if render-blocking | **`laravel-vite-plugin/fonts` (`bunny()`)** already built into `laravel-vite-plugin: ^3.1` | `0 KB` extra package (Already installed) |
| **Public UI Interactivity & A11y** | React / Vue / jQuery on public pages | Bloats public JS bundle (`150 KB+`) and hurts Core Web Vitals INP/LCP | **`alpinejs` (`^3.17.5`) + `@alpinejs/focus` (`^3.17.5`) + `@alpinejs/collapse` (`^3.17.5`)** | `compro-*.js` measured at `82.40 kB` raw / `28.20 kB` gzip in the last `npm run build` (MIT, Official Alpine) |

#### C. Phase 5 Admin CMS Packages (Strictly Deferred Until Phase 5)
Do **not** install these packages during Phases 2, 3, or 4. Install them only when beginning Phase 5 (`/cms/*` back-office implementation) after receiving user approval:
- **Composer (Phase 5 Only):** `inertiajs/inertia-laravel` (`^2.0`), `spatie/laravel-translatable` (`^6.11`), `spatie/laravel-medialibrary` (`^11.12`), `spatie/laravel-settings` (`^3.4`).
- **NPM (Phase 5 Only):** `@inertiajs/react` (`^2.0`), `react` (`^19.0`), `react-dom` (`^19.0`), `@vitejs/plugin-react` (`^4.3`).

---

## PHASE 1: Context Engineering & Pre-Flight Preparation (Before Coding)

*Rule: Never prompt the AI to write application code until `docs/knowledge-base.md`, `docs/design.md`, and `docs/data-contracts.md` are populated and reviewed.*

### Step 1.1: Business Knowledge Extraction (`docs/knowledge-base.md`)
Collect raw client assets (PDF company profiles, engineering datasheets, pitch decks, legacy site exports) and synthesize them into `docs/knowledge-base.md`:
- **Core Identity:** Legal entity name, founding year, headquarters address, contact channels, and a 1-sentence factual value proposition in Indonesian (`id`) and English (`en`).
- **Service Matrix:** Exact breakdown of offerings, target B2B segments, deliverables, quantified technical specifications, and real multi-stage engineering workflows.
- **Proof & Trust Assets:** Verified operational metrics, ISO/K3/TKDN certifications, permitted client sector references, and real case study summaries.
- **Legacy SEO Audit (If Refactoring):** Export of existing URLs, high-ranking pages to preserve, 301 redirect mappings (`legacy-url` -> `/{locale}/new-slug`), and target primary keywords per page.

### Step 1.2: Sitemap, Design Read & Design System Specification (`docs/design.md`)
Translate brand identity into checkable technical constraints:
- **Antislop Design Read & Dials:** Declare the page kind, target audience, visual language, and explicit `ENERGY / RHYTHM / MOTION` dial values (Part 3 of `antislop`).
- **Route & Sitemap Table:** Exact URL structure (`/{locale}`, `/{locale}/tentang-kami` or `/about`, `/{locale}/layanan/{slug}` or `/services/{slug}`, `/{locale}/studi-kasus/{slug}` or `/case-studies/{slug}`, `/{locale}/artikel/{slug}` or `/articles/{slug}`, `/{locale}/hubungi-kami` or `/contact`).
- **Page-by-Page Section Flow:** Explicit vertical composition sequence per page that matches the declared `RHYTHM` dial and avoids monotonous centered card grids (R-05, R-14).
- **Tailwind CSS v4 Design Tokens (`@theme` in `resources/css/compro.css`):**
  - **Color Palette:** Capped at 2-3 core colors + 1 deliberate accent (R-29), with every text/surface pair verified at $\ge 4.5:1$ via `contrast-check.py` (R-25).
  - **Typography:** Display font, Sans body font, and Mono font (strictly scoped to technical metrics, codes, and tabular numbers) with fluid `clamp()` scales and written brand reasons (R-06, R-31).
  - **Spacing, Radii & Base Affordances:** Container widths, sharp architectural radii, base `cursor: pointer` rules on enabled controls, `:focus-visible` outlines, and `prefers-reduced-motion` support (R-11, R-32, R-39).

### Step 1.3: Anti-Slop Guardrails Enforcement
Lock in strict quality gates across all deliverables:
- **Copywriting Anti-Slop Rules (`antislop-copywriting`):**
  - **Zero Em Dashes (R-02):** Never output the em dash character in UI copy or documentation prose.
  - **Banned Vocabulary (R-16):** Never use *delve, elevate, unleash, seamless, cutting-edge, transformative, game-changer, revolutionary, next-generation, testament, tapestry, symphony, in today's fast-paced world, look no further*.
  - **Evidence Over Claims (C-5, R-36):** Every claim must cite a concrete metric, standard code, or process step from `docs/knowledge-base.md`.
- **UI & Layout Anti-Slop Rules (`antislop-ui` & `antislop-layoutmobile`):**
  - **Banned Default Patterns (R-01, R-05, R-14):** No unmotivated blue-purple glows, no copy-paste 3-column icon cards with heavy drop shadows, no forced 3-step round-icon workflows, no unverified "Trusted By" logo bars, and no decorative eyebrow pills repeating the H1.
  - **Intentional Craftsmanship:** Structural `1px` hairline borders, asymmetric 12-column desktop splits that reflow into dedicated tablet (2-column) and mobile (1-column) layouts, and purposeful Alpine.js state transitions.

---

## PHASE 2: Dual-Entry Vite, Blade & Data Contract Setup

*Goal: Isolate the lightweight public Compro assets from the CMS React bundle while sharing a single Laravel 13 backend.*

### Step 2.1: Dual-Entry `vite.config.js` & Asset Separation
Configure Vite to compile two independent pipelines so public visitors never download React or Inertia:
1. **Public Compro Pipeline:**
   - `resources/css/compro.css` (Tailwind CSS v4 `@import "tailwindcss";` + `@theme` tokens + `@layer base` interaction affordances)
   - `resources/js/compro.js` (Alpine.js v3 core + `@alpinejs/collapse` and `@alpinejs/focus`; registers `comproShell` for theme toggle and mobile drawer, and `rfqForm` for the 4-state RFQ form. Add `@alpinejs/intersect` only if a scroll-triggered behavior is actually needed.)
   - Injected into `resources/views/layouts/compro.blade.php` via `@vite(['resources/css/compro.css', 'resources/js/compro.js'])`.
2. **Admin CMS Pipeline:**
   - `resources/css/cms.css` (Tailwind CSS v4 + Admin back-office tokens)
   - `resources/js/cms.jsx` (`createInertiaApp` mounting React 19 `.jsx` pages from `resources/js/Pages/Cms/**/*.jsx`)
   - Injected into `resources/views/layouts/cms.blade.php` via `@viteReactRefresh` and `@vite(['resources/css/cms.css', 'resources/js/cms.jsx'])`.

### Step 2.2: Modular Blade Component Hierarchy (Public Compro)
Enforce a clean Blade component structure with zero hardcoded copy:
1. **`resources/views/layouts/`**:
   - `compro.blade.php` (Master public shell: `<html lang="{{ app()->getLocale() }}">`, skip-to-content link, `<head>` SEO meta, JSON-LD `@stack('schema')`, `<header>` + `<nav aria-label="...">`, `<main id="main-content">`, `<footer>`). Pages call it through the anonymous wrapper `resources/views/components/layouts/compro.blade.php` as `<x-layouts.compro :settings="$settings" :seo="$seo">`; edit the shell, not the wrapper.
   - `amp.blade.php` (**PLANNED, not built:** standalone valid `⚡` AMP shell for `/{locale}/articles/{slug}/amp` or `/{locale}/artikel/{slug}/amp`).
2. **`resources/views/components/ui/`**: Built primitives: `<x-ui.button>`, `<x-ui.badge>`, `<x-ui.section-header>`, `<x-ui.container>`, `<x-ui.image>`, `<x-ui.empty-state>`, `<x-ui.alert>`. Planned, build only when a page needs them: `<x-ui.modal>`, `<x-ui.accordion>` (the FAQ accordion currently lives inside `<x-sections.technical-faq>`).
3. **`resources/views/components/sections/`**: Built Compro domain blocks: `<x-sections.hero-split>`, `<x-sections.proof-ledger>`, `<x-sections.service-matrix>`, `<x-sections.process-timeline>`, `<x-sections.case-study-showcase>`, `<x-sections.technical-faq>`, `<x-sections.rfq-cta-banner>`. SEO head markup lives in `resources/views/components/seo/meta.blade.php` (`<x-seo.meta>`).
4. **`resources/views/pages/`**: Built route views: `home.blade.php`, `about.blade.php`, `services/index.blade.php`, `services/show.blade.php`, `case-studies/index.blade.php`, `case-studies/show.blade.php`, `contact.blade.php`. Planned: `articles/index.blade.php`, `articles/show.blade.php`, `articles/amp.blade.php`. Pages assemble `<x-sections.*>` and pass typed PHP DTOs.

### Step 2.3: The "CMS-Ready" DTO / ViewModel Contract (Zero-Hardcoding Rule)
**Critical Rule:** Never hardcode business copy, image paths, or raw associative arrays inside `.blade.php` files.
- Define PHP 8.5 `readonly` Data Transfer Objects in `app/Data/` matching the exact schemas in `docs/data-contracts.md` (`HomePageData`, `ServiceData`, `CaseStudyData`, `ArticleData`, `CompanySettingsData`, `SeoMetaData`).
- During Phase 3 (before building the Inertia CMS), hydrate these DTOs from localized PHP mock repositories in `app/Data/Mocks/` sourced from `docs/knowledge-base.md`, and pass them from the Controller to the Blade view (`view('pages.home', ['page' => $homeData])`).
- Every `<x-sections.*>` component must declare explicit `@props` at the top of the file and handle empty collections gracefully (`@if(count($items) > 0)` or `<x-ui.empty-state />` per R-27, R-38).

---

## PHASE 3: Vibe Coding the Public Compro (Pure Blade + Alpine.js)

*Execute in sequential steps. Build, test, and verify the public Compro before building the CMS.*

- **Step 3.1 (Foundation & Layout Shell):** Set up `vite.config.js` dual entries, `resources/css/compro.css` design tokens and R-39 base cursor/focus rules, and `layouts/compro.blade.php` with accessible sticky navigation (`x-data="{ mobileOpen: false }"`, Escape key closure, and a labeled mobile menu button with `44x44px` minimum hit area).
- **Step 3.2 (UI Primitives & Resilience States):** Build `<x-ui.*>` Blade components using Tailwind v4 and Alpine.js (`x-collapse` for FAQ accordions, `x-trap` for modals/drawers, plus explicit empty, loading, and error state components per R-27).
- **Step 3.3 (Mock DTO Layer):** Implement the PHP 8.5 DTO classes in `app/Data/` and localized (`id`, `en`) mock data providers in `app/Data/Mocks/` matching `docs/knowledge-base.md` and `docs/data-contracts.md`.
- **Step 3.4 (Page Assembly & 3-State Responsive Reflow):** Wire Laravel 13 Public Controllers -> DTOs -> `pages/*.blade.php` -> `<x-sections.*>`. Verify layout reflow across Phone (`< 640px`), Tablet (`640px - 1023px`), and Desktop (`>= 1024px`) viewports (R-03).
- **Step 3.5 (Interactive RFQ & Contact Form):** Build the technical inquiry/RFQ form with visible `<label for>` elements (R-39), standard CSRF protection, Laravel 13 `FormRequest` validation (`StoreInquiryRequest`), spam honeypot protection, and perceivable idle, submitting (loading), field-error, and success states (R-26, R-27).

---

## PHASE 4: Technical SEO, Localization, AMP & A11y Hardening

*Goal: Deliver server-rendered HTML with complete structured data, bilingual routing, and verified WCAG 2.2 AA compliance.*

### Step 4.1: Dynamic JSON-LD Schema Graph
Use a dedicated `App\Services\SchemaGraphBuilder` service to push structured `@graph` JSON-LD scripts into `@stack('schema')` using data from `CompanySettingsData` and page DTOs:
- **Global:** `Organization` and `LocalBusiness` (LegalName, URL, Logo, Address, GeoCoordinates, OpeningHoursSpecification, SameAs, ContactPoint).
- **All Pages:** `WebPage` + `BreadcrumbList`.
- **Service Detail:** `Service` schema linked to `Organization` (`provider`, `areaServed`, `serviceType`).
- **Article Detail (PLANNED, with Step 4.4):** `TechArticle` / `Article` schema (`headline`, `datePublished`, `dateModified`, `author`, `image`).
- **FAQ Sections:** `FAQPage` schema generated dynamically from the active `FaqItemData[]` collection.

### Step 4.2: Multi-Language (`id` / `en`) Architecture
- **URL Strategy:** Prefix-based routing (`/{locale}/...` where `locale` is `id` or `en`, defaulting `/` via 302/301 redirect to `/id`) handled by `SetLocaleMiddleware`.
- **Legacy 301 Redirects:** Middleware or route map redirecting legacy URLs listed in Section 7 of `docs/knowledge-base.md` to their canonical localized routes.
- **Head Tags:** Automatic `<link rel="alternate" hreflang="id" ...>`, `hreflang="en"`, and `hreflang="x-default"` rendered in `layouts/compro.blade.php`.
- **Translations:** Static UI chrome labels resolved via `__('ui.*')` in `lang/id/ui.php` and `lang/en/ui.php`; domain content resolved from localized DTO properties.

### Step 4.3: On-Page SEO, Sitemap & Performance Mechanisms (R-40)
- Render `<x-seo.meta :meta="$page->seo" />` for unique `<title>`, `<meta name="description">`, canonical URL, OpenGraph, and Twitter Cards.
- Generate `/sitemap.xml` with localized `xhtml:link` alternates for all public routes.
- **Performance Mechanisms (R-40):**
  - Every `<img>`, `<video>`, and `<iframe>` must carry explicit `width` and `height` (or CSS `aspect-ratio`) to prevent layout shifts.
  - The above-the-fold hero image must be a standard `<img>` with `fetchpriority="high"` and `loading="eager"` (never lazy-loaded).
  - Below-the-fold images use `<x-ui.image>` with `loading="lazy"` and `decoding="async"`.
  - Zero render-blocking third-party scripts in `<head>`.
  - Never claim a Lighthouse or Web Vitals score unless actually measured; otherwise state `"not measured"` (R-36, R-40).

### Step 4.4: Native Blade AMP for Article Details (PLANNED, not built)
> Status: no article routes, views, `ArticleData`, `AmpSanitizer`, or `layouts/amp.blade.php` exist yet. Build this step only when the client needs articles, and update `docs/guideline.md` (status table), `docs/data-contracts.md` (Section 3.4), and `docs/design.md` (Section 6.1) in the same changeset.
- **Standard Route:** `/{locale}/artikel/{slug}` (ID) and `/{locale}/articles/{slug}` (EN) -> `pages/articles/show.blade.php` (includes `<link rel="amphtml" href="...">`).
- **AMP Route:** `/{locale}/artikel/{slug}/amp` and `/{locale}/articles/{slug}/amp` -> `pages/articles/amp.blade.php` extending `layouts/amp.blade.php` (`<!doctype html><html ⚡ lang="{{ app()->getLocale() }}">`).
- **AMP Sanitizer Service:** `App\Services\AmpSanitizer` converts standard HTML article bodies into valid `<amp-img layout="responsive" width="..." height="...">` markup with inline `<style amp-custom>` kept strictly under 75KB.

### Step 4.5: Accessibility (A11y) & Human Affordances Checklist (WCAG 2.2 AA)
- [ ] `<html lang="{{ app()->getLocale() }}">`, unique `<title>`, and semantic landmarks (`<header>`, `<nav aria-label="...">`, `<main id="main-content">`, `<footer>`) on every page (R-39).
- [ ] Single `<h1>` per page and strictly sequential heading hierarchy (`h1` -> `h2` -> `h3`) (R-39).
- [ ] Viewport meta never includes `user-scalable=no` or `maximum-scale=1`, and text scales cleanly to 200% zoom without horizontal clipping (R-39).
- [ ] Every enabled interactive control shows `cursor: pointer` and disabled controls show `cursor: not-allowed` via the base CSS layer (R-39).
- [ ] Actions use `<button type="...">` and navigation uses `<a href="...">` pointing to real destinations; zero clickable `<div>`/`<span>` elements or dead `#` links (R-24, R-26, R-39).
- [ ] Every form input has a visible `<label for="...">` and text-first error messages (not color alone) (R-39).
- [ ] Visible `:focus-visible` indicator ($\ge 3:1$ contrast) and a "Skip to main content" link at the top of `layouts/compro.blade.php` (R-32).
- [ ] Verified contrast ratio $\ge 4.5:1$ for normal text, $\ge 3.0:1$ for large text and interactive boundaries, and `@media (prefers-reduced-motion: reduce)` support (R-25, R-39).

---

## PHASE 5: CMS Upgrade Implementation (Inertia.js v2 + React 19 `.jsx`)

*Because Phase 2 enforced the DTO / `@props` Contract in `docs/data-contracts.md`, attaching the Inertia `.jsx` CMS requires zero changes to the public Blade views.*

### Step 5.1: Database Schema & Eloquent Models
Create migrations, factories, and models to replace the static mock repositories:
- `pages` & `page_sections` (using `spatie/laravel-translatable` for `id`/`en` JSON columns matching `docs/data-contracts.md`).
- `services`, `case_studies`, `articles`, `categories`, `faqs`, `testimonials`, `inquiries`, and global `settings` (`spatie/laravel-settings`).
- Attach `spatie/laravel-medialibrary` for responsive WebP/AVIF conversions with stored `width` and `height` metadata.

### Step 5.2: Inertia `.jsx` CMS Architecture (`/cms/*`)
Mount the Inertia middleware (`HandleInertiaRequests`) exclusively on the `cms` route group (`routes/cms.php` with prefix `/cms` and root view `layouts.cms`):
- **`resources/js/cms.jsx`**: Entry point initializing React 19 + Inertia v2.
- **`resources/js/Layouts/CmsLayout.jsx`**: Accessible sidebar navigation, breadcrumb bar, active user menu, and status notifications.
- **`resources/js/Pages/Cms/`**:
  - `Dashboard.jsx` (Inquiry summary metrics, cache status, quick actions).
  - `Pages/Edit.jsx` (Section block editor mapping 1:1 to the section schemas in `docs/data-contracts.md`).
  - `Services/Index.jsx` & `Services/Form.jsx` (Bilingual `id`/`en` tabs, technical deliverables repeater, workflow steps editor).
  - `CaseStudies/Index.jsx` & `CaseStudies/Form.jsx`.
  - `Articles/Index.jsx` & `Articles/Form.jsx` (Rich text editor, SEO meta preview, AMP readiness check, `id`/`en` tabs).
  - `Faqs/Index.jsx` & `Testimonials/Index.jsx` (Includes mandatory `is_verified_real` consent toggle before public display).
  - `Inquiries/Index.jsx` & `Inquiries/Show.jsx` (RFQ lead status workflow & CSV export).
  - `Settings/Edit.jsx` (Global company profile, JSON-LD entity data, certifications).

### Step 5.3: Swap Public Controllers from Mock Data to Cached Eloquent
1. Update the Public Compro Repositories/Controllers to query Eloquent Models instead of `app/Data/Mocks/`, hydrating the exact same PHP 8.5 DTOs defined in `docs/data-contracts.md`.
2. Wrap public read queries in `Cache::flexible()` or `Cache::rememberForever()` using the canonical cache keys specified in `docs/data-contracts.md`.
3. Register Model Observers (`PageObserver`, `ServiceObserver`, `CaseStudyObserver`, `ArticleObserver`, `FaqObserver`, `SettingObserver`) so every save in the Inertia CMS clears the affected public Blade cache keys and refreshes `sitemap.xml`.

---

## PHASE 6: Mandatory Antislop Delivery Gate & Pre-Ship Verification

*Rule: No phase or feature is complete until it passes automated CLI checks and the 4-block Antislop Delivery Gate.*

### Step 6.1: Automated CLI Verification
Run and verify all three commands before presenting any code deliverable:
1. `vendor/bin/pint --dirty --format agent` (PHP code style formatting)
2. `php artisan test --compact` (Pest feature and unit tests covering routes, localization, DTO hydration, and inquiry form validation)
3. `npm run build` (Vite production bundle verification)

### Step 6.2: Interactive Click-Through & Responsive Reflow Audit (R-35)
Verify and record element-by-element behavior across light/dark modes and Phone (`375px`), Tablet (`768px`), and Desktop (`1440px`) widths:
- Every navbar link, CTA button, language switcher (`ID` / `EN`), FAQ accordion (`Enter`/`Space`/`Escape`), mobile menu drawer, and RFQ form submission (empty validation, valid submission, error feedback).

### Step 6.3: Four-Block Antislop Delivery Gate Report
Close every UI/copy deliverable with the mandatory PASS/FAIL report from `.agents/skills/antislop/SKILL.md`:
- **Block 1: Hard Gate** (`R-02`, `R-03`, `R-17`, `R-18`, `R-23`, `R-24`, `R-25`, `R-26`, `R-27`, `R-28`, `R-32`, `R-33`, `R-34`, `R-35`, `R-36`, `R-37`, `R-38`, `R-39`, `R-40`)
- **Block 2: Purpose-Gate** (`R-01`, `R-04`, `R-06`, `R-07`, `R-08`, `R-09`, `R-10`, `R-12`, `R-13`, `R-14`, `R-19`, `R-22`) with one-line written reasons
- **Block 3: Liveliness Dials & Levers** (Explicit `ENERGY / RHYTHM / MOTION` alignment, focal point, structural whitespace, single deliberate accent, identity motif, Design Read)
- **Block 4: Craftsmanship & Quality Locks** (`C-1` to `C-5`, `R-05`, `R-11`, `R-15`, `R-16`, `R-20`, `R-21`, `R-29`, `R-30`, `R-31`)