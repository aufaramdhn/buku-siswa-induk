<?php

namespace App\Actions\Extracurricular;

use App\Models\Extracurricular;
use Illuminate\Support\Str;

class CreateExtracurricularAction
{
    public function execute(array $data, int $schoolId, int $userId): Extracurricular
    {
        return Extracurricular::create([
            'uuid' => 'exc-' . Str::lower(Str::random(12)),
            'school_id' => $schoolId,
            'created_by' => $userId,
            'updated_by' => $userId,
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
    }
}
