<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Shared\CertificationData;
use App\Data\Shared\MetricProofData;

readonly class CompanySettingsData
{
    /**
     * @param  array<int, string>  $kbliCodes
     * @param  array{lat: float, lng: float}  $geoCoordinates
     * @param  array<string, string>  $sameAsUrls
     * @param  array<int, MetricProofData>  $metrics
     * @param  array<int, CertificationData>  $certifications
     * @param  array<int, string>  $clientSectorDescriptors
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

