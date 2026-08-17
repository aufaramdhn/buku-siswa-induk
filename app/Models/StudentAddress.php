<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAddress extends Model
{
    protected $primaryKey = 'student_id';

    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'address',
        'rt',
        'rw',
        'dusun',
        'village',
        'district',
        'postal_code',
        'residence_type',
        'transportation',
        'latitude',
        'longitude',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
