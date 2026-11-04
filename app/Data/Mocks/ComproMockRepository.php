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
            legalName: 'PT Garda Teknika Presisi',
            brandName: 'GardaTek Engineering',
            foundingYear: 2012,
            kbliCodes: ['43224', '28193'],
            valueProposition: $isId
                ? 'Kami merancang, memasang, dan memelihara sistem pendingin rantai dingin (cold storage), perpipaan mekanikal, serta otomasi chiller untuk fasilitas manufaktur, farmasi, dan logistik di Indonesia dengan kapasitas terpasang mulai 20 TR hingga 1.500 TR.'
                : 'We engineer, install, and maintain industrial cold-chain refrigeration, mechanical piping, and chiller automation systems for manufacturing, pharmaceutical, and logistics facilities across Indonesia with installed capacities ranging from 20 TR to 1,500 TR.',
            hqAddress: 'Kawasan Industri Jababeka II, Jl. Industri Selatan Blok JJ No. 14, Cikarang Selatan, Kabupaten Bekasi, Jawa Barat 17530, Indonesia',
            branchAddress: 'Kawasan Industri Rungkut (SIER), Jl. Berbek Industri III No. 8, Sidoarjo, Jawa Timur 61256, Indonesia',
            geoCoordinates: ['lat' => -6.3084, 'lng' => 107.1485],
            officeHours: $isId
                ? 'Senin s/d Jumat: 08:00 s/d 17:00 WIB | Sabtu: 08:00 s/d 13:00 WIB'
                : 'Monday to Friday: 08:00 to 17:00 WIB | Saturday: 08:00 to 13:00 WIB',
            emergencySlaHours: $isId
                ? 'Siaga Darurat SLA 24 Jam (Senin s/d Minggu, termasuk Hari Libur Nasional)'
                : '24/7 Emergency SLA Dispatch (Monday to Sunday, including Public Holidays)',
            primaryPhone: '+62-21-8984-0110',
            whatsappLeadNumber: '+62-811-1024-880',
            engineeringEmail: 'engineering@gardatek.co.id',
            generalEmail: 'info@gardatek.co.id',
            sameAsUrls: [
                'linkedin' => 'https://www.linkedin.com/company/gardatek-engineering',
                'youtube' => 'https://www.youtube.com/@gardatek-engineering',
            ],
            metrics: [
                new MetricProofData(
                    id: 'metric-years',
                    label: $isId ? 'Pengalaman Operasional' : 'Operational Track Record',
                    exactFigure: $isId ? '14 Tahun' : '14 Years',
                    contextNote: $isId
                        ? 'Beroperasi sejak 2012 di koridor industri Jawa & Sumatera'
                        : 'Operating since 2012 across Java and Sumatra industrial corridors',
                    isSamplePlaceholder: true,
                ),
                new MetricProofData(
                    id: 'metric-capacity',
                    label: $isId ? 'Kapasitas Pendinginan Terpasang' : 'Installed Cooling Capacity',
                    exactFigure: $isId ? '48.500+ TR' : '48,500+ TR',
                    contextNote: $isId
                        ? 'Akumulasi instalasi chiller & cold storage (2012 s/d 2026)'
                        : 'Cumulative chiller and cold storage commissioning (2012 to 2026)',
                    isSamplePlaceholder: true,
                ),
                new MetricProofData(
                    id: 'metric-sla',
                    label: $isId ? 'Kepatuhan Waktu Tanggap Darurat' : 'Emergency SLA Response Rate',
                    exactFigure: $isId ? '98,7% < 4 Jam' : '98.7% < 4 Hours',
                    contextNote: $isId
                        ? 'Waktu tiba teknisi di lokasi klien Jabodetabek & Karawang'
                        : 'On-site technician arrival across Greater Jakarta and Karawang',
                    isSamplePlaceholder: true,
                ),
                new MetricProofData(
                    id: 'metric-projects',
                    label: $isId ? 'Proyek Industri Selesai' : 'Completed Industrial Commissions',
                    exactFigure: $isId ? '310 Fasilitas' : '310 Facilities',
                    contextNote: $isId
                        ? 'Gudang rantai dingin, pabrik farmasi, dan pengolahan pangan'
                        : 'Cold warehouses, pharmaceutical plants, and food processing',
                    isSamplePlaceholder: true,
                ),
            ],
            certifications: [
                new CertificationData(
                    standardCode: 'ISO 9001:2015',
                    scope: $isId
                        ? 'Sistem Manajemen Mutu Desain, Instalasi & Pemeliharaan HVACR'
                        : 'Quality Management System for HVACR Engineering & Maintenance',
                    issuingBody: 'TUV Rheinland',
                    referenceNumber: 'ID-QMS-00000-SEED',
                    isSamplePlaceholder: true,
                ),
                new CertificationData(
                    standardCode: 'SMK3 Kemnaker RI',
                    scope: $isId
                        ? 'Keselamatan & Kesehatan Kerja Konstruksi Mekanikal & Bejana Tekan (PP No. 50/2012)'
                        : 'Occupational Health & Safety for Mechanical & Pressure Vessel Works (PP No. 50/2012)',
                    issuingBody: 'Kementerian Ketenagakerjaan RI',
                    referenceNumber: 'SMK3-0000-SEED',
                    isSamplePlaceholder: true,
                ),
                new CertificationData(
                    standardCode: 'TKDN 42,6%',
                    scope: $isId
                        ? 'Verifikasi Tingkat Komponen Dalam Negeri Panel Kontrol PLC/SCADA & Rak Pipa'
                        : 'Local Content Verification for PLC/SCADA Control Panels & Pipe Racks (42.6%)',
                    issuingBody: 'PT Surveyor Indonesia',
                    referenceNumber: 'TKDN-0000-SEED',
                    isSamplePlaceholder: true,
                ),
                new CertificationData(
                    standardCode: 'BNSP & Kemnaker Kelas 1',
                    scope: $isId
                        ? 'Teknisi Refrigerasi Industri, Juru Las Kelas 1 (SMAW/GTAW), & Teknisi K3 Listrik'
                        : 'Certified Industrial Refrigeration, Class 1 Welders (SMAW/GTAW), & Electrical Safety',
                    issuingBody: 'BNSP & Kemnaker RI',
                    referenceNumber: 'LIC-TECH-SEED',
                    isSamplePlaceholder: true,
                ),
            ],
            clientSectorDescriptors: $isId
                ? [
                    'Distribusi Logistik Rantai Dingin Nasional (Kawasan Industri MM2100, Bekasi)',
                    'Fasilitas Manufaktur Farmasi & Vaksin Steril (Rungkut Industri, Surabaya)',
                    'Pabrik Pengolahan Hasil Laut & Pembekuan Cepat IQF (Tanjung Emas, Semarang)',
                    'Pusat Data & Ruang Server Telekomunikasi Tier-III (Kuningan, Jakarta Selatan)',
                ]
                : [
                    'National Cold-Chain Logistics Distribution Hub (MM2100 Industrial Town, Bekasi)',
                    'Sterile Pharmaceutical & Vaccine Manufacturing Plant (Rungkut Industrial Estate, Surabaya)',
                    'Seafood Processing & IQF Blast Freezing Facility (Tanjung Emas, Semarang)',
                    'Tier-III Telecommunications Data Center & Server Facility (Kuningan, South Jakarta)',
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
                    'id' => 'instalasi-rantai-dingin',
                    'en' => 'cold-chain-installation',
                ],
                'title' => [
                    'id' => 'Instalasi Sistem Rantai Dingin & Gudang Berpendingin',
                    'en' => 'Cold-Chain Storage & Industrial Refrigeration Engineering',
                ],
                'targetSegment' => [
                    'id' => 'Operator logistik cold-chain (3PL), pabrik pengolahan daging/hasil laut, dan distributor bahan pangan beku.',
                    'en' => 'Cold-chain 3PL operators, meat and seafood processors, and frozen food distribution hubs.',
                ],
                'problemSolved' => [
                    'id' => 'Mencegah kerusakan komoditas akibat fluktuasi suhu ruang simpan dan kebocoran termal pada operasional gudang berkapasitas tinggi.',
                    'en' => 'Prevents commodity spoilage caused by storage temperature drift and thermal leakage in high-throughput warehouse operations.',
                ],
                'deliverables' => [
                    'id' => [
                        'Rentang suhu terkalibrasi: Chiller Room (+2°C s/d +8°C), Freezer Storage (-18°C s/d -25°C), dan Blast Freezer (-35°C s/d -40°C).',
                        'Konstruksi panel insulasi Polyurethane (PIR/PUR) berdensitas 42 kg/m3 dengan ketebalan 100 mm hingga 200 mm dilengkapi cam-lock kedap udara.',
                        'Sistem refrigerasi kompresor screw/semi-hermetik (Freon R-448A/R-449A, Amonia NH3, atau CO2 Transkritikal) dengan pencatatan suhu otomatis 24 jam.',
                        'Pemanas lantai anti-beku (underfloor frost heave protection) dan tirai udara berkecepatan tinggi pada area loading dock.',
                    ],
                    'en' => [
                        'Calibrated temperature zones: Chiller Room (+2°C to +8°C), Freezer Storage (-18°C to -25°C), and Blast Freezer (-35°C to -40°C).',
                        'High-density Polyurethane (42 kg/m3 PIR/PUR) insulated panels from 100 mm to 200 mm thickness with airtight cam-lock joints.',
                        'Screw or semi-hermetic compressor racks (R-448A/R-449A, Ammonia NH3, or Transcritical CO2) paired with 24-hour automated temperature logging.',
                        'Underfloor frost-heave heating mats and high-velocity air curtains across loading dock bays.',
                    ],
                ],
                'technicalSpecs' => [
                    'id' => [
                        ['parameter' => 'Rentang Suhu Desain', 'value' => '+8°C s/d -40°C'],
                        ['parameter' => 'Densitas Insulasi PIR/PUR', 'value' => '42 kg/m3 (100 mm s/d 200 mm)'],
                        ['parameter' => 'Uji Tekan Nitrogen & Vakum', 'value' => '28 bar / < 500 mikron'],
                        ['parameter' => 'Opsi Refrigeran', 'value' => 'R-448A, R-449A, NH3, CO2'],
                    ],
                    'en' => [
                        ['parameter' => 'Design Temperature Range', 'value' => '+8°C down to -40°C'],
                        ['parameter' => 'PIR/PUR Insulation Density', 'value' => '42 kg/m3 (100 mm to 200 mm)'],
                        ['parameter' => 'Nitrogen Pressure & Vacuum Test', 'value' => '28 bar / < 500 microns'],
                        ['parameter' => 'Refrigerant Options', 'value' => 'R-448A, R-449A, NH3, CO2'],
                    ],
                ],
                'workflowSteps' => [
                    'id' => [
                        ['stepNumber' => 1, 'title' => 'Audit Beban Termal & Simulasi', 'description' => 'Perhitungan beban transmisi dinding, infiltrasi pintu, dan panas produk harian.'],
                        ['stepNumber' => 2, 'title' => 'Rekayasa Desain & P&ID', 'description' => 'Pembuatan gambar kerja 3D, diagram perpipaan, serta seleksi kapasitas kompresor dan evaporator.'],
                        ['stepNumber' => 3, 'title' => 'Fabrikasi & Instalasi Mekanikal', 'description' => 'Pemasangan panel insulasi, pengelasan pipa refrigeran bertekanan, dan perakitan panel kontrol.'],
                        ['stepNumber' => 4, 'title' => 'Uji Tekan, Vakum & Komisioning', 'description' => 'Uji tekan nitrogen 28 bar, evakuasi vakum < 500 mikron, dan penarikan suhu bertahap (pull-down test).'],
                        ['stepNumber' => 5, 'title' => 'Serah Terima & Kalibrasi Sensor', 'description' => 'Pelatihan operator lapangan, penyerahan dokumen As-Built Drawing, dan sertifikat kalibrasi sensor suhu.'],
                    ],
                    'en' => [
                        ['stepNumber' => 1, 'title' => 'Thermal Load Audit & Simulation', 'description' => 'Calculation of wall transmission load, dock door infiltration, and daily product heat load.'],
                        ['stepNumber' => 2, 'title' => 'Engineering Design & P&ID', 'description' => '3D shop drawings, piping schematics, and compressor/evaporator capacity sizing.'],
                        ['stepNumber' => 3, 'title' => 'Site Mechanical Installation', 'description' => 'Insulated panel erection, pressurized refrigerant pipe welding, and control panel assembly.'],
                        ['stepNumber' => 4, 'title' => 'Pressure Test, Vacuum & Commissioning', 'description' => '28 bar nitrogen pressure hold, < 500 micron vacuum evacuation, and stepped pull-down testing.'],
                        ['stepNumber' => 5, 'title' => 'Handover & Sensor Calibration', 'description' => 'Plant operator training, As-Built Drawing dossier handover, and temperature sensor calibration certificates.'],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Ajukan Perhitungan Beban Cold Storage',
                    'en' => 'Request Cold Storage Load Calculation',
                ],
                'relatedCaseStudySlugs' => [
                    'id' => ['cold-storage-distribusi-cikarang'],
                    'en' => ['cikarang-cold-storage-hub'],
                ],
            ],
            [
                'code' => 'SRV-02',
                'slug' => [
                    'id' => 'pemeliharaan-preventif-hvacr',
                    'en' => 'hvacr-preventive-maintenance',
                ],
                'title' => [
                    'id' => 'Kontrak Pemeliharaan Preventif & Audit Termal HVACR',
                    'en' => 'HVACR Preventive Maintenance Contracts & Thermal Auditing',
                ],
                'targetSegment' => [
                    'id' => 'Pabrik farmasi (CPOB/GMP), fasilitas F&B, gedung komersial, dan pusat data yang beroperasi 24/7.',
                    'en' => 'GMP pharmaceutical plants, food and beverage facilities, commercial buildings, and 24/7 data centers.',
                ],
                'problemSolved' => [
                    'id' => 'Menurunkan risiko henti mendadak (unplanned downtime) kompresor utama dan memangkas pemborosan konsumsi listrik akibat kondensor kotor atau ketidakseimbangan beban.',
                    'en' => 'Reduces unplanned compressor downtime and eliminates electrical waste caused by fouled condensers or refrigerant charge imbalance.',
                ],
                'deliverables' => [
                    'id' => [
                        'Inspeksi terjadwal bulanan dan kuartalan dengan waktu tanggap panggilan darurat maksimal < 4 jam (Jabodetabek) dan < 6 jam (Jawa Timur).',
                        'Pemindaian termografi inframerah (FLIR) pada panel distribusi daya dan kontaktor motor untuk mendeteksi titik panas sebelum terjadi hubung singkat.',
                        'Analisis vibrasi bantalan motor, uji keasaman oli kompresor, serta pembersihan kimiawi (descaling) tabung heat exchanger chiller.',
                        'Laporan audit efisiensi kelistrikan (kW/TR) lengkap dengan rekomendasi penghematan beban puncak.',
                    ],
                    'en' => [
                        'Monthly and quarterly scheduled inspections with an emergency call-out SLA of < 4 hours in Greater Jakarta and < 6 hours in East Java.',
                        'Infrared thermography scanning (FLIR) across power distribution panels and motor contactors to detect hotspots before failure.',
                        'Motor bearing vibration analysis, compressor oil acidity testing, and chemical descaling of chiller heat-exchanger tubes.',
                        'Comprehensive electrical efficiency (kW/TR) audit reports with peak-load reduction recommendations.',
                    ],
                ],
                'technicalSpecs' => [
                    'id' => [
                        ['parameter' => 'SLA Tanggap Darurat', 'value' => '< 4 Jam (Jabar) / < 6 Jam (Jatim)'],
                        ['parameter' => 'Diagnostik Termal & Vibrasi', 'value' => 'Kamera Inframerah FLIR & Vibration Meter'],
                        ['parameter' => 'Target Efisiensi Spesifik', 'value' => 'Pemantauan kW/TR & Subcooling/Superheat'],
                        ['parameter' => 'Frekuensi Kunjungan', 'value' => 'Bulanan / Kuartalan + Panggilan 24/7'],
                    ],
                    'en' => [
                        ['parameter' => 'Emergency Dispatch SLA', 'value' => '< 4 Hours (West Java) / < 6 Hours (East Java)'],
                        ['parameter' => 'Thermal & Vibration Diagnostics', 'value' => 'FLIR Thermography & Bearing Vibration'],
                        ['parameter' => 'Specific Efficiency Tracking', 'value' => 'kW/TR & Subcooling/Superheat Logging'],
                        ['parameter' => 'Inspection Cadence', 'value' => 'Monthly / Quarterly + 24/7 On-Call'],
                    ],
                ],
                'workflowSteps' => [
                    'id' => [
                        ['stepNumber' => 1, 'title' => 'Inspeksi Baseline & Inventarisasi Aset', 'description' => 'Pencatatan nomor seri, jam kerja kompresor, dan pengukuran performa awal (kW/TR).'],
                        ['stepNumber' => 2, 'title' => 'Eksekusi Pemeliharaan Terjadwal', 'description' => 'Pembersihan koil, kalibrasi sensor tekanan/suhu, dan penggantian suku cadang aus sesuai jam operasional.'],
                        ['stepNumber' => 3, 'title' => 'Diagnostik Prediktif', 'description' => 'Pengambilan sampel oli, analisis getaran mekanis, dan pencitraan termal panel listrik.'],
                        ['stepNumber' => 4, 'title' => 'Pelaporan Digital & Evaluasi SLA', 'description' => 'Penyerahan berita acara parameter operasi dan rekapitulasi tren kesehatan mesin setiap kuartal.'],
                    ],
                    'en' => [
                        ['stepNumber' => 1, 'title' => 'Asset Baseline Audit', 'description' => 'Serial inventory, compressor run-hour logging, and baseline kW/TR performance measurement.'],
                        ['stepNumber' => 2, 'title' => 'Scheduled Preventive Execution', 'description' => 'Coil descaling, pressure/temperature sensor calibration, and wear-part replacement by run-hours.'],
                        ['stepNumber' => 3, 'title' => 'Predictive Diagnostics', 'description' => 'Compressor oil acidity sampling, bearing vibration analysis, and electrical panel thermography.'],
                        ['stepNumber' => 4, 'title' => 'Digital Reporting & Quarterly SLA Review', 'description' => 'Submission of operational parameter logs and quarterly plant health trend reviews.'],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Jadwalkan Inspeksi Baseline Mesin',
                    'en' => 'Schedule a Baseline Equipment Inspection',
                ],
                'relatedCaseStudySlugs' => [
                    'id' => ['retrofit-chiller-farmasi-surabaya'],
                    'en' => ['surabaya-pharma-chiller-retrofit'],
                ],
            ],
            [
                'code' => 'SRV-03',
                'slug' => [
                    'id' => 'fabrikasi-mekanikal-pipa',
                    'en' => 'mechanical-piping-fabrication',
                ],
                'title' => [
                    'id' => 'Fabrikasi Pipa Industri & Integrasi Mekanikal-Elektrikal (MEP)',
                    'en' => 'Industrial Piping Fabrication & MEP System Integration',
                ],
                'targetSegment' => [
                    'id' => 'Pabrik pengolahan kimia, industri makanan-minuman, dan fasilitas utilitas pabrik baru (greenfield/brownfield).',
                    'en' => 'Chemical processing plants, food and beverage factories, and greenfield/brownfield utility plants.',
                ],
                'problemSolved' => [
                    'id' => 'Menyediakan jalur distribusi fluida dingin (chilled water), uap (steam), dan udara tekan bebas bocor yang memenuhi standar uji tak rusak (NDT) industri.',
                    'en' => 'Delivers leak-free chilled water, steam, and compressed air distribution networks verified against industrial non-destructive testing (NDT) standards.',
                ],
                'deliverables' => [
                    'id' => [
                        'Pengelasan pipa baja karbon (Carbon Steel Sch 40/80) dan baja tahan karat (Stainless Steel SS304/SS316L orbital/GTAW) oleh juru las bersertifikat Kemnaker.',
                        'Insulasi termal pipa chilled water menggunakan cellular glass atau elastomeric nitrile rubber berlapis cladding aluminium 0,6 mm.',
                        'Pengujian Non-Destructive Test (NDT Penetrant / Radiography X-Ray pada titik las kritis) dan uji hidrostatik hingga 1,5x tekanan kerja desain.',
                        'Integrasi pompa sirkulasi (primary/secondary variable flow), cooling tower, dan katup penyeimbang hidronik (balancing valves).',
                    ],
                    'en' => [
                        'Carbon steel (Sch 40/80) and food-grade stainless steel (SS304/SS316L GTAW) pipe welding executed by Kemnaker-certified Class 1 welders.',
                        'Thermal pipe insulation using cellular glass or nitrile rubber jacketed with 0.6 mm embossed aluminum cladding.',
                        'Non-Destructive Testing (dye penetrant and X-ray radiography on critical weld joints) plus hydrostatic testing at 1.5x design working pressure.',
                        'Complete hydronic integration including primary/secondary variable-speed pumps, cooling towers, and calibrated balancing valves.',
                    ],
                ],
                'technicalSpecs' => [
                    'id' => [
                        ['parameter' => 'Material Perpipaan', 'value' => 'Carbon Steel Sch 40/80 & SS304/SS316L'],
                        ['parameter' => 'Metode Pengelasan & Uji', 'value' => 'GTAW/SMAW Kelas 1 + NDT Penetrant/X-Ray'],
                        ['parameter' => 'Uji Tekan Hidrostatik', 'value' => '1,5x Tekanan Kerja Desain (24 Jam)'],
                        ['parameter' => 'Jaket Insulasi Termal', 'value' => 'PIR / Nitrile Rubber + Aluminium 0,6 mm'],
                    ],
                    'en' => [
                        ['parameter' => 'Piping Materials', 'value' => 'Carbon Steel Sch 40/80 & SS304/SS316L'],
                        ['parameter' => 'Welding & Inspection', 'value' => 'Class 1 GTAW/SMAW + NDT Penetrant/X-Ray'],
                        ['parameter' => 'Hydrostatic Pressure Test', 'value' => '1.5x Design Working Pressure (24 Hours)'],
                        ['parameter' => 'Thermal Insulation Jacket', 'value' => 'PIR / Nitrile Rubber + 0.6 mm Aluminum'],
                    ],
                ],
                'workflowSteps' => [
                    'id' => [
                        ['stepNumber' => 1, 'title' => 'Survei Jalur & Isometric Drawing', 'description' => 'Pengukuran elevasi lapangan dan pembuatan gambar isometrik bebas benturan (clash-free routing).'],
                        ['stepNumber' => 2, 'title' => 'Pre-Fabrikasi Bengkel', 'description' => 'Pemotongan, pembubutan bevel, dan pengelasan modul pipa (pipe spools) di bengkel terkontrol.'],
                        ['stepNumber' => 3, 'title' => 'Ereksi Lapangan & Insulasi', 'description' => 'Pemasangan gantungan (pipe supports), penyambungan jalur utama, dan pelapisan insulasi termal.'],
                        ['stepNumber' => 4, 'title' => 'Uji Hidrostatik, Flushing & Balancing', 'description' => 'Pengujian tekanan air, pembilasan kerak internal, dan penyeimbangan laju aliran tiap cabang.'],
                    ],
                    'en' => [
                        ['stepNumber' => 1, 'title' => 'Route Survey & Isometric Drawings', 'description' => 'Field elevation survey and clash-free isometric pipe routing drawings.'],
                        ['stepNumber' => 2, 'title' => 'Workshop Spool Pre-Fabrication', 'description' => 'Precision cutting, beveling, and controlled workshop welding of modular pipe spools.'],
                        ['stepNumber' => 3, 'title' => 'Site Erection & Thermal Cladding', 'description' => 'Hanger support installation, header tie-ins, and vapor-sealed aluminum insulation jacketing.'],
                        ['stepNumber' => 4, 'title' => 'Hydrotest, Flushing & Hydronic Balancing', 'description' => 'Hydrostatic pressure testing, internal line flushing, and calibrated branch flow balancing.'],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Kirim Gambar Isometrik untuk Estimasi',
                    'en' => 'Submit Isometric Drawings for Estimation',
                ],
                'relatedCaseStudySlugs' => [
                    'id' => ['pipa-chilled-water-pabrik-susu-pasuruan'],
                    'en' => ['pasuruan-dairy-piping-network'],
                ],
            ],
            [
                'code' => 'SRV-04',
                'slug' => [
                    'id' => 'retrofit-otomasi-chiller',
                    'en' => 'chiller-automation-retrofit',
                ],
                'title' => [
                    'id' => 'Retrofitting Efisiensi Energi & Otomasi Chiller (PLC/SCADA)',
                    'en' => 'Chiller Energy Retrofitting & PLC/SCADA Plant Automation',
                ],
                'targetSegment' => [
                    'id' => 'Fasilitas industri dengan usia sistem chiller di atas 7 tahun yang mengalami kenaikan biaya listrik bulanan.',
                    'en' => 'Industrial facilities operating chiller plants older than 7 years facing rising monthly electricity costs.',
                ],
                'problemSolved' => [
                    'id' => 'Memodernisasi sistem kontrol chiller dan pompa konvensional menjadi sistem berbasis beban aktual (VSD/Inverter) tanpa harus mengganti seluruh unit mesin utama.',
                    'en' => 'Modernizes legacy fixed-speed chiller and pump plants into load-responsive VSD/PLC systems without full mechanical plant replacement.',
                ],
                'deliverables' => [
                    'id' => [
                        'Pemasangan Variable Speed Drive (VSD/Inverter) pada motor pompa chilled water, pompa condenser, dan kipas cooling tower.',
                        'Perakitan panel kontrol berbasis PLC (Siemens / Schneider / Omron) dengan antarmuka layar sentuh HMI 10 inci dan komunikasi protokol Modbus TCP / BACnet IP.',
                        'Penggantian refrigeran lama (R-22 / R-404A) ke refrigeran ramah lingkungan ber-GWP rendah tanpa penggantian pipa utama.',
                        'Pemantauan tren COP (Coefficient of Performance) dan konsumsi daya (kWh) secara real-time beserta alarm gangguan via WhatsApp/Email gateway.',
                    ],
                    'en' => [
                        'Variable Speed Drive (VSD) integration across chilled water pumps, condenser water pumps, and cooling tower fans.',
                        'Custom PLC control panels (Siemens, Schneider, or Omron) with 10-inch industrial HMI touchscreens and Modbus TCP / BACnet IP connectivity.',
                        'Refrigerant retrofit from phased-out HCFCs/HFCs (R-22 / R-404A) to low-GWP alternatives with full elastomer and oil compatibility conversion.',
                        'Real-time COP and kWh telemetry logging with automated fault alerts via WhatsApp and email gateways.',
                    ],
                ],
                'technicalSpecs' => [
                    'id' => [
                        ['parameter' => 'Platform Kontrol & HMI', 'value' => 'PLC Siemens / Schneider / Omron + HMI 10"'],
                        ['parameter' => 'Protokol Integrasi BMS', 'value' => 'Modbus RTU/TCP & BACnet IP'],
                        ['parameter' => 'Metode Eksekusi', 'value' => 'Phased Live Retrofit (Tanpa Henti Total)'],
                        ['parameter' => 'Protokol Verifikasi Energi', 'value' => 'Logging Ultrasonic Flow & Power Meter (kW/TR)'],
                    ],
                    'en' => [
                        ['parameter' => 'PLC & HMI Platform', 'value' => 'Siemens / Schneider / Omron PLC + 10" HMI'],
                        ['parameter' => 'BMS Integration Protocol', 'value' => 'Modbus RTU/TCP & BACnet IP'],
                        ['parameter' => 'Execution Methodology', 'value' => 'Phased Live Retrofit (Zero Full Shutdown)'],
                        ['parameter' => 'Energy Verification Protocol', 'value' => 'Ultrasonic Flow & Power Logging (kW/TR)'],
                    ],
                ],
                'workflowSteps' => [
                    'id' => [
                        ['stepNumber' => 1, 'title' => 'Pencatatan Beban & Audit kW/TR', 'description' => 'Pemasangan power logger dan ultrasonic flowmeter selama 7 hari penuh untuk memetakan profil beban nyata.'],
                        ['stepNumber' => 2, 'title' => 'Perhitungan ROI & Desain Otomasi', 'description' => 'Simulasi penghematan listrik tahunan (kWh) dan perancangan logika sekuensial staging chiller.'],
                        ['stepNumber' => 3, 'title' => 'Instalasi Bertahap Tanpa Henti Total', 'description' => 'Integrasi panel VSD/PLC dan sensor per jalur secara bergantian agar operasional pabrik tetap berjalan.'],
                        ['stepNumber' => 4, 'title' => 'Verifikasi Penghematan Energi (M&V)', 'description' => 'Pengukuran ulang nilai kW/TR pasca-instalasi mengacu pada protokol IPMVP untuk membuktikan penurunan konsumsi energi.'],
                    ],
                    'en' => [
                        ['stepNumber' => 1, 'title' => '7-Day Baseline kW/TR Data Logging', 'description' => 'Non-intrusive ultrasonic flowmeter and power analyzer logging across a full 7-day production cycle.'],
                        ['stepNumber' => 2, 'title' => 'ROI Modeling & Control Architecture', 'description' => 'Annual kWh savings simulation and sequential chiller staging logic design.'],
                        ['stepNumber' => 3, 'title' => 'Phased Live Retrofit Execution', 'description' => 'Line-by-line VSD/PLC switchover during standby windows so factory production stays online.'],
                        ['stepNumber' => 4, 'title' => 'Post-Retrofit Energy M&V', 'description' => 'Post-commissioning kW/TR measurement under IPMVP guidelines to verify achieved energy reduction.'],
                    ],
                ],
                'ctaLabel' => [
                    'id' => 'Hitung Potensi Penghematan Energi Chiller',
                    'en' => 'Calculate Chiller Energy Savings Potential',
                ],
                'relatedCaseStudySlugs' => [
                    'id' => ['retrofit-chiller-farmasi-surabaya'],
                    'en' => ['surabaya-pharma-chiller-retrofit'],
                ],
            ],
        ];

        $result = [];
        foreach ($rawServices as $item) {
            $slugId = $item['slug']['id'];
            $slugEn = $item['slug']['en'];
            $currentSlug = $item['slug'][$locale];
            $routePath = $isId ? "/id/layanan/{$slugId}" : "/en/services/{$slugEn}";
            $pageUrl = $baseUrl.$routePath;
            $title = $item['title'][$locale];
            $problem = $item['problemSolved'][$locale];

            $serviceDto = new ServiceData(
                code: $item['code'],
                slug: $currentSlug,
                title: $title,
                targetSegment: $item['targetSegment'][$locale],
                problemSolved: $problem,
                deliverables: $item['deliverables'][$locale],
                technicalSpecs: $item['technicalSpecs'][$locale],
                workflowSteps: $item['workflowSteps'][$locale],
                heroImage: new MediaAssetData(
                    url: '/images/placeholders/service-'.strtolower($item['code']).'.svg',
                    webpUrl: null,
                    avifUrl: null,
                    alt: $title.' ('.$item['code'].')',
                    width: 800,
                    height: 600,
                    aspectRatio: '4/3',
                    caption: $item['code'].' // '.$title,
                    isPlaceholder: true,
                    placeholderLabel: $isId
                        ? '[FOTO DOKUMENTASI TEKNIS '.$item['code'].': GANTI DENGAN FOTO INSTALASI KLIEN]'
                        : '[TECHNICAL DOCUMENTATION PHOTO '.$item['code'].': REPLACE WITH CLIENT SITE PHOTO]',
                ),
                primaryCta: new ActionLinkData(
                    label: $item['ctaLabel'][$locale],
                    url: ($isId ? '/id/hubungi-kami' : '/en/contact').'?service='.$item['code'],
                    variant: 'primary',
                    icon: 'arrow-right',
                ),
                datasheetPdfUrl: ($isId ? '/id/hubungi-kami' : '/en/contact').'?service='.$item['code'].'&intent=datasheet',
                relatedCaseStudySlugs: $item['relatedCaseStudySlugs'][$locale],
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

            $result[] = $serviceDto;
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
                    'id' => 'cold-storage-distribusi-cikarang',
                    'en' => 'cikarang-cold-storage-hub',
                ],
                'title' => [
                    'id' => 'Pembangunan Cold Storage Multi-Zona 2.400 Pallet untuk Pusat Distribusi Pangan Beku',
                    'en' => '2,400-Pallet Multi-Zone Cold Storage Facility for Frozen Food Distribution Hub',
                ],
                'clientDescriptor' => [
                    'id' => 'Operator Logistik Rantai Dingin Nasional (Nama Klien Dirahasiakan Sesuai NDA)',
                    'en' => 'National Cold-Chain Logistics Operator (Client Identity Protected Under NDA)',
                ],
                'location' => 'Cikarang, Jawa Barat',
                'completionYear' => 2025,
                'relatedServiceCode' => 'SRV-01',
                'relatedServiceSlug' => [
                    'id' => 'instalasi-rantai-dingin',
                    'en' => 'cold-chain-installation',
                ],
                'installedCapacity' => '180 TR (-22°C Freezer & +4°C Anteroom)',
                'challenge' => [
                    'id' => 'Klien membutuhkan fasilitas penyimpanan beku -22°C dengan 12 pintu loading dock aktif yang mampu mempertahankan suhu stabil meskipun terjadi 80 siklus bongkar-muat truk per hari.',
                    'en' => 'The client required a -22°C freezer warehouse with 12 active loading docks capable of maintaining stable core temperatures during 80 daily truck loading cycles.',
                ],
                'solution' => [
                    'id' => 'Instalasi rak kompresor paralel semi-hermetik total 180 TR, panel insulasi PIR 150 mm, sistem pencairan bunga es gas panas (hot-gas defrost), dan ruang anteroom bertekanan positif +4°C.',
                    'en' => 'Installed a 180 TR parallel semi-hermetic compressor rack, 150 mm PIR insulation panels, automated hot-gas defrosting, and a +4°C dehumidified loading anteroom.',
                ],
                'outcome' => [
                    'id' => 'Fluktuasi suhu ruang utama terjaga di bawah ±0,8°C selama jam puncak operasional',
                    'en' => 'Core freezer temperature drift held within ±0.8°C during peak dock hours',
                ],
            ],
            [
                'code' => 'CS-02',
                'slug' => [
                    'id' => 'retrofit-chiller-farmasi-surabaya',
                    'en' => 'surabaya-pharma-chiller-retrofit',
                ],
                'title' => [
                    'id' => 'Retrofit Otomasi VSD & PLC pada Sentral Chiller 900 TR Fasilitas Farmasi',
                    'en' => 'VSD & PLC Automation Retrofit on a 900 TR Pharmaceutical Chiller Plant',
                ],
                'clientDescriptor' => [
                    'id' => 'Pabrik Manufaktur Farmasi Steril CPOB',
                    'en' => 'GMP Sterile Pharmaceutical Manufacturing Plant',
                ],
                'location' => 'Surabaya, Jawa Timur',
                'completionYear' => 2024,
                'relatedServiceCode' => 'SRV-04',
                'relatedServiceSlug' => [
                    'id' => 'retrofit-otomasi-chiller',
                    'en' => 'chiller-automation-retrofit',
                ],
                'installedCapacity' => '900 TR (3x 300 TR Water-Cooled Chiller)',
                'challenge' => [
                    'id' => 'Tiga unit water-cooled chiller berusia 9 tahun beroperasi pada kecepatan tetap sehingga efisiensi sistem turun menjadi 1,08 kW/TR saat beban malam hari.',
                    'en' => 'Three 9-year-old water-cooled chillers operated at fixed speed, causing plant efficiency to degrade to 1.08 kW/TR during partial night-shift loads.',
                ],
                'solution' => [
                    'id' => 'Integrasi VSD pada pompa sekunder dan kipas cooling tower, pemasangan katup kontrol tekanan diferensial otomatis, serta pemrograman ulang staging beban berbasis PLC Siemens S7-1200.',
                    'en' => 'Integrated VSDs across secondary chilled-water pumps and cooling tower fans, installed automated differential-pressure control valves, and reprogrammed chiller staging via Siemens S7-1200 PLC.',
                ],
                'outcome' => [
                    'id' => 'Perbaikan efisiensi rata-rata pabrik menjadi 0,76 kW/TR tanpa menghentikan jadwal produksi ruang bersih',
                    'en' => 'Plant efficiency improved to 0.76 kW/TR with zero cleanroom production shutdown',
                ],
            ],
            [
                'code' => 'CS-03',
                'slug' => [
                    'id' => 'pipa-chilled-water-pabrik-susu-pasuruan',
                    'en' => 'pasuruan-dairy-piping-network',
                ],
                'title' => [
                    'id' => 'Fabrikasi Jalur Pipa Chilled Water SS304 Sepanjang 1,4 KM untuk Pabrik Pengolahan Susu',
                    'en' => '1.4 KM SS304 Chilled Water Piping Network for Dairy Processing Plant',
                ],
                'clientDescriptor' => [
                    'id' => 'Industri Pengolahan Susu & Minuman Kemasan',
                    'en' => 'Dairy & Packaged Beverage Processing Facility',
                ],
                'location' => 'Pasuruan, Jawa Timur',
                'completionYear' => 2025,
                'relatedServiceCode' => 'SRV-03',
                'relatedServiceSlug' => [
                    'id' => 'fabrikasi-mekanikal-pipa',
                    'en' => 'mechanical-piping-fabrication',
                ],
                'installedCapacity' => '1,4 KM Header SS304 Sch 40 (-4°C Glycol)',
                'challenge' => [
                    'id' => 'Menyambungkan jalur pasokan glikol dingin -4°C ke 6 lini pasteurisasi baru dengan toleransi kebocoran nol dan standar kebersihan ruang produksi pangan.',
                    'en' => 'Connected a -4°C chilled glycol supply header to 6 new pasteurization lines under food-grade hygiene rules and zero-leak tolerances.',
                ],
                'solution' => [
                    'id' => 'Pre-fabrikasi modul pipa Stainless Steel SS304 Sch 40 dengan pengelasan GTAW purge gas argon, pengujian NDT penetrant 100% sambungan, dan insulasi tertutup berjaket aluminium.',
                    'en' => 'Pre-fabricated SS304 Sch 40 pipe spools using argon-purged GTAW welding, executed 100% dye-penetrant joint inspections, and applied vapor-sealed aluminum cladding.',
                ],
                'outcome' => [
                    'id' => 'Lulus uji tekan hidrostatik 12 bar selama 24 jam penuh pada percobaan pertama',
                    'en' => 'Passed 24-hour 12 bar hydrostatic pressure testing on the first commissioning run',
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
                        ? '[DOKUMENTASI PROYEK '.$study['code'].': GANTI DENGAN FOTO KOMISIONING KLIEN]'
                        : '[PROJECT COMMISSION PHOTO '.$study['code'].': REPLACE WITH CLIENT SITE PHOTO]',
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
                category: 'SLA & Maintenance',
                question: $isId
                    ? 'Berapa batas waktu tanggap (response time) teknisi jika terjadi gangguan kompresor darurat di luar jam kerja?'
                    : 'What is the guaranteed technician response time if a critical compressor fault occurs outside normal working hours?',
                answer: $isId
                    ? 'Untuk pemegang Kontrak Pemeliharaan Preventif (SLA), tim teknisi siaga kami diberangkatkan menuju lokasi dalam waktu maksimal 4 jam untuk area Jabodetabek-Karawang dan maksimal 6 jam untuk koridor Surabaya-Sidoarjo-Pasuruan, 24 jam sehari termasuk hari libur nasional.'
                    : 'For Preventive Maintenance Contract (SLA) holders, our on-call field engineers dispatch to reach your site within 4 hours across Greater Jakarta-Karawang and within 6 hours across the Surabaya-Sidoarjo-Pasuruan industrial corridor, 24/7 including public holidays.',
                relatedServiceCode: 'SRV-02',
            ),
            new FaqItemData(
                id: 'faq-02',
                category: 'Engineering & Compliance',
                question: $isId
                    ? 'Apakah GardaTek menyediakan dokumen perhitungan beban pendinginan (cooling load calculation) dan P&ID sebelum pengajuan penawaran harga final?'
                    : 'Does GardaTek provide engineering cooling-load calculations and P&ID schematics prior to final commercial quotation?',
                answer: $isId
                    ? 'Ya. Setiap penawaran proyek instalasi cold storage maupun chiller selalu diawali dengan survei lokasi, perhitungan beban termal terperinci (transmisi, infiltrasi, dan produk), serta draf diagram perpipaan (P&ID) dan daftar volume material (BoQ) terbuka.'
                    : 'Yes. Every cold storage or chiller installation proposal begins with an on-site survey, itemized thermal load calculations (transmission, infiltration, and product heat), a preliminary P&ID schematic, and an itemized Bill of Quantities (BoQ).',
                relatedServiceCode: 'SRV-01',
            ),
            new FaqItemData(
                id: 'faq-03',
                category: 'Retrofitting & Operations',
                question: $isId
                    ? 'Apakah pekerjaan retrofit panel PLC/VSD atau penggantian jalur pipa mengharuskan penghentian total (total shutdown) operasional pabrik?'
                    : 'Does a PLC/VSD chiller retrofit or piping expansion require a complete plant production shutdown?',
                answer: $isId
                    ? 'Tidak harus berhenti total. Kami menjadwalkan metode Phased Live Retrofit, di mana penyambungan katup isolasi (tie-in) dan pengalihan panel kontrol dilakukan secara bergantian per unit mesin atau pada jeda pemeliharaan terjadwal akhir pekan.'
                    : 'A full plant shutdown is rarely required. We execute a Phased Live Retrofit methodology where isolation valve tie-ins and control panel switchovers are staged unit-by-unit on standby lines or during scheduled weekend maintenance windows.',
                relatedServiceCode: 'SRV-04',
            ),
            new FaqItemData(
                id: 'faq-04',
                category: 'Procurement & TKDN',
                question: $isId
                    ? 'Apakah pekerjaan instalasi dan panel kontrol dari GardaTek dilengkapi dokumen sertifikasi K3 dan verifikasi TKDN untuk kebutuhan tender korporasi/BUMN?'
                    : 'Are GardaTek installations and control panels backed by Kemnaker OHS certifications and TKDN local-content documentation for corporate or state-enterprise tenders?',
                answer: $isId
                    ? 'Seluruh pekerjaan lapangan dipimpin oleh pengawas K3 bersertifikat Kemnaker RI dengan juru las berlisensi Kelas 1, serta dilengkapi dokumen verifikasi TKDN (capaian 42,6%) untuk perakitan panel kontrol dan fabrikasi rak perpipaan lokal.'
                    : 'All site works are supervised by Kemnaker-certified OHS officers and Class 1 licensed welders, accompanied by verified TKDN local-content documentation (42.6% score) for locally assembled PLC control panels and fabricated pipe racks.',
                relatedServiceCode: 'SRV-03',
            ),
            new FaqItemData(
                id: 'faq-05',
                category: 'Warranty & Spare Parts',
                question: $isId
                    ? 'Bagaimana cakupan garansi purnajual untuk instalasi sistem baru maupun pekerjaan overhaul kompresor?'
                    : 'What post-commissioning warranty applies to new refrigeration installations and compressor overhauls?',
                answer: $isId
                    ? 'Instalasi sistem baru dilindungi garansi pengerjaan mekanikal-elektrikal selama 12 bulan sejak tanggal Berita Acara Serah Terima (BAST) ditambah garansi resmi pabrikan unit utama, sedangkan pekerjaan overhaul kompresor mencakup garansi operasional 6 bulan.'
                    : 'New system installations carry a 12-month mechanical and electrical workmanship warranty from the date of commissioning handover alongside OEM equipment warranties, while compressor overhauls include a 6-month operational warranty.',
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
            ? 'Kontraktor Cold Storage, Chiller & Perpipaan Industri | '.$settings->brandName
            : 'Industrial Cold Storage, Chiller & Mechanical Piping Engineering | '.$settings->brandName;
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
            sectorCode: 'KBLI 43224 // INDUSTRIAL HVACR, COLD-CHAIN & MEP ENGINEERING',
            headline: $isId
                ? 'Rekayasa Rantai Dingin, Perpipaan Mekanikal, dan Otomasi Chiller untuk Fasilitas Industri.'
                : 'Cold-Chain Refrigeration, Mechanical Piping, and Chiller Plant Automation for Industrial Facilities.',
            subheadline: $settings->valueProposition,
            primaryCta: new ActionLinkData(
                label: $isId ? 'Jadwalkan Audit Termal Lokasi' : 'Schedule a Site Thermal Audit',
                url: '#rfq-form',
                variant: 'primary',
                icon: 'arrow-right',
            ),
            secondaryCta: new ActionLinkData(
                label: $isId ? 'Lihat Matriks Spesifikasi Layanan' : 'Review Service Specification Matrix',
                url: '#service-matrix',
                variant: 'outline',
                icon: 'none',
            ),
            heroMedia: new MediaAssetData(
                url: '/images/placeholders/hero-chiller-plant.svg',
                webpUrl: null,
                avifUrl: null,
                alt: $isId
                    ? 'Skema instalasi rak kompresor paralel cold storage dan jalur perpipaan chilled water industri'
                    : 'Industrial parallel compressor rack and chilled water header piping schematic',
                width: 800,
                height: 600,
                aspectRatio: '4/3',
                caption: $isId
                    ? 'Rentang Kapasitas: 20 TR s/d 1.500 TR | Tanggap Darurat SLA: < 4 Jam (Jabodetabek-Karawang)'
                    : 'Capacity Range: 20 TR to 1,500 TR | Emergency SLA Dispatch: < 4 Hours (Greater Jakarta-Karawang)',
                isPlaceholder: true,
                placeholderLabel: $isId
                    ? '[FOTO UTAMA FASILITAS / RUANG MESIN CHILLER: GANTI DENGAN FOTO ASLI KLIEN]'
                    : '[HERO FACILITY / CHILLER PLANT ROOM PHOTO: REPLACE WITH REAL CLIENT PHOTO]',
            ),
            specCaption: $isId
                ? 'Kapasitas Terukur: 20 TR s/d 1.500 TR | Suhu Desain: +8°C s/d -40°C | Uji Tekan: 28 Bar'
                : 'Rated Capacity: 20 TR to 1,500 TR | Design Temp: +8°C down to -40°C | Pressure Test: 28 Bar',
            servicesHeading: $isId
                ? 'Matriks Kapabilitas Rekayasa & Pemeliharaan Industri'
                : 'Industrial Engineering & Maintenance Capability Matrix',
            servicesSummary: $isId
                ? 'Setiap lingkup pekerjaan dirancang berdasarkan perhitungan beban termal aktual, gambar isometrik P&ID, serta target efisiensi energi (kW/TR) yang terukur.'
                : 'Every scope of work is engineered around calculated thermal loads, clash-free P&ID isometrics, and measurable electrical efficiency (kW/TR) targets.',
            caseStudiesHeading: $isId
                ? 'Rekam Jejak Komisioning & Hasil Pengukuran Lapangan'
                : 'Commissioned Project Dossiers & Measured Field Outcomes',
            caseStudiesSummary: $isId
                ? 'Dokumentasi proyek instalasi gudang berpendingin, pemipaan proses pangan, dan modernisasi kontrol chiller pada fasilitas manufaktur.'
                : 'Documented cold storage installations, food-grade process piping networks, and chiller control retrofits across active manufacturing plants.',
            faqHeading: $isId
                ? 'Pertanyaan Teknis, Kepatuhan K3/TKDN & SLA Operasional'
                : 'Technical Specifications, OHS/TKDN Compliance & SLA FAQ',
            faqSummary: $isId
                ? 'Jawaban teknis langsung untuk tim engineering, manajer utilitas pabrik, dan departemen pengadaan (procurement).'
                : 'Direct engineering answers for plant utility managers, MEP project engineers, and corporate procurement teams.',
            rfqHeading: $isId
                ? 'Ajukan Audit Termal Lokasi atau Perhitungan Beban Pendinginan (BoQ)'
                : 'Request an On-Site Thermal Audit or Cooling Load & BoQ Calculation',
            rfqSubheadline: $isId
                ? 'Kirimkan parameter fasilitas atau gambar isometrik awal Anda. Tim insinyur aplikasi kami merespons dalam < 4 jam kerja dengan jadwal survei atau estimasi teknis.'
                : 'Submit your facility parameters or preliminary isometric drawings. Our application engineers respond within 4 working hours with a survey schedule or technical estimate.',
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

