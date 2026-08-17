<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $school = School::first();
        $users = User::all();
        $adminUser = $users->where('role', 'admin')->first();
        $staffUser = $users->where('role', 'staff')->first() ?? $adminUser;
        $subjects = Subject::all();
        $extracurriculars = Extracurricular::all();

        $rombelGroups = [
            'VII-A' => 51,
            'VII-B' => 51,
            'VIII-A' => 51,
            'VIII-B' => 51,
            'IX-A' => 50,
            'IX-B' => 50,
        ];

        $studentCount = 1;

        DB::transaction(function () use ($faker, $school, $adminUser, $staffUser, $subjects, $extracurriculars, $rombelGroups, &$studentCount) {
            foreach ($rombelGroups as $rombel => $count) {
                for ($i = 0; $i < $count; $i++) {
                    $creator = $faker->boolean(50) ? $adminUser : $staffUser;
                    $gender = $faker->randomElement(['L', 'P']);
                    $name = $gender === 'L' 
                        ? $faker->firstNameMale() . ' ' . $faker->lastNameMale() 
                        : $faker->firstNameFemale() . ' ' . $faker->lastNameFemale();

                    $nisn = sprintf('310%07d', $studentCount);
                    $nipd = sprintf('25%04d', $studentCount);
                    $uuid = 'std-' . sprintf('%06d', $studentCount) . '-' . strtolower($faker->bothify('??##'));

                    $student = Student::create([
                        'uuid' => $uuid,
                        'school_id' => $school->id,
                        'created_by' => $creator->id,
                        'updated_by' => $creator->id,
                        'nipd' => $nipd,
                        'name' => $name,
                        'gender' => $gender,
                        'nisn' => $nisn,
                        'birth_place' => $faker->city(),
                        'birth_date' => $faker->date('Y-m-d', '2013-12-31'),
                        'religion' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                        'email' => $faker->unique()->safeEmail(),
                        'mobile_phone' => '08' . $faker->numerify('##########'),
                        'phone' => '022' . $faker->numerify('#######'),
                        'previous_school' => 'SDN ' . $faker->numberBetween(1, 5) . ' ' . $faker->city(),
                        'family_card_no' => $faker->numerify('3212##############'),
                        'rombel' => $rombel,
                    ]);

                    $student->address()->create([
                        'address' => $faker->streetAddress(),
                        'rt' => sprintf('%03d', $faker->numberBetween(1, 20)),
                        'rw' => sprintf('%03d', $faker->numberBetween(1, 20)),
                        'dusun' => 'Dusun ' . $faker->word(),
                        'village' => 'Desa ' . $faker->word(),
                        'district' => 'Kecamatan ' . $faker->word(),
                        'postal_code' => $faker->numerify('441##'),
                        'residence_type' => $faker->randomElement(['Bersama orang tua', 'Kos', 'Wali']),
                        'transportation' => $faker->randomElement(['Jalan kaki', 'Sepeda motor', 'Sepeda', 'Angkutan umum']),
                        'latitude' => $faker->latitude(-7.500000, -7.200000),
                        'longitude' => $faker->longitude(107.400000, 107.600000),
                    ]);

                    $fatherName = $faker->firstNameMale() . ' ' . $faker->lastNameMale();
                    $motherName = $faker->firstNameFemale() . ' ' . $faker->lastNameFemale();
                    $guardianName = $faker->boolean(15) ? $faker->name() : null;

                    $student->parent()->create([
                        'father_name' => $fatherName,
                        'father_birth_year' => (string)$faker->numberBetween(1970, 1985),
                        'father_education' => $faker->randomElement(['SD', 'SMP', 'SMA', 'Diploma', 'S1']),
                        'father_occupation' => $faker->randomElement(['Petani', 'Buruh', 'Wiraswasta', 'PNS', 'Karyawan Swasta']),
                        'father_income' => $faker->randomElement(['Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 5.000.000', '> Rp 5.000.000']),
                        'father_nik' => $faker->numerify('3212##############'),
                        'mother_name' => $motherName,
                        'mother_birth_year' => (string)$faker->numberBetween(1972, 1988),
                        'mother_education' => $faker->randomElement(['SD', 'SMP', 'SMA', 'Diploma', 'S1']),
                        'mother_occupation' => $faker->randomElement(['Ibu Rumah Tangga', 'Petani', 'Buruh', 'Wiraswasta', 'PNS']),
                        'mother_income' => $faker->randomElement(['Tidak Berpenghasilan', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 5.000.000']),
                        'mother_nik' => $faker->numerify('3212##############'),
                        'guardian_name' => $guardianName,
                        'guardian_birth_year' => $guardianName ? (string)$faker->numberBetween(1965, 1980) : null,
                        'guardian_education' => $guardianName ? $faker->randomElement(['SD', 'SMP', 'SMA', 'S1']) : null,
                        'guardian_occupation' => $guardianName ? $faker->randomElement(['Petani', 'Wiraswasta', 'Buruh']) : null,
                        'guardian_income' => $guardianName ? $faker->randomElement(['Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 5.000.000']) : null,
                        'guardian_nik' => $guardianName ? $faker->numerify('3212##############') : null,
                        'siblings' => $faker->numberBetween(0, 4),
                        'birth_order' => $faker->numberBetween(1, 5),
                    ]);

                    $student->academic()->create([
                        'skhun_number' => 'DN-01/D-SD/06/' . $faker->numerify('#######'),
                        'un_number' => '1-15-02-01-001-' . $faker->numerify('###') . '-9',
                        'ijazah_number' => 'DN-01/D-SD/06/' . $faker->numerify('#######'),
                        'akta_number' => 'AKTA-' . $faker->numerify('#####/####/Y-####'),
                        'weight' => $faker->numberBetween(35, 65),
                        'height' => $faker->numberBetween(135, 170),
                        'head_circum' => $faker->numberBetween(51, 58),
                        'school_dist_km' => $faker->randomFloat(2, 0.1, 15.0),
                    ]);

                    $isKip = $faker->boolean(20);
                    $student->financial()->create([
                        'is_kps' => $faker->boolean(10),
                        'kps_number' => $faker->boolean(10) ? 'KPS-' . $faker->numerify('#########') : null,
                        'is_kip' => $isKip,
                        'kip_number' => $isKip ? 'KIP-' . $faker->numerify('#########') : null,
                        'kip_name' => $isKip ? $name : null,
                        'kks_number' => $faker->boolean(10) ? 'KKS-' . $faker->numerify('#########') : null,
                        'is_pip_eligible' => $isKip,
                        'pip_reason' => $isKip ? 'Penerima KIP' : null,
                        'bank_name' => $isKip ? $faker->randomElement(['BRI', 'BNI', 'Mandiri']) : null,
                        'bank_account' => $isKip ? $faker->numerify('##############') : null,
                        'bank_holder' => $isKip ? $name : null,
                        'special_needs' => $faker->boolean(2) ? 'Lambat Belajar' : 'Tidak Ada',
                    ]);

                    $student->subjects()->sync($subjects->pluck('id')->toArray());

                    $chosenEkskul = $extracurriculars->random($faker->numberBetween(1, 2));
                    $student->extracurriculars()->sync($chosenEkskul->pluck('id')->toArray());

                    $studentCount++;
                }
            }
        });
    }
}
