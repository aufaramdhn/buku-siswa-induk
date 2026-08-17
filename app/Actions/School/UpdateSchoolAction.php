<?php

namespace App\Actions\School;

use App\Models\School;
use Illuminate\Support\Facades\Cache;

class UpdateSchoolAction
{
    public function execute(School $school, array $data): bool
    {
        $updated = $school->update($data);

        if ($updated) {
            Cache::forget('active_school_profile');
        }

        return $updated;
    }
}
