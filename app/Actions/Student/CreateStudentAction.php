<?php

namespace App\Actions\Student;

use App\Models\AuditLog;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateStudentAction
{
    public function execute(array $data, int $schoolId, int $userId): Student
    {
        return DB::transaction(function () use ($data, $schoolId, $userId) {
            $student = Student::create([
                'uuid' => 'std-' . Str::lower(Str::random(12)),
                'school_id' => $schoolId,
                'created_by' => $userId,
                'updated_by' => $userId,
                'nipd' => $data['nipd'],
                'name' => $data['name'],
                'gender' => $data['gender'],
                'nisn' => $data['nisn'] ?? null,
                'birth_place' => $data['birth_place'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'religion' => $data['religion'] ?? null,
                'email' => $data['email'] ?? null,
                'mobile_phone' => $data['mobile_phone'] ?? null,
                'phone' => $data['phone'] ?? null,
                'previous_school' => $data['previous_school'] ?? null,
                'family_card_no' => $data['family_card_no'] ?? null,
                'rombel' => $data['rombel'],
            ]);

            $student->address()->create([
                'address' => $data['address'] ?? null,
                'rt' => $data['rt'] ?? null,
                'rw' => $data['rw'] ?? null,
                'dusun' => $data['dusun'] ?? null,
                'village' => $data['village'] ?? null,
                'district' => $data['district'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'residence_type' => $data['residence_type'] ?? null,
                'transportation' => $data['transportation'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
            ]);

            $student->parent()->create([
                'father_name' => $data['father_name'] ?? null,
                'father_birth_year' => $data['father_birth_year'] ?? null,
                'father_education' => $data['father_education'] ?? null,
                'father_occupation' => $data['father_occupation'] ?? null,
                'father_income' => $data['father_income'] ?? null,
                'father_nik' => $data['father_nik'] ?? null,
                'mother_name' => $data['mother_name'] ?? null,
                'mother_birth_year' => $data['mother_birth_year'] ?? null,
                'mother_education' => $data['mother_education'] ?? null,
                'mother_occupation' => $data['mother_occupation'] ?? null,
                'mother_income' => $data['mother_income'] ?? null,
                'mother_nik' => $data['mother_nik'] ?? null,
                'guardian_name' => $data['guardian_name'] ?? null,
                'guardian_birth_year' => $data['guardian_birth_year'] ?? null,
                'guardian_education' => $data['guardian_education'] ?? null,
                'guardian_occupation' => $data['guardian_occupation'] ?? null,
                'guardian_income' => $data['guardian_income'] ?? null,
                'guardian_nik' => $data['guardian_nik'] ?? null,
                'siblings' => $data['siblings'] ?? null,
                'birth_order' => $data['birth_order'] ?? null,
            ]);

            $student->academic()->create([
                'skhun_number' => $data['skhun_number'] ?? null,
                'un_number' => $data['un_number'] ?? null,
                'ijazah_number' => $data['ijazah_number'] ?? null,
                'akta_number' => $data['akta_number'] ?? null,
                'weight' => $data['weight'] ?? null,
                'height' => $data['height'] ?? null,
                'head_circum' => $data['head_circum'] ?? null,
                'school_dist_km' => $data['school_dist_km'] ?? null,
            ]);

            $student->financial()->create([
                'is_kps' => filter_var($data['is_kps'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'kps_number' => $data['kps_number'] ?? null,
                'is_kip' => filter_var($data['is_kip'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'kip_number' => $data['kip_number'] ?? null,
                'kip_name' => $data['kip_name'] ?? null,
                'kks_number' => $data['kks_number'] ?? null,
                'is_pip_eligible' => filter_var($data['is_pip_eligible'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'pip_reason' => $data['pip_reason'] ?? null,
                'bank_name' => $data['bank_name'] ?? null,
                'bank_account' => $data['bank_account'] ?? null,
                'bank_holder' => $data['bank_holder'] ?? null,
                'special_needs' => $data['special_needs'] ?? null,
            ]);

            if (isset($data['subjects'])) {
                $student->subjects()->sync($data['subjects']);
            }

            if (isset($data['extracurriculars'])) {
                $student->extracurriculars()->sync($data['extracurriculars']);
            }

            AuditLog::create([
                'user_id' => $userId,
                'action' => 'CREATE_STUDENT',
                'student_id' => $student->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'payload_changes' => [
                    'nipd' => $student->nipd,
                    'name' => $student->name,
                    'rombel' => $student->rombel,
                ],
            ]);

            return $student;
        });
    }
}
