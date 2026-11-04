# SHARED DATA CONTRACTS (`docs/data-contracts.md`)

> **Source-of-Truth Mandate:** This file defines the canonical 1:1 schema contracts binding PHP 8.5 `readonly` DTOs (`app/Data/`), Public Blade `@props` (`resources/views/components/sections/*.blade.php`), Eloquent database columns (`database/migrations/`), and Admin Inertia.js v2 + React 19 (`.jsx`) CMS forms (`resources/js/Pages/Cms/**/*.jsx`). Whenever any DTO property, Blade prop, database column, or form field changes, update this document in the same changeset.

---

## 1. Localized Field Convention (`id` & `en`)

In the database (`spatie/laravel-translatable`) and Admin Inertia `.jsx` CMS forms, translatable fields use a locale map (`{"id": "...", "en": "..."}`). Public Blade DTOs receive the **resolved string** for the active `app()->getLocale()` so Blade templates never contain translation-lookup clutter:

- **CMS Form / Database JSON Column Payload (`.jsx` & Eloquent):**
  ```json
  {
    "title": {
      "id": "Instalasi Sistem Rantai Dingin & Gudang Berpendingin",
      "en": "Cold-Chain Storage & Industrial Refrigeration Engineering"
    },
    "slug": {
      "id": "instalasi-rantai-dingin",
      "en": "cold-chain-installation"
    }
  }
  ```

- **Resolved Public Blade DTO Property (`app/Data/ServiceData.php` when `locale === 'id'`):**
  ```php
  $service->title; // "Instalasi Sistem Rantai Dingin & Gudang Berpendingin"
  $service->slug;  // "instalasi-rantai-dingin"
  ```

---

## 2. Shared Value Object DTO Contracts (`app/Data/Shared/`)

### 2.1 `SeoMetaData` (`app/Data/Shared/SeoMetaData.php`)
Passed to `<x-seo.meta :meta="$page->seo" />` on every public route.

```php
namespace App\Data\Shared;

readonly class SeoMetaData
{
    /**
     * @param array{id: string, en: string, xDefault: string} $alternates
     * @param array<int, array<string, mixed>> $schemaGraph
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $canonicalUrl,
        public string $ogTitle,
        public string $ogDescription,
        public ?string $ogImageUrl = null,
        public string $ogType = 'website',
        public string $robots = 'index, follow',
        public array $alternates = ['id' => '', 'en' => '', 'xDefault' => ''],
        public ?string $ampUrl = null,
        public array $schemaGraph = [],
    ) {}
}
```

### 2.2 `MediaAssetData` (`app/Data/Shared/MediaAssetData.php`)
Enforces Antislop **R-23** (honest placeholder tracking), **R-39** (mandatory `alt` attribute), and **R-40** (mandatory explicit `width` and `height` dimensions to prevent CLS).

```php
namespace App\Data\Shared;

readonly class MediaAssetData
{
    public function __construct(
        public string $url,
        public ?string $webpUrl,
        public ?string $avifUrl,
        public string $alt,
        public int $width,
        public int $height,
        public string $aspectRatio = '4/3',
        public ?string $caption = null,
        public bool $isPlaceholder = true,
        public ?string $placeholderLabel = '[PHOTO PLACEHOLDER: REPLACE WITH CLIENT FACILITY PHOTO]',
    ) {}
}
```

### 2.3 `ActionLinkData` (`app/Data/Shared/ActionLinkData.php`)
Enforces Antislop **R-08** (purposeful directional cues), **R-15** (specific action labels, never generic *"Learn More"*), **R-24/R-26** (real destinations only), and **R-39** (accessible names).

```php
namespace App\Data\Shared;

readonly class ActionLinkData
{
    /**
     * @param 'primary'|'secondary'|'outline'|'ghost' $variant
     * @param 'arrow-right'|'download'|'external'|'none' $icon
     */
    public function __construct(
        public string $label,
        public string $url,
        public string $variant = 'primary',
        public string $icon = 'none',
        public bool $isExternal = false,
        public ?string $ariaLabel = null,
    ) {}
}
```

### 2.4 `MetricProofData` & `CertificationData` (`app/Data/Shared/`)
Enforces Antislop **R-17**, **R-36**, and **R-38** (every metric and compliance badge must declare its verification context and whether it is a boilerplate seed placeholder).

```php
namespace App\Data\Shared;

readonly class MetricProofData
{
    public function __construct(
        public string $id,
        public string $label,
        public string $exactFigure,
        public string $contextNote,
        public bool $isSamplePlaceholder = true,
    ) {}
}

readonly class CertificationData
{
    public function __construct(
        public string $standardCode,
        public string $scope,
        public string $issuingBody,
        public string $referenceNumber,
        public ?string $certificatePdfUrl = null,
        public bool $isSamplePlaceholder = true,
    ) {}
}
```

