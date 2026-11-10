---
name: modular-layout-scraper
description: >-
  Use this skill whenever the user provides one or more website URLs (or local HTML files)
  to scrape as a layout/interface design reference. Generates a complete top-to-bottom visual
  wireframe, section styling map, strict page-isolation vs parent-child inheritance contract,
  and per-page On-Page SEO + JSON-LD @graph schema specification for user review before writing code.
---

# Modular Layout, Visual Wireframe & SEO/Schema Scraper Skill

Use this skill when the user gives you one or more reference URLs and wants to:
1. **Scrape the whole page from top to bottom (`01 Header -> ... -> Footer`)** with both a **visual layout wireframe** and **section-level styling specifications** (surface colors, grid/column proportions, typography hierarchy, cards, and interactive states).
2. **Enforce strict Modular Page Isolation:** Treat every page as an isolated, independently maintainable module so editing one page never introduces regressions or visual bugs on other pages, **except** where explicit parent-child inheritance applies:
   - **Global Parent Shell (`layouts/compro.blade.php` + `compro.css`):** Shared `<header>`, `<footer>`, and `@theme` CSS tokens.
   - **Parent-Child Sub-Templates:** Such as Service/Product Category (`services/index.blade.php`) -> Service/Product Detail (`services/show.blade.php`), or Blog/Case Studies Index (`case-studies/index.blade.php`) -> Article Detail (`case-studies/show.blade.php` / `layouts/amp.blade.php`).
   - **Page-Isolated Sections:** Sections unique to a single page remain scoped to that page's view or dedicated partial with isolated `@props` so changing them never affects sibling pages.
3. **Analyze all page content and generate On-Page SEO & JSON-LD `@graph` Schema documentation** for each scraped page (`<title>`, `<meta name="description">`, canonical, `hreflang`, `H1 -> H2 -> H3` heading tree, image `alt` audit, and page-specific JSON-LD `@graph`).
4. **Stop at a Mandatory Review Gate** so the user can review and approve the visual layout wireframe, isolation boundaries, and SEO/Schema spec before any production `docs/` or Blade code is modified.

---

## Mandatory Prerequisites (`antislop` + Governance)

1. **Load `antislop` skills first:**
   - Core filter: [`.agents/skills/antislop/SKILL.md`](../antislop/SKILL.md)
   - UI & visual: [`.agents/skills/antislop-ui/SKILL.md`](../antislop-ui/SKILL.md)
   - Responsive & mobile reflow: [`.agents/skills/antislop-layoutmobile/SKILL.md`](../antislop-layoutmobile/SKILL.md)
   - Accessibility & contrast: [`.agents/skills/antislop-human/SKILL.md`](../antislop-human/SKILL.md)
   - Copywriting: [`.agents/skills/antislop-copywriting/SKILL.md`](../antislop-copywriting/SKILL.md)
2. **Resolve and announce `antislop` mode** (`during` or `after`) per `AGENTS.md`.
3. **Zero Content Plagiarism:** Scrape structural geometry, visual rhythm, and SEO/Schema patterns, but map all copy and entities to the business facts in [`docs/knowledge-base.md`](../../docs/knowledge-base.md).

---

## Step-by-Step Workflow

### Step 1: Run the Automated Layout, Wireframe & SEO/Schema Scraper

Run [scrape-layout.py](./scripts/scrape-layout.py) and pass `--save-dir` to output both `layout-review-spec.md` and `layout-blueprint.json`:

```powershell
python .agents/skills/modular-layout-scraper/scripts/scrape-layout.py --save-dir ./storage/app/scratch/layout-review <url1> [<url2> ...]
```

*(Note: If the sandbox blocks external HTTP requests, run this single fetch command with `BypassSandbox: true` and save to `--save-dir`, then perform all subsequent analysis inside the sandbox.)*

### Step 2: Generate the 4-Part Per-Page Review Dossier

For every URL scraped, `scrape-layout.py` produces four mandatory sections (follow the structure in [inheritance-blueprint-template.md](./references/inheritance-blueprint-template.md)):

