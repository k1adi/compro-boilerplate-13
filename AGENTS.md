<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.5. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

</laravel-boost-guidelines>

# AI Agent Orchestration, Governance & Verification (`AGENTS.md`)

## 1. Source-of-Truth Documentation Governance (Phase 0 Mandate)

This repository uses five canonical documentation files under `docs/`. Four are single sources of truth for their domain, and `docs/guideline.md` is the onboarding recap that points to them:

| Document | Canonical Scope | Mandatory Update Trigger |
| :--- | :--- | :--- |
| [`docs/knowledge-base.md`](docs/knowledge-base.md) | Company identity, legal entity data, verified metrics, certifications, service specs, technical FAQ bank, and 301 redirect map | Any change to business facts, service offerings, contact channels, SEO keywords, or legacy URL redirects |
| [`docs/workflow.md`](docs/workflow.md) | End-to-end development SOP (Phase 0 preparation through Phase 6 pre-ship gate) | Any change to build pipelines, folder hierarchy, localization strategy, or verification gates |
| [`docs/design.md`](docs/design.md) | Visual direction, Antislop Design Read, liveliness dials, WCAG AA contrast table, Tailwind v4 `@theme` tokens, responsive reflow, and page section blueprints | Any change to color tokens, typography, layout rhythm, breakpoints, navigation, or page section order |
| [`docs/data-contracts.md`](docs/data-contracts.md) | 1:1 schema contracts between PHP 8.5 DTOs, Public Blade `@props`, Eloquent JSON columns, and Admin Inertia `.jsx` CMS forms | Any addition or modification to DTO properties, Blade component props, database columns, or CMS form payloads |
| [`docs/guideline.md`](docs/guideline.md) | Developer onboarding recap: project map, request flow, implementation status table, daily commands, troubleshooting, and the change-to-document sync matrix. Owns no facts, tokens, or schemas; it links to the four documents above | Any phase completed or started, file or folder added, moved or removed, route or component added, command or environment requirement changed, or any edit to the four documents above that changes what a new developer must know |

**Bi-Directional Synchronization Rule:**
- Never hardcode business facts, unverified statistics, or ad-hoc component props in code without first recording them in the governing `docs/*.md` file.
- Whenever a schema, route, token, or workflow step is modified during implementation, update the matching `docs/*.md` file in the **same changeset**. Code and `docs/` must never drift apart.
- New developers start at [`docs/guideline.md`](docs/guideline.md). Its "Change-to-Document Sync Matrix" lists which file to update for each kind of change, and its "Implementation Status" table must be updated whenever a phase, page, component, or route is added or removed.
- Before finishing any task that touched code, re-read the sections of `docs/` that describe it and fix every stale path, prop, route, command, or count in the same changeset.

### 1.1 Worldwide Community Standards & Technical References

When creating agents, defining standards, or implementing features for crawler governance, XML sitemaps, or web accessibility, all implementations must adhere to these global community specifications alongside modern framework practices:

| Standard Domain | Worldwide Reference URL | Modern Implementation Requirement in This Codebase |
| :--- | :--- | :--- |
| **Robots Exclusion Standard (`robots.txt` / RFC 9309)** | http://www.robotstxt.org/robotstxt.html | Dynamic `/robots.txt` route (`ComproPageController::robots`) with `Content-Type: text/plain; charset=UTF-8`, `User-agent: *`, `Allow: /`, `Disallow: /cms`, `Disallow: /cms/`, and a dynamic `Sitemap: {APP_URL}/sitemap.xml` auto-discovery directive based on current environment / host. |
| **Sitemaps XML Protocol (`sitemap.xml` v0.9)** | https://www.sitemaps.org/index.html | Generate UTF-8 XML natively via `App\Services\SitemapGenerator` (`DOMDocument`) with `text/xml; charset=UTF-8` and modern CSS styling (`/sitemap.css`, zero deprecated XSLT per ChromeStatus 4709671889534976) using a parent `<sitemapindex>` at `/sitemap.xml` referencing modular child sitemaps (`main-sitemap.xml`, `services-sitemap.xml`, `case-studies-sitemap.xml`, `articles-sitemap.xml`), each rendering `<urlset>`, `<loc>`, W3C Datetime `<lastmod>` (`YYYY-MM-DD`), `<changefreq>`, `<priority>`, and reciprocal `<xhtml:link rel="alternate" hreflang="..." />` (`id`, `en`, `x-default`). |
| **Web Accessibility Compliance & Auditing (`WCAG 2.2 AA / ADA / EAA`)** | https://www.accessibilitychecker.org/ | Enforce semantic HTML5 landmarks, single `<h1>`, labeled controls (`<label for>`), keyboard operability (`:focus-visible`, `Escape` closure), `44x44px` minimum hit areas, local contrast math (`contrast-check.py` from `.agents/skills/antislop-human`), and live page audits against https://www.accessibilitychecker.org/ criteria. |

