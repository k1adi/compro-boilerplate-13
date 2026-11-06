<?php

declare(strict_types=1);

namespace App\Data;

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
