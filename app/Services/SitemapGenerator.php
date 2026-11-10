<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\Mocks\ComproMockRepository;
use DOMDocument;

class SitemapGenerator
{
    public function __construct(
        private readonly ComproMockRepository $repository,
    ) {}

    /**
     * Render the XML sitemap index or a specific child section using native DOMDocument.
     *
     * @see https://www.sitemaps.org/index.html
     */
    public function toXml(?string $section = null, ?string $baseUrl = null): string
    {
        if ($section === null || $section === 'index') {
            return $this->toIndexXml($baseUrl);
        }

        return $this->toSectionXml($section, $baseUrl);
    }

    /**
     * Render the Sitemaps.org v0.9 XML sitemap index document.
     *
     * @see https://www.sitemaps.org/protocol.html#index
     */
    public function toIndexXml(?string $baseUrl = null): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $cssInstruction = $dom->createProcessingInstruction(
            'xml-stylesheet',
            'type="text/css" href="/sitemap.css"',
        );
        $dom->appendChild($cssInstruction);

        $sitemapindex = $dom->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'sitemapindex');
        $dom->appendChild($sitemapindex);

        foreach ($this->getIndexEntries($baseUrl) as $indexEntry) {
            $sitemap = $dom->createElement('sitemap');

            $loc = $dom->createElement('loc');
            $loc->appendChild($dom->createTextNode($indexEntry['loc']));
            $sitemap->appendChild($loc);

            if (! empty($indexEntry['lastmod'])) {
                $sitemap->appendChild($dom->createElement('lastmod', $indexEntry['lastmod']));
            }

            $sitemapindex->appendChild($sitemap);
        }

        return (string) $dom->saveXML();
    }

    /**
     * Render a specific modular child sitemap as Sitemaps.org v0.9 urlset.
     */
    public function toSectionXml(string $section, ?string $baseUrl = null): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $cssInstruction = $dom->createProcessingInstruction(
            'xml-stylesheet',
            'type="text/css" href="/sitemap.css"',
        );
        $dom->appendChild($cssInstruction);

        $urlset = $dom->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
        $urlset->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xhtml',
            'http://www.w3.org/1999/xhtml',
        );
        $dom->appendChild($urlset);

        foreach ($this->getEntries($section, $baseUrl) as $entry) {
            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc');
            $loc->appendChild($dom->createTextNode($entry['loc']));
            $url->appendChild($loc);

            if (! empty($entry['lastmod'])) {
                $url->appendChild($dom->createElement('lastmod', $entry['lastmod']));
            }

            $alternates = [
                'id' => $entry['alternates']['id'] ?? '',
                'en' => $entry['alternates']['en'] ?? '',
                'x-default' => $entry['alternates']['xDefault'] ?? '',
            ];

            foreach ($alternates as $hreflang => $href) {
                if ($href === '') {
                    continue;
                }

                $link = $dom->createElement('xhtml:link');
                $link->setAttribute('rel', 'alternate');
                $link->setAttribute('hreflang', $hreflang);
                $link->setAttribute('href', $href);
                $url->appendChild($link);
            }

            $url->appendChild($dom->createElement('changefreq', $entry['changefreq']));
            $url->appendChild($dom->createElement('priority', $entry['priority']));

            $urlset->appendChild($url);
        }

        return (string) $dom->saveXML();
    }

    /**
     * Get sitemap index entries referencing modular child sitemaps.
     *
     * @return array<int, array{loc: string, lastmod: string}>
     */
    public function getIndexEntries(?string $baseUrl = null): array
    {
        $resolvedBaseUrl = $this->getBaseUrl($baseUrl);
        $defaultLastMod = '2026-11-06';

        return [
            [
                'loc' => $resolvedBaseUrl.'/main-sitemap.xml',
                'lastmod' => $defaultLastMod,
            ],
            [
                'loc' => $resolvedBaseUrl.'/services-sitemap.xml',
                'lastmod' => $defaultLastMod,
            ],
            [
                'loc' => $resolvedBaseUrl.'/case-studies-sitemap.xml',
                'lastmod' => '2025-01-15',
            ],
            [
                'loc' => $resolvedBaseUrl.'/articles-sitemap.xml',
                'lastmod' => $defaultLastMod,
            ],
        ];
    }

    /**
     * Build Sitemaps.org v0.9 protocol entries filtered by modular section or combined.
     *
     * @return array<int, array{loc: string, lastmod: string, alternates: array{id: string, en: string, xDefault: string}, changefreq: string, priority: string}>
     */
    public function getEntries(?string $section = null, ?string $baseUrl = null): array
    {
        $normalized = $section !== null ? str_replace('_', '-', strtolower($section)) : null;

        return match ($normalized) {
            'main', 'pages' => $this->getMainEntries($baseUrl),
            'services', 'products' => $this->getServicesEntries(),
            'case-studies' => $this->getCaseStudiesEntries(),
            'articles', 'posts', 'blog' => $this->getArticlesEntries(),
            default => array_merge(
                $this->getMainEntries($baseUrl),
                $this->getServicesEntries(),
                $this->getCaseStudiesEntries(),
                $this->getArticlesEntries(),
            ),
        };
    }

    /**
     * Core static pages (home, about, services index, case studies index, contact).
     *
     * @return array<int, array{loc: string, lastmod: string, alternates: array{id: string, en: string, xDefault: string}, changefreq: string, priority: string}>
     */
    public function getMainEntries(?string $baseUrl = null): array
    {
        $resolvedBaseUrl = $this->getBaseUrl($baseUrl);
        $defaultLastMod = '2026-11-06';

        $staticPairs = [
            ['id' => '/id', 'en' => '/en', 'priority' => '1.0', 'lastmod' => $defaultLastMod],
            ['id' => '/id/tentang-kami', 'en' => '/en/about', 'priority' => '0.8', 'lastmod' => $defaultLastMod],
            ['id' => '/id/layanan', 'en' => '/en/services', 'priority' => '0.9', 'lastmod' => $defaultLastMod],
            ['id' => '/id/studi-kasus', 'en' => '/en/case-studies', 'priority' => '0.8', 'lastmod' => $defaultLastMod],
            ['id' => '/id/hubungi-kami', 'en' => '/en/contact', 'priority' => '0.9', 'lastmod' => $defaultLastMod],
        ];

        $entries = [];

        foreach ($staticPairs as $pair) {
            $alternates = [
                'id' => $resolvedBaseUrl.$pair['id'],
                'en' => $resolvedBaseUrl.$pair['en'],
                'xDefault' => $resolvedBaseUrl.$pair['id'],
            ];

            $entries[] = [
                'loc' => $resolvedBaseUrl.$pair['id'],
                'lastmod' => $pair['lastmod'],
                'alternates' => $alternates,
                'changefreq' => 'weekly',
                'priority' => $pair['priority'],
            ];

            $entries[] = [
                'loc' => $resolvedBaseUrl.$pair['en'],
                'lastmod' => $pair['lastmod'],
                'alternates' => $alternates,
                'changefreq' => 'weekly',
                'priority' => $pair['priority'],
            ];
        }

        return $entries;
    }

    /**
     * Service / product detail pages with localized alternates.
     *
     * @return array<int, array{loc: string, lastmod: string, alternates: array{id: string, en: string, xDefault: string}, changefreq: string, priority: string}>
     */
    public function getServicesEntries(): array
    {
        $defaultLastMod = '2026-11-06';
        $entries = [];

        foreach ($this->repository->getServices('id') as $serviceId) {
            $entries[] = [
                'loc' => $serviceId->seo->canonicalUrl,
                'lastmod' => $defaultLastMod,
                'alternates' => $serviceId->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        foreach ($this->repository->getServices('en') as $serviceEn) {
            $entries[] = [
                'loc' => $serviceEn->seo->canonicalUrl,
                'lastmod' => $defaultLastMod,
                'alternates' => $serviceEn->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        return $entries;
    }

    /**
     * Case study portfolio dossiers with localized alternates.
     *
     * @return array<int, array{loc: string, lastmod: string, alternates: array{id: string, en: string, xDefault: string}, changefreq: string, priority: string}>
     */
    public function getCaseStudiesEntries(): array
    {
        $entries = [];

        foreach ($this->repository->getCaseStudies('id') as $studyId) {
            $entries[] = [
                'loc' => $studyId->seo->canonicalUrl,
                'lastmod' => sprintf('%d-01-15', $studyId->completionYear),
                'alternates' => $studyId->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        foreach ($this->repository->getCaseStudies('en') as $studyEn) {
            $entries[] = [
                'loc' => $studyEn->seo->canonicalUrl,
                'lastmod' => sprintf('%d-01-15', $studyEn->completionYear),
                'alternates' => $studyEn->seo->alternates,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        return $entries;
    }

    /**
     * Article pages (ready for Phase 4.4 articles).
     *
     * @return array<int, array{loc: string, lastmod: string, alternates: array{id: string, en: string, xDefault: string}, changefreq: string, priority: string}>
     */
    public function getArticlesEntries(): array
    {
        if (method_exists($this->repository, 'getArticles')) {
            $entries = [];
            foreach (['id', 'en'] as $locale) {
                /** @var array<int, object> $articles */
                $articles = $this->repository->getArticles($locale);
                foreach ($articles as $article) {
                    if (isset($article->seo)) {
                        $entries[] = [
                            'loc' => $article->seo->canonicalUrl,
                            'lastmod' => isset($article->updatedAtIso) ? substr((string) $article->updatedAtIso, 0, 10) : '2026-11-06',
                            'alternates' => $article->seo->alternates ?? ['id' => '', 'en' => '', 'xDefault' => ''],
                            'changefreq' => 'monthly',
                            'priority' => '0.7',
                        ];
                    }
                }
            }

            return $entries;
        }

        return [];
    }

    private function getBaseUrl(?string $baseUrl = null): string
    {
        if ($baseUrl !== null && $baseUrl !== '') {
            return rtrim($baseUrl, '/');
        }

        $configured = config('app.url');
        if (! empty($configured)) {
            return rtrim((string) $configured, '/');
        }

        if (app()->bound('request')) {
            return rtrim(request()->schemeAndHttpHost(), '/');
        }

        return 'http://localhost';
    }
}
