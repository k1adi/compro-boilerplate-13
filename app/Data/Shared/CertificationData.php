<?php

declare(strict_types=1);

namespace App\Data\Shared;

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

