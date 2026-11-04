<?php

declare(strict_types=1);

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