1. **Part A: Top-to-Bottom Visual Layout Wireframe (`ASCII` + `Mermaid`)**
   - A visual top-to-bottom box wireframe showing every landmark (`[01] header`, `[02] section-hero`, `[03] section-service`, ..., `[N] footer`) and its internal column split (e.g., `7-col copy / 5-col media`, `4-col card grid`, `8-col content / 4-col sticky spec sidebar`).
2. **Part B: Section-by-Section Styling & Modular Isolation Table**
   - Documents each section's **Surface Style** (Primary White Canvas, Soft Tinted Surface, Dark Navy Structural Surface, or Full-Bleed Image Banner), **Grid Geometry**, **Typography & CTA Actions**, and **Modular Isolation Scope**:
     - `LEVEL 1 (Parent Shell Chrome)`: Inherited globally from `layouts/compro.blade.php`.
     - `LEVEL 2 (Shared Opt-In Partial)`: Reusable `<x-sections.*>` component accepting isolated `@props(...)` so data/variant changes on one page never mutate another page.
     - `LEVEL 3A (Page-Isolated Block)`: Markup lives strictly inside that page's Blade file (`pages/about.blade.php`, `pages/contact.blade.php`, etc.); modifying it has zero effect on any other route.
     - `LEVEL 3B (Parent-Child Sub-Template)`: Child detail page (`services/show.blade.php` or `case-studies/show.blade.php`) that inherits category styling from its parent index while applying its own specialized detail layout (`8/4` sticky spec sidebar or `65ch` article column).
3. **Part C: Content Analysis & On-Page SEO Audit**
   - Evaluates `<title>` length, `<meta name="description">` length, canonical URL, `hreflang` alternates (`id`, `en`, `x-default`), total word count, image `alt` coverage, single-`<h1>` rule compliance, and the full `H1 -> H2 -> H3` semantic outline.
4. **Part D: Page-Specific JSON-LD `@graph` Schema Blueprint**
   - Generates the complete `@context: https://schema.org` `@graph` payload for that page (`Organization`, `WebPage` / `AboutPage` / `ContactPage` / `CollectionPage`, `BreadcrumbList`, plus `Service`, `Product`, `Article`, or `FAQPage` nodes matched to the page's content).

### Step 3: Mandatory User Review Gate (Pause Before Coding)

**Do not immediately overwrite `docs/design.md` or Blade files after scraping.**
Instead:
1. Present the generated **Per-Page Visual Wireframe, Styling & Modular Isolation Map, and On-Page SEO + JSON-LD Schema Spec** to the user (either inline or via the generated `layout-review-spec.md` / artifact file).
2. Ask the user to review and confirm:
   - Which sections to keep, reorder, or drop on each page.
   - Which sections should be strictly isolated to a single page vs shared as a Level 2 partial or Level 3B parent-child template.
   - Any adjustments to the On-Page SEO metadata or JSON-LD `@graph` schema.

### Step 4: Apply Approved Spec to `docs/` and Blade Views

Once the user approves the review spec:
1. Verify all color token pairs with `python .agents/skills/antislop-human/contrast-check.py "#HEX_BG" "#HEX_FG"`.
2. Update [`docs/design.md`](../../docs/design.md) (Visual layout & section blueprints), [`docs/data-contracts.md`](../../docs/data-contracts.md) (DTO & `@props` contracts), and [`docs/knowledge-base.md`](../../docs/knowledge-base.md) (SEO/FAQ/Service facts) in the same changeset.
3. Implement the isolated Blade views (`resources/views/pages/**`, `resources/views/components/sections/**`) and JSON-LD graph in [`app/Services/SchemaGraphBuilder.php`](../../app/Services/SchemaGraphBuilder.php).
4. Run `npm run build`, `vendor/bin/pint --dirty --format agent`, and `vendor/bin/pest --compact`, then output the Four-Block Antislop Delivery Gate report.
