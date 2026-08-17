<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('id');

        return [
            'nipd' => ['required', 'string', 'max:20', 'unique:students,nipd,' . $studentId],
            'name' => ['required', 'string', 'max:150'],
            'gender' => ['required', 'in:L,P'],
            'nisn' => ['required', 'string', 'max:10', 'unique:students,nisn,' . $studentId],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'religion' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:100'],
            'mobile_phone' => ['required', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'previous_school' => ['nullable', 'string', 'max:150'],
            'family_card_no' => ['required', 'string', 'max:30'],
            'rombel' => ['required', 'string', 'max:50'],

            'address' => ['required', 'string'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'dusun' => ['nullable', 'string', 'max:100'],
            'village' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:5'],
            'residence_type' => ['required', 'string', 'max:50'],
            'transportation' => ['required', 'string', 'max:50'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],

            'father_name' => ['required', 'string', 'max:150'],
            'father_birth_year' => ['required', 'string', 'max:4'],
            'father_education' => ['required', 'string', 'max:50'],
            'father_occupation' => ['required', 'string', 'max:100'],
            'father_income' => ['required', 'string', 'max:50'],
            'father_nik' => ['required', 'string', 'max:30'],

            'mother_name' => ['required', 'string', 'max:150'],
            'mother_birth_year' => ['required', 'string', 'max:4'],
            'mother_education' => ['required', 'string', 'max:50'],
            'mother_occupation' => ['required', 'string', 'max:100'],
            'mother_income' => ['required', 'string', 'max:50'],
            'mother_nik' => ['required', 'string', 'max:30'],

            'guardian_name' => ['nullable', 'string', 'max:150'],
            'guardian_birth_year' => ['nullable', 'string', 'max:4'],
            'guardian_education' => ['nullable', 'string', 'max:50'],
            'guardian_occupation' => ['nullable', 'string', 'max:100'],
            'guardian_income' => ['nullable', 'string', 'max:50'],
            'guardian_nik' => ['nullable', 'string', 'max:30'],

            'siblings' => ['required', 'integer', 'min:0'],
            'birth_order' => ['required', 'integer', 'min:1'],

            'skhun_number' => ['nullable', 'string', 'max:30'],
            'un_number' => ['nullable', 'string', 'max:30'],
            'ijazah_number' => ['nullable', 'string', 'max:30'],
            'akta_number' => ['required', 'string', 'max:50'],
            'weight' => ['required', 'integer', 'min:1'],
            'height' => ['required', 'integer', 'min:1'],
            'head_circum' => ['required', 'integer', 'min:1'],
            'school_dist_km' => ['required', 'numeric', 'min:0'],

            'is_kps' => ['nullable', 'boolean'],
            'kps_number' => ['nullable', 'string', 'max:50'],
            'is_kip' => ['nullable', 'boolean'],
            'kip_number' => ['nullable', 'string', 'max:50'],
            'kip_name' => ['nullable', 'string', 'max:150'],
            'kks_number' => ['nullable', 'string', 'max:50'],
            'is_pip_eligible' => ['nullable', 'boolean'],
            'pip_reason' => ['nullable', 'string'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'bank_holder' => ['nullable', 'string', 'max:150'],
            'special_needs' => ['nullable', 'string', 'max:100'],

            'subjects' => ['nullable', 'array'],
            'subjects.*' => ['exists:subjects,id'],
            'extracurriculars' => ['nullable', 'array'],
            'extracurriculars.*' => ['exists:extracurriculars,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nipd.required' => 'NIPD wajib diisi.',
            'nipd.unique' => 'NIPD sudah terdaftar di sistem.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
            'gender.in' => 'Jenis kelamin harus berupa L atau P.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.unique' => 'NISN sudah terdaftar di sistem.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'religion.required' => 'Agama wajib diisi.',
            'mobile_phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'family_card_no.required' => 'Nomor Kartu Keluarga wajib diisi.',
            'rombel.required' => 'Rombel wajib diisi.',
            'address.required' => 'Alamat jalan wajib diisi.',
            'rt.required' => 'RT wajib diisi.',
            'rw.required' => 'RW wajib diisi.',
            'village.required' => 'Desa / Kelurahan wajib diisi.',
            'district.required' => 'Kecamatan wajib diisi.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'residence_type.required' => 'Jenis tempat tinggal wajib diisi.',
            'transportation.required' => 'Alat transportasi wajib diisi.',
            'father_name.required' => 'Nama ayah kandung wajib diisi.',
            'father_birth_year.required' => 'Tahun lahir ayah wajib diisi.',
            'father_education.required' => 'Pendidikan ayah wajib diisi.',
            'father_occupation.required' => 'Pekerjaan ayah wajib diisi.',
            'father_income.required' => 'Penghasilan ayah wajib diisi.',
            'father_nik.required' => 'NIK ayah wajib diisi.',
            'mother_name.required' => 'Nama ibu kandung wajib diisi.',
            'mother_birth_year.required' => 'Tahun lahir ibu wajib diisi.',
            'mother_education.required' => 'Pendidikan ibu wajib diisi.',
            'mother_occupation.required' => 'Pekerjaan ibu wajib diisi.',
            'mother_income.required' => 'Penghasilan ibu wajib diisi.',
            'mother_nik.required' => 'NIK ibu wajib diisi.',
            'siblings.required' => 'Jumlah saudara kandung wajib diisi.',
            'birth_order.required' => 'Anak ke- wajib diisi.',
            'akta_number.required' => 'Nomor registrasi akta lahir wajib diisi.',
            'weight.required' => 'Berat badan wajib diisi.',
            'height.required' => 'Tinggi badan wajib diisi.',
            'head_circum.required' => 'Lingkar kepala wajib diisi.',
            'school_dist_km.required' => 'Jarak tempat tinggal ke sekolah wajib diisi.',
        ];
    }
}
