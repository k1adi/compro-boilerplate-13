<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Shared\ActionLinkData;
use App\Data\Shared\MediaAssetData;
use App\Data\Shared\SeoMetaData;

readonly class HomePageData
{
    /**
     * @param  array<int, ServiceData>  $services
     * @param  array<int, CaseStudyData>  $caseStudies
     * @param  array<int, FaqItemData>  $faqs
     * @param  array<int, TestimonialData>  $testimonials
     */
    public function __construct(
        public string $sectorCode,
        public string $headline,
        public string $subheadline,
        public ActionLinkData $primaryCta,
        public ActionLinkData $secondaryCta,
        public MediaAssetData $heroMedia,
        public string $specCaption,
        public string $servicesHeading,
        public string $servicesSummary,
        public string $caseStudiesHeading,
        public string $caseStudiesSummary,
        public string $faqHeading,
        public string $faqSummary,
        public string $rfqHeading,
        public string $rfqSubheadline,
        public array $services,
        public array $caseStudies,
        public array $faqs,
        public array $testimonials,
        public SeoMetaData $seo,
    ) {}
}
