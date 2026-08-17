<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::create([
            'uuid' => 'sch-cisewu-202526',
            'name' => 'SMPN 1 Cisewu',
            'npsn' => '958465432128',
            'nss' => '8465432188765',
            'address' => 'Kecamatan Kec. Cisewu, Kabupaten Kab. Garut, Provinsi Prov. Jawa Barat',
            'rt' => 15,
            'rw' => 18,
            'village' => 'Desa Cisewu',
            'district' => 'Cisewu',
            'regency' => 'Kabupaten Garut',
            'province' => 'Jawa Barat',
            'headmaster_name' => 'Est nemo labore temp',
            'headmaster_nip' => 'Sed illo in amet ve',
            'tu_head_name' => 'Cumque quia alias fu',
            'tu_head_nip' => 'Enim animi ut dolor',
            'academic_year' => '2025-2026',
        ]);
    }
}
