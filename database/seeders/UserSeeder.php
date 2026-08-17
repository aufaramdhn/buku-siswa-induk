<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();

        User::create([
            'uuid' => 'usr-admin-000001',
            'school_id' => $school->id,
            'username' => 'admin',
            'email' => 'admin@bukuinduk.sch.id',
            'password' => Hash::make('@SMPN1CisewuAdmin2026!'),
            'role' => 'admin',
        ]);

        User::create([
            'uuid' => 'usr-staff-000002',
            'school_id' => $school->id,
            'username' => 'staff',
            'email' => 'staff@bukuinduk.sch.id',
            'password' => Hash::make('@SMPN1CisewuStaff2026!'),
            'role' => 'staff',
        ]);
    }
}
