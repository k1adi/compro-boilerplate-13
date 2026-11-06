<?php

declare(strict_types=1);

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
