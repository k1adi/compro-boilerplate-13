<?php

declare(strict_types=1);

namespace App\Data\Mocks;

use App\Data\CaseStudyData;
use App\Data\CompanySettingsData;
use App\Data\FaqItemData;
use App\Data\HomePageData;
use App\Data\ServiceData;
use App\Data\Shared\ActionLinkData;
use App\Data\Shared\CertificationData;
use App\Data\Shared\MediaAssetData;
use App\Data\Shared\MetricProofData;
use App\Data\Shared\SeoMetaData;
use App\Services\SchemaGraphBuilder;

class ComproMockRepository
{
    public function __construct(
        private readonly SchemaGraphBuilder $schemaBuilder,
    ) {}

    public function getCompanySettings(string $locale): CompanySettingsData
    {
        $isId = $locale === 'id';

        return new CompanySettingsData(
            legalName: 'PT Koolom Mitra Konsultan',
            brandName: 'Koolom Partners',
            foundingYear: 2014,
            kbliCodes: ['70209', '69101'],
            valueProposition: $isId
                ? 'Kami membantu perusahaan merapikan perizinan usaha, menyusun kontrak bisnis yang aman, dan mengelola kepatuhan regulasi secara praktis dengan estimasi biaya tertulis yang transparan.'
                : 'We help businesses secure corporate licenses, draft clear commercial contracts, and manage regulatory compliance with transparent, upfront fee estimates.',
            hqAddress: 'Gedung Menara Sudirman Lt. 15, Jl. Jend. Sudirman Kav. 60, Kebayoran Baru, Jakarta Selatan 12190, Indonesia',
            branchAddress: 'Graha Pangeran Lt. 8, Jl. Ahmad Yani No. 286, Gayungan, Surabaya, Jawa Timur 60234, Indonesia',
            geoCoordinates: ['lat' => -6.2246, 'lng' => 106.8096],
            officeHours: $isId
                ? 'Senin s/d Jumat: 09:00 s/d 18:00 WIB'
                : 'Monday to Friday: 09:00 to 18:00 WIB',
            emergencySlaHours: $isId
                ? 'Respon Konsultasi Cepat < 24 Jam Kerja (Senin s/d Sabtu)'
                : 'Fast Consultation Reply < 24 Business Hours (Monday to Saturday)',
            primaryPhone: '+62-21-5200-4180',
            whatsappLeadNumber: '+62-811-9040-180',
            engineeringEmail: 'consult@koolom.co.id',
            generalEmail: 'info@koolom.co.id',
            sameAsUrls: [
                'linkedin' => 'https://www.linkedin.com/company/koolom-partners',
                'youtube' => 'https://www.youtube.com/@koolom-partners',
            ],
            metrics: [
                new MetricProofData(
                    id: 'metric-response',
                    label: $isId ? 'Respon Konsultasi' : 'Consultation Reply',
                    exactFigure: $isId ? '< 24 Jam' : '< 24 Hours',
                    contextNote: $isId
                        ? 'Waktu tanggap tertulis untuk setiap permohonan konsultasi baru'
                        : 'Written response time for every new client inquiry',
                    isSamplePlaceholder: true,
                ),
                new MetricProofData(
                    id: 'metric-clients',
                    label: $isId ? 'Klien Bisnis Terbantu' : 'Business Clients Served',
                    exactFigure: $isId ? '450+ Klien' : '450+ Clients',
                    contextNote: $isId
                        ? 'Perusahaan lokal dan PMA yang didampingi sejak 2014'
                        : 'Local and foreign-invested companies advised since 2014',
                    isSamplePlaceholder: true,
                ),
                new MetricProofData(
                    id: 'metric-years',
                    label: $isId ? 'Pengalaman Praktik' : 'Years of Practice',
                    exactFigure: $isId ? '12 Tahun' : '12 Years',
                    contextNote: $isId
                        ? 'Mendampingi pendirian usaha, kontrak, dan kepatuhan bisnis'
                        : 'Advising on company setup, contracts, and compliance',
                    isSamplePlaceholder: true,
                ),
                new MetricProofData(
                    id: 'metric-cases',
                    label: $isId ? 'Dokumen & Proyek Selesai' : 'Matters Completed',
                    exactFigure: $isId ? '1.200+ Proyek' : '1,200+ Matters',
                    contextNote: $isId
                        ? 'Kontrak komersial, izin usaha OSS, dan audit kepatuhan selesai'
                        : 'Commercial contracts, OSS licenses, and compliance audits delivered',
                    isSamplePlaceholder: true,
                ),
            ],
            certifications: [
                new CertificationData(
                    standardCode: 'ISO 9001:2015',
                    scope: $isId
                        ? 'Sistem Manajemen Mutu Layanan Konsultasi Bisnis & Korporasi'
                        : 'Quality Management System for Corporate & Business Advisory',
                    issuingBody: 'TUV Rheinland',
                    referenceNumber: 'ID-QMS-9001-SEED',
                    isSamplePlaceholder: true,
                ),
                new CertificationData(
                    standardCode: 'PERADI & AKHKI',
                    scope: $isId
                        ? 'Konsultan Hukum Korporasi & Perizinan Investasi Terdaftar'
                        : 'Registered Corporate Legal & Investment Licensing Advisors',
                    issuingBody: 'PERADI & AKHKI',
                    referenceNumber: 'REG-ADV-2014-SEED',
                    isSamplePlaceholder: true,
                ),
                new CertificationData(
                    standardCode: 'IKPI Certified',
                    scope: $isId
                        ? 'Konsultan Kepatuhan Pajak Korporasi & Audit Regulasi Usaha'
                        : 'Certified Corporate Tax & Regulatory Compliance Advisors',
                    issuingBody: 'IKPI',
                    referenceNumber: 'REG-TAX-2016-SEED',
                    isSamplePlaceholder: true,
                ),
            ],
            clientSectorDescriptors: $isId
                ? [
                    'Perusahaan Teknologi & Startup SaaS (Jakarta Selatan)',
                    'Distributor Perdagangan & Ritel Modern (Surabaya & Jakarta)',
                    'Perusahaan Manufaktur & Penanaman Modal Asing / PMA (Bekasi & Karawang)',
                    'Grup Properti Komersial & Perhotelan (Jakarta & Bali)',
                ]
                : [
                    'Technology & B2B SaaS Companies (South Jakarta)',
                    'Commercial Distribution & Modern Retail Networks (Surabaya & Jakarta)',
                    'Foreign-Invested Manufacturing / PT PMA Entities (Bekasi & Karawang)',
                    'Commercial Real Estate & Hospitality Groups (Jakarta & Bali)',
                ],
            isSampleBoilerplate: true,
        );
    }

