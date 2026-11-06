<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\Mocks\ComproMockRepository;

class SitemapGenerator
{
    public function __construct(
        private readonly ComproMockRepository $repository,
    ) {}

    /**
     * @return array<int, array{loc: string, alternates: array{id: string, en: string, xDefault: string}, changefreq: string, priority: string}>
     */
    public function getEntries(): array
    {
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');

        $staticPairs = [
            ['id' => '/id', 'en' => '/en', 'priority' => '1.0'],
            ['id' => '/id/tentang-kami', 'en' => '/en/about', 'priority' => '0.8'],
            ['id' => '/id/layanan', 'en' => '/en/services', 'priority' => '0.9'],
            ['id' => '/id/studi-kasus', 'en' => '/en/case-studies', 'priority' => '0.8'],
            ['id' => '/id/hubungi-kami', 'en' => '/en/contact', 'priority' => '0.9'],
        ];

        $entries = [];

        foreach ($staticPairs as $pair) {
            $alternates = [
                'id' => $baseUrl.$pair['id'],
                'en' => $baseUrl.$pair['en'],
                'xDefault' => $baseUrl.$pair['id'],
            ];

            $entries[] = [
                'loc' => $baseUrl.$pair['id'],
                'alternates' => $alternates,
                'changefreq' => 'weekly',
                'priority' => $pair['priority'],
            ];

            $entries[] = [
                'loc' => $baseUrl.$pair['en'],
                'alternates' => $alternates,
                'changefreq' => 'weekly',
                'priority' => $pair['priority'],
            ];
        }

        foreach ($this->repository->getServices('id') as $serviceId) {
            $entries[] = [
                'loc' => $serviceId->seo->canonicalUrl,
                'alternates' => $serviceId->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        foreach ($this->repository->getServices('en') as $serviceEn) {
            $entries[] = [
                'loc' => $serviceEn->seo->canonicalUrl,
                'alternates' => $serviceEn->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        foreach ($this->repository->getCaseStudies('id') as $studyId) {
            $entries[] = [
                'loc' => $studyId->seo->canonicalUrl,
                'alternates' => $studyId->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        foreach ($this->repository->getCaseStudies('en') as $studyEn) {
            $entries[] = [
                'loc' => $studyEn->seo->canonicalUrl,
                'alternates' => $studyEn->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        return $entries;
    }
}
