<?php

declare(strict_types=1);

it('renders the indonesian landing page with full seo, schema graph, a11y landmarks, and zero em dashes', function () {
    $response = $this->get('/id');

    $response->assertOk()
        ->assertSee('lang="id"', false)
        ->assertSee('Pendamping Hukum dan Perizinan Bisnis saat Perusahaan Anda Membutuhkannya.')
        ->assertSee('rel="canonical"', false)
        ->assertSee('hreflang="id"', false)
        ->assertSee('hreflang="en"', false)
        ->assertSee('hreflang="x-default"', false)
        ->assertSee('application/ld+json', false)
        ->assertSee('"@context":"https://schema.org"', false)
        ->assertSee('"@type":"Organization"', false)
        ->assertSee('"@type":"LocalBusiness"', false)
        ->assertSee('"@type":"FAQPage"', false)
        ->assertSee('fetchpriority="high"', false)
        ->assertSee('id="main-content"', false)
        ->assertSee('id="service-matrix"', false)
        ->assertSee('id="rfq-form"', false)
        ->assertSee('for="rfq-full-name"', false)
        ->assertSee('for="rfq-work-email"', false)
        ->assertSee('SRV-01')
        ->assertSee('SRV-04')
        ->assertSee('CS-01')
        ->assertSee('faq-01');

    $html = $response->getContent();
    expect($html)->not->toContain("\u{2014}")
        ->and($html)->not->toContain("\u{2013}")
        ->and($html)->not->toContain('&mdash;');
});

it('renders the english landing page with reciprocal hreflang and localized copy', function () {
    $response = $this->get('/en');

    $response->assertOk()
        ->assertSee('lang="en"', false)
        ->assertSee('Trusted Business and Legal Counsel When It Matters Most.')
        ->assertSee('Request a Free Consultation')
        ->assertSee('hreflang="id"', false)
        ->assertSee('hreflang="en"', false)
        ->assertSee('"@context":"https://schema.org"', false)
        ->assertSee('SRV-01')
        ->assertSee('CS-01')
        ->assertSee('faq-05');

    $html = $response->getContent();
    expect($html)->not->toContain("\u{2014}")
        ->and($html)->not->toContain("\u{2013}")
        ->and($html)->not->toContain('&mdash;');
});

it('renders all bilingual secondary pages so zero navigation or cta links are dead', function (string $url, string $expectedText) {
    $response = $this->get($url);

    $response->assertOk()
        ->assertSee($expectedText);
})->with([
    'ID Services Index' => ['/id/layanan', 'SRV-01'],
    'EN Services Index' => ['/en/services', 'SRV-01'],
    'ID Service Detail SRV-01' => ['/id/layanan/pendirian-badan-usaha', 'OSS RBA'],
    'EN Service Detail SRV-01' => ['/en/services/company-formation-licensing', 'OSS RBA'],
    'ID Case Studies Index' => ['/id/studi-kasus', 'CS-01'],
    'EN Case Studies Index' => ['/en/case-studies', 'CS-01'],
    'ID Case Study Detail' => ['/id/studi-kasus/pendirian-pt-pma-logistik-jakarta', 'Jakarta Selatan'],
    'EN Case Study Detail' => ['/en/case-studies/jakarta-logistics-pma-setup', 'Jakarta Selatan'],
    'ID About Page' => ['/id/tentang-kami', 'ISO 9001:2015'],
    'EN About Page' => ['/en/about', 'ISO 9001:2015'],
    'ID Contact Page' => ['/id/hubungi-kami', 'SRV-01'],
    'EN Contact Page' => ['/en/contact', 'SRV-01'],
]);

it('returns 404 for unknown service or case study slugs', function () {
    $this->get('/id/layanan/tidak-ada')->assertNotFound();
    $this->get('/en/case-studies/unknown-project')->assertNotFound();
});

it('processes a valid technical rfq inquiry via json and returns a ticket reference code', function () {
    $response = $this->postJson('/id/inquiries', [
        'full_name' => 'Budi Santoso (Direktur Operasional)',
        'company_name' => 'PT Nusantara Maju Bersama',
        'work_email' => 'budi.santoso@nusantaramaju.co.id',
        'phone_whatsapp' => '+62-812-8800-9900',
        'service_code' => 'SRV-01',
        'facility_location' => 'Jakarta Selatan',
        'estimated_capacity' => 'Pendirian PT Lokal bulan depan',
        'project_brief' => 'Kami membutuhkan pendampingan pendirian PT lokal beserta pengurusan NIB pada sistem OSS RBA.',
        'company_website_hp' => '',
    ]);

    $response->assertCreated()
        ->assertJsonPath('status', 'success')
        ->assertJsonStructure([
            'status',
            'reference_code',
            'message',
            'summary' => ['company_name', 'service_code', 'facility_location'],
        ]);

    expect($response->json('reference_code'))->toStartWith('RFQ-');
});