---

## 3. Core Domain Entity DTOs & Eloquent Schema Contracts

### 3.1 `CompanySettingsData` (`app/Data/CompanySettingsData.php`)
Sourced from `docs/knowledge-base.md` Sections 1, 2, and 3 (Phase 3 Mock) and `spatie/laravel-settings` (Phase 5 CMS).

```php
namespace App\Data;

use App\Data\Shared\CertificationData;
use App\Data\Shared\MetricProofData;

readonly class CompanySettingsData
{
    /**
     * @param array<int, string> $kbliCodes
     * @param array{lat: float, lng: float} $geoCoordinates
     * @param array<string, string> $sameAsUrls
     * @param array<int, MetricProofData> $metrics
     * @param array<int, CertificationData> $certifications
     * @param array<int, string> $clientSectorDescriptors
     */
    public function __construct(
        public string $legalName,
        public string $brandName,
        public int $foundingYear,
        public array $kbliCodes,
        public string $valueProposition,
        public string $hqAddress,
        public ?string $branchAddress,
        public array $geoCoordinates,
        public string $officeHours,
        public string $emergencySlaHours,
        public string $primaryPhone,
        public string $whatsappLeadNumber,
        public string $engineeringEmail,
        public string $generalEmail,
        public array $sameAsUrls,
        public array $metrics,
        public array $certifications,
        public array $clientSectorDescriptors,
        public bool $isSampleBoilerplate = true,
    ) {}
}
```

### 3.2 `ServiceData` (`app/Data/ServiceData.php` & `services` Table)
Sourced from `docs/knowledge-base.md` Section 4. Note that `workflowSteps` accepts any real stage count (`4` or `5` stages, never locked to a 3-step template per **R-05**).

```php
namespace App\Data;

use App\Data\Shared\ActionLinkData;
use App\Data\Shared\MediaAssetData;
use App\Data\Shared\SeoMetaData;

readonly class ServiceData
{
    /**
     * @param array<int, string> $deliverables
     * @param array<int, array{parameter: string, value: string}> $technicalSpecs
     * @param array<int, array{stepNumber: int, title: string, description: string}> $workflowSteps
     * @param array<int, string> $relatedCaseStudySlugs
     */
    public function __construct(
        public string $code,
        public string $slug,
        public string $title,
        public string $targetSegment,
        public string $problemSolved,
        public array $deliverables,
        public array $technicalSpecs,
        public array $workflowSteps,
        public MediaAssetData $heroImage,
        public ActionLinkData $primaryCta,
        public ?string $datasheetPdfUrl,
        public array $relatedCaseStudySlugs,
        public SeoMetaData $seo,
    ) {}
}
```

**Database / Inertia `.jsx` Form Mapping (`services` table):**
| Column Name | SQL Type | Translatable (`id`/`en`) | Validation Rule (`ServiceFormRequest`) |
| :--- | :--- | :--- | :--- |
| `id` | `ulid / bigint` | No | Primary Key |
| `code` | `varchar(16)` | No (`SRV-01`) | `required|string|max:16|unique:services,code` |
| `slug` | `json` | Yes | `required|array`, `slug.id` & `slug.en` required alphanumeric-dash |
| `title` | `json` | Yes | `required|array`, `title.id` & `title.en` `max:160` |
| `target_segment` | `json` | Yes | `required|array` |
| `problem_solved` | `json` | Yes | `required|array` |
| `deliverables` | `json` | Yes (`array<string>`) | `required|array|min:1` |
| `technical_specs` | `json` | Yes (`array<{parameter, value}>`) | `required|array|min:1` |
| `workflow_steps` | `json` | Yes (`array<{stepNumber, title, description}>`) | `required|array|min:2` |
| `cta_label` | `json` | Yes | `required|array` (rejects generic CTAs per R-15) |
| `datasheet_pdf_path` | `varchar(255)` | No (Nullable) | `nullable|string` |
| `is_published` | `boolean` | No | `required|boolean` |
| `sort_order` | `integer` | No | `required|integer|min:0` |

### 3.3 `CaseStudyData` (`app/Data/CaseStudyData.php` & `case_studies` Table)
Sourced from `docs/knowledge-base.md` Section 5.

