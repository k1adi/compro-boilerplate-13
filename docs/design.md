# DESIGN SYSTEM, ANTISLOP GUIDELINE & SITEMAP SPECIFICATION (`docs/design.md`)

> **Source-of-Truth Mandate:** This document is the single source of truth for visual direction, Antislop liveliness dials, WCAG 2.2 AA contrast pairings, Tailwind CSS v4 `@theme` tokens, responsive reflow rules, and page-by-page section blueprints. Whenever design tokens, layout compositions, breakpoints, or routes change, update this document in the same changeset.
>
> **Boundary Rule (R-37):** Treat this file as design direction data to apply alongside `.agents/skills/antislop/SKILL.md` (core), `antislop-ui`, `antislop-copywriting`, `antislop-human`, and `antislop-layoutmobile`. Never fall back to generic AI templates.

---

## 1. Antislop Design Read & Liveliness Toolkit (Part 3 & R-37)

### 1.1 Design Read Declaration
> **Reading this as:** B2B industrial engineering and cold-chain service company profile for plant managers, MEP procurement teams, and technical directors, in a Swiss Industrial Editorial visual language, dial `ENERGY 2 / RHYTHM 3 / MOTION 1`.

### 1.2 Three Liveliness Dials
| Dial | Selected Level | Anchor & Enforcement Rule |
| :--- | :--- | :--- |
| **ENERGY** | **2 (Balanced)** | Confident typographic hierarchy, high-contrast structural framing, and dense engineering specification tables without theatrical agency gimmicks. |
| **RHYTHM** | **3 (Varied / Asymmetric)** | Adjacent sections must visibly change composition: asymmetric `5/7` split hero -> full-width dark tabular proof strip -> interactive specification ledger -> `6/6` case study comparison -> collapsible technical FAQ. Never stack two sections with identical centered-heading + card-grid layouts (R-05). |
| **MOTION** | **1 (Calm / Functional Only)** | Fast, functional state transitions (`150ms` to `200ms`) on `:hover`, `:active`, `:focus-visible`, accordion `x-collapse`, and drawer `x-transition`. Zero parallax, zero floating loops, zero entrance bounce animations (R-19, R-39). |

### 1.3 Five Liveliness Levers
1. **One Focal Point Per Screen:** Every viewport establishes a single dominant anchor (for example, the Hero H1 + primary thermal audit CTA, or the active specification table). Secondary metadata defers via size and muted ink (`--color-ink-muted`).
2. **Hierarchical Contrast:** Clear separation between geometric display headings (`Plus Jakarta Sans` 700), readable body prose (`Plus Jakarta Sans` 400/500), and tabular technical parameters (`JetBrains Mono` 500 with `tabular-nums`).
3. **Whitespace as Structure:** Exposed `1px` architectural hairlines (`--color-border-subtle`) and asymmetric column spans separate functional blocks instead of floating drop shadows.
4. **One Deliberate Accent:** Industrial Safety Orange (`#c2410c` in light mode, `#fb923c` in dark mode) is reserved strictly for primary conversion CTAs, active navigation indicators, and critical SLA metrics. Never scatter the accent across every icon, border, and background (R-29).
5. **Identity Motif:** Exposed `1px` architectural grid cells carrying monospaced index coordinates (`[01 // COLD-CHAIN]`, `SPEC-ID`, `kW/TR`) modeled after industrial P&ID title blocks and engineering datasheets.

---

## 2. Written Purpose Justifications (Keystone Rule R-31 & Purpose-Gate R-01..R-22)

Every major visual and structural decision in this boilerplate is governed by a one-line functional reason:

