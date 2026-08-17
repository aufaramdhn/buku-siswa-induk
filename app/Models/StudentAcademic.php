<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAcademic extends Model
{
    protected $primaryKey = 'student_id';

    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'skhun_number',
        'un_number',
        'ijazah_number',
        'akta_number',
        'weight',
        'height',
        'head_circum',
        'school_dist_km',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