    /**
     * @return array<int, ServiceData>
     */
    public function getServices(string $locale): array
    {
        $isId = $locale === 'id';
        $settings = $this->getCompanySettings($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');

        $rawServices = [
            [
                'code' => 'SRV-01',
                'slug' => [
                    'id' => 'pendirian-badan-usaha',
                    'en' => 'company-formation-licensing',
                ],
                'title' => [
                    'id' => 'Pendirian Badan Usaha & Perizinan OSS',
                    'en' => 'Company Formation & Business Licensing',
                ],
                'targetSegment' => [
                    'id' => 'Pendiri bisnis baru, UMKM yang bertransformasi menjadi PT, serta investor asing (PT PMA).',
                    'en' => 'Business founders, growing SMEs incorporating as a PT, and foreign investors establishing a PT PMA.',
                ],
                'problemSolved' => [
                    'id' => 'Memastikan pendirian PT, pemilihan kode KBLI, dan penerbitan izin usaha OSS RBA selesai tepat waktu tanpa penolakan berkas atau kesalahan struktur kepemilikan saham.',
                    'en' => 'Ensures company incorporation, KBLI code selection, and OSS RBA business licensing are completed accurately without filing rejections or shareholding structure mistakes.',
                ],
                'deliverables' => [
                    'id' => [
                        'Pemeriksaan nama PT, penyusunan Akta Pendirian Notaris, dan pengesahan SK Kemenkumham RI.',
                        'Pemetaan kode KBLI 2020 yang tepat sesuai aktivitas bisnis riil serta pengurusan NPWP Badan.',
                        'Penerbitan Nomor Induk Berusaha (NIB), Sertifikat Standar, dan izin operasional berbasis risiko pada sistem OSS RBA.',
                        'Penyusunan Anggaran Dasar dan Perjanjian Pemegang Saham (Shareholders Agreement) awal.',
                    ],
                    'en' => [
                        'Company name reservation, Notarial Deed of Establishment, and Ministry of Law (Kemenkumham) ratification decree.',
                        'Accurate KBLI business classification mapping and corporate Tax ID (NPWP) registration.',
                        'Risk-based Business Identification Number (NIB) and operational license issuance via OSS RBA.',
                        'Initial Articles of Association and foundational Shareholders Agreement drafting.',
                    ],
                ],
                'specs' => [
                    'id' => [
                        ['parameter' => 'Bentuk Badan Usaha', 'value' => 'PT Lokal, PT PMA & CV'],
                        ['parameter' => 'Sistem Perizinan', 'value' => 'OSS RBA & AHU Online'],
                        ['parameter' => 'Estimasi Penyelesaian', 'value' => '5 s/d 18 Hari Kerja'],
                        ['parameter' => 'Skema Biaya', 'value' => 'Paket Biaya Tetap (Fixed Fee)'],
                    ],
                    'en' => [
                        ['parameter' => 'Entity Types', 'value' => 'Local PT, PT PMA & CV'],
                        ['parameter' => 'Licensing System', 'value' => 'OSS RBA & AHU Online'],
                        ['parameter' => 'Estimated Turnaround', 'value' => '5 to 18 Business Days'],
                        ['parameter' => 'Fee Structure', 'value' => 'Upfront Fixed-Fee Package'],
                    ],
                ],
                'steps' => [
                    'id' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Konsultasi Awal Gratis',
                            'description' => 'Diskusi rencana bisnis, komposisi pemegang saham, dan pemetaan kode KBLI yang sesuai.',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Estimasi Biaya Tertulis',
                            'description' => 'Penyampaian rincian biaya resmi dan daftar dokumen persyaratan di awal tanpa biaya tersembunyi.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Penyusunan Akta & Pengajuan',
                            'description' => 'Penyusunan draf akta pendirian, penandatanganan notaris, dan pengajuan pengesahan Kemenkumham.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Penerbitan NIB & Serah Terima',
                            'description' => 'Penerbitan NIB/izin usaha OSS RBA dan penyerahan bundel dokumen legal perusahaan lengkap.',
                        ],
                    ],
                    'en' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Free Initial Consultation',
                            'description' => 'Discuss your business model, shareholding structure, and appropriate KBLI classifications.',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Transparent Written Quote',
                            'description' => 'Receive an itemized fixed-fee quote and document checklist upfront with zero hidden charges.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Deed Drafting & Filing',
                            'description' => 'Prepare the incorporation deed, execute notarial signing, and secure Ministry ratification.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'NIB Issuance & Handover',
                            'description' => 'Issue your OSS RBA NIB and operational licenses with a complete corporate legal binder.',
                        ],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Konsultasi Pendirian Usaha',
                    'en' => 'Start Company Formation',
                ],
                'relatedStudies' => ['pendirian-pt-pma-logistik-jakarta', 'jakarta-logistics-pma-setup'],
            ],
            [
                'code' => 'SRV-02',
                'slug' => [
                    'id' => 'penyusunan-kontrak-bisnis',
                    'en' => 'corporate-contract-drafting',
                ],
                'title' => [
                    'id' => 'Penyusunan Kontrak Bisnis & Perjanjian Komersial',
                    'en' => 'Corporate Contract Drafting & Review',
                ],
                'targetSegment' => [
                    'id' => 'Perusahaan B2B, distributor, vendor layanan, dan tim manajemen dalam transaksi komersial.',
                    'en' => 'B2B companies, distributors, service vendors, and management teams in commercial deals.',
                ],
                'problemSolved' => [
                    'id' => 'Mencegah sengketa pembayaran, wanprestasi vendor, dan kebocoran rahasia dagang melalui kontrak berbahasa jelas yang melindungi posisi bisnis Anda.',
                    'en' => 'Prevents payment disputes, vendor defaults, and confidentiality breaches through plain-language contracts that protect your commercial position.',
                ],
                'deliverables' => [
                    'id' => [
                        'Penyusunan dan peninjauan (review) Perjanjian Kerja Sama (MoU/PKS), Kontrak Vendor, dan Perjanjian Distribusi.',
                        'Penyusunan Perjanjian Kerahasiaan (NDA), Perjanjian Kerja (PKWT/PKWTT), dan Peraturan Perusahaan.',
                        'Daftar risiko klausul (redline risk summary) beserta rekomendasi negosiasi yang praktis.',
                        'Tersedia dalam format dwibahasa (Bahasa Indonesia & Bahasa Inggris) sesuai kewajiban UU Bahasa.',
                    ],
                    'en' => [
                        'Drafting and review of Master Service Agreements (MSA), Vendor Contracts, and Distribution Agreements.',
                        'Non-Disclosure Agreements (NDA), Employment Contracts, and Company Regulations.',
                        'Clear redline risk summaries with practical negotiation fallback clauses.',
                        'Delivered in compliant bilingual format (Indonesian and English) per statutory requirements.',
                    ],
                ],
                'specs' => [
                    'id' => [
                        ['parameter' => 'Waktu Review Kontrak', 'value' => '2 s/d 3 Hari Kerja'],
                        ['parameter' => 'Penyusunan Kontrak Baru', 'value' => '3 s/d 5 Hari Kerja'],
                        ['parameter' => 'Format Bahasa', 'value' => 'Indonesia, Inggris, atau Dwibahasa'],
                        ['parameter' => 'Revisi Termasuk', 'value' => '2 Putaran Revisi Negosiasi'],
                    ],
                    'en' => [
                        ['parameter' => 'Contract Review SLA', 'value' => '2 to 3 Business Days'],
                        ['parameter' => 'Custom Drafting SLA', 'value' => '3 to 5 Business Days'],
                        ['parameter' => 'Language Format', 'value' => 'Indonesian, English, or Bilingual'],
                        ['parameter' => 'Included Revisions', 'value' => '2 Rounds of Negotiation Edits'],
                    ],
                ],
                'steps' => [
                    'id' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Pemetaan Transaksi',
                            'description' => 'Memahami tujuan transaksi, nilai komersial, dan potensi risiko utama yang ingin dihindari.',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Penawaran Biaya Tetap',
                            'description' => 'Penetapan biaya penyusunan atau review per dokumen secara transparan sebelum kerja dimulai.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Penyusunan & Redlining',
                            'description' => 'Pengerjaan draf kontrak atau koreksi klausul dalam 2 hingga 5 hari kerja.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Finalisasi & Panduan Negosiasi',
                            'description' => 'Penyerahan kontrak siap tanda tangan disertai sesi penjelasan poin krusial.',
                        ],
                    ],
                    'en' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Deal Scoping',
                            'description' => 'Understand your commercial goals, payment terms, and key operational risks.',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Fixed Fee Estimate',
                            'description' => 'Confirm a transparent per-document drafting or review fee before work starts.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Drafting & Redlining',
                            'description' => 'Deliver a custom contract draft or annotated redline review within 2 to 5 business days.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Finalization & Briefing',
                            'description' => 'Hand over execution-ready contracts with a practical walkthrough of key negotiation points.',
                        ],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Ajukan Review Kontrak',
                    'en' => 'Request Contract Review',
                ],
                'relatedStudies' => ['restrukturisasi-kontrak-ritel-surabaya', 'surabaya-retail-contract-overhaul'],
            ],
            [
                'code' => 'SRV-03',
                'slug' => [
                    'id' => 'kepatuhan-regulasi-retainer',
                    'en' => 'regulatory-compliance-retainer',
                ],
                'title' => [
                    'id' => 'Audit Kepatuhan Regulasi & Layanan Retainer Korporasi',
                    'en' => 'Regulatory Compliance & Corporate Legal Retainer',
                ],
                'targetSegment' => [
                    'id' => 'Perusahaan berkembang yang membutuhkan pendampingan hukum dan kepatuhan rutin setiap bulan.',
                    'en' => 'Growing companies needing ongoing monthly legal and regulatory support.',
                ],
                'problemSolved' => [
                    'id' => 'Memastikan seluruh izin operasional, pelaporan LKPM, dan dokumen korporasi selalu patuh pada aturan terbaru sambil menyediakan akses konsultasi langsung kapan pun dibutuhkan.',
                    'en' => 'Keeps operational licenses, LKPM investment filings, and corporate governance records up to date while providing on-demand access to senior advisors.',
                ],
                'deliverables' => [
                    'id' => [
                        'Kuota jam konsultasi bulanan terdedikasi dengan konsultan senior untuk diskusi operasional harian.',
                        'Pelaporan Kegiatan Penanaman Modal (LKPM) berkala dan pembaruan masa berlaku izin usaha.',
                        'Penyusunan risalah RUPS Tahunan/Luar Biasa, perubahan pengurus, dan administrasi korporasi.',
                        'Audit kepatuhan berkala terhadap regulasi ketenagakerjaan, perlindungan data, dan kemitraan usaha.',
                    ],
                    'en' => [
                        'Dedicated monthly advisory hours with senior consultants for day-to-day operational questions.',
                        'Quarterly Investment Activity Report (LKPM) filings and license renewal tracking.',
                        'Annual and Extraordinary General Meeting (GMS) resolutions, director changes, and corporate secretarial upkeep.',
                        'Periodic compliance health checks covering employment, data privacy, and commercial regulations.',
                    ],
                ],
                'specs' => [
                    'id' => [
                        ['parameter' => 'Model Kerja Sama', 'value' => 'Retainer Bulanan / Kuartalan'],
                        ['parameter' => 'Konsultan Pendamping', 'value' => 'Konsultan Senior Terdedikasi'],
                        ['parameter' => 'Pelaporan Wajib', 'value' => 'LKPM, RUPS Tahunan & Perizinan'],
                        ['parameter' => 'Waktu Tanggap', 'value' => 'Prioritas < 24 Jam Kerja'],
                    ],
                    'en' => [
                        ['parameter' => 'Engagement Model', 'value' => 'Monthly / Quarterly Retainer'],
                        ['parameter' => 'Assigned Advisor', 'value' => 'Dedicated Senior Consultant'],
                        ['parameter' => 'Statutory Filings', 'value' => 'LKPM, Annual GMS & Permits'],
                        ['parameter' => 'Response SLA', 'value' => 'Priority < 24 Business Hours'],
                    ],
                ],
                'steps' => [
                    'id' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Pemeriksaan Kesehatan Legal',
                            'description' => 'Evaluasi status izin usaha, kontrak aktif, dan kewajiban pelaporan perusahaan saat ini.',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Pemilihan Paket Retainer',
                            'description' => 'Penentuan kuota jam layanan bulanan yang sesuai dengan skala aktivitas perusahaan.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Pendampingan Rutin Bulanan',
                            'description' => 'Penanganan review kontrak harian, tanya-jawab regulasi, dan pelaporan wajib.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Evaluasi Kuartalan',
                            'description' => 'Laporan ringkas seluruh pekerjaan yang diselesaikan dan jadwal kepatuhan berikutnya.',
                        ],
                    ],
                    'en' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Compliance Health Check',
                            'description' => 'Review current business permits, active contracts, and statutory filing obligations.',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Retainer Plan Selection',
                            'description' => 'Select a monthly advisory allocation tailored to your company transaction volume.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Ongoing Monthly Advisory',
                            'description' => 'Handle day-to-day contract reviews, regulatory questions, and mandatory filings.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Quarterly Compliance Report',
                            'description' => 'Receive a clear summary of completed matters and upcoming regulatory deadlines.',
                        ],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Lihat Paket Retainer Bulanan',
                    'en' => 'Explore Monthly Retainer Plans',
                ],
                'relatedStudies' => [],
            ],
            [
                'code' => 'SRV-04',
                'slug' => [
                    'id' => 'pendampingan-transaksi-bisnis',
                    'en' => 'business-transaction-advisory',
                ],
                'title' => [
                    'id' => 'Pendampingan Transaksi Bisnis, Akuisisi & Uji Tuntas (Due Diligence)',
                    'en' => 'Business Transactions, M&A & Legal Due Diligence',
                ],
                'targetSegment' => [
                    'id' => 'Pemilik bisnis, investor, dan korporasi yang merencanakan investasi, joint venture, atau akuisisi usaha.',
                    'en' => 'Business owners, investors, and corporations planning investments, joint ventures, or acquisitions.',
                ],
                'problemSolved' => [
                    'id' => 'Mengidentifikasi risiko tersembunyi pada perusahaan target (utang, sengketa, atau izin tidak lengkap) sebelum Anda menandatangani perjanjian investasi atau akuisisi.',
                    'en' => 'Identifies hidden liabilities in target companies (undisclosed debts, disputes, or missing permits) before you sign investment or acquisition agreements.',
                ],
                'deliverables' => [
                    'id' => [
                        'Pemeriksaan Uji Tuntas Hukum (Legal Due Diligence) menyeluruh atas aset, perizinan, kontrak, dan status sengketa.',
                        'Penyusunan Term Sheet, Conditional Sale and Purchase Agreement (CSPA), dan Akta Jual Beli Saham.',
                        'Pengurusan pengumuman koran, persetujuan kreditur/pemegang saham, dan pelaporan perubahan kepemilikan.',
                        'Pendampingan langsung di meja negosiasi hingga penutupan transaksi (closing).',
                    ],
                    'en' => [
                        'Comprehensive Legal Due Diligence (LDD) covering corporate permits, material contracts, assets, and litigation records.',
                        'Drafting of Term Sheets, Conditional Share Purchase Agreements (CSPA), and Transfer Deeds.',
                        'Statutory newspaper announcements, shareholder approvals, and post-closing ministry notifications.',
                        'Direct representation across negotiation sessions through final transaction closing.',
                    ],
                ],
                'specs' => [
                    'id' => [
                        ['parameter' => 'Cakupan Transaksi', 'value' => 'Akuisisi Saham, Aset & Joint Venture'],
                        ['parameter' => 'Durasi Uji Tuntas (LDD)', 'value' => '10 s/d 14 Hari Kerja'],
                        ['parameter' => 'Output Utama', 'value' => 'Laporan Risiko Eksekutif & CSPA'],
                        ['parameter' => 'Kerahasiaan', 'value' => 'Dilindungi NDA Sejak Hari Pertama'],
                    ],
                    'en' => [
                        ['parameter' => 'Transaction Scope', 'value' => 'Share M&A, Asset Deal & Joint Venture'],
                        ['parameter' => 'Due Diligence Window', 'value' => '10 to 14 Business Days'],
                        ['parameter' => 'Key Deliverables', 'value' => 'Executive Red-Flag Report & CSPA'],
                        ['parameter' => 'Confidentiality', 'value' => 'Strict Mutual NDA Protection'],
                    ],
                ],
                'steps' => [
                    'id' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Diskusi Struktur Transaksi',
                            'description' => 'Penentuan skema transaksi paling efisien (akuisisi saham, pembelian aset, atau joint venture).',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Pelaksanaan Uji Tuntas',
                            'description' => 'Pemeriksaan dokumen perusahaan target dan penyusunan laporan temuan risiko eksekutif.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Penyusunan & Negosiasi',
                            'description' => 'Penyusunan perjanjian transaksi dengan klausul jaminan dan ganti rugi yang melindungi posisi Anda.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Penutupan & Pasca-Transaksi',
                            'description' => 'Penandatanganan akta transaksi, pembaruan daftar pemegang saham, dan serah terima dokumen.',
                        ],
                    ],
                    'en' => [
                        [
                            'stepNumber' => 1,
                            'title' => 'Transaction Structuring',
                            'description' => 'Determine the most effective deal structure (share acquisition, asset purchase, or joint venture).',
                        ],
                        [
                            'stepNumber' => 2,
                            'title' => 'Due Diligence Audit',
                            'description' => 'Audit target company records and deliver an executive red-flag risk report.',
                        ],
                        [
                            'stepNumber' => 3,
                            'title' => 'Contract Negotiation',
                            'description' => 'Draft transaction agreements with clear warranties and indemnification protections.',
                        ],
                        [
                            'stepNumber' => 4,
                            'title' => 'Closing & Post-Merger',
                            'description' => 'Execute transfer deeds, update ministry shareholder registries, and complete handover.',
                        ],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Jadwalkan Diskusi Transaksi',
                    'en' => 'Schedule a Transaction Briefing',
                ],
                'relatedStudies' => ['uji-tuntas-akuisisi-saas-jakarta', 'jakarta-b2b-saas-acquisition'],
            ],
        ];

        $contactUrl = route($isId ? 'compro.contact.id' : 'compro.contact.en', ['locale' => $locale]);
        $result = [];

        foreach ($rawServices as $item) {
            $slugId = $item['slug']['id'];
            $slugEn = $item['slug']['en'];
            $currentSlug = $item['slug'][$locale];
            $routePath = $isId ? "/id/layanan/{$slugId}" : "/en/services/{$slugEn}";
            $pageUrl = $baseUrl.$routePath;
            $title = $item['title'][$locale];
            $problem = $item['problemSolved'][$locale];

            $result[] = new ServiceData(
                code: $item['code'],
                slug: $currentSlug,
                title: $title,
                targetSegment: $item['targetSegment'][$locale],
                problemSolved: $problem,
                deliverables: $item['deliverables'][$locale],
                technicalSpecs: $item['specs'][$locale],
                workflowSteps: $item['steps'][$locale],
                primaryCta: new ActionLinkData(
                    label: $item['ctaLabel'][$locale],
                    url: $contactUrl.'?service='.$item['code'],
                    variant: 'primary',
                    icon: 'arrow-right',
                ),
                heroImage: new MediaAssetData(
                    url: '/images/placeholders/service-'.strtolower($item['code']).'.svg',
                    webpUrl: null,
                    avifUrl: null,
                    alt: $title.' ('.$item['code'].')',
                    width: 800,
                    height: 500,
                    aspectRatio: '16/10',
                    caption: $item['code'].' // '.$title,
                    isPlaceholder: true,
                    placeholderLabel: $isId
                        ? '[ILUSTRASI LAYANAN '.$item['code'].': GANTI DENGAN FOTO TIM/KANTOR KLIEN]'
                        : '[SERVICE VISUAL '.$item['code'].': REPLACE WITH CLIENT OFFICE/TEAM PHOTO]',
                ),
                datasheetPdfUrl: null,
                relatedCaseStudySlugs: $item['relatedStudies'],
                seo: new SeoMetaData(
                    title: $title.' | '.$settings->brandName,
                    description: $problem,
                    canonicalUrl: $pageUrl,
                    ogTitle: $title.' | '.$settings->brandName,
                    ogDescription: $problem,
                    alternates: [
                        'id' => $baseUrl."/id/layanan/{$slugId}",
                        'en' => $baseUrl."/en/services/{$slugEn}",
                        'xDefault' => $baseUrl."/id/layanan/{$slugId}",
                    ],
                ),
            );
        }

        return $result;
    }

    public function findServiceBySlug(string $locale, string $slug): ?ServiceData
    {
        foreach ($this->getServices($locale) as $service) {
            if ($service->slug === $slug) {
                return $service;
            }
        }

        return null;
    }

    /**
     * @return array<int, CaseStudyData>
     */
    public function getCaseStudies(string $locale): array
    {
        $isId = $locale === 'id';
        $settings = $this->getCompanySettings($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');

        $rawStudies = [
            [
                'code' => 'CS-01',
                'slug' => [
                    'id' => 'pendirian-pt-pma-logistik-jakarta',
                    'en' => 'jakarta-logistics-pma-setup',
                ],
                'title' => [
                    'id' => 'Pendirian PT PMA & Perizinan Operasional Lengkap untuk Perusahaan Logistik Regional',
                    'en' => 'PT PMA Incorporation & Full Operational Licensing for Regional Logistics Provider',
                ],
                'clientDescriptor' => [
                    'id' => 'Perusahaan Logistik & Rantai Pasok Asia Tenggara (Identitas Dijaga Sesuai NDA)',
                    'en' => 'Southeast Asian Logistics & Supply Chain Provider (Identity Protected Under NDA)',
                ],
                'location' => 'Jakarta Selatan',
                'completionYear' => 2025,
                'relatedServiceCode' => 'SRV-01',
                'relatedServiceSlug' => [
                    'id' => 'pendirian-badan-usaha',
                    'en' => 'company-formation-licensing',
                ],
                'installedCapacity' => $isId ? 'PT PMA Multi-KBLI & Izin OSS RBA' : 'Multi-KBLI PT PMA & OSS RBA Permits',
                'challenge' => [
                    'id' => 'Klien membutuhkan pendirian badan hukum PT PMA beserta izin operasional transportasi dan pergudangan multi-KBLI dalam waktu singkat agar dapat mengikuti tender kontrak distribusi nasional.',
                    'en' => 'The client needed a fully licensed PT PMA entity with multi-KBLI warehousing and logistics permits under a tight deadline to qualify for a national distribution tender.',
                ],
                'solution' => [
                    'id' => 'Pemetaan klasifikasi KBLI yang presisi, penyusunan akta pendirian dan perjanjian pemegang saham dwibahasa, serta pendampingan verifikasi izin teknis pada sistem OSS RBA.',
                    'en' => 'Executed precise KBLI classification mapping, drafted bilingual incorporation deeds and shareholder agreements, and managed OSS RBA technical permit verifications.',
                ],
                'outcome' => [
                    'id' => 'Seluruh izin operasional dan NIB terbit dalam 18 Hari Kerja tanpa revisi pengajuan',
                    'en' => 'Full operational NIB and licenses issued within 18 Business Days with zero filing rejections',
                ],
            ],
            [
                'code' => 'CS-02',
                'slug' => [
                    'id' => 'restrukturisasi-kontrak-ritel-surabaya',
                    'en' => 'surabaya-retail-contract-overhaul',
                ],
                'title' => [
                    'id' => 'Restrukturisasi 45 Kontrak Vendor & Distribusi untuk Jaringan Ritel Nasional',
                    'en' => 'Restructuring 45 Vendor & Distribution Contracts for a National Retail Network',
                ],
                'clientDescriptor' => [
                    'id' => 'Grup Distribusi & Ritel Konsumen Nasional',
                    'en' => 'National Consumer Retail & Distribution Group',
                ],
                'location' => 'Surabaya, Jawa Timur',
                'completionYear' => 2024,
                'relatedServiceCode' => 'SRV-02',
                'relatedServiceSlug' => [
                    'id' => 'penyusunan-kontrak-bisnis',
                    'en' => 'corporate-contract-drafting',
                ],
                'installedCapacity' => $isId ? '45 Kontrak Vendor & Distribusi Dwibahasa' : '45 Bilingual Vendor & Distribution Contracts',
                'challenge' => [
                    'id' => 'Klien menggunakan templat kontrak lama yang tidak mengatur batas waktu klaim retur barang dan denda keterlambatan pengiriman secara tegas, sehingga memicu perselisihan tagihan berulang.',
                    'en' => 'The client relied on legacy contract templates that lacked clear return-claim windows and delivery penalty clauses, resulting in recurring billing disputes.',
                ],
                'solution' => [
                    'id' => 'Penyusunan buku standar kontrak distribusi baru (Master Distribution Agreement), klausul SLA pengiriman yang terukur, serta sesi sosialisasi untuk tim pengadaan dan penjualan.',
                    'en' => 'Drafted standardized Master Distribution Agreements with measurable delivery SLA clauses and conducted training sessions for procurement and sales teams.',
                ],
                'outcome' => [
                    'id' => 'Waktu negosiasi kontrak vendor baru turun dari 3 Minggu menjadi 4 Hari Kerja',
                    'en' => 'New vendor contract turnaround reduced from 3 Weeks to 4 Business Days',
                ],
            ],
            [
                'code' => 'CS-03',
                'slug' => [
                    'id' => 'uji-tuntas-akuisisi-saas-jakarta',
                    'en' => 'jakarta-b2b-saas-acquisition',
                ],
                'title' => [
                    'id' => 'Uji Tuntas Hukum (Legal Due Diligence) & Akuisisi Mayoritas Saham Perusahaan SaaS B2B',
                    'en' => 'Legal Due Diligence & Majority Share Acquisition of a B2B SaaS Company',
                ],
                'clientDescriptor' => [
                    'id' => 'Grup Investasi & Teknologi Korporasi',
                    'en' => 'Corporate Technology & Investment Group',
                ],
                'location' => 'Jakarta Selatan',
                'completionYear' => 2025,
                'relatedServiceCode' => 'SRV-04',
                'relatedServiceSlug' => [
                    'id' => 'pendampingan-transaksi-bisnis',
                    'en' => 'business-transaction-advisory',
                ],
                'installedCapacity' => $isId ? 'Akuisisi 70% Saham & Pengalihan HKI' : '70% Equity Acquisition & IP Assignment',
                'challenge' => [
                    'id' => 'Investor perlu memastikan kepemilikan Hak Kekayaan Intelektual (HKI) kode perangkat lunak, kepatuhan kontrak karyawan, dan ketiadaan kewajiban pajak tersembunyi sebelum mengakuisisi 70% saham.',
                    'en' => 'The investor needed to verify software IP ownership, employment contract compliance, and the absence of hidden tax liabilities prior to acquiring a 70% equity stake.',
                ],
                'solution' => [
                    'id' => 'Pelaksanaan uji tuntas hukum menyeluruh dalam 14 hari, pengalihan hak cipta perangkat lunak ke badan hukum perusahaan, serta penyusunan CSPA dengan mekanisme pembayaran bertahap.',
                    'en' => 'Completed a 14-day legal due diligence audit, formalized IP assignment deeds into the corporate entity, and structured a milestone-based CSPA.',
                ],
                'outcome' => [
                    'id' => 'Transaksi akuisisi senilai Rp 28 Miliar selesai tepat jadwal dengan perlindungan klausul indemnifikasi penuh',
                    'en' => 'IDR 28 Billion acquisition closed on schedule with full indemnity protection',
                ],
            ],
        ];

        $result = [];
        foreach ($rawStudies as $study) {
            $slugId = $study['slug']['id'];
            $slugEn = $study['slug']['en'];
            $currentSlug = $study['slug'][$locale];
            $routePath = $isId ? "/id/studi-kasus/{$slugId}" : "/en/case-studies/{$slugEn}";
            $pageUrl = $baseUrl.$routePath;
            $title = $study['title'][$locale];
            $challenge = $study['challenge'][$locale];

            $result[] = new CaseStudyData(
                code: $study['code'],
                slug: $currentSlug,
                title: $title,
                clientDescriptor: $study['clientDescriptor'][$locale],
                isClientNameConsented: false,
                location: $study['location'],
                completionYear: $study['completionYear'],
                relatedServiceCode: $study['relatedServiceCode'],
                relatedServiceSlug: $study['relatedServiceSlug'][$locale],
                installedCapacity: $study['installedCapacity'],
                engineeringChallenge: $challenge,
                technicalSolution: $study['solution'][$locale],
                measurableOutcome: $study['outcome'][$locale],
                heroImage: new MediaAssetData(
                    url: '/images/placeholders/case-study-'.strtolower($study['code']).'.svg',
                    webpUrl: null,
                    avifUrl: null,
                    alt: $title.' ('.$study['code'].')',
                    width: 800,
                    height: 500,
                    aspectRatio: '16/10',
                    caption: $study['code'].' // '.$study['location'].' ('.$study['completionYear'].')',
                    isPlaceholder: true,
                    placeholderLabel: $isId
                        ? '[DOKUMENTASI STUDI KASUS '.$study['code'].': GANTI DENGAN FOTO PROYEK KLIEN]'
                        : '[CASE STUDY VISUAL '.$study['code'].': REPLACE WITH CLIENT MATTER PHOTO]',
                ),
                gallery: [],
                isSamplePlaceholder: true,
                seo: new SeoMetaData(
                    title: $title.' | '.$settings->brandName,
                    description: $challenge,
                    canonicalUrl: $pageUrl,
                    ogTitle: $title.' | '.$settings->brandName,
                    ogDescription: $challenge,
                    alternates: [
                        'id' => $baseUrl."/id/studi-kasus/{$slugId}",
                        'en' => $baseUrl."/en/case-studies/{$slugEn}",
                        'xDefault' => $baseUrl."/id/studi-kasus/{$slugId}",
                    ],
                ),
            );
        }

        return $result;
    }

    public function findCaseStudyBySlug(string $locale, string $slug): ?CaseStudyData
    {
        foreach ($this->getCaseStudies($locale) as $study) {
            if ($study->slug === $slug) {
                return $study;
            }
        }

        return null;
    }

    /**
     * @return array<int, FaqItemData>
     */
    public function getFaqs(string $locale): array
    {
        $isId = $locale === 'id';

        return [
            new FaqItemData(
                id: 'faq-01',
                category: $isId ? 'Konsultasi & Biaya' : 'Consultation & Fees',
                question: $isId
                    ? 'Apakah konsultasi awal dikenakan biaya, dan bagaimana sistem penentuan biaya layanan di Koolom Partners?'
                    : 'Do you offer free initial consultations, and how are your service fees structured?',
                answer: $isId
                    ? 'Sesi diskusi awal selama 30 menit tidak dikenakan biaya (gratis) dan bersifat 100% rahasia. Setelah memahami kebutuhan Anda, kami selalu memberikan penawaran biaya tetap tertulis (fixed-fee quote) di muka sebelum pekerjaan dimulai, sehingga tidak ada biaya kejutan di akhir.'
                    : 'Yes, our initial 30-minute consultation is free of charge and 100% confidential. Once we understand your scope, we provide a clear, written fixed-fee estimate upfront before any work begins, so there are never billing surprises.',
                relatedServiceCode: 'SRV-01',
            ),
            new FaqItemData(
                id: 'faq-02',
                category: $isId ? 'Pendirian Usaha & OSS' : 'Company Setup & OSS',
                question: $isId
                    ? 'Berapa lama proses pendirian PT atau PT PMA hingga Nomor Induk Berusaha (NIB) siap digunakan untuk beroperasi?'
                    : 'How long does it take to incorporate a local PT or foreign-owned PT PMA until the NIB license is ready for operation?',
                answer: $isId
                    ? 'Untuk PT lokal dengan struktur standar, proses penyusunan akta, pengesahan SK Kemenkumham, NPWP, hingga terbitnya NIB pada sistem OSS RBA umumnya selesai dalam 5 hingga 10 hari kerja setelah dokumen persyaratan lengkap. Untuk PT PMA berkisar antara 10 hingga 18 hari kerja.'
                    : 'For a standard local PT, deed drafting, Ministry ratification, tax registration, and OSS RBA NIB issuance typically take 5 to 10 business days once documents are complete. For a foreign-invested PT PMA, the process takes 10 to 18 business days.',
                relatedServiceCode: 'SRV-01',
            ),
            new FaqItemData(
                id: 'faq-03',
                category: $isId ? 'Kontrak Bisnis' : 'Commercial Contracts',
                question: $isId
                    ? 'Berapa lama waktu pengerjaan untuk penyusunan draf kontrak baru atau peninjauan (review) kontrak dari mitra bisnis kami?'
                    : 'What is the turnaround time for drafting a new commercial contract or reviewing an agreement from a counterparty?',
                answer: $isId
                    ? 'Peninjauan (review) dan pemberian catatan revisi (redlining) atas draf kontrak komersial standar diselesaikan dalam 2 hingga 3 hari kerja, sedangkan penyusunan kontrak baru dari awal rata-rata memerlukan 3 hingga 5 hari kerja.'
                    : 'Reviewing and redlining a standard commercial contract takes 2 to 3 business days, while drafting a custom agreement from scratch typically takes 3 to 5 business days.',
                relatedServiceCode: 'SRV-02',
            ),
            new FaqItemData(
                id: 'faq-04',
                category: $isId ? 'Tim & Pendampingan' : 'Senior Advisory Team',
                question: $isId
                    ? 'Apakah pekerjaan perusahaan kami akan ditangani langsung oleh konsultan berpengalaman?'
                    : 'Will our business matters be handled directly by experienced senior consultants?',
                answer: $isId
                    ? 'Ya. Setiap klien didampingi langsung oleh konsultan senior yang bertanggung jawab penuh sejak diskusi pertama hingga dokumen selesai, bukan diserahkan begitu saja kepada staf junior yang berganti-ganti.'
                    : 'Yes. You work directly with an assigned senior consultant from the first briefing through final delivery, never handed off to a rotating cast of junior staff.',
                relatedServiceCode: 'SRV-03',
            ),
            new FaqItemData(
                id: 'faq-05',
                category: $isId ? 'Kerahasiaan Data' : 'Confidentiality & NDA',
                question: $isId
                    ? 'Bagaimana Koolom Partners menjaga kerahasiaan dokumen bisnis dan rencana transaksi perusahaan kami?'
                    : 'How does Koolom Partners protect the confidentiality of our business documents and transaction plans?',
                answer: $isId
                    ? 'Seluruh informasi dan dokumen yang Anda bagikan dilindungi oleh standar kerahasiaan profesi sejak kontak pertama. Kami juga siap menandatangani Perjanjian Kerahasiaan (NDA) sebelum Anda mengirimkan dokumen transaksi sensitif.'
                    : 'Every document and briefing you share is protected under strict professional confidentiality from first contact. We are also happy to sign a mutual Non-Disclosure Agreement (NDA) before you transmit sensitive transaction files.',
                relatedServiceCode: 'SRV-04',
            ),
        ];
    }

    public function getHomePageData(string $locale): HomePageData
    {
        $isId = $locale === 'id';
        $settings = $this->getCompanySettings($locale);
        $services = $this->getServices($locale);
        $caseStudies = $this->getCaseStudies($locale);
        $faqs = $this->getFaqs($locale);
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        $pageUrl = $baseUrl.'/'.$locale;

        $title = $isId
            ? 'Konsultan Hukum Bisnis, Pendirian PT & Perizinan Usaha | '.$settings->brandName
            : 'Corporate Legal Advisory, Company Formation & Business Licensing | '.$settings->brandName;
        $description = $settings->valueProposition;

        $schemaGraph = $this->schemaBuilder->buildPageGraph(
            settings: $settings,
            locale: $locale,
            pageUrl: $pageUrl,
            pageTitle: $title,
            pageDescription: $description,
            breadcrumbs: [
                ['name' => $isId ? 'Beranda' : 'Home', 'url' => $pageUrl],
            ],
            faqs: $faqs,
        );

        return new HomePageData(
            sectorCode: $isId ? 'KONSULTAN HUKUM & PERIZINAN BISNIS' : 'CORPORATE LEGAL & BUSINESS ADVISORY',
            headline: $isId
                ? 'Pendamping Hukum dan Perizinan Bisnis saat Perusahaan Anda Membutuhkannya.'
                : 'Trusted Business and Legal Counsel When It Matters Most.',
            subheadline: $settings->valueProposition,
            primaryCta: new ActionLinkData(
                label: $isId ? 'Jadwalkan Konsultasi Gratis' : 'Request a Free Consultation',
                url: '#rfq-form',
                variant: 'primary',
                icon: 'arrow-right',
            ),
            secondaryCta: new ActionLinkData(
                label: $isId ? 'Lihat Layanan Kami' : 'Explore Our Services',
                url: '#service-matrix',
                variant: 'outline',
                icon: 'none',
            ),
            heroMedia: new MediaAssetData(
                url: '/images/placeholders/hero-chiller-plant.svg',
                webpUrl: null,
                avifUrl: null,
                alt: $isId
                    ? 'Tim konsultan hukum dan bisnis Koolom Partners mendampingi klien korporasi'
                    : 'Koolom Partners corporate legal and business advisory team',
                width: 800,
                height: 600,
                aspectRatio: '4/3',
                caption: $isId
                    ? '450+ Klien Korporasi | Estimasi Biaya Tertulis di Muka | Respon < 24 Jam Kerja'
                    : '450+ Corporate Clients | Upfront Fixed-Fee Quotes | Reply Within 24 Business Hours',
                isPlaceholder: true,
                placeholderLabel: $isId
                    ? '[FOTO UTAMA TIM / RUANG KONSULTASI KLIEN: GANTI DENGAN FOTO ASLI]'
                    : '[HERO ADVISORY TEAM / OFFICE PHOTO: REPLACE WITH REAL CLIENT PHOTO]',
            ),
            specCaption: $isId
                ? 'Pendirian PT & PMA | Kontrak Komersial | Retainer Kepatuhan | Uji Tuntas M&A'
                : 'Company Setup | Commercial Contracts | Compliance Retainer | M&A Due Diligence',
            servicesHeading: $isId
                ? 'Bagaimana Kami Membantu Bisnis Anda'
                : 'How We Can Help Your Business',
            servicesSummary: $isId
                ? 'Layanan praktis dan terstruktur untuk setiap tahap perkembangan perusahaan Anda, mulai dari pendirian badan usaha hingga transaksi strategis.'
                : 'Practical, structured counsel for every stage of your company growth, from initial incorporation to complex commercial transactions.',
            caseStudiesHeading: $isId
                ? 'Studi Kasus & Solusi Nyata untuk Klien Kami'
                : 'Recent Client Matters & Practical Outcomes',
            caseStudiesSummary: $isId
                ? 'Contoh pendampingan perizinan investasi, penataan kontrak distribusi, dan transaksi akuisisi yang telah kami selesaikan.'
                : 'Selected examples of investment licensing, distribution contract overhauls, and acquisition due diligence delivered for our clients.',
            faqHeading: $isId
                ? 'Pertanyaan yang Sering Diajukan'
                : 'Common Questions Before You Start',
            faqSummary: $isId
                ? 'Jawaban jelas seputar konsultasi awal gratis, transparansi biaya layanan, dan estimasi waktu pengerjaan dokumen.'
                : 'Clear answers regarding free initial consultations, upfront fixed-fee quotes, and document turnaround times.',
            rfqHeading: $isId
                ? 'Diskusikan Kebutuhan Bisnis Anda Hari Ini Tanpa Biaya Awal'
                : 'Talk to a Senior Consultant Today, Free of Charge',
            rfqSubheadline: $isId
                ? 'Ceritakan rencana bisnis atau kebutuhan dokumen Anda. Tim konsultan senior kami akan merespons dalam maksimal 1 hari kerja dengan langkah solusi yang jelas.'
                : 'Tell us about your business matter or licensing need. Our senior consultants respond within 1 business day with clear options and a transparent fee estimate.',
            services: $services,
            caseStudies: $caseStudies,
            faqs: $faqs,
            testimonials: [],
            seo: new SeoMetaData(
                title: $title,
                description: $description,
                canonicalUrl: $pageUrl,
                ogTitle: $title,
                ogDescription: $description,
                alternates: [
                    'id' => $baseUrl.'/id',
                    'en' => $baseUrl.'/en',
                    'xDefault' => $baseUrl.'/id',
                ],
                schemaGraph: $schemaGraph,
            ),
        );
    }
}
