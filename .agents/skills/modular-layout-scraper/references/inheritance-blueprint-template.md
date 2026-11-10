# Modular Template Inheritance Blueprint Reference

Use this structure when updating `docs/design.md` (Section 1.4 and Section 6) after scraping reference URLs.

## 1. Four-Level Modular Template Hierarchy

Every scraped website must be decomposed into four modular layers so styles and components are inherited cleanly without duplication:

| Inheritance Level | Laravel / Blade Target | What Lives Here | Styling & Token Inheritance Rule |
| :--- | :--- | :--- | :--- |
| **Level 1: Parent Master Shell** | `resources/views/layouts/compro.blade.php` | `<head>` SEO/Schema stack, `@vite` CSS/JS entrypoints, sticky `<header>` navbar, language switcher, mobile drawer, `<footer>`, floating action bar | Defines the root `@theme` CSS tokens (`resources/css/compro.css`), typography scale, surface canvas (`--color-surface-canvas`), and container padding (`--spacing-container`). All child templates extend or mount inside `<x-layouts.compro>`. |
| **Level 2: Reusable Section Partials & UI Primitives** | `resources/views/components/sections/*.blade.php`<br>`resources/views/components/ui/*.blade.php` | Self-contained blocks shared across 2+ pages (e.g., `hero-split`, `service-matrix`, `proof-ledger`, `process-timeline`, `case-study-showcase`, `technical-faq`, `rfq-cta-banner`) and atomic UI primitives (`button`, `badge`, `section-header`) | Inherit parent `@theme` tokens and accept typed `@props(...)` backed by PHP 8.5 `readonly` DTOs (`docs/data-contracts.md`). Never hardcode page-specific copy inside a Level 2 component. |
| **Level 3A: Child Index / Landing Pages** | `resources/views/pages/home.blade.php`<br>`resources/views/pages/about.blade.php`<br>`resources/views/pages/services/index.blade.php`<br>`resources/views/pages/case-studies/index.blade.php`<br>`resources/views/pages/contact.blade.php` | Route-level views that inherit `layouts/compro.blade.php`, open with a page-specific header banner variant (`full-bleed-image`, `split-with-image`, or `left-aligned-text`), render page-specific grids (e.g., featured landscape item + 2-col card grid, or 2-col location cards), and compose shared Level 2 sections (`<x-sections.technical-faq>`, `<x-sections.rfq-cta-banner>`) | Inherit 100% of spacing, radius, border, and color tokens from Level 1 (`compro.css`). Only compose grid layout utilities (`grid-cols-1 lg:grid-cols-12`) and section rhythm (`py-16 lg:py-24`). |
| **Level 3B: Specialized Detail / Article Sub-Templates** | `resources/views/pages/services/show.blade.php`<br>`resources/views/pages/case-studies/show.blade.php`<br>`resources/views/layouts/amp.blade.php` | **Service / Product Detail Child Template:** Inherits Level 1 parent shell + dark navy breadcrumb header, then switches into a 2-column asymmetric spec layout (8-col deliverables & workflow steps + 4-col sticky technical parameters sidebar).<br>**Article / Case Study Detail Template:** Inherits Level 1 typography & color tokens, but constrains body prose to a `65ch` editorial reading column with key-metric callout cards and related study cards (or renders via `layouts/amp.blade.php` for `<html ⚡>` AMP routes). | Inherit brand palette and font pairings from Level 1 while applying layout-specific reading widths (`max-w-[65ch]`), prose rhythm, or sticky sidebar containers (`lg:sticky lg:top-28`). |

---

## 2. Markdown Blueprint Template for `docs/design.md`

```markdown
### 1.4 Reference URLs & Modular Inheritance Map
| Page Role | Reference URL | Target Blade View | Header Banner Variant | Reused Level 2 Partials | Unique Child Sections |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Homepage (Root)** | `https://.../` | `pages/home.blade.php` | `section-hero[variant=bento-grid]` | `service-matrix`, `proof-ledger`, `process-timeline`, `case-study-showcase`, `technical-faq`, `rfq-cta-banner` | Partner trust strip |
| **About Us** | `https://.../about-us` | `pages/about.blade.php` | `section-banner[variant=split-with-image]` | `rfq-cta-banner` | Client & stats card, Founder quote portrait, Vertical milestone timeline, Numbered values list |
| **Services Index** | `https://.../services` | `pages/services/index.blade.php` | `section-banner[variant=full-bleed-image]` | `technical-faq`, `rfq-cta-banner` | 2-col landscape service cards with scope tags |
| **Service / Product Detail** | `https://.../services/{slug}` | `pages/services/show.blade.php` | Breadcrumb + Dark Navy Summary Header | `rfq-cta-banner` | 8-col Deliverables & 4-Step Workflow + 4-col Sticky Spec Table & Related Case Studies |
| **Blog / Case Studies Index** | `https://.../blog` | `pages/case-studies/index.blade.php` | `section-banner[variant=left-aligned-text]` | `rfq-cta-banner` | 12-col Featured Landscape Card (`.main`) + 2-col Secondary Article Grid |
| **Article / Case Study Detail** | `https://.../blog/{slug}` | `pages/case-studies/show.blade.php` | Editorial Meta & Outcome Callout Header | `rfq-cta-banner` | `65ch` Narrative Column (Challenge, Solution, Outcome) + Sticky Project Metadata Card |
| **Contact** | `https://.../contact` | `pages/contact.blade.php` | `section-banner[variant=split-with-image]` | `technical-faq` | 2-col Contact Form + Direct Channels, `.section-locations` 2-col Office Cards |
```
