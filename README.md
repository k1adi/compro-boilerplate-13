# B2B Company Profile (Compro) Boilerplate

A production-grade, bilingual (`id` default, `en`) B2B service company profile boilerplate built with **Laravel 13**, **PHP 8.5**, **Tailwind CSS v4**, and **Alpine.js v3**.

This template is engineered for technical, industrial, and specialized B2B service enterprises. It enforces a strict "Zero-Hardcoding in Blade" principle, full WCAG 2.2 AA accessibility, structured JSON-LD SEO schema graphs, and a 4-state technical Request for Quotation (RFQ) inquiry system.

---

## What This Boilerplate Provides

- **Dual-Entry Architecture:**
  - **Public Frontend:** Server-rendered Laravel Blade with Tailwind CSS v4 and Alpine.js v3 (`compro.css` and `compro.js`). Zero React or Inertia runtime overhead on public pages for fast Core Web Vitals (LCP, INP, CLS).
  - **Admin CMS (Phase 5 Scaffolding):** Dedicated Inertia.js v2 + React 19 `.jsx` pipeline scoped strictly to `/cms/*`.
- **Typed DTO Data Layer:** All business copy and section schemas pass through PHP 8.5 `readonly` Data Transfer Objects (`app/Data/`), decoupled from views via mock repositories (`app/Data/Mocks/`) ready to swap to Eloquent models.
- **Bilingual by Design (`id` and `en`):**
  - Clean URL prefix pairs (`/id/layanan` and `/en/services`).
  - Reciprocal `hreflang` tags (`id`, `en`, and `x-default`).
  - XML sitemap (`/sitemap.xml`) with localized `xhtml:link` alternates.
  - Legacy 301 redirect map for site migrations.
- **On-Page SEO & Structured Data:**
  - Automated JSON-LD `@graph` generation (`Organization`, `LocalBusiness`, `WebSite`, `WebPage`, `BreadcrumbList`, `Service`, `FAQPage`).
  - Canonical tags, OpenGraph cards, and Twitter Cards.
- **Accessible & Resilient UI (WCAG 2.2 AA):**
  - Keyboard skip link (`#main-content`), ARIA landmarks, and focus-trapped mobile drawer.
  - Working persistent light and dark theme switcher.
  - High-contrast color tokens verified with contrast math.
  - Interactive 4-state RFQ form (`idle`, `submitting`, `error`, `success`) with anti-spam honeypot.
- **Anti-Slop Quality Standards:** Zero em dashes, honest placeholder labeling (`isSampleBoilerplate`), no fabricated client logos or testimonials, and verified technical metrics.

---

## Tech Stack & Requirements

| Layer | Technology | Version |
| :--- | :--- | :--- |
| Runtime | PHP (CLI / NTS) | `^8.3` (Developed on `8.5.12`) |
| Framework | Laravel Framework | `^13.17` |
| Styling | Tailwind CSS | `^4.0.0` (Vite Oxide engine) |
| UI Interactivity | Alpine.js + Focus + Collapse | `^3.17.5` |
| Bundler | Vite + Laravel Vite Plugin | `^8.0.0` / `^3.1.0` |
| Testing | Pest PHP | `^5.3` |
| Code Formatter | Laravel Pint | `^1.27` |

---

## Getting Started

### 1. Prerequisites

Ensure you have installed:
- PHP 8.3 or higher (PHP 8.5 recommended) with `ext-dom`, `ext-curl`, `ext-mbstring`, `ext-pdo_sqlite` or MySQL.
- Composer 2.x
- Node.js (v20+) and NPM

### 2. Installation

Clone the repository and install dependencies:

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Install Node dependencies
npm install

# Build frontend production assets
npm run build
```

*(Alternatively, run `composer run setup` to execute all initial bootstrap steps automatically.)*

### 3. Local Development

Run the unified development watcher (serves Laravel and Vite concurrently):

```bash
composer run dev
```

Or run services in separate terminals:

```bash
# Terminal 1: Laravel backend server
php artisan serve

# Terminal 2: Vite hot module reloading (HMR)
npm run dev
```

Visit the application in your browser at `http://localhost:8000`. The root URL (`/`) automatically redirects to `/id`.

---

## Operating & Maintaining the Codebase

### Daily Commands

| Operation | Command | Purpose |
| :--- | :--- | :--- |
| **Run Tests** | `php artisan test --compact` | Runs the Pest feature and unit test suite |
| **Run Scoped Test** | `php artisan test --compact tests/Feature/ComproLandingPageTest.php` | Runs a specific test file |
| **Format Code** | `vendor/bin/pint --dirty --format agent` | Formats modified PHP files (requires Git) |
| **Format All PHP** | `vendor/bin/pint --format agent` | Formats the entire PHP codebase |
| **Build Assets** | `npm run build` | Compiles production assets and fonts via Vite |
| **List Routes** | `php artisan route:list --except-vendor` | Inspects all public and localized routes |
| **Clear Caches** | `php artisan optimize:clear` | Flushes view, route, config, and application cache |
| **Clear Blade Views** | `php artisan view:clear` | Clears compiled Blade templates |

### Quality & Governance Rules

- **Zero Em Dashes:** Never use em dashes in UI copy, translations, code comments, or documentation. Tests assert that no em dashes exist in rendered HTML.
- **Zero Dead Links:** Every navigation item, CTA button, and footer link must resolve to a valid named route or an existing anchor (`#rfq-form`, `#service-matrix`).
- **Zero Hardcoded Business Facts:** Business data must reside in DTOs (`app/Data/`), mock repositories (`app/Data/Mocks/`), or translation files (`lang/{locale}/ui.php`).

---

## Documentation Guide

The project includes five canonical documentation files under `docs/` and root governance in `AGENTS.md`:

| File | Scope & Purpose |
| :--- | :--- |
| [`docs/guideline.md`](docs/guideline.md) | **Start Here.** Developer onboarding guide, request flow diagram, implementation status, and change-to-document sync matrix. |
| [`AGENTS.md`](AGENTS.md) | AI agent orchestration rules, specialist roles (`@Architect-DTO`, `@Compro-Blade-Crafter`, etc.), and verification mandates. |
| [`docs/knowledge-base.md`](docs/knowledge-base.md) | Single source of truth for business facts, service specifications, case studies, technical FAQs, and 301 redirects. |
| [`docs/workflow.md`](docs/workflow.md) | SOP phases 0 through 6, dependency rules, and pre-ship delivery gate checklist. |
| [`docs/design.md`](docs/design.md) | Design Read, liveliness dials, WCAG contrast verification table, Tailwind tokens, and responsive reflow rules. |
| [`docs/data-contracts.md`](docs/data-contracts.md) | 1:1 schema contracts between PHP DTOs, Blade `@props`, database columns, and CMS forms. |

---

## Adapting for a Real Business

This boilerplate ships with sample data for a fictional engineering company (`GardaTek Engineering`). When adapting this template for a real client:

1. Follow the **Client Onboarding Checklist** in [`docs/workflow.md`](docs/workflow.md) (Step 0.3).
2. Record real business identity, services, and contacts in [`docs/knowledge-base.md`](docs/knowledge-base.md).
3. If using an AI coding agent, invoke `@Template-Handoff-Cleaner` (defined in [`AGENTS.md`](AGENTS.md) Section 3) to execute an approved dry run, remove boilerplate seed records, and verify leftover strings.
4. Replace placeholder images in `public/images/placeholders/` with authentic facility photos.
5. Set `isSampleBoilerplate` and `isSamplePlaceholder` flags to `false` in `CompanySettingsData`.

---

## License

This project is open-source software licensed under the [MIT license](LICENSE).
