<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CompanySettingsData;
use App\Data\FaqItemData;
use App\Data\ServiceData;

class SchemaGraphBuilder
{
    /**
     * @param  array<int, array{name: string, url: string}>  $breadcrumbs
     * @param  array<int, FaqItemData>  $faqs
     * @return array<int, array<string, mixed>>
     */
    public function buildPageGraph(
        CompanySettingsData $settings,
        string $locale,
        string $pageUrl,
        string $pageTitle,
        string $pageDescription,
        array $breadcrumbs = [],
        ?ServiceData $service = null,
        array $faqs = [],
    ): array {
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $orgId = $baseUrl.'/#organization';
        $localBusinessId = $baseUrl.'/#localbusiness';
        $websiteId = $baseUrl.'/#website';

        $graph = [
            [
                '@type' => 'Organization',
                '@id' => $orgId,
                'name' => $settings->brandName,
                'legalName' => $settings->legalName,
                'foundingDate' => (string) $settings->foundingYear,
                'url' => $baseUrl.'/'.$locale,
                'description' => $settings->valueProposition,
                'email' => $settings->engineeringEmail,
                'telephone' => $settings->primaryPhone,
                'sameAs' => array_values($settings->sameAsUrls),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $settings->hqAddress,
                    'addressLocality' => 'Cikarang Selatan, Bekasi',
                    'addressRegion' => 'Jawa Barat',
                    'postalCode' => '17530',
                    'addressCountry' => 'ID',
                ],
                'contactPoint' => [
                    [
                        '@type' => 'ContactPoint',
                        'telephone' => $settings->whatsappLeadNumber,
                        'contactType' => 'technical support',
                        'email' => $settings->engineeringEmail,
                        'availableLanguage' => ['Indonesian', 'English'],
                        'areaServed' => 'ID',
                    ],
                ],
            ],
            [
                '@type' => 'LocalBusiness',
                '@id' => $localBusinessId,
                'name' => $settings->brandName,
                'url' => $baseUrl.'/'.$locale,
                'telephone' => $settings->primaryPhone,
                'email' => $settings->engineeringEmail,
                'parentOrganization' => ['@id' => $orgId],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $settings->hqAddress,
                    'addressLocality' => 'Cikarang Selatan, Bekasi',
                    'addressRegion' => 'Jawa Barat',
                    'postalCode' => '17530',
                    'addressCountry' => 'ID',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => $settings->geoCoordinates['lat'],
                    'longitude' => $settings->geoCoordinates['lng'],
                ],
            ],
            [
                '@type' => 'WebSite',
                '@id' => $websiteId,
                'url' => $baseUrl.'/'.$locale,
                'name' => $settings->brandName,
                'inLanguage' => $locale === 'id' ? 'id-ID' : 'en-US',
                'publisher' => ['@id' => $orgId],
            ],
            [
                '@type' => 'WebPage',
                '@id' => $pageUrl.'#webpage',
                'url' => $pageUrl,
                'name' => $pageTitle,
                'description' => $pageDescription,
                'inLanguage' => $locale === 'id' ? 'id-ID' : 'en-US',
                'isPartOf' => ['@id' => $websiteId],
                'about' => ['@id' => $orgId],
            ],
        ];

        if ($breadcrumbs !== []) {
            $itemList = [];
            foreach (array_values($breadcrumbs) as $index => $crumb) {
                $itemList[] = [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $crumb['name'],
                    'item' => $crumb['url'],
                ];
            }

            $graph[] = [
                '@type' => 'BreadcrumbList',
                '@id' => $pageUrl.'#breadcrumb',
                'itemListElement' => $itemList,
            ];
        }

        if ($service !== null) {
            $graph[] = [
                '@type' => 'Service',
                '@id' => $pageUrl.'#service',
                'name' => $service->title,
                'serviceType' => $service->code,
                'description' => $service->problemSolved,
                'provider' => ['@id' => $orgId],
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => 'Indonesia',
                ],
            ];
        }

        if ($faqs !== []) {
            $faqEntities = [];
            foreach ($faqs as $faq) {
                $faqEntities[] = [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ];
            }

            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $pageUrl.'#faq',
                'mainEntity' => $faqEntities,
            ];
        }

        return $graph;
    }
}
