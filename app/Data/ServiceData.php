<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Shared\ActionLinkData;
use App\Data\Shared\MediaAssetData;
use App\Data\Shared\SeoMetaData;

readonly class ServiceData
{
    /**
     * @param  array<int, string>  $deliverables
     * @param  array<int, array{parameter: string, value: string}>  $technicalSpecs
     * @param  array<int, array{stepNumber: int, title: string, description: string}>  $workflowSteps
     * @param  array<int, string>  $relatedCaseStudySlugs
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

