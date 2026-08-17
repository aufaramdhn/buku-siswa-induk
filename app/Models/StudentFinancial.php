<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentFinancial extends Model
{
    protected $primaryKey = 'student_id';

    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'is_kps',
        'kps_number',
        'is_kip',
        'kip_number',
        'kip_name',
        'kks_number',
        'is_pip_eligible',
        'pip_reason',
        'bank_name',
        'bank_account',
        'bank_holder',
        'special_needs',
    ];

    protected function casts(): array
    {
        return [
            'is_kps' => 'boolean',
            'is_kip' => 'boolean',
            'is_pip_eligible' => 'boolean',
            'bank_account' => 'encrypted',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