- **Why this color palette? (R-01, R-29):** High-contrast zinc neutrals (`#fafafa` surface, `#09090b` ink), deep slate (`#0f172a`), and a single industrial safety orange accent (`#c2410c`) make dense technical specifications effortless to scan while reserving chromatic weight for primary RFQ actions.
- **Why zero decorative gradients or glows? (R-01, R-13):** Solid matte surfaces and `1px` structural borders communicate mechanical engineering precision, whereas blue-purple gradients and blurred radial orbs read as generic AI decoration.
- **Why this glassmorphism cap? (R-10):** `backdrop-blur-md` is applied exclusively to the sticky top navigation bar on scroll so passing grid lines do not clash with nav links; every other card, modal, and section stays 100% opaque.
- **Why this typography pairing? (R-06):** `Plus Jakarta Sans` provides clean geometric legibility for bilingual Indonesian and English engineering prose, while `JetBrains Mono` is strictly scoped to capacities (`TR`, `kW`), temperatures (`-25°C`), ISO codes, and tabular numbers so figures align vertically.
- **Why exposed hairline borders instead of background grids? (R-07):** Wallpaper dot/graph grids are forbidden; exposed `1px` cell borders (`border-border-subtle`) serve as real table and section boundaries that organize engineering data.
- **Why this icon and illustration policy? (R-04, R-08, R-22):** Generic AI glyphs (sparkles, stars, lightning, robots) and stock vector blobs are forbidden; sections use monospaced index numbers (`01` to `04`), real facility photos (or explicit `[PHOTO PLACEHOLDER]` frames per R-23), and directional arrows (`→`) exclusively on primary RFQ CTAs and PDF datasheet downloads.
- **Why this badge policy? (R-09):** Badges are restricted to functional metadata (`SRV-01`, `ISO 9001:2015`, `SLA < 4 Jam`) with sharp `2px` corners and zero glow; decorative eyebrow pills above the H1 that repeat the headline are forbidden.
- **Why sharp border radii and flat surfaces? (R-11, R-12):** Sharp `0.25rem` (`4px`) radii on containers/buttons and `0.125rem` (`2px`) on technical tags reflect industrial fabrication tolerances, while `shadow-lg` is reserved exclusively for elevated overlays (modals and the mobile navigation drawer).
- **Why specification rows instead of 3-column feature cards? (R-14):** Technical services and deliverables have unequal depth and parameters, so presenting them in asymmetric specification ledgers and comparison tables preserves hierarchy better than copy-paste feature cards.
- **Why Light Mode default with a working Dark Mode toggle? (R-21, R-34):** Procurement teams and plant engineers primarily read technical datasheets in bright office or plant environments (making `#fafafa` the optimal default), while a fully verified `.dark` theme (`#09090b`) supports low-light control-room and evening review.

---

## 3. Verified WCAG 2.2 AA Color & Contrast Specification (`antislop-human` R-25)

All pairings below have been computed and verified using `python .agents/skills/antislop-human/contrast-check.py` to prevent grey-on-grey or orange-on-white contrast failures:

### 3.1 Light Mode Tokens (Default Theme)
| Semantic Token | Hex Value | Paired Against | Computed Ratio | WCAG 2.2 AA Verdict | Intended Usage |
| :--- | :--- | :--- | :--- | :--- | :--- |
| `--color-surface` | `#fafafa` | `--color-ink` (`#09090b`) | **19.06:1** | PASS (Normal & Large) | Primary page background |
| `--color-surface-elevated` | `#ffffff` | `--color-ink` (`#09090b`) | **19.90:1** | PASS (Normal & Large) | Active specification cells, modals, inputs |
| `--color-ink` | `#09090b` | `--color-surface` (`#fafafa`) | **19.06:1** | PASS (Normal & Large) | Primary headings and body prose |
| `--color-ink-muted` | `#52525b` | `--color-surface` (`#fafafa`) | **7.41:1** | PASS (Normal & Large) | Secondary descriptions, captions, metadata |
| `--color-primary` | `#0f172a` | `#ffffff` (Text on Primary) | **17.85:1** | PASS (Normal & Large) | High-contrast dark structural bands & secondary buttons |
| `--color-accent` | `#c2410c` | `#ffffff` (Button Text) | **5.18:1** | PASS (Normal & Large) | Primary conversion CTA background & active links |
| `--color-accent` (Text) | `#c2410c` | `--color-surface` (`#fafafa`) | **4.96:1** | PASS (Normal & Large) | Monospaced index codes & inline accent labels |
| `--color-border-interactive` | `#71717a` | `--color-surface` (`#fafafa`) | **4.63:1** | PASS ($\ge 3.0:1$ Non-Text) | Form input borders, button outlines, focus boundaries |
| `--color-border-subtle` | `#e4e4e7` | `--color-surface` (`#fafafa`) | Decorative | Structural Hairline Only | Decorative section dividers (never used as sole control boundary) |
| `--color-status-success` | `#15803d` | `--color-surface` (`#fafafa`) | **4.81:1** | PASS (Normal & Large) | Form submission success text & icon (always paired with text) |
| `--color-status-warning` | `#b45309` | `--color-surface` (`#fafafa`) | **4.81:1** | PASS (Normal & Large) | Maintenance / SLA notice text & icon |
| `--color-status-danger` | `#b91c1c` | `--color-surface` (`#fafafa`) | **6.20:1** | PASS (Normal & Large) | Validation error text & icon (never color alone per R-39) |