```php
namespace App\Data;

use App\Data\Shared\MediaAssetData;
use App\Data\Shared\SeoMetaData;

readonly class CaseStudyData
{
    /**
     * @param array<int, MediaAssetData> $gallery
     */
    public function __construct(
        public string $code,
        public string $slug,
        public string $title,
        public string $clientDescriptor,
        public bool $isClientNameConsented,
        public string $location,
        public int $completionYear,
        public string $relatedServiceCode,
        public string $relatedServiceSlug,
        public string $installedCapacity,
        public string $engineeringChallenge,
        public string $technicalSolution,
        public string $measurableOutcome,
        public MediaAssetData $heroImage,
        public array $gallery,
        public bool $isSamplePlaceholder,
        public SeoMetaData $seo,
    ) {}
}
```

### 3.4 `ArticleData` (`app/Data/ArticleData.php` & `articles` Table)
> **Status: PLANNED (not yet implemented).** No `ArticleData` class, article routes, article views, `AmpSanitizer`, or `layouts/amp.blade.php` exist yet. This contract is the target schema for `docs/workflow.md` Step 4.4. When it is built, update this status line in the same changeset.

Supports both standard Blade rendering (`pages/articles/show.blade.php`) and native `<html ⚡>` AMP rendering (`pages/articles/amp.blade.php`).

```php
namespace App\Data;

use App\Data\Shared\MediaAssetData;
use App\Data\Shared\SeoMetaData;

readonly class ArticleData
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $excerpt,
        public string $bodyHtml,
        public string $ampBodyHtml,
        public string $categoryName,
        public string $authorName,
        public string $authorRole,
        public string $publishedAtIso,
        public string $updatedAtIso,
        public int $readingTimeMinutes,
        public MediaAssetData $featuredImage,
        public SeoMetaData $seo,
    ) {}
}
```

### 3.5 `FaqItemData` & `TestimonialData` (`app/Data/`)
Enforces Antislop **R-28** (domain-specific technical FAQs only) and **R-18** (testimonials only render when `isVerifiedReal === true`; otherwise the collection is empty `[]`).

```php
namespace App\Data;

readonly class FaqItemData
{
    public function __construct(
        public string $id,
        public string $category,
        public string $question,
        public string $answer,
        public ?string $relatedServiceCode = null,
    ) {}
}

readonly class TestimonialData
{
    public function __construct(
        public string $id,
        public string $quote,
        public string $reviewerName,
        public string $reviewerRole,
        public string $companyName,
        public string $projectReference,
        public bool $isVerifiedReal = false,
    ) {}
}
```

---

## 4. Technical Inquiry / RFQ Form Contract (`inquiries` Table & `StoreInquiryRequest`)

Governs the public RFQ & Thermal Audit booking form (`POST /{locale}/inquiries`) and the Phase 5 CMS Inquiry Manager (`resources/js/Pages/Cms/Inquiries/Index.jsx`).

### 4.1 Request Payload & Validation Rules (`App\Http\Requests\StoreInquiryRequest`)
| Field Name | Input Type | Validation Rule | UI Label (ID / EN, Required `<label for>` per R-39) |
| :--- | :--- | :--- | :--- |
| `full_name` | `text` | `required|string|min:2|max:120` | Nama Lengkap & Jabatan / Full Name & Job Title |
| `company_name` | `text` | `required|string|min:2|max:160` | Nama Perusahaan / Company Name |
| `work_email` | `email` | `required|email:rfc|max:160` | Email Korporasi / Work Email |
| `phone_whatsapp` | `tel` | `required|string|min:8|max:30` | Nomor Telepon / WhatsApp Aktif / Active Phone or WhatsApp |
| `service_code` | `select` | `required|string|in:SRV-01,SRV-02,SRV-03,SRV-04,OTHER` | Kategori Layanan Teknis / Technical Service Category |
| `facility_location` | `text` | `required|string|max:160` | Lokasi Pabrik / Gudang (Kota/Kawasan Industri) / Facility Location |
| `estimated_capacity` | `text` | `nullable|string|max:100` | Estimasi Kapasitas (`TR` / `m3` / Diameter Pipa) / Estimated Capacity |
| `project_brief` | `textarea` | `required|string|min:20|max:2000` | Spesifikasi Kebutuhan / Kendala Teknis / Technical Scope & Requirements |
| `company_website_hp` | `hidden` (Honeypot) | `prohibited` (must be empty) | Anti-spam honeypot field (`tabindex="-1"`, `autocomplete="off"`, `aria-hidden="true"`) |

