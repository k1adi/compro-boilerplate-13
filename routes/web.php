<?php

declare(strict_types=1);

use App\Http\Controllers\ComproPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComproPageController::class, 'redirectRoot'])->name('compro.root');
Route::get('/robots.txt', [ComproPageController::class, 'robots'])->name('compro.robots');
Route::get('/sitemap.xml', [ComproPageController::class, 'sitemap'])->name('compro.sitemap');
Route::get('/sitemap_index.xml', [ComproPageController::class, 'sitemapIndex'])->name('compro.sitemap.index');
Route::get('/{section}-sitemap.xml', [ComproPageController::class, 'sitemapSection'])
    ->whereIn('section', ['main', 'pages', 'services', 'products', 'case-studies', 'articles', 'posts', 'blog', 'all'])
    ->name('compro.sitemap.section');
Route::get('/sitemap-{section}.xml', [ComproPageController::class, 'sitemapSection'])
    ->whereIn('section', ['main', 'pages', 'services', 'products', 'case-studies', 'articles', 'posts', 'blog', 'all']);

// Legacy 301 SEO Redirects (from docs/knowledge-base.md Section 7)
Route::redirect('/index.html', '/id', 301);
Route::redirect('/home', '/id', 301);
Route::redirect('/about-us.html', '/id/tentang-kami', 301);
Route::redirect('/services.html', '/id/layanan', 301);
Route::get('/product-detail', [ComproPageController::class, 'legacyProductRedirect']);
Route::redirect('/projects.php', '/id/studi-kasus', 301);
Route::redirect('/contact-us.html', '/id/hubungi-kami', 301);

Route::prefix('{locale}')
    ->whereIn('locale', ['id', 'en'])
    ->middleware(['set.locale'])
    ->group(function (): void {
        Route::get('/', [ComproPageController::class, 'home'])->name('compro.home');

        // Indonesian & English localized route pairs
        Route::get('/tentang-kami', [ComproPageController::class, 'about'])->name('compro.about.id');
        Route::get('/about', [ComproPageController::class, 'about'])->name('compro.about.en');

        Route::get('/layanan', [ComproPageController::class, 'servicesIndex'])->name('compro.services.index.id');
        Route::get('/services', [ComproPageController::class, 'servicesIndex'])->name('compro.services.index.en');

        Route::get('/layanan/{slug}', [ComproPageController::class, 'serviceShow'])->name('compro.services.show.id');
        Route::get('/services/{slug}', [ComproPageController::class, 'serviceShow'])->name('compro.services.show.en');

        Route::get('/studi-kasus', [ComproPageController::class, 'caseStudiesIndex'])->name('compro.case_studies.index.id');
        Route::get('/case-studies', [ComproPageController::class, 'caseStudiesIndex'])->name('compro.case_studies.index.en');

        Route::get('/studi-kasus/{slug}', [ComproPageController::class, 'caseStudyShow'])->name('compro.case_studies.show.id');
        Route::get('/case-studies/{slug}', [ComproPageController::class, 'caseStudyShow'])->name('compro.case_studies.show.en');

        Route::get('/hubungi-kami', [ComproPageController::class, 'contact'])->name('compro.contact.id');
        Route::get('/contact', [ComproPageController::class, 'contact'])->name('compro.contact.en');

        Route::post('/inquiries', [ComproPageController::class, 'storeInquiry'])
            ->middleware('throttle:10,1')
            ->name('compro.inquiries.store');
    });
