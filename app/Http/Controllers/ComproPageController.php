<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Mocks\ComproMockRepository;
use App\Data\Shared\SeoMetaData;
use App\Http\Requests\StoreInquiryRequest;
use App\Services\SchemaGraphBuilder;
use App\Services\SitemapGenerator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ComproPageController extends Controller
{
    public function __construct(
        private readonly ComproMockRepository $repository,
        private readonly SchemaGraphBuilder $schemaBuilder,
        private readonly SitemapGenerator $sitemapGenerator,
    ) {}

    public function redirectRoot(): RedirectResponse
    {
        return redirect()->route('compro.home', ['locale' => 'id']);
    }

    public function home(string $locale): View
    {
        $settings = $this->repository->getCompanySettings($locale);
        $page = $this->repository->getHomePageData($locale);

        return view('pages.home', [
            'settings' => $settings,
            'page' => $page,
            'seo' => $page->seo,
        ]);
    }

    public function about(string $locale): View
    {
        $isId = $locale === 'id';
        $settings = $this->repository->getCompanySettings($locale);
        $services = $this->repository->getServices($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $pageUrl = $baseUrl.($isId ? '/id/tentang-kami' : '/en/about');
        $title = ($isId ? 'Profil Engineering, Sertifikasi ISO/K3 & Workshop' : 'Engineering Profile, ISO/OHS Compliance & Workshop').' | '.$settings->brandName;

        $seo = new SeoMetaData(
            title: $title,
            description: $settings->valueProposition,
            canonicalUrl: $pageUrl,
            ogTitle: $title,
            ogDescription: $settings->valueProposition,
            alternates: [
                'id' => $baseUrl.'/id/tentang-kami',
                'en' => $baseUrl.'/en/about',
                'xDefault' => $baseUrl.'/id/tentang-kami',
            ],
            schemaGraph: $this->schemaBuilder->buildPageGraph(
                settings: $settings,
                locale: $locale,
                pageUrl: $pageUrl,
                pageTitle: $title,
                pageDescription: $settings->valueProposition,
                breadcrumbs: [
                    ['name' => $isId ? 'Beranda' : 'Home', 'url' => $baseUrl.'/'.$locale],
                    ['name' => $isId ? 'Tentang Kami' : 'About Us', 'url' => $pageUrl],
                ],
            ),
        );

        return view('pages.about', [
            'settings' => $settings,
            'services' => $services,
            'seo' => $seo,
        ]);
    }

    public function servicesIndex(string $locale): View
    {
        $isId = $locale === 'id';
        $settings = $this->repository->getCompanySettings($locale);
        $services = $this->repository->getServices($locale);
        $faqs = $this->repository->getFaqs($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $pageUrl = $baseUrl.($isId ? '/id/layanan' : '/en/services');
        $title = ($isId ? 'Layanan Instalasi Cold Storage, Chiller & Perpipaan Industri' : 'Industrial Cold Storage, Chiller & Piping Engineering Services').' | '.$settings->brandName;

        $seo = new SeoMetaData(
            title: $title,
            description: $settings->valueProposition,
            canonicalUrl: $pageUrl,
            ogTitle: $title,
            ogDescription: $settings->valueProposition,
            alternates: [
                'id' => $baseUrl.'/id/layanan',
                'en' => $baseUrl.'/en/services',
                'xDefault' => $baseUrl.'/id/layanan',
            ],
            schemaGraph: $this->schemaBuilder->buildPageGraph(
                settings: $settings,
                locale: $locale,
                pageUrl: $pageUrl,
                pageTitle: $title,
                pageDescription: $settings->valueProposition,
                breadcrumbs: [
                    ['name' => $isId ? 'Beranda' : 'Home', 'url' => $baseUrl.'/'.$locale],
                    ['name' => $isId ? 'Layanan Teknis' : 'Engineering Services', 'url' => $pageUrl],
                ],
                faqs: $faqs,
            ),
        );

        return view('pages.services.index', [
            'settings' => $settings,
            'services' => $services,
            'faqs' => $faqs,
            'seo' => $seo,
        ]);
    }

    public function serviceShow(string $locale, string $slug): View
    {
        $isId = $locale === 'id';
        $settings = $this->repository->getCompanySettings($locale);
        $service = $this->repository->findServiceBySlug($locale, $slug);

        if ($service === null) {
            abort(404);
        }

        $allStudies = $this->repository->getCaseStudies($locale);
        $relatedStudies = array_values(array_filter(
            $allStudies,
            fn ($study) => $study->relatedServiceCode === $service->code || in_array($study->slug, $service->relatedCaseStudySlugs, true),
        ));

        $allFaqs = $this->repository->getFaqs($locale);
        $relatedFaqs = array_values(array_filter(
            $allFaqs,
            fn ($faq) => $faq->relatedServiceCode === null || $faq->relatedServiceCode === $service->code,
        ));

        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $seo = new SeoMetaData(
            title: $service->seo->title,
            description: $service->seo->description,
            canonicalUrl: $service->seo->canonicalUrl,
            ogTitle: $service->seo->ogTitle,
            ogDescription: $service->seo->ogDescription,
            alternates: $service->seo->alternates,
            schemaGraph: $this->schemaBuilder->buildPageGraph(
                settings: $settings,
                locale: $locale,
                pageUrl: $service->seo->canonicalUrl,
                pageTitle: $service->seo->title,
                pageDescription: $service->seo->description,
                breadcrumbs: [
                    ['name' => $isId ? 'Beranda' : 'Home', 'url' => $baseUrl.'/'.$locale],
                    ['name' => $isId ? 'Layanan Teknis' : 'Engineering Services', 'url' => $baseUrl.($isId ? '/id/layanan' : '/en/services')],
                    ['name' => $service->title, 'url' => $service->seo->canonicalUrl],
                ],
                service: $service,
                faqs: $relatedFaqs,
            ),
        );

        return view('pages.services.show', [
            'settings' => $settings,
            'service' => $service,
            'allServices' => $this->repository->getServices($locale),
            'relatedStudies' => $relatedStudies,
            'relatedFaqs' => $relatedFaqs,
            'seo' => $seo,
        ]);
    }

    public function caseStudiesIndex(string $locale): View
    {
        $isId = $locale === 'id';
        $settings = $this->repository->getCompanySettings($locale);
        $caseStudies = $this->repository->getCaseStudies($locale);
        $services = $this->repository->getServices($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $pageUrl = $baseUrl.($isId ? '/id/studi-kasus' : '/en/case-studies');
        $title = ($isId ? 'Studi Kasus Proyek Cold Storage, Chiller & Perpipaan' : 'Industrial Cold Storage, Chiller & Piping Case Studies').' | '.$settings->brandName;

        $seo = new SeoMetaData(
            title: $title,
            description: $settings->valueProposition,
            canonicalUrl: $pageUrl,
            ogTitle: $title,
            ogDescription: $settings->valueProposition,
            alternates: [
                'id' => $baseUrl.'/id/studi-kasus',
                'en' => $baseUrl.'/en/case-studies',
                'xDefault' => $baseUrl.'/id/studi-kasus',
            ],
            schemaGraph: $this->schemaBuilder->buildPageGraph(
                settings: $settings,
                locale: $locale,
                pageUrl: $pageUrl,
                pageTitle: $title,
                pageDescription: $settings->valueProposition,
                breadcrumbs: [
                    ['name' => $isId ? 'Beranda' : 'Home', 'url' => $baseUrl.'/'.$locale],
                    ['name' => $isId ? 'Studi Kasus' : 'Case Studies', 'url' => $pageUrl],
                ],
            ),
        );

        return view('pages.case-studies.index', [
            'settings' => $settings,
            'caseStudies' => $caseStudies,
            'services' => $services,
            'seo' => $seo,
        ]);
    }

    public function caseStudyShow(string $locale, string $slug): View
    {
        $isId = $locale === 'id';
        $settings = $this->repository->getCompanySettings($locale);
        $study = $this->repository->findCaseStudyBySlug($locale, $slug);

        if ($study === null) {
            abort(404);
        }

        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $seo = new SeoMetaData(
            title: $study->seo->title,
            description: $study->seo->description,
            canonicalUrl: $study->seo->canonicalUrl,
            ogTitle: $study->seo->ogTitle,
            ogDescription: $study->seo->ogDescription,
            alternates: $study->seo->alternates,
            schemaGraph: $this->schemaBuilder->buildPageGraph(
                settings: $settings,
                locale: $locale,
                pageUrl: $study->seo->canonicalUrl,
                pageTitle: $study->seo->title,
                pageDescription: $study->seo->description,
                breadcrumbs: [
                    ['name' => $isId ? 'Beranda' : 'Home', 'url' => $baseUrl.'/'.$locale],
                    ['name' => $isId ? 'Studi Kasus' : 'Case Studies', 'url' => $baseUrl.($isId ? '/id/studi-kasus' : '/en/case-studies')],
                    ['name' => $study->title, 'url' => $study->seo->canonicalUrl],
                ],
            ),
        );

        return view('pages.case-studies.show', [
            'settings' => $settings,
            'study' => $study,
            'services' => $this->repository->getServices($locale),
            'seo' => $seo,
        ]);
    }

    public function contact(Request $request, string $locale): View
    {
        $isId = $locale === 'id';
        $settings = $this->repository->getCompanySettings($locale);
        $services = $this->repository->getServices($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $pageUrl = $baseUrl.($isId ? '/id/hubungi-kami' : '/en/contact');
        $title = ($isId ? 'Jadwalkan Audit Termal & Permintaan BoQ Teknis' : 'Schedule a Site Thermal Audit & Technical RFQ').' | '.$settings->brandName;

        $seo = new SeoMetaData(
            title: $title,
            description: $settings->valueProposition,
            canonicalUrl: $pageUrl,
            ogTitle: $title,
            ogDescription: $settings->valueProposition,
            alternates: [
                'id' => $baseUrl.'/id/hubungi-kami',
                'en' => $baseUrl.'/en/contact',
                'xDefault' => $baseUrl.'/id/hubungi-kami',
            ],
            schemaGraph: $this->schemaBuilder->buildPageGraph(
                settings: $settings,
                locale: $locale,
                pageUrl: $pageUrl,
                pageTitle: $title,
                pageDescription: $settings->valueProposition,
                breadcrumbs: [
                    ['name' => $isId ? 'Beranda' : 'Home', 'url' => $baseUrl.'/'.$locale],
                    ['name' => $isId ? 'Hubungi Kami' : 'Contact & RFQ', 'url' => $pageUrl],
                ],
            ),
        );

        return view('pages.contact', [
            'settings' => $settings,
            'services' => $services,
            'selectedServiceCode' => (string) $request->query('service', 'SRV-01'),
            'seo' => $seo,
        ]);
    }

    public function storeInquiry(StoreInquiryRequest $request, string $locale): JsonResponse|RedirectResponse
    {
        $validated = $request->safe()->only([
            'full_name',
            'company_name',
            'work_email',
            'phone_whatsapp',
            'service_code',
            'facility_location',
            'estimated_capacity',
            'project_brief',
        ]);

        $referenceCode = 'RFQ-'.now()->format('Ymd').'-'.Str::upper(Str::random(4));
        $isId = $locale === 'id';

        $responsePayload = [
            'status' => 'success',
            'reference_code' => $referenceCode,
            'message' => $isId
                ? "Permintaan teknis Anda telah tercatat dengan nomor referensi {$referenceCode}. Tim Application Engineer kami akan menghubungi {$validated['work_email']} / {$validated['phone_whatsapp']} dalam maksimal 4 jam kerja."
                : "Your technical inquiry has been logged under reference {$referenceCode}. Our Application Engineering desk will contact {$validated['work_email']} / {$validated['phone_whatsapp']} within 4 working hours.",
            'summary' => [
                'company_name' => $validated['company_name'],
                'service_code' => $validated['service_code'],
                'facility_location' => $validated['facility_location'],
            ],
        ];

        if ($request->expectsJson()) {
            return response()->json($responsePayload, 201);
        }

        return back()->with('rfq_success', $responsePayload);
    }

    public function sitemap(): Response
    {
        $entries = $this->sitemapGenerator->getEntries();

        return response()
            ->view('seo.sitemap', ['entries' => $entries], 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function legacyProductRedirect(Request $request): RedirectResponse
    {
        $id = (int) $request->query('id', 1);

        $slugMap = [
            1 => '/id/layanan/instalasi-rantai-dingin',
            2 => '/id/layanan/pemeliharaan-preventif-hvacr',
            3 => '/id/layanan/fabrikasi-mekanikal-pipa',
            4 => '/id/layanan/retrofit-otomasi-chiller',
        ];

        return redirect($slugMap[$id] ?? '/id/layanan', 301);
    }
}

