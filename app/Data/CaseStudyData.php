<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Shared\MediaAssetData;
use App\Data\Shared\SeoMetaData;

readonly class CaseStudyData
{
    /**
     * @param  array<int, MediaAssetData>  $gallery
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
