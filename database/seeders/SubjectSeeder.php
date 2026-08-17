<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $admin = User::where('username', 'admin')->first();

        $subjects = [
            ['code' => 'MP01', 'name' => 'Pendidikan Agama dan Budi Pekerti'],
            ['code' => 'MP02', 'name' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)'],
            ['code' => 'MP03', 'name' => 'Bahasa Indonesia'],
            ['code' => 'MP04', 'name' => 'Matematika'],
            ['code' => 'MP05', 'name' => 'Ilmu Pengetahuan Alam (IPA)'],
            ['code' => 'MP06', 'name' => 'Ilmu Pengetahuan Sosial (IPS)'],
            ['code' => 'MP07', 'name' => 'Bahasa Inggris'],
            ['code' => 'MP08', 'name' => 'Seni Budaya'],
            ['code' => 'MP09', 'name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)'],
            ['code' => 'MP10', 'name' => 'Informatika'],
            ['code' => 'MP11', 'name' => 'Bahasa Sunda (Muatan Lokal Jawa Barat)'],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'uuid' => 'sub-' . strtolower($subject['code']),
                'school_id' => $school->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
                'code' => $subject['code'],
                'name' => $subject['name'],
            ]);
        }
    }
}