### 4.2 Mandatory Frontend Form States (Antislop R-27 & R-39)
Every instance of `<x-sections.rfq-cta-banner>` (used on `home`, `services.show`, `case-studies.show`, `about`, `services.index`, `case-studies.index`, and `contact`) must implement all four states. The form submits to `POST /{locale}/inquiries` (`compro.inquiries.store`, throttled `throttle:10,1`) through the Alpine `rfqForm()` factory in `resources/js/compro.js`, and falls back to a standard server-rendered POST with a `rfq_success` session flash when JavaScript is unavailable:
1. **`idle`**: Inputs bordered with `--color-border-interactive` (`#71717a`, $\ge 3:1$ contrast), visible `<label for>` above every input, and helper unit hints in `JetBrains Mono`.
2. **`submitting` (`loading`)**: Submit button sets `disabled` (`cursor: not-allowed`), `aria-busy="true"`, and updates visible label to `"Mengirim Permintaan Teknis..."` / `"Submitting Technical Request..."`.
3. **`error`**: Displays a top summary alert (`role="alert"`) and per-field text errors (`<p id="err-work_email" class="text-status-danger">` paired with an inline warning icon and `aria-invalid="true" aria-describedby="err-work_email"` on the input). Never rely on a red border alone (R-39).
4. **`success`**: Displays a confirmation dossier card containing the generated reference code (`RFQ-YYYYMMDD-XXXX`), submitted scope summary, and the 4-hour/1-business-day engineering response commitment.

---

## 5. Public Blade Section `@props` & CMS Block Builder Schemas

Each `<x-sections.*>` Blade component accepts a strongly-typed DTO or explicit `@props` contract that mirrors the Phase 5 `page_sections.payload` JSON column:

| Blade Component | Required `@props` Signature | Empty-State Behavior (R-27 & R-38) |
| :--- | :--- | :--- |
| `<x-sections.hero-split>` | `@props(['sectorCode', 'headline', 'subheadline', 'primaryCta', 'secondaryCta', 'heroMedia', 'specCaption'])` | `primaryCta` and `secondaryCta` are `ActionLinkData` passed to `<x-ui.button :action="...">`. The hero image is the only `priority` (LCP) image. If `$heroMedia->isPlaceholder` is `true`, `<x-ui.image>` renders a labeled placeholder frame with `$heroMedia->placeholderLabel`. |
| `<x-sections.proof-ledger>` | `@props(['metrics' => [], 'certifications' => [], 'sectorDescriptors' => [], 'isSampleBoilerplate' => true])` | If both `$metrics` and `$certifications` are empty, omits the section entirely. When `$isSampleBoilerplate` is `true`, renders the `ui.proof.seed_badge` notice. `sectorDescriptors` renders sector-based client references only (never fabricated logos, R-16). |
| `<x-sections.service-matrix>` | `@props(['sectionCode' => '01 // CAPABILITIES', 'heading', 'summary' => null, 'services' => []])` | Renders `id="service-matrix"` (target of the hero secondary CTA). If `$services` is empty, renders `<x-ui.empty-state>` with `ui.services.empty_*` copy. |
| `<x-sections.process-timeline>` | `@props(['sectionCode' => '02 // METHODOLOGY', 'heading', 'summary' => null, 'steps' => []])` | Each step is `array{stepNumber: int, title: string, description: string}`. Renders exactly `count($steps)` stages (grid adapts for 2, 3, 4, or 5 stages, never forced to 3 columns). Omits the section when `$steps` is empty. |
| `<x-sections.case-study-showcase>` | `@props(['sectionCode' => '02 // COMMISSIONED PROJECT DOSSIERS', 'heading', 'summary' => null, 'caseStudies' => []])` | If `$caseStudies` is empty, renders `<x-ui.empty-state>` explaining that project dossiers are available upon NDA request. |
| `<x-sections.technical-faq>` | `@props(['sectionCode' => '03 // TECHNICAL & PROCUREMENT FAQ', 'heading', 'summary' => null, 'faqs' => [], 'contactSettings'])` | If `$faqs` is empty, omits the accordion and renders only the direct engineering desk escalation card. |
| `<x-sections.rfq-cta-banner>` | `@props(['heading', 'subheadline', 'services' => [], 'contactSettings', 'selectedServiceCode' => 'SRV-01'])` | Renders `id="rfq-form"` (target of the hero primary CTA). Always renders the interactive RFQ form plus direct phone, WhatsApp, and email dispatch links. `selectedServiceCode` pre-selects the service dropdown (`?service=SRV-0x` on the contact page, current service on `services.show`). |