## 2. Environment & CLI Verification Commands

When implementing features, agents must verify their changes using these exact commands:
- **PHP / Laravel Format (Pint):** `vendor/bin/pint --dirty --format agent`
- **PHP / Pest Test Suite:** `php artisan test --compact` (or scoped to a file/filter)
- **Build Dual-Entry Assets (Vite):** `npm run build` (verifies both `compro.js` and `cms.jsx` compile cleanly without cross-imports)
- **Route & Middleware Audit:** `php artisan route:list --path=cms` and `php artisan route:list --path=id`
- **Clear Cached Views & Data:** `php artisan optimize:clear`
- **WCAG Contrast Verification:** `python .agents/skills/antislop-human/contrast-check.py "#HEX_BG" "#HEX_FG"`
- **Reference URL Modular Layout Scraper:** `python .agents/skills/modular-layout-scraper/scripts/scrape-layout.py --save-dir ./storage/app/scratch <url1> [<url2> ...]`
- **Environment notes:** On the Laragon/Windows setup the `php` in `PATH` may be older than 8.5. Call the project binary explicitly (see `docs/guideline.md` Section 7). `vendor/bin/pint --dirty` only works inside a Git repository; without Git, run `vendor/bin/pint --format agent`.

## 3. Specialized Agent Personas (Invoke by `@Role` in Prompts)

### `@Architect-DTO` (PHP 8.5 & Data Layer Specialist)
- **Scope:** `app/Data/**`, `app/Models/**`, `app/Http/Controllers/**`, `database/migrations/**`, `database/seeders/**`
- **Mission:** Design `readonly` PHP 8.5 DTOs that serve both Phase 3 Mock Data and Phase 5 Eloquent Models in strict compliance with `docs/data-contracts.md`. Never touch CSS or React when acting as `@Architect-DTO`.

### `@Compro-Blade-Crafter` (Public Frontend & Anti-Slop UI Specialist)
- **Scope:** `resources/views/**`, `resources/css/compro.css`, `resources/js/compro.js`
- **Mission:** Build pure Laravel 13 Blade `<x-ui.*>` and `<x-sections.*>` components with Tailwind CSS v4 and Alpine.js v3 following `docs/design.md`. Enforce all Antislop rules (R-01 to R-40), WCAG 2.2 AA accessibility and https://www.accessibilitychecker.org/ audit compliance, 3-state responsive reflow, and 0KB React leakage.

### `@SEO-AMP-Auditor` (Technical SEO, JSON-LD & AMP Specialist)
- **Scope:** `app/Services/AmpSanitizer.php`, `app/Services/SchemaGraphBuilder.php`, `app/Services/SitemapGenerator.php`, `resources/views/layouts/compro.blade.php`, `resources/views/layouts/amp.blade.php`
- **Mission:** Verify `@stack('schema')` JSON-LD graphs against `docs/knowledge-base.md`, `hreflang` alternates (`id`, `en`, `x-default`), canonical tags, dynamic `/robots.txt` compliance with http://www.robotstxt.org/robotstxt.html, `/sitemap.xml` compliance with https://www.sitemaps.org/index.html, accessibility compliance with https://www.accessibilitychecker.org/, LCP image attributes (`fetchpriority="high"`, explicit dimensions), and valid `<html ⚡>` AMP output under 75KB CSS.

