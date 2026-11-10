# DESIGN SYSTEM, KOOLOM MULTI-PAGE LAYOUT ARCHITECTURE & ANTISLOP GUIDELINE (`docs/design.md`)

> **Source-of-Truth Mandate:** This document is the single source of truth for visual direction, the scraped Koolom multi-page layout references ([`https://koolom.webflow.io/`](https://koolom.webflow.io/), [`/about-us`](https://koolom.webflow.io/about-us), [`/blog`](https://koolom.webflow.io/blog), [`/services-v3`](https://koolom.webflow.io/services-v3), [`/contact-v1`](https://koolom.webflow.io/contact-v1)), the three-color spectrum (**White Primary**, **Blue Secondary**, **Orange Tertiary**), Antislop liveliness dials, WCAG 2.2 AA contrast pairings, Tailwind CSS v4 `@theme` tokens, responsive reflow rules, and page-by-page section blueprints. Whenever design tokens, layout compositions, breakpoints, or routes change, update this document in the same changeset.
>
> **Boundary Rule (R-37):** Treat this file as design direction data to apply alongside `.agents/skills/antislop/SKILL.md` (core), `antislop-ui`, `antislop-copywriting`, `antislop-human`, and `antislop-layoutmobile`. Never fall back to generic AI templates.

---

## 1. Antislop Design Read, Liveliness Toolkit & Reference Architecture (Part 3 & R-37)

### 1.1 Design Read Declaration
> **Reading this as:** B2B corporate advisory, licensing, and business consulting company profile (`Koolom Partners`) for business owners, founders, and corporate teams, modeled on the structured Bento and editorial multi-page layout of `koolom.webflow.io` with a modern **White (Primary) + Architectural Blue (Secondary) + Signal Amber-Orange (Tertiary)** color system, dial `ENERGY 2 / RHYTHM 3 / MOTION 1`.

### 1.2 Three Liveliness Dials
| Dial | Selected Level | Anchor & Enforcement Rule |
| :--- | :--- | :--- |
| **ENERGY** | **2 (Balanced)** | Confident editorial typographic scale (`clamp(2.25rem, 4.2vw + 1rem, 4.25rem)` display H1), high-contrast Cobalt/Navy Bento anchors on a crisp White canvas, and clear, plain-language service blocks without theatrical agency gimmicks. |
| **RHYTHM** | **3 (Varied / Asymmetric)** | Adjacent sections visibly shift layout geometry following the 5 scraped Koolom pages: `58%/42%` Asymmetric Bento Hero + 4-Tile Metric Strip -> Numbered Practice Area Cards -> 3-Column Differentiator Grid + Split Firm Narrative -> 4-Step Tinted Timeline Band -> Featured + 2-Column Case Dossiers -> Split `5/7` FAQ Accordion -> Full-Bleed Secondary Blue Conversion CTA. Never stack two sections with identical centered-heading + 3-column card layouts (R-05). |
| **MOTION** | **1 (Calm / Functional Only)** | Fast, functional transitions (`150ms` to `250ms` cubic-bezier) on link underline reveals (`.link_line`), card border/surface hover states, accordion `x-collapse`, and mobile drawer `x-transition`. Zero continuous ticker loops, zero parallax, and zero decorative entrance bounces (R-19, R-39). |

### 1.3 Five Liveliness Levers
1. **One Focal Point Per Screen:** Every viewport establishes a single dominant visual anchor (for example, the Secondary Blue `.bento-tile-main` H1 paired with the Tertiary Orange primary CTA in the hero, or the highlighted `.bento-stat-accent` counter tile). Secondary metadata defers via size and muted slate ink (`--color-ink-muted`).
2. **Hierarchical Contrast:** Clear separation between geometric display headings (`Plus Jakarta Sans` 600/700, tight tracking `-0.02em`), readable bilingual prose (`Plus Jakarta Sans` 400/500), and tabular figures (`JetBrains Mono` 500 with `tabular-nums`).
3. **Whitespace & Surface Contrast as Structure:** Following the Koolom layout system, sections alternate cleanly between Crisp White (`#FFFFFF`), Cool Alabaster (`#F8FAFC`), Ice Slate Tint (`#F1F5F9`), and High-Contrast Architectural Blue (`#1E3A8A` / `#0F2547`) with `1px` structural borders (`#E2E8F0`) instead of heavy drop shadows.
4. **60-30-10 Triadic Color Discipline:**
   - **60% Primary (White Spectrum):** `#FFFFFF`, `#F8FAFC`, and `#F1F5F9` keep service descriptions, case studies, and forms open, clean, and effortless to scan.
   - **30% Secondary (Architectural Blue Spectrum):** `#0B1528`, `#0F2547`, `#1E3A8A`, and `#1D4ED8` provide structural authority for the top utility bar, the main hero Bento card, subpage `.section-banner` headers, badges (`#DBEAFE`), the full-width conversion band, and the dark footer.
   - **10% Tertiary (Signal / Amber-Orange Spectrum):** `#C2410C`, `#F97316`, and `#FB923C` are reserved strictly for primary conversion CTAs, the hero accent metric tile (`.bento-stat-accent`), step index badges, and active focus/navigation states (R-29).
5. **Identity Motif:** Rounded architectural Bento tiles (`--radius-tile: 1.125rem` / `18px`) paired with numbered practice areas (`01` to `04`), status dot indicators, and clear service milestones.

### 1.4 Scraped Multi-Page Reference Map (`koolom.webflow.io`)
Scraping the 5 reference pages on `koolom.webflow.io` established the following layout rules across our template:

| Reference URL | Scraped Koolom Sections & Variants | Mapped Blade View in This Boilerplate |
| :--- | :--- | :--- |
| [`https://koolom.webflow.io/`](https://koolom.webflow.io/) | `.navbar[variant=with-topbar]` -> `.section-hero[variant=bento-grid]` -> `.section-service` -> `.section-why[variant=icon-grid]` -> `.section-about` -> `.section-timeline[variant=numbered-milestones]` -> `.section-blog-list` -> `.section-faq` -> `.section-cta` -> `.section-footer` | `resources/views/pages/home.blade.php` |
| [`https://koolom.webflow.io/about-us`](https://koolom.webflow.io/about-us) | `.section-banner[variant=split-with-image]` -> `.section-about[variant=client-and-stats-card]` -> `.section-founder[variant=quote-led-portrait]` -> `.section-timeline[variant=vertical-steps]` -> `.section-why[variant=numbered-list]` -> `.section-cta` | `resources/views/pages/about.blade.php` |
| [`https://koolom.webflow.io/services-v3`](https://koolom.webflow.io/services-v3) | `.section-banner[variant=full-bleed-image]` -> `.section-service[variant=landscape-card-slider]` -> `.section-faq` -> `.section-cta` | `resources/views/pages/services/index.blade.php` & `pages/services/show.blade.php` |
| [`https://koolom.webflow.io/blog`](https://koolom.webflow.io/blog) | `.section-banner[variant=left-aligned-text]` -> `.section-blog-single` (featured 12-col landscape item `.blog-slider-item.main` + 2-col card grid) -> `.section-cta` | `resources/views/pages/case-studies/index.blade.php` & `pages/case-studies/show.blade.php` |
| [`https://koolom.webflow.io/contact-v1`](https://koolom.webflow.io/contact-v1) | `.section-banner[variant=split-with-image]` -> `.section-contact[variant=base]` (`.contact-two-col`: form shell + direct advisor card) -> `.section-locations` (`.location-card-wrap`) -> `.section-faq` -> `.section-cta` | `resources/views/pages/contact.blade.php` |

---

## 2. Written Purpose Justifications (Keystone Rule R-31 & Purpose-Gate R-01..R-22)

Every visual and structural decision in this guideline is backed by an explicit functional reason:

- **Why White (Primary), Blue (Secondary), and Orange (Tertiary)? (R-01, R-29):** Crisp White (`#FFFFFF`) maximizes legibility for service scopes and legal/business guides; Architectural Blue (`#1E3A8A` to `#0B1528`) signals corporate trust and anchors the Hero Bento, `.section-banner` headers, and CTA bands; Signal Orange (`#C2410C` / `#F97316`) creates an unmistakable complementary contrast against Blue to drive consultation bookings.
- **Why simple, plain-text navigation labels? (R-03, R-24):** Modeled directly on Koolom's `.nav_menu` (`Home`, `About Us`, `Services`, `Case Studies`, `Contact` / `Beranda`, `Tentang Kami`, `Layanan`, `Studi Kasus`, `Kontak`), short single-word or two-word nav labels keep the header uncluttered and prevent text wrapping across desktop viewports.
- **Why a Bento Grid Hero (`58%/42%` top split + 4-tile bottom metric bar)? (R-05):** Grouping the value proposition (in a Secondary Blue tile), the primary office/team visual (in a matching rounded media tile), and 4 quantified proof counters (led by a Tertiary Orange accent tile) delivers identity, trust, and track record in the first viewport.
- **Why zero decorative gradients or glows? (R-01, R-13):** Solid color blocks (`#FFFFFF`, `#F1F5F9`, `#1E3A8A`, `#F97316`) and `1px` crisp borders (`#E2E8F0`) create clean editorial separation, whereas blurred neon orbs and multi-stop gradients look like generic AI templates.
- **Why this glassmorphism cap? (R-10):** `backdrop-blur-md` (`bg-white/95`) is restricted exclusively to the sticky navigation bar on scroll so passing Bento cards do not visually collide with nav links; every Bento tile, card, and modal remains 100% solid.
- **Why this typography pairing? (R-06):** `Plus Jakarta Sans` matches Koolom's modern editorial grotesque proportions in both Indonesian and English, and `JetBrains Mono` (`tabular-nums`) keeps counters (`450+`, `< 24 Jam`), service codes (`SRV-01`), and step numbers (`01`..`04`) vertically aligned.
- **Why `1.125rem` (`18px`) Bento tile radius with `0.5rem` (`8px`) inner controls? (R-11, R-12):** Concentric border radii (outer Bento tile at `18px`, inner cards at `12px`, buttons/inputs at `8px`) mirror Koolom's modern framing while avoiding puffy pill-shaped cards and heavy drop shadows.
- **Why Light Mode (`#FFFFFF`) default with a verified Dark Mode (`.dark`) toggle? (R-21, R-34):** White-primary surfaces (`#FFFFFF` / `#F8FAFC`) provide the cleanest daytime reading experience for business clients, while the Midnight Navy dark mode (`#0B1528` surface, `#0F2547` elevated cards) preserves the Blue + Orange brand identity in low-light environments.

---

## 3. Modern Three-Color Spectrum & Verified WCAG 2.2 AA Contrast Matrix (`antislop-human` R-25 & https://www.accessibilitychecker.org/)

> **Accessibility Standard Reference:** All color pairings, interactive boundaries, focus indicators, and landmark structures are designed to pass local contrast math (`python .agents/skills/antislop-human/contrast-check.py`) and worldwide accessibility audits per https://www.accessibilitychecker.org/ (WCAG 2.2 AA, ADA, Section 508, and EAA).

### 3.1 Primary Color Spectrum: White & Cool Alabaster (60% Dominant Canvas)
| Token Name | Hex | Role in Koolom Layout Architecture |
| :--- | :--- | :--- |
| `--color-primary-white` | `#FFFFFF` | **Core Primary Surface:** Main page background, primary navbar, service cards (`.service-card`), location cards (`.location-card`), FAQ rows (`.faqs_item`), and form input backgrounds. |
| `--color-primary-50` | `#F8FAFC` | **Cool Alabaster Surface:** Alternating section background (`.section-why`, `.section-locations`, `.section-faq`) and subtle card hover surface. |
| `--color-primary-100` | `#F1F5F9` | **Ice Slate Tint (Koolom `--subtle-main-color` equivalent):** Secondary Bento stat tiles (`.bento-stat`) and 4-step process timeline band (`.section-timeline`). |
| `--color-primary-200` | `#E2E8F0` | **Hairline Structural Border:** `1px` card borders, FAQ dividers, and table cell lines (`--color-border-subtle`). |
| `--color-primary-500` | `#64748B` | **Interactive Boundary Slate:** Form input borders, unchecked checkboxes, and secondary outline button borders (`--color-border-interactive`, verified $\ge 4.5:1$ on white). |

### 3.2 Secondary Color Spectrum: Modern Architectural Blue (30% Structural & Authority)
| Token Name | Hex | Role in Koolom Layout Architecture |
| :--- | :--- | :--- |
| `--color-secondary-950` | `#0B1528` | **Midnight Navy (Primary Ink & Dark Footer):** All H1-H6 headings and body text on white surfaces (`18.23:1` contrast), plus `.section-footer.background-color-dark` and Dark Mode primary canvas. |
| `--color-secondary-900` | `#0F2547` | **Deep Royal Navy:** `.topbar` utility strip background, FAQ escalation card, contact advisor card, and Dark Mode elevated Bento tiles. |
| `--color-secondary-800` | `#1E3A8A` | **Architectural Cobalt Blue (Koolom `--main-color` equivalent):** Hero main Bento card surface (`.bento-tile-main`), subpage `.section-banner` headers, full-width conversion banner (`.section-cta`), and secondary solid buttons. |
| `--color-secondary-700` | `#1D4ED8` | **Interactive Royal Blue:** Text links, active navigation underline (`.link_line`), eyebrow category labels on white surfaces, and secondary button `:hover` fill. |
| `--color-secondary-600` | `#2563EB` | **Vibrant Cobalt:** Focus rings on dark surfaces, active tab borders, and dark-mode interactive highlights. |
| `--color-secondary-100` | `#DBEAFE` | **Soft Ice Blue Badge:** Category chip fills, `.practice-icon` badge containers on white cards, and high-contrast muted subcopy inside `#1E3A8A` / `#0F2547` blue Bento tiles (`8.49:1` contrast). |
| `--color-secondary-50` | `#EFF6FF` | **Subtle Blue Wash:** Hover background tint for interactive service rows. |
| `--color-ink-muted` | `#475569` | **Slate-Blue Muted Ink:** Body descriptions, captions, and secondary metadata on `#FFFFFF`, `#F8FAFC`, and `#F1F5F9` surfaces (`6.92:1` to `7.58:1` contrast). |

### 3.3 Tertiary Color Spectrum: Modern Signal & Amber-Orange (10% Conversion & Focal Accent)
| Token Name | Hex | Role in Koolom Layout Architecture |
| :--- | :--- | :--- |
| `--color-tertiary-800` | `#9A3412` | **Deep Copper Orange:** Primary CTA button `:hover` and `:active` background (`7.31:1` with `#FFFFFF`), and high-contrast text inside `#FFEDD5` / `#FFF7ED` orange badges. |
| `--color-tertiary-700` | `#C2410C` | **Burnt Signal Orange (Primary CTA & Accessible Accent Ink):** Primary CTA button background with `#FFFFFF` text (`5.18:1` AA pass), and index numbers (`01`..`04`) or eyebrow tags on white surfaces (`5.18:1` AA pass). |
| `--color-tertiary-600` | `#EA580C` | **Bright Flame Orange:** Decorative top border accent (`4px`) on the dark footer and active timeline connectors. |
| `--color-tertiary-500` | `#F97316` | **Vibrant Tangerine (Koolom `.bento-stat-accent` equivalent):** Hero highlighted metric tile surface (`.bento-stat-accent`) paired with `#0B1528` Midnight Navy text (`6.50:1` AA pass), and status indicator dots on `#0F2547` dark navy (`5.44:1`). |
| `--color-tertiary-400` | `#FB923C` | **Warm Amber-Orange:** Accent numbers, eyebrow labels, and primary CTA button fill on dark blue (`#1E3A8A`, `#0F2547`, `#0B1528`) surfaces (`4.58:1` to `8.05:1` AA pass). |
| `--color-tertiary-100` | `#FFEDD5` | **Soft Apricot Tint:** Step number badge background (`.step-num-1`) and icon container fill when paired with `#9A3412` text (`6.38:1`). |
| `--color-tertiary-50` | `#FFF7ED` | **Warm Cream Wash:** Highlighted fee-guarantee callout box background (`.fee-note-1`) paired with `#9A3412` text (`6.88:1`) and `#F97316` left accent bar. |

### 3.4 Verified Light Mode WCAG 2.2 AA Contrast Pairing Matrix
Every pairing below has been verified using `python .agents/skills/antislop-human/contrast-check.py`:

| Background Token (Hex) | Foreground / Text Token (Hex) | Computed Ratio | WCAG 2.2 AA Verdict | Approved Component Usage |
| :--- | :--- | :--- | :--- | :--- |
| `--color-primary-white` (`#FFFFFF`) | `--color-secondary-950` (`#0B1528`) | **18.23:1** | PASS (AAA Normal & Large) | Primary headings (H1-H6) & body prose on white canvas |
| `--color-primary-50` (`#F8FAFC`) | `--color-secondary-950` (`#0B1528`) | **17.42:1** | PASS (AAA Normal & Large) | Headings & prose on cool alabaster sections |
| `--color-primary-100` (`#F1F5F9`) | `--color-secondary-950` (`#0B1528`) | **16.64:1** | PASS (AAA Normal & Large) | Counter numbers & titles on `.bento-stat` & `.section-timeline` |
| `--color-primary-white` (`#FFFFFF`) | `--color-ink-muted` (`#475569`) | **7.58:1** | PASS (AAA Normal & Large) | Secondary descriptions, captions, table labels on white |
| `--color-primary-50` (`#F8FAFC`) | `--color-ink-muted` (`#475569`) | **7.24:1** | PASS (AAA Normal & Large) | Secondary descriptions on alabaster sections |
| `--color-primary-100` (`#F1F5F9`) | `--color-ink-muted` (`#475569`) | **6.92:1** | PASS (AA Normal, AAA Large) | Subtitles inside `.bento-stat` and timeline cards |
| `--color-primary-white` (`#FFFFFF`) | `--color-secondary-800` (`#1E3A8A`) | **10.36:1** | PASS (AAA Normal & Large) | Secondary blue subheadings, outline buttons, nav brand text |
| `--color-primary-white` (`#FFFFFF`) | `--color-secondary-700` (`#1D4ED8`) | **6.70:1** | PASS (AA Normal, AAA Large) | Interactive text links & blue eyebrow labels on white |
| `--color-secondary-100` (`#DBEAFE`) | `--color-secondary-800` (`#1E3A8A`) | **8.49:1** | PASS (AAA Normal & Large) | Blue category chips & `.practice-icon` badges |
| `--color-secondary-800` (`#1E3A8A`) | `--color-primary-white` (`#FFFFFF`) | **10.36:1** | PASS (AAA Normal & Large) | Hero `.bento-tile-main` H1, `.section-banner` H1, & `.section-cta` H2 |
| `--color-secondary-800` (`#1E3A8A`) | `--color-secondary-100` (`#DBEAFE`) | **8.49:1** | PASS (AAA Normal & Large) | Lead paragraph & chip labels inside `.bento-tile-main` & `.section-banner` |
| `--color-secondary-800` (`#1E3A8A`) | `--color-tertiary-400` (`#FB923C`) | **4.58:1** | PASS (AA Normal & Large) | Orange status dot & eyebrow text on `.bento-tile-main` Cobalt Blue |
| `--color-secondary-900` (`#0F2547`) | `--color-primary-white` (`#FFFFFF`) | **15.26:1** | PASS (AAA Normal & Large) | `.topbar` utility bar text & dark navy card headings |
| `--color-secondary-900` (`#0F2547`) | `--color-tertiary-500` (`#F97316`) | **5.44:1** | PASS (AA Normal & Large) | `.topbar` status icon & orange highlights on Deep Royal Navy |
| `--color-tertiary-700` (`#C2410C`) | `--color-primary-white` (`#FFFFFF`) | **5.18:1** | PASS (AA Normal & Large) | Primary Orange CTA button background with crisp white label |
| `--color-tertiary-800` (`#9A3412`) | `--color-primary-white` (`#FFFFFF`) | **7.31:1** | PASS (AAA Normal & Large) | Primary Orange CTA button `:hover` state with white label |
| `--color-primary-white` (`#FFFFFF`) | `--color-tertiary-700` (`#C2410C`) | **5.18:1** | PASS (AA Normal & Large) | Service index numbers (`01`..`04`) & orange eyebrow tags on white |
| `--color-tertiary-500` (`#F97316`) | `--color-secondary-950` (`#0B1528`) | **6.50:1** | PASS (AA Normal, AAA Large) | Hero `.bento-stat-accent` Tangerine tile with Midnight Navy text |
| `--color-tertiary-100` (`#FFEDD5`) | `--color-tertiary-800` (`#9A3412`) | **6.38:1** | PASS (AA Normal, AAA Large) | Timeline `.step-num-1` Apricot badge with Deep Copper number |
| `--color-primary-white` (`#FFFFFF`) | `--color-border-interactive` (`#64748B`) | **4.76:1** | PASS ($\ge 3.0:1$ Non-Text) | Form input borders, select controls, and outline buttons |
| `--color-primary-white` (`#FFFFFF`) | `--color-status-success` (`#15803D`) | **5.02:1** | PASS (AA Normal & Large) | Checkmark icons & verified compliance labels |
| `--color-primary-white` (`#FFFFFF`) | `--color-status-warning` (`#B45309`) | **5.02:1** | PASS (AA Normal & Large) | Boilerplate seed notice & SLA caution labels |
| `--color-primary-white` (`#FFFFFF`) | `--color-status-danger` (`#B91C1C`) | **6.47:1** | PASS (AA Normal, AAA Large) | Form validation error text & icons (never color alone per R-39) |

### 3.5 Verified Dark Mode (`.dark`) & Dark Footer WCAG 2.2 AA Contrast Pairing Matrix
| Background Token (Hex) | Foreground / Text Token (Hex) | Computed Ratio | WCAG 2.2 AA Verdict | Approved Component Usage |
| :--- | :--- | :--- | :--- | :--- |
| `--color-secondary-950` (`#0B1528`) | `--color-primary-50` (`#F8FAFC`) | **17.42:1** | PASS (AAA Normal & Large) | `.section-footer` & `.dark` primary page canvas text |
| `--color-secondary-900` (`#0F2547`) | `--color-primary-50` (`#F8FAFC`) | **14.59:1** | PASS (AAA Normal & Large) | `.dark` elevated Bento cards, modals, and form inputs |
| `--color-secondary-950` (`#0B1528`) | `#94A3B8` (Dark Muted Ink) | **7.11:1** | PASS (AAA Normal & Large) | Footer secondary links, copyright bar, and `.dark` body prose |
| `--color-secondary-900` (`#0F2547`) | `#CBD5E1` (Elevated Card Muted) | **10.28:1** | PASS (AAA Normal & Large) | Secondary text inside `.dark` elevated navy cards |
| `--color-secondary-950` (`#0B1528`) | `--color-tertiary-400` (`#FB923C`) | **8.05:1** | PASS (AAA Normal & Large) | Orange accent links, index numbers, and icons in Dark Mode / Footer |
| `--color-tertiary-400` (`#FB923C`) | `--color-secondary-950` (`#0B1528`) | **8.05:1** | PASS (AAA Normal & Large) | Primary CTA button fill in `.dark` mode (uses `#0B1528` dark navy text) |
| `--color-secondary-950` (`#0B1528`) | `#7889A1` (Dark Border Interactive) | **5.11:1** | PASS ($\ge 3.0:1$ Non-Text) | Form input borders and interactive control outlines in `.dark` mode |
| `--color-secondary-950` (`#0B1528`) | `#4ADE80` / `#FBBF24` / `#F87171` | **10.46:1 / 10.92:1 / 6.59:1** | PASS (AA/AAA) | Dark mode status success, warning, and danger text + icons |

---

## 4. Tailwind CSS v4 `@theme` & Base Layer Specification (`resources/css/compro.css`)

The exact token implementation in [`resources/css/compro.css`](../resources/css/compro.css) maps the three-color spectrum (`--color-primary-*`, `--color-secondary-*`, `--color-tertiary-*`) and Koolom radii (`--radius-tile: 1.125rem`, `--radius-card: 0.75rem`, `--radius-button: 0.5rem`, `--radius-tag: 0.25rem`, `--radius-pill: 9999px`) to Tailwind v4 utility classes.

---

## 5. Responsive Reflow & Mobile Layout Architecture (`antislop-layoutmobile` R-03)

| Viewport Band | Width Range | Koolom Bento & Grid Reflow Behavior | Spacing & Type Register |
| :--- | :--- | :--- | :--- |
| **State 1: Phone** | `< 640px` (tested down to `320px`) | `.topbar` hides secondary address item and keeps response commitment. `.bento-row` (`58%/42%`) stacks vertically (`grid-cols-1`); `.bento-img-tile` sets `min-h-[18rem]`. `.bento-stats-row` stacks into a `1-col` or `2x2` compact grid. `.why-grid`, `.steps-grid-1`, `.location-card-wrap`, and `.service-list` stack into single-column cards with zero horizontal overflow. | Container: `px-4`. Section padding: `py-14`. Hero uses `h-auto` (never `100vh`). |
| **State 2: Tablet** | `640px` to `1023px` (`sm:` & `md:`) | `.bento-row` stacks into 2 full-width tiles while `.bento-stats-row` forms a clean `2x2` grid (`sm:grid-cols-2`). `.why-grid` (`3-col` desktop) and `.steps-grid-1` (`4-col` desktop) reflow to `sm:grid-cols-2`. | Container: `sm:px-6`. Section padding: `md:py-20`. Gap: `md:gap-6`. |
| **State 3: Desktop** | `>= 1024px` (`lg:` & `xl:`) | Full Koolom container (`max-w-7xl mx-auto px-8`): `.bento-row` uses a 12-column `7/5` (`58%/42%`) split (`lg:grid-cols-12`, `gap-4`); `.bento-stats-row` runs 4 columns (`lg:grid-cols-4`, `gap-4`); `.why-grid` runs 3 columns (`lg:grid-cols-3`); `.steps-grid-1` runs 4 columns (`lg:grid-cols-4`). | Section padding: `lg:py-[8.25rem]` (standard) or `lg:py-24` (`6rem` compact). |

---

## 6. Sitemap, Simple Navbar Specification & Multi-Page Blueprints

### 6.1 Canonical Bilingual Route Table & Simple Navbar Labels (R-24: Zero Ghost Links)
Every link in the header, footer, or section CTAs must resolve to one of the active routes below. Crawler discovery and XML indexing follow http://www.robotstxt.org/robotstxt.html (`/robots.txt`) and https://www.sitemaps.org/index.html (`/sitemap.xml` index referencing `main-sitemap.xml`, `services-sitemap.xml`, `case-studies-sitemap.xml`, and `articles-sitemap.xml`). Navbar items use **simple, plain text** matching `koolom.webflow.io`:

| Page Key | Simple Navbar Label (ID / EN) | Indonesian Route (`/id/...`) | English Route (`/en/...`) | Reference Koolom URL |
| :--- | :--- | :--- | :--- | :--- |
| `home` | `Beranda` / `Home` | `/id` | `/en` | `https://koolom.webflow.io/` |
| `about` | `Tentang Kami` / `About Us` | `/id/tentang-kami` | `/en/about` | `https://koolom.webflow.io/about-us` |
| `services.index` | `Layanan` / `Services` | `/id/layanan` | `/en/services` | `https://koolom.webflow.io/services-v3` |
| `services.show` | *(Child of Services)* | `/id/layanan/{slug}` | `/en/services/{slug}` | `https://koolom.webflow.io/services-v3` |
| `case-studies.index` | `Studi Kasus` / `Case Studies` | `/id/studi-kasus` | `/en/case-studies` | `https://koolom.webflow.io/blog` |
| `case-studies.show` | *(Child of Case Studies)* | `/id/studi-kasus/{slug}` | `/en/case-studies/{slug}` | `https://koolom.webflow.io/blog` |
| `contact` | `Kontak` / `Contact` | `/id/hubungi-kami` | `/en/contact` | `https://koolom.webflow.io/contact-v1` |

- **Primary Header CTA Button (ID / EN):** `Konsultasi Gratis` / `Free Consultation`
- **Navbar Brand Text:** Clean single-line brand name (`Koolom Partners`) with a simple rounded-square mark (`K`), free of technical KBLI codes or multi-line legal entity subtitles.

---

### 6.2 Homepage Blueprint (`pages/home.blade.php` <- `https://koolom.webflow.io/`)
1. **Top Utility Bar (`.topbar`) + Simple Sticky Header (`.nav_wrap`):**
   - `.topbar` (`bg-surface-topbar` `#0F2547`): Left shows pulsing orange indicator + `"Respon Konsultasi < 24 Jam Kerja"`; Right shows office hours + phone (`+62-21-5200-4180`).
   - `.nav_wrap` (`bg-surface/95` `#FFFFFF`): Left brand (`Koolom Partners`), center simple text menu (`Beranda`, `Tentang Kami`, `Layanan`, `Studi Kasus`, `Kontak`), right language toggle, theme toggle, and `Konsultasi Gratis` button (`#C2410C`).
2. **Bento Grid Hero (`<x-sections.hero-split>` <- `.section-hero[variant="bento-grid"]`):**
   - **Top Row (`58% / 42%` split):** Left Cobalt Blue tile (`#1E3A8A`, `rounded-[1.125rem]`) with status pill, H1, lead copy, 2 CTA buttons (`Konsultasi Gratis` in Orange + `Lihat Layanan` in White outline), and 4 practice-area chips (`Pendirian PT & PMA`, `Kontrak Bisnis`, `Kepatuhan & Retainer`, `Transaksi & M&A`). Right media tile (`rounded-[1.125rem]`) with priority image and bottom trust caption.
   - **Bottom Row (`.bento-stats-row`):** 4 metric tiles: Tile 1 in Vibrant Tangerine Orange (`#F97316` with `#0B1528` text: `< 24 Jam` Consultation Reply), Tiles 2 to 4 in Ice Slate Tint (`#F1F5F9`: `450+ Klien`, `12 Tahun`, `1.200+ Proyek`).
3. **Practice Areas / Service Matrix (`<x-sections.service-matrix>` <- `.section-service`):**
   - Split header (`Layanan Kami` / `How We Can Help You` + `Lihat Semua Layanan` button) followed by a 2-column grid of numbered service cards (`01` to `04` in `#C2410C` Orange) with plain-language descriptions, key deliverables, and `"Lihat Detail Layanan"` links.
4. **Why Choose Us & Firm Overview (`<x-sections.proof-ledger>` <- `.section-why` + `.section-about`):**
   - Cool Alabaster surface (`#F8FAFC`) with 3 value cards (`Estimasi Biaya Transparan`, `Konsultan Senior di Setiap Kasus`, `Respon Cepat & Tepat Waktu`) followed by a `6/6` split firm overview (`Tentang Firma Kami` / `About Our Firm` with 3 checkmark promises + registered credentials and client sectors).
5. **How It Works / 4-Step Timeline (`<x-sections.process-timeline>` <- `.section-timeline[variant="numbered-milestones"]`):**
   - Ice Slate Tint band (`#F1F5F9`) with 4 milestone cards (`01 Konsultasi Awal Gratis`, `02 Estimasi Biaya Tertulis`, `03 Penyusunan & Pengajuan`, `04 Penyelesaian & Serah Terima`) and a bottom transparent-fee note (`.fee-note-1` in `#FFF7ED`).
6. **Featured Case Studies & Insights (`<x-sections.case-study-showcase>` <- `.section-blog-list` & `.section-testimonial` adaptation):**
   - Featured 12-column landscape dossier card followed by 2-column case cards on a crisp White canvas.
7. **Common Questions (`<x-sections.technical-faq>` <- `.section-faq`):**
   - Split `5/7` layout with sticky Deep Navy (`#0F2547`) consultation desk card on the left and collapsible white FAQ cards on the right.
8. **Full-Width Conversion CTA & Consultation Form (`<x-sections.rfq-cta-banner>` <- `.section-cta`):**
   - Architectural Cobalt Blue (`#1E3A8A`) band with assurance badges (`100% Rahasia`, `Estimasi Biaya Jelas`, `Respon < 1 Hari Kerja`), crisp white consultation form card, and Deep Navy office contact card.

---

### 6.3 Subpage Layout Blueprints (Scraped from Koolom Subpages)

#### A. About Us Page (`pages/about.blade.php` <- `https://koolom.webflow.io/about-us`)
1. **Split Banner Header (`.section-banner[variant="split-with-image"]`):**
   - Rounded Secondary Blue (`#1E3A8A`, `rounded-[1.125rem]`) split hero container inside `.container-large`: Left side has orange eyebrow (`Tentang Kami` / `About Us`), white H1 (`Pendamping Hukum & Bisnis Terpercaya untuk Perusahaan Anda`), and lead paragraph (`#DBEAFE`); Right side has office/team visual card and founding year badge (`Est. 2014`).
2. **About Our Firm & Stats Card (`<x-sections.proof-ledger>` <- `.section-about[variant="client-and-stats-card"]`):**
   - 4 metric tiles (`< 24 Jam`, `450+ Klien`, `12 Tahun`, `1.200+ Proyek`), 3 Why-Choose-Us cards, and 3 checkmark commitments alongside registered professional credentials (`ISO 9001:2015`, `PERADI & AKHKI`, `IKPI`).
3. **Managing Partner Commitment Block (`.section-founder[variant="quote-led-portrait"]`):**
   - Split `5/7` editorial block on crisp White (`#FFFFFF`) highlighting the firm's core principle: *"Pendampingan hukum dan perizinan bisnis seharusnya terasa jelas, praktis, dan memberikan kepastian bagi pengambil keputusan."*
4. **How It Works Timeline (`<x-sections.process-timeline>` <- `.section-timeline[variant="vertical-steps"]`):**
   - 4-step consultation-to-resolution process on `#F1F5F9` tinted surface.
5. **Conversion CTA & Consultation Form (`<x-sections.rfq-cta-banner>` <- `.section-cta`):**
   - Full-width Cobalt Blue consultation section.

#### B. Services Index & Detail Pages (`pages/services/index.blade.php` & `show.blade.php` <- `https://koolom.webflow.io/services-v3`)
1. **Practice Areas Banner (`.section-banner[variant="full-bleed-image"]`):**
   - High-contrast Secondary Blue (`#1E3A8A`, `rounded-[1.125rem]`) banner with orange eyebrow (`Layanan Kami` / `Our Practice Areas`), white H1 (`Layanan Konsultasi Bisnis & Hukum yang Terukur` / `Comprehensive Business & Legal Services`), lead subcopy, and quick jump links to `SRV-01`..`SRV-04`.
2. **Practice Area Cards (`<x-sections.service-matrix>` <- `.section-service[variant="landscape-card-slider"]`):**
   - 2-column numbered practice cards (`01`..`04`) with target segment chip, problem solved, deliverables, key parameters, and direct link to the service detail page.
3. **Common Questions (`<x-sections.technical-faq>` <- `.section-faq`):**
   - 5 practical FAQs on free consultations, fixed-fee quotes, and turnaround times.
4. **Conversion CTA (`<x-sections.rfq-cta-banner>` <- `.section-cta`):**
   - Consultation booking section.

#### C. Case Studies / Insights Index & Detail Pages (`pages/case-studies/index.blade.php` & `show.blade.php` <- `https://koolom.webflow.io/blog`)
1. **Left-Aligned Editorial Banner (`.section-banner[variant="left-aligned-text"]`):**
   - Rounded Secondary Blue (`#1E3A8A`, `rounded-[1.125rem]`) header with orange eyebrow (`Studi Kasus & Wawasan` / `Case Studies & Insights`), white H1 (`Rekam Jejak Pendampingan & Solusi Bisnis Klien` / `Client Matters & Practical Business Outcomes`), and concise description.
2. **Featured Main Item + 2-Column Grid (`<x-sections.case-study-showcase>` <- `.section-blog-single` / `.blog-list-wrap`):**
   - First item (`CS-01`) renders as the featured 12-column landscape card (`5/7` image-to-content split, `.blog-slider-item.main`), followed by `CS-02` and `CS-03` in a 2-column (`6/6`) grid below.
3. **Conversion CTA (`<x-sections.rfq-cta-banner>` <- `.section-cta`):**
   - Consultation booking section.

#### D. Contact Page (`pages/contact.blade.php` <- `https://koolom.webflow.io/contact-v1`)
1. **Split Contact Banner (`.section-banner[variant="split-with-image"]`):**
   - Secondary Blue (`#1E3A8A`, `rounded-[1.125rem]`) banner with eyebrow (`Hubungi Kami` / `Contact`), white H1 (`Mari Diskusikan Kebutuhan Bisnis Anda` / `Let's Talk About Your Business Matter`), lead copy (`Hubungi kami untuk konsultasi awal gratis dan rahasia. Kami merespons setiap pesan dalam 1 hari kerja.`), and 3 assurance pills (`100% Rahasia`, `Konsultasi Awal Gratis`, `Respon < 24 Jam`).
2. **Two-Column Contact & Form Section (`<x-sections.rfq-cta-banner>` <- `.section-contact[variant="base"]`):**
   - Left (`7 cols`): `.contact-form-shell` 4-state interactive consultation form (`Idle`, `Submitting`, `Error`, `Success`).
   - Right (`5 cols`): `.contact-card` direct advisor contact details (Phone, WhatsApp, Email, and Mon-Fri hours).
3. **Office Locations Grid (`.section-locations` / `.location-card-wrap`):**
   - Cool Alabaster (`#F8FAFC`) section displaying the Jakarta Headquarters and Surabaya Branch office cards (`.location-card`) with full street address, phone, email, and operating hours.
4. **Common Questions (`<x-sections.technical-faq>` <- `.section-faq`):**
   - Practical FAQs for prospective clients before booking a consultation.
