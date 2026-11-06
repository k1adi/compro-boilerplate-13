<?php

declare(strict_types=1);

namespace App\Data\Shared;

readonly class SeoMetaData
{
    /**
     * @param  array{id: string, en: string, xDefault: string}  $alternates
     * @param  array<int, array<string, mixed>>  $schemaGraph
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $canonicalUrl,
        public string $ogTitle,
        public string $ogDescription,
        public ?string $ogImageUrl = null,
        public string $ogType = 'website',
        public string $robots = 'index, follow',
        public array $alternates = ['id' => '', 'en' => '', 'xDefault' => ''],
        public ?string $ampUrl = null,
        public array $schemaGraph = [],
    ) {}
}