### 3.2 Dark Mode Tokens (`.dark` Theme, R-21 & R-34)
| Semantic Token | Hex Value | Paired Against | Computed Ratio | WCAG 2.2 AA Verdict | Intended Usage |
| :--- | :--- | :--- | :--- | :--- | :--- |
| `--color-surface` | `#09090b` | `--color-ink` (`#fafafa`) | **19.06:1** | PASS (Normal & Large) | Primary dark page background |
| `--color-surface-elevated` | `#18181b` | `--color-ink` (`#f4f4f5`) | **16.12:1** | PASS (Normal & Large) | Elevated dark cells, drawers, inputs |
| `--color-ink-muted` | `#a1a1aa` | `--color-surface` (`#09090b`) | **7.76:1** | PASS (Normal & Large) | Dark mode secondary prose & labels |
| `--color-ink-muted` | `#a1a1aa` | `--color-surface-elevated` (`#18181b`) | **6.91:1** | PASS (Normal & Large) | Dark mode elevated card metadata |
| `--color-accent` | `#fb923c` | `#09090b` (Button Text) | **8.79:1** | PASS (Normal & Large) | Dark mode primary CTA button fill (uses `#09090b` dark ink) |
| `--color-border-interactive` | `#71717a` | `--color-surface` (`#09090b`) | **4.11:1** | PASS ($\ge 3.0:1$ Non-Text) | Dark mode input borders & interactive control edges |
| `--color-status-success` | `#4ade80` | `--color-surface` (`#09090b`) | **11.42:1** | PASS (Normal & Large) | Dark mode validation success |
| `--color-status-warning` | `#fbbf24` | `--color-surface` (`#09090b`) | **11.92:1** | PASS (Normal & Large) | Dark mode warning text |
| `--color-status-danger` | `#f87171` | `--color-surface` (`#09090b`) | **7.19:1** | PASS (Normal & Large) | Dark mode validation error text |

---

## 4. Tailwind CSS v4 `@theme` & Base Layer Specification (`resources/css/compro.css`)

```css
@import "tailwindcss";

@theme {
  /* Typography (R-06: Brand-specific legibility + tabular technical metrics) */
  --font-display: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
  --font-sans: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
  --font-mono: "JetBrains Mono", ui-monospace, SFMono-Regular, monospace;

  /* Fluid Type Scale (R-03 & antislop-human: scales cleanly across viewports & 200% zoom) */
  --text-hero: clamp(2.25rem, 4vw + 1rem, 3.75rem);
  --text-h2: clamp(1.75rem, 2.5vw + 0.75rem, 2.5rem);
  --text-h3: clamp(1.25rem, 1.5vw + 0.5rem, 1.625rem);
  --text-body-lg: clamp(1.0625rem, 0.5vw + 0.9rem, 1.25rem);

  /* Semantic Color Tokens (Light Mode Default, Verified >= 4.5:1 AA) */
  --color-surface: #fafafa;
  --color-surface-elevated: #ffffff;
  --color-surface-inverse: #09090b;
  --color-ink: #09090b;
  --color-ink-muted: #52525b;
  --color-ink-inverse: #fafafa;
  --color-primary: #0f172a;
  --color-accent: #c2410c;
  --color-accent-hover: #9a3412;
  --color-accent-ink: #ffffff;
  --color-border-subtle: #e4e4e7;
  --color-border-interactive: #71717a;
  --color-status-success: #15803d;
  --color-status-warning: #b45309;
  --color-status-danger: #b91c1c;

  /* Architectural Radii (R-11: deliberate hierarchy, zero pill defaults) */
  --radius-tag: 0.125rem;    /* 2px for technical codes & ISO badges */
  --radius-card: 0.25rem;    /* 4px for structural containers & inputs */
  --radius-button: 0.25rem;  /* 4px for action controls */
}

/* Dark Mode Overrides (R-21, R-34: Verified >= 4.5:1 AA) */
.dark {
  --color-surface: #09090b;
  --color-surface-elevated: #18181b;
  --color-surface-inverse: #fafafa;
  --color-ink: #fafafa;
  --color-ink-muted: #a1a1aa;
  --color-ink-inverse: #09090b;
  --color-primary: #f4f4f5;
  --color-accent: #fb923c;
  --color-accent-hover: #fdba74;
  --color-accent-ink: #09090b;
  --color-border-subtle: #27272a;
  --color-border-interactive: #71717a;
  --color-status-success: #4ade80;
  --color-status-warning: #fbbf24;
  --color-status-danger: #f87171;
}

@layer base {
  html {
    background-color: var(--color-surface);
    color: var(--color-ink);
    font-family: var(--font-sans);
    scroll-behavior: smooth;
  }

  /* R-39: Mandatory pointer cursor on all enabled interactive controls */
  a[href],
  button:not(:disabled),
  input[type="button"]:not(:disabled),
  input[type="submit"]:not(:disabled),
  input[type="reset"]:not(:disabled),
  input[type="checkbox"]:not(:disabled),
  input[type="radio"]:not(:disabled),
  select:not(:disabled),
  summary,
  label[for],
  [role="button"]:not([aria-disabled="true"]),
  [role="tab"]:not([aria-disabled="true"]),
  [role="switch"]:not([aria-disabled="true"]) {
    cursor: pointer;
  }

  /* R-39: Mandatory not-allowed cursor on disabled controls */
  button:disabled,
  input:disabled,
  select:disabled,
  textarea:disabled,
  [aria-disabled="true"] {
    cursor: not-allowed;
  }

  /* R-32: High-contrast visible keyboard focus indicator (>= 3:1 against surface) */
  :focus-visible {
    outline: 2px solid var(--color-accent);
    outline-offset: 2px;
  }

  /* R-39: Respect user reduced-motion preference */
  @media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
      scroll-behavior: auto !important;
    }
  }
}
```