it('rejects invalid rfq submissions and spam honeypot payloads with 422 errors', function () {
    $invalidResponse = $this->postJson('/en/inquiries', [
        'full_name' => '',
        'company_name' => '',
        'work_email' => 'not-an-email',
        'phone_whatsapp' => '123',
        'service_code' => 'INVALID',
        'facility_location' => '',
        'project_brief' => 'Too short',
    ]);

    $invalidResponse->assertUnprocessable()
        ->assertJsonValidationErrors([
            'full_name',
            'company_name',
            'work_email',
            'phone_whatsapp',
            'service_code',
            'facility_location',
            'project_brief',
        ]);

    $honeypotResponse = $this->postJson('/id/inquiries', [
        'full_name' => 'Spam Bot',
        'company_name' => 'Bot Corp',
        'work_email' => 'bot@example.com',
        'phone_whatsapp' => '+628123456789',
        'service_code' => 'SRV-01',
        'facility_location' => 'Jakarta',
        'project_brief' => 'This is a sufficiently long project brief filled by an automated spam bot.',
        'company_website_hp' => 'https://spam-link.example.com',
    ]);

    $honeypotResponse->assertUnprocessable()
        ->assertJsonValidationErrors(['company_website_hp']);
});

it('generates a compliant robots.txt and modular xml sitemap index with child sitemaps and handles 301 legacy redirects', function () {
    $robots = $this->get('/robots.txt');

    $robots->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('User-agent: *', false)
        ->assertSee('Allow: /', false)
        ->assertSee('Disallow: /cms', false)
        ->assertSee('Sitemap: '.rtrim(config('app.url'), '/').'/sitemap.xml', false);

    config(['app.url' => 'https://example.com']);
    $customRobots = $this->get('/robots.txt');
    $customRobots->assertOk()
        ->assertSee('Sitemap: https://example.com/sitemap.xml', false);
    config(['app.url' => 'http://localhost:8000']);

    // 1. Parent Sitemap Index
    $sitemapIndex = $this->get('/sitemap.xml');
    $sitemapIndex->assertOk()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
        ->assertSee('xml-stylesheet', false)
        ->assertSee('sitemap.css', false)
        ->assertDontSee('sitemap.xsl')
        ->assertSee('<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false)
        ->assertSee('/main-sitemap.xml', false)
        ->assertSee('/services-sitemap.xml', false)
        ->assertSee('/case-studies-sitemap.xml', false)
        ->assertSee('/articles-sitemap.xml', false);

    // 2. Main static pages child sitemap
    $mainSitemap = $this->get('/main-sitemap.xml');
    $mainSitemap->assertOk()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
        ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false)
        ->assertSee('/id/tentang-kami', false)
        ->assertSee('/en/about', false)
        ->assertSee('xhtml:link', false);

    // 3. Services child sitemap
    $servicesSitemap = $this->get('/services-sitemap.xml');
    $servicesSitemap->assertOk()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
        ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false)
        ->assertSee('<lastmod>', false)
        ->assertSee('xhtml:link', false)
        ->assertSee('/id/layanan/pendirian-badan-usaha', false)
        ->assertSee('/en/services/company-formation-licensing', false);

    // 4. Case studies child sitemap
    $caseStudiesSitemap = $this->get('/case-studies-sitemap.xml');
    $caseStudiesSitemap->assertOk()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
        ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false)
        ->assertSee('/id/studi-kasus/pendirian-pt-pma-logistik-jakarta', false)
        ->assertSee('/en/case-studies/jakarta-logistics-pma-setup', false);

    // 5. Articles child sitemap
    $articlesSitemap = $this->get('/articles-sitemap.xml');
    $articlesSitemap->assertOk()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
        ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false);

    // 6. Child sitemap aliases
    $this->get('/sitemap_index.xml')->assertOk()->assertSee('<sitemapindex', false);
    $this->get('/sitemap-main.xml')->assertOk()->assertSee('<urlset', false);
    $this->get('/sitemap-services.xml')->assertOk()->assertSee('<urlset', false);

    // 7. Legacy 301 redirects
    $this->get('/about-us.html')->assertRedirect('/id/tentang-kami')->assertStatus(301);
    $this->get('/services.html')->assertRedirect('/id/layanan')->assertStatus(301);
    $this->get('/product-detail?id=1')->assertRedirect('/id/layanan/pendirian-badan-usaha')->assertStatus(301);
    $this->get('/product-detail?id=4')->assertRedirect('/id/layanan/pendampingan-transaksi-bisnis')->assertStatus(301);
    $this->get('/projects.php')->assertRedirect('/id/studi-kasus')->assertStatus(301);
    $this->get('/contact-us.html')->assertRedirect('/id/hubungi-kami')->assertStatus(301);
});