### `@CMS-Inertia-Builder` (Phase 5 Admin Panel Specialist)
- **Scope:** `routes/cms.php`, `app/Http/Controllers/Cms/**`, `resources/js/cms.jsx`, `resources/js/Pages/Cms/**/*.jsx`
- **Mission:** Build the Inertia.js v2 + React 19 (`.jsx`) CMS dashboard to manage the exact data structures defined in `docs/data-contracts.md`, triggering cache invalidation and sitemap regeneration on save.

### `@Template-Handoff-Cleaner` (Boilerplate-to-Real-Business Conversion Specialist)
- **Trigger:** Invoke only after the boilerplate is production-ready as a template and is being forked for a new, real business. Never run it on the master template repository itself.
- **Scope:** Whole repository, but restricted to the inventory and procedure below. Never touches `vendor/`, `node_modules/`, `.git/`, `.agents/skills/**`, or `AGENTS.md` governance rules.
- **Mission:** Remove every seed, sample, and unrelated file so the fork contains only the real business. Keep `docs/*.md` as the source of truth and update them in the same changeset as any deletion (Section 1 sync rule).

**Mandatory Procedure (in order):**
1. **Intake:** Ask the user for the real business facts (legal name, brand, services, contacts, languages). Record them in `docs/knowledge-base.md` first. Do not delete anything until this is done.
2. **Dry run:** List every file and string you intend to remove or replace, grouped by the inventory below, and wait for user approval. Never delete tests, migrations, or files outside the inventory without approval.
3. **Execute:** Delete or replace per inventory. Prefer replacing seed data over deleting structural files.
4. **Sync docs:** Update `docs/knowledge-base.md`, `docs/data-contracts.md`, `docs/design.md`, `docs/workflow.md`, and `docs/guideline.md` (status table, file tree, and route list) so they describe only the real business and the real file tree.
5. **Verify:** Run `php artisan optimize:clear`, `vendor/bin/pint --format agent`, `php artisan test --compact`, `npm run build`, then the leftover scan below. Report any remaining hit.

**Removal & Replacement Inventory:**

| Category | Files / Patterns | Action |
| :--- | :--- | :--- |
| Seed data | `app/Data/Mocks/ComproMockRepository.php` (all `Koolom`, `PT Koolom Mitra Konsultan`, `SRV-0x`, `CS-0x`, `faq-0x` records) | Rewrite with real data, or swap to Eloquent per `docs/workflow.md` Step 5.3. Empty collections (`[]`) for anything unverified (R-17, R-18, R-38). |
| Placeholder media | `public/images/placeholders/*.svg` | Delete once real photos exist. Update every `MediaAssetData` that references them. |
| Boilerplate notices | `isSampleBoilerplate`, `isSamplePlaceholder` flags, `ui.boilerplate_banner_*`, `ui.proof.seed_badge`, `ui.case_studies.seed_note` | Set flags to `false` for verified data. Remove the banner and badge markup only when no seed data remains. |
| Sample copy | `lang/id/ui.php`, `lang/en/ui.php` strings that name the sample company, KBLI codes, cities, or capacity ranges | Rewrite for the real business in both locales. |
| Hardcoded sample strings outside the mock repository | `resources/views/layouts/compro.blade.php` (`Koolom Partners` brand monogram), `resources/views/components/sections/hero-split.blade.php` (SLA and parameter bar), `resources/views/components/sections/technical-faq.blade.php` (escalation desk label), `resources/views/components/sections/rfq-cta-banner.blade.php` (fallback `SRV-0x` select options), `resources/views/pages/about.blade.php` (KBLI badge), `app/Http/Controllers/ComproPageController.php` (page titles), `app/Http/Requests/StoreInquiryRequest.php` (`Rule::in` list of `SRV-0x` codes), `resources/js/compro.js` | Move each value into a DTO or `lang/*/ui.php` key (zero-hardcoding rule), or rewrite it for the real business. Derive `service_code` validation from the real service list. |
| Legacy redirects | `/about-us.html`, `/services.html`, `/product-detail`, `/projects.php`, `/contact-us.html` in `routes/web.php` and `legacyProductRedirect()` | Keep only if the real business has old URLs. Otherwise delete them and the matching tests. |
| Unrelated sections | Any `<x-sections.*>` or `pages/*` the real business does not need (for example `case-studies/*` when there are no projects) | Delete the view, route, controller method, nav and footer links, sitemap entries, and tests together, so no dead link remains (R-24, R-26). |
| Framework leftovers | `resources/views/welcome.blade.php`, `tests/Feature/ExampleTest.php` if superseded, unused default `resources/css/app.css` and `resources/js/app.js` entries when Phase 5 is not used | Delete after confirming nothing imports them. |
| Phase 5 scaffolding | `routes/cms.php`, `app/Http/Controllers/Cms/**`, `resources/js/cms.jsx`, `resources/js/Pages/Cms/**`, Inertia and React packages | Delete only if the client will never get the CMS. Needs explicit user approval because it changes dependencies. |
| Tests | `tests/Feature/ComproLandingPageTest.php` assertions containing sample strings (`SRV-01`, `CS-01`, `faq-01`, sample slugs) | Update to the real data. Do not delete the test file. |
| Docs | Sample-specific content in `docs/knowledge-base.md`, `docs/design.md` (brand name, palette rationale), `docs/data-contracts.md` examples | Replace with real facts. Keep structure and governance tables. |

