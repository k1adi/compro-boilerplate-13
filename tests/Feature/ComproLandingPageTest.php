<?php

declare(strict_types=1);

it('renders the indonesian landing page with full seo, schema graph, a11y landmarks, and zero em dashes', function () {
    $response = $this->get('/id');

    $response->assertOk()
        ->assertSee('lang="id"', false)
        ->assertSee('Rekayasa Rantai Dingin, Perpipaan Mekanikal, dan Otomasi Chiller untuk Fasilitas Industri.')
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
        ->assertSee('Cold-Chain Refrigeration, Mechanical Piping, and Chiller Plant Automation for Industrial Facilities.')
        ->assertSee('Schedule a Site Thermal Audit')
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
    'ID Service Detail SRV-01' => ['/id/layanan/instalasi-rantai-dingin', 'PIR/PUR'],
    'EN Service Detail SRV-01' => ['/en/services/cold-chain-installation', 'PIR/PUR'],
    'ID Case Studies Index' => ['/id/studi-kasus', 'CS-01'],
    'EN Case Studies Index' => ['/en/case-studies', 'CS-01'],
    'ID Case Study Detail' => ['/id/studi-kasus/cold-storage-distribusi-cikarang', 'Cikarang'],
    'EN Case Study Detail' => ['/en/case-studies/cikarang-cold-storage-hub', 'Cikarang'],
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
        'full_name' => 'Budi Santoso (MEP Manager)',
        'company_name' => 'PT Nusantara Pangan Dingin',
        'work_email' => 'budi.santoso@nusantarapangan.co.id',
        'phone_whatsapp' => '+62-812-8800-9900',
        'service_code' => 'SRV-01',
        'facility_location' => 'Kawasan Industri Jababeka II, Cikarang',
        'estimated_capacity' => '300 TR / 1.500 Pallet -22C',
        'project_brief' => 'Kami membutuhkan desain dan instalasi cold room kapasitas 1.500 pallet dengan target komisioning Q3.',
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

it('generates an xml sitemap with bilingual xhtml:link alternates and handles 301 legacy redirects', function () {
    $sitemap = $this->get('/sitemap.xml');

    $sitemap->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee('<urlset', false)
        ->assertSee('xhtml:link', false)
        ->assertSee('/id/layanan/instalasi-rantai-dingin', false)
        ->assertSee('/en/services/cold-chain-installation', false);

    $this->get('/about-us.html')->assertRedirect('/id/tentang-kami')->assertStatus(301);
    $this->get('/services.html')->assertRedirect('/id/layanan')->assertStatus(301);
    $this->get('/product-detail?id=1')->assertRedirect('/id/layanan/instalasi-rantai-dingin')->assertStatus(301);
    $this->get('/product-detail?id=4')->assertRedirect('/id/layanan/retrofit-otomasi-chiller')->assertStatus(301);
    $this->get('/projects.php')->assertRedirect('/id/studi-kasus')->assertStatus(301);
    $this->get('/contact-us.html')->assertRedirect('/id/hubungi-kami')->assertStatus(301);
});
