<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:120'],
            'company_name' => ['required', 'string', 'min:2', 'max:160'],
            'work_email' => ['required', 'email:rfc', 'max:160'],
            'phone_whatsapp' => ['required', 'string', 'min:8', 'max:30'],
            'service_code' => ['required', 'string', Rule::in(['SRV-01', 'SRV-02', 'SRV-03', 'SRV-04', 'OTHER'])],
            'facility_location' => ['required', 'string', 'max:160'],
            'estimated_capacity' => ['nullable', 'string', 'max:100'],
            'project_brief' => ['required', 'string', 'min:20', 'max:2000'],
            'company_website_hp' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        $isId = app()->getLocale() === 'id';

        if ($isId) {
            return [
                'full_name.required' => 'Nama lengkap dan jabatan wajib diisi (minimal 2 karakter).',
                'full_name.min' => 'Nama lengkap minimal terdiri dari 2 karakter.',
                'company_name.required' => 'Nama perusahaan atau entitas pabrik wajib diisi.',
                'work_email.required' => 'Alamat email korporasi wajib diisi untuk pengiriman dokumen teknis.',
                'work_email.email' => 'Format alamat email tidak valid.',
                'phone_whatsapp.required' => 'Nomor telepon atau WhatsApp aktif wajib diisi (minimal 8 digit).',
                'phone_whatsapp.min' => 'Nomor telepon minimal terdiri dari 8 karakter.',
                'service_code.required' => 'Pilih salah satu kategori layanan teknis yang dibutuhkan.',
                'service_code.in' => 'Kategori layanan teknis yang dipilih tidak valid.',
                'facility_location.required' => 'Lokasi pabrik atau kawasan industri wajib dicantumkan.',
                'project_brief.required' => 'Spesifikasi kebutuhan atau kendala teknis wajib dijelaskan (minimal 20 karakter).',
                'project_brief.min' => 'Jelaskan spesifikasi kebutuhan atau kendala teknis minimal 20 karakter agar tim engineer dapat menganalisis.',
                'company_website_hp.prohibited' => 'Permintaan ditolak oleh filter keamanan otomatis.',
            ];
        }

        return [
            'full_name.required' => 'Full name and job title are required (at least 2 characters).',
            'full_name.min' => 'Full name must be at least 2 characters.',
            'company_name.required' => 'Company or plant entity name is required.',
            'work_email.required' => 'Work email address is required for technical dossier delivery.',
            'work_email.email' => 'Please enter a valid work email address.',
            'phone_whatsapp.required' => 'An active phone or WhatsApp number is required (at least 8 digits).',
            'phone_whatsapp.min' => 'Phone number must be at least 8 characters.',
            'service_code.required' => 'Please select a technical service category.',
            'service_code.in' => 'The selected technical service category is invalid.',
            'facility_location.required' => 'Facility city or industrial estate location is required.',
            'project_brief.required' => 'Please describe your technical scope or operating requirements (at least 20 characters).',
            'project_brief.min' => 'Please provide at least 20 characters describing your technical requirements so our engineers can assess the scope.',
            'company_website_hp.prohibited' => 'Submission rejected by automated security filter.',
        ];
    }
}