---

## 5. Responsive Reflow & Mobile Layout Architecture (`antislop-layoutmobile` R-03)

Mobile is a distinct designed state, never a squeezed desktop layout. Every page section must implement a **three-state reflow** across the continuous viewport range:

| Viewport Band | Width Range | Grid & Reflow Behavior | Spacing & Type Register |
| :--- | :--- | :--- | :--- |
| **State 1: Phone** | `< 640px` (tested down to `320px`) | Single reflowing column (`grid-cols-1`). Sticky headers unpin into standard vertical headers. Wide specification tables convert into stacked key-value definition cards (`<dl>`) or horizontally scrollable containers with visible scroll affordances and zero page-level horizontal overflow. | Section padding: `py-12 px-4`. Gap: `gap-6`. Fluid type at lower clamp bound. Hero uses `min-h-dvh` or `h-auto` (never `100vh`). |
| **State 2: Tablet & Small Laptop** | `640px` to `1023px` (`sm:` & `md:`) | Dedicated 2-column or 6-column intermediate grid (`sm:grid-cols-2 md:grid-cols-6`). Prevents single-column cards from stretching unnaturally wide across `768px` screens and prevents 12-column desktop splits from cramping. | Section padding: `md:py-16 md:px-6`. Gap: `md:gap-8`. |
| **State 3: Desktop** | `>= 1024px` (`lg:` & `xl:`) | Full 12-column architectural grid (`lg:grid-cols-12`, `max-w-7xl mx-auto`) with asymmetric splits (such as `lg:col-span-5` sticky section index + `lg:col-span-7` specification ledger). | Section padding: `lg:py-24 lg:px-8`. Gap: `lg:gap-12`. |

### Mobile Interaction & Navigation Rules (R-03, R-24, R-39)
1. **Minimum Tap Targets:** Every interactive control (buttons, nav links, language switcher, accordion triggers, form inputs) must maintain a minimum hit area of `44px x 44px` (`min-h-11 min-w-11`) with at least `8px` (`gap-2`) separation between adjacent targets.
2. **Discoverable Mobile Navigation:** Below `1024px` (`lg:hidden`), collapse the primary navigation links into an accessible drawer triggered by a `<button type="button">` that displays both a menu icon and the visible text label `"Menu"` (never a bare unlabeled hamburger icon).
3. **Keyboard & Screen-Reader Drawer Behavior:** The mobile menu trigger binds `:aria-expanded="mobileOpen"`, `aria-controls="mobile-nav-drawer"`, closes on `Escape` (`@keydown.escape.window="mobileOpen = false"`), traps focus while open (`x-trap.noscroll="mobileOpen"`), and keeps the primary RFQ CTA (`Jadwalkan Audit Termal`) one tap away.
4. **Form Keyboard Clearance:** On mobile viewports, focused form inputs in the RFQ section must maintain sufficient scroll padding (`scroll-pb-24`) so the on-screen keyboard never covers the active input or error message.

