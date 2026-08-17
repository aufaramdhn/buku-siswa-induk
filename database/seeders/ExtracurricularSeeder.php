<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExtracurricularSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $admin = User::where('username', 'admin')->first();

        $extracurriculars = [
            ['code' => 'EK01', 'name' => 'Pramuka (Wajib)'],
            ['code' => 'EK02', 'name' => 'Paskibra (Pasukan Pengibar Bendera)'],
            ['code' => 'EK03', 'name' => 'PMR (Palang Merah Remaja)'],
            ['code' => 'EK04', 'name' => 'Futsal'],
            ['code' => 'EK05', 'name' => 'Bola Voli'],
            ['code' => 'EK06', 'name' => 'English Club'],
            ['code' => 'EK07', 'name' => 'Seni Tari Sunda (Muatan Lokal Jawa Barat)'],
            ['code' => 'EK08', 'name' => 'Rohani Islam (Rohis)'],
        ];

        foreach ($extracurriculars as $ekskul) {
            Extracurricular::create([
                'uuid' => 'exc-' . strtolower($ekskul['code']),
                'school_id' => $school->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
                'code' => $ekskul['code'],
                'name' => $ekskul['name'],
            ]);
        }
    }
}