#### 5.1 Shared UI Primitive Props (`resources/views/components/ui/`)
| Component | `@props` Signature | Notes |
| :--- | :--- | :--- |
| `<x-ui.button>` | `['action' => null, 'href' => null, 'variant' => 'primary', 'icon' => 'none', 'type' => 'button', 'isExternal' => false, 'external' => false]` | Pass either an `ActionLinkData` via `:action` (label, URL, variant, icon, external flag, and aria label come from the DTO) or `href` plus a slot label. Renders `<a>` when a URL exists, otherwise `<button>`. |
| `<x-ui.section-header>` | `['sectionCode' => null, 'code' => null, 'heading', 'summary' => null]` | `code` is an alias of `sectionCode`. |
| `<x-ui.image>` | `['media', 'priority' => false]` | Takes `MediaAssetData`. `priority` sets `fetchpriority="high"` and `loading="eager"`, otherwise `loading="lazy"` and `decoding="async"`. Always emits explicit `width` and `height` (R-40). |
| `<x-ui.empty-state>` | `['code' => 'STATUS // EMPTY', 'title', 'description', 'actionLabel' => null, 'actionUrl' => null]` | Used by every section with a collection. |
| `<x-ui.alert>` | `['variant' => 'danger', 'title']` | `role="alert"`. Variants: `success`, `warning`, `danger`. |
| `<x-ui.badge>` / `<x-ui.container>` | See component files | Presentation primitives with no business data. |

#### 5.2 Page-Level View Data (Controller to `pages/*.blade.php`)
| View | Variables Passed By `ComproPageController` |
| :--- | :--- |
| `pages/home` | `settings` (`CompanySettingsData`), `page` (`HomePageData`), `seo` (`SeoMetaData`) |
| `pages/about` | `settings`, `services`, `seo` |
| `pages/services/index` | `settings`, `services`, `faqs`, `seo` |
| `pages/services/show` | `settings`, `service`, `allServices`, `relatedStudies`, `relatedFaqs`, `seo` |
| `pages/case-studies/index` | `settings`, `caseStudies`, `services`, `seo` |
| `pages/case-studies/show` | `settings`, `study`, `services`, `seo` |
| `pages/contact` | `settings`, `services`, `selectedServiceCode`, `seo` |

Every page is wrapped in `<x-layouts.compro :settings="$settings" :seo="$seo">`. That anonymous component (`resources/views/components/layouts/compro.blade.php`) is a thin wrapper that includes the real shell `resources/views/layouts/compro.blade.php`. Edit the shell, not the wrapper.

#### 5.3 `HomePageData` (`app/Data/HomePageData.php`)
Fields: `sectorCode`, `headline`, `subheadline`, `primaryCta`, `secondaryCta`, `heroMedia`, `specCaption`, `servicesHeading`, `servicesSummary`, `caseStudiesHeading`, `caseStudiesSummary`, `faqHeading`, `faqSummary`, `rfqHeading`, `rfqSubheadline`, `services`, `caseStudies`, `faqs`, `testimonials`, `seo`. Testimonials stay an empty array until verified real quotes exist (R-18).

---

## 6. Canonical Cache Keys & Observer Invalidation Matrix (Phase 5)

When Phase 5 swaps the Public Controllers from `app/Data/Mocks/` to cached Eloquent queries, use these exact cache keys (`locale` in `['id', 'en']`):

| Cache Key Pattern | Hydrated DTO Return Type | Invalidated By Eloquent Observer |
| :--- | :--- | :--- |
| `compro:v1:{locale}:settings` | `CompanySettingsData` | `SettingObserver` (`saved`, `deleted`) |
| `compro:v1:{locale}:page:{pageKey}` | `PageData` | `PageObserver`, `PageSectionObserver`, `SettingObserver` |
| `compro:v1:{locale}:services:all` | `array<int, ServiceData>` | `ServiceObserver` (`saved`, `deleted`) |
| `compro:v1:{locale}:service:{slug}` | `ServiceData` | `ServiceObserver`, `CaseStudyObserver` |
| `compro:v1:{locale}:case-studies:all` | `array<int, CaseStudyData>` | `CaseStudyObserver` (`saved`, `deleted`) |
| `compro:v1:{locale}:case-study:{slug}` | `CaseStudyData` | `CaseStudyObserver` (`saved`, `deleted`) |
| `compro:v1:{locale}:articles:page:{n}` | `LengthAwarePaginator<ArticleData>` | `ArticleObserver` (`saved`, `deleted`) |
| `compro:v1:{locale}:article:{slug}` | `ArticleData` | `ArticleObserver` (`saved`, `deleted`) |
| `compro:v1:{locale}:faqs:all` | `array<int, FaqItemData>` | `FaqObserver` (`saved`, `deleted`) |