---

## 6. Sitemap, Bilingual Route Table & Page-by-Page Section Blueprints

### 6.1 Canonical Bilingual Route Table (R-24: Zero Ghost Links)
Every link in the header, footer, or section CTAs must resolve to one of the active routes below. Never add navbar links to unbuilt pages.

| Page Key | Indonesian Route (`/id/...`) | English Route (`/en/...`) | Blade View (`resources/views/pages/...`) | Primary Purpose |
| :--- | :--- | :--- | :--- | :--- |
| `home` | `/id` | `/en` | `pages/home.blade.php` | Executive overview, verified metrics ledger, service matrix, featured case studies, technical FAQ, and rapid RFQ dispatch |
| `about` | `/id/tentang-kami` | `/en/about` | `pages/about.blade.php` | Engineering history, workshop capabilities, ISO/SMK3/TKDN compliance dossier, and operational coverage |
| `services.index` | `/id/layanan` | `/en/services` | `pages/services/index.blade.php` | Complete B2B capability matrix with technical filter & BoQ inquiry trigger |
| `services.show` | `/id/layanan/{slug}` | `/en/services/{slug}` | `pages/services/show.blade.php` | Deep technical specification datasheet, quantified deliverables, 4-5 stage engineering workflow, and related case studies |
| `case-studies.index` | `/id/studi-kasus` | `/en/case-studies` | `pages/case-studies/index.blade.php` | Filterable commission archive with capacity (`TR`), location, and measured outcomes |
| `case-studies.show` | `/id/studi-kasus/{slug}` | `/en/case-studies/{slug}` | `pages/case-studies/show.blade.php` | Full engineering project report (challenge, P&ID/system architecture, measured `kW/TR` or temperature stability result) |
| `articles.index` | `/id/artikel` | `/en/articles` | `pages/articles/index.blade.php` | **PLANNED (not built).** Technical engineering guides, refrigerant compliance briefings, and energy audit methodologies |
| `articles.show` | `/id/artikel/{slug}` | `/en/articles/{slug}` | `pages/articles/show.blade.php` | **PLANNED (not built).** Long-form technical article with table of contents, schema graph, and canonical link to AMP version |
| `articles.amp` | `/id/artikel/{slug}/amp` | `/en/articles/{slug}/amp` | `pages/articles/amp.blade.php` | **PLANNED (not built).** Standalone valid `<html ⚡>` AMP article representation (`< 75KB` inline CSS) |
| `contact` | `/id/hubungi-kami` | `/en/contact` | `pages/contact.blade.php` | Technical RFQ & site audit booking form, workshop coordinates, and 24/7 SLA emergency dispatch contacts |

### 6.2 Page-by-Page Section Composition (`RHYTHM: 3` Enforcement)

#### A. Home Page (`pages/home.blade.php`)
Each section shifts layout structure to maintain `RHYTHM: 3` without repeating templates:
1. **`<x-sections.hero-split>` (Asymmetric `7/5` Architectural Split):**
   - **Left (`lg:col-span-7`):** Monospaced sector coordinate (`[KBLI 43224 // INDUSTRIAL HVACR & COLD-CHAIN]`), H1 factual value proposition (no duplicating eyebrow pill per R-09), concise technical subheadline, primary CTA (`Jadwalkan Audit Termal Lokasi →`, anchors to `#rfq-form`), and secondary CTA (`Lihat Matriks Spesifikasi Layanan`, anchors to `#service-matrix`). A PDF catalogue CTA is not used because no datasheet file exists (R-26).
   - **Right (`lg:col-span-5`):** High-priority LCP facility engineering photograph (`<img fetchpriority="high" loading="eager" width="800" height="600">` or explicit `[PHOTO PLACEHOLDER]` frame) bordered by a `1px` technical specification caption bar (`Rentang Kapasitas: 20 TR s/d 1.500 TR | Tanggap SLA: < 4 Jam`).
2. **`<x-sections.proof-ledger>` (Full-Width Inverse Dark Tabular Strip, `--color-primary`):**
   - Four hairline-divided tabular cells displaying verified metrics from `docs/knowledge-base.md` (`14 Tahun`, `48.500+ TR`, `98,7% < 4 Jam`, `310 Fasilitas`) in `JetBrains Mono` (`tabular-nums`) alongside ISO 9001:2015, SMK3, and TKDN registration codes. Includes a visible `[BOILERPLATE SEED]` badge while `isSamplePlaceholder` is true.
