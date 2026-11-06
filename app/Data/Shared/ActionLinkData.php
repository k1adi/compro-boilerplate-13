<?php

declare(strict_types=1);

namespace App\Data\Shared;

readonly class ActionLinkData
{
    /**
     * @param  'primary'|'secondary'|'outline'|'ghost'  $variant
     * @param  'arrow-right'|'download'|'external'|'none'  $icon
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