**Leftover Scan (must return zero hits before handoff):**
```powershell
Select-String -Path (Get-ChildItem app,resources,lang,routes,tests,docs,public -Recurse -File).FullName -Pattern "Koolom|Koolom Mitra|GardaTek|BOILERPLATE|SAMPEL|SRV-0|CS-0|koolom.co.id|placeholders/"
```

**Hard Rules:**
- Never delete a file without listing it in the approved dry run.
- Never invent replacement business facts. Missing facts become empty collections or are omitted (R-16, R-17, R-18, R-38).
- Zero em dashes in any replacement copy (R-02).
- Finish with the Four-Block Antislop Delivery Gate report (`docs/workflow.md` Step 6.3).

<!-- antislop:start -->
## antislop
For UI, copy, people, mobile layout, reference URL scraping, or code comments work, read these installed skill files directly (use these paths even if a same-named global skill exists):
- Core filter, always on: `antislop`: `.agents/skills/antislop/SKILL.md`
- UI / visual: `antislop-ui`: `.agents/skills/antislop-ui/SKILL.md`
- Copy & text: `antislop-copywriting`: `.agents/skills/antislop-copywriting/SKILL.md`
- People: `antislop-human`: `.agents/skills/antislop-human/SKILL.md`
- Mobile / responsive: `antislop-layoutmobile`: `.agents/skills/antislop-layoutmobile/SKILL.md`
- Code comments: `antislop-code`: `.agents/skills/antislop-code/SKILL.md`
- Reference URL Layout Scraper & Modular Inheritance: `modular-layout-scraper`: `.agents/skills/modular-layout-scraper/SKILL.md`

Before starting, follow the core's "Two Usage Modes" section in strict order: explicit session instruction first, then global preference, then ask. A session instruction always wins. For a resolved mode, say `antislop active: <mode> (session override).` or `antislop active: <mode> (global preference).` once before presenting findings or making edits, using the actual mode and source. Acknowledging the user's request without naming the source does not replace this notice.
Only an explicit choice of antislop during or after selects a session mode. A request to review, audit, or avoid file edits does not select a mode; read the global preference in that case. Another skill's mode does not select antislop's mode.
If the mode is unresolved, ask during/after and end the response; wait for the answer before any UI review, planning, or concept. For read-only tasks, put the active-mode notice only at the start of the final answer, never in progress messages. For editing tasks, announce before the first edit and omit it from the final answer.
To update antislop later: `npx antislop-ai --update`, or run `npx antislop-ai` and pick Overwrite them.
<!-- antislop:end -->