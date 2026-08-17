<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Extracurricular extends Model
{
    protected $fillable = [
        'uuid',
        'school_id',
        'created_by',
        'updated_by',
        'code',
        'name',
    ];

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

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_extracurricular');
    }
}
