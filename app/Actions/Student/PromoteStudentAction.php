<?php

namespace App\Actions\Student;

use App\Models\AuditLog;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class PromoteStudentAction
{
    public function execute(array $studentIds, string $targetRombel, int $userId): bool
    {
        return DB::transaction(function () use ($studentIds, $targetRombel, $userId) {
            $updated = Student::whereIn('id', $studentIds)->update([
                'rombel' => $targetRombel,
                'updated_by' => $userId,
            ]);

            if ($updated > 0) {
                AuditLog::create([
                    'user_id' => $userId,
                    'action' => 'PROMOTE_STUDENTS',
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'payload_changes' => [
                        'student_ids' => $studentIds,
                        'target_rombel' => $targetRombel,
                        'count' => $updated,
                    ],
                ]);
            }

            return $updated > 0;
        });
    }
}
