<?php

namespace App\Actions\Subject;

use App\Models\Subject;
use Illuminate\Support\Str;

class CreateSubjectAction
{
    public function execute(array $data, int $schoolId, int $userId): Subject
    {
        return Subject::create([
            'uuid' => 'sub-' . Str::lower(Str::random(12)),
            'school_id' => $schoolId,
            'created_by' => $userId,
            'updated_by' => $userId,
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
    }
}
