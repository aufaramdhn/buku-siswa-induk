<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentParent extends Model
{
    protected $primaryKey = 'student_id';

    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'father_name',
        'father_birth_year',
        'father_education',
        'father_occupation',
        'father_income',
        'father_nik',
        'mother_name',
        'mother_birth_year',
        'mother_education',
        'mother_occupation',
        'mother_income',
        'mother_nik',
        'guardian_name',
        'guardian_birth_year',
        'guardian_education',
        'guardian_occupation',
        'guardian_income',
        'guardian_nik',
        'siblings',
        'birth_order',
    ];

    protected function casts(): array
    {
        return [
            'father_nik' => 'encrypted',
            'mother_nik' => 'encrypted',
            'guardian_nik' => 'encrypted',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
