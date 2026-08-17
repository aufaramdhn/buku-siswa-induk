<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'npsn' => ['required', 'string', 'max:20'],
            'nss' => ['nullable', 'string', 'max:20'],
            'academic_year' => ['required', 'string', 'max:9'],
            'address' => ['required', 'string'],
            'rt' => ['nullable', 'integer'],
            'rw' => ['nullable', 'integer'],
            'village' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'regency' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'headmaster_name' => ['required', 'string', 'max:150'],
            'headmaster_nip' => ['required', 'string', 'max:50'],
            'tu_head_name' => ['nullable', 'string', 'max:150'],
            'tu_head_nip' => ['nullable', 'string', 'max:50'],
            'headmaster_period' => ['nullable', 'string', 'max:50'],
            'tu_head_period' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama sekolah wajib diisi.',
            'npsn.required' => 'NPSN sekolah wajib diisi.',
            'academic_year.required' => 'Tahun pelajaran wajib diisi.',
            'address.required' => 'Alamat sekolah wajib diisi.',
            'village.required' => 'Desa/Kelurahan wajib diisi.',
            'district.required' => 'Kecamatan wajib diisi.',
            'regency.required' => 'Kabupaten/Kota wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'headmaster_name.required' => 'Nama kepala sekolah wajib diisi.',
            'headmaster_nip.required' => 'NIP kepala sekolah wajib diisi.',
        ];
    }
}
