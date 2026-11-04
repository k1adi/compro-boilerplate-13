<?php

declare(strict_types=1);

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