3. **`<x-sections.service-matrix>` (Asymmetric `4/8` Sticky Header + Interactive Specification Rows):**
   - **Left (`lg:col-span-4`):** Sticky section title, engineering scope summary, and direct link to full service catalog.
   - **Right (`lg:col-span-8`):** Four stacked hairline-bordered specification rows (`SRV-01` to `SRV-04`). Each row shows the monospaced service code, title, target industrial segment, core problem solved, key technical parameters (`°C`, `bar`, `kW/TR`), and a specific link (`Lihat Spesifikasi & Alur Kerja`). Zero copy-paste 3-column icon cards (R-14).
4. **`<x-sections.case-study-showcase>` (`6/6` Two-Column Technical Dossier Split):**
   - Highlights top commissioned projects (`CS-01` to `CS-03`) with location, year, installed capacity, engineering challenge, and measured outcome. Includes an explicit empty-state fallback (`<x-ui.empty-state>`) if no case studies are published (R-27).
5. **`<x-sections.technical-faq>` (Asymmetric `5/7` Split + Accessible Alpine.js Accordion):**
   - **Left (`lg:col-span-5`):** Section heading and direct WhatsApp/Email engineering desk escalation box.
   - **Right (`lg:col-span-7`):** Five domain-specific B2B engineering FAQs (`x-collapse`, `<button aria-expanded="..." aria-controls="...">`).
6. **`<x-sections.rfq-cta-banner>` (High-Contrast Architectural Dispatch Block):**
   - Split action block combining rapid RFQ inquiry form / modal trigger with 24/7 SLA dispatch phone and Cikarang/Sidoarjo workshop addresses.

#### B. Service Detail Page (`pages/services/show.blade.php`)
Built as an inline hero (breadcrumb, service code badge, H1, target segment, problem solved, deliverables list, `<dl>` technical specs table, priority LCP image) followed by reusable sections. There is no separate `service-hero` or `technical-specs-table` component; extract one only when a second page needs it.
1. **Inline hero (`7/5` split):** Breadcrumb navigation, monospaced service code (`SRV-01`), H1 title, target industrial segment, core problem solved, quantified deliverables, and technical specification table.
2. **`<x-sections.process-timeline>`:** Vertical or stepped engineering workflow rendering the exact number of real stages (`4` or `5` stages as defined in `docs/knowledge-base.md`, never forced into a 3-step round-icon template per R-05).
3. **`<x-sections.case-study-showcase>`:** Filtered project commissions matching this service (rendered only when related studies exist).
4. **`<x-sections.technical-faq>`:** FAQs related to this service or general FAQs.
5. **`<x-sections.rfq-cta-banner>`:** Service-specific BoQ / thermal audit request form pre-selecting the current service via `selectedServiceCode`.

#### C. Contact & RFQ Page (`pages/contact.blade.php`)
Reuses `<x-sections.rfq-cta-banner>` (there is no separate `rfq-form-split` component) under a short H1 band, followed by `<x-sections.proof-ledger>`. The banner is a `7/5` split:
   - **Left (`lg:col-span-7`):** Interactive technical RFQ form with visible `<label for>` elements, service selector, facility location, estimated cooling/piping capacity, and project brief. Must implement all four UI states (R-27):
     - `Idle`: Clean bordered inputs (`border-border-interactive`).
     - `Submitting (Loading)`: Disabled submit button (`cursor-not-allowed`, `aria-busy="true"`) with explicit text `"Mengirim Permintaan Teknis..."` / `"Submitting Technical Inquiry..."`.
     - `Error`: Summary alert banner (`role="alert"`) + field-level text error messages (`id="error-field"`, `aria-describedby="error-field"`) paired with warning icon and `--color-status-danger`.
     - `Success`: Confirmation dossier card displaying reference ticket ID and guaranteed SLA response window.
   - **Right (`lg:col-span-5`):** Headquarters & East Java branch addresses, operational hours, and 24/7 emergency SLA contact card with tap-to-call, WhatsApp, and email links. A static or lazy-loaded map frame with reserved `aspect-ratio` (R-40) is not built yet; add it only once real coordinates are verified in `docs/knowledge-base.md`.