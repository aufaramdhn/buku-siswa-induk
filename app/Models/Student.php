<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = [
        'uuid',
        'school_id',
        'created_by',
        'updated_by',
        'nipd',
        'name',
        'gender',
        'nisn',
        'birth_place',
        'birth_date',
        'religion',
        'email',
        'mobile_phone',
        'phone',
        'previous_school',
        'family_card_no',
        'rombel',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'family_card_no' => 'encrypted',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function address(): HasOne
    {
        return $this->hasOne(StudentAddress::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(StudentParent::class);
    }

    public function academic(): HasOne
    {
        return $this->hasOne(StudentAcademic::class);
    }

    public function financial(): HasOne
    {
        return $this->hasOne(StudentFinancial::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }

    public function extracurriculars(): BelongsToMany
    {
        return $this->belongsToMany(Extracurricular::class, 'student_extracurricular');
    }
}
