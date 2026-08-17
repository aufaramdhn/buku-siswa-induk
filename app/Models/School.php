<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'npsn',
        'nss',
        'academic_year',
        'address',
        'rt',
        'rw',
        'village',
        'district',
        'regency',
        'province',
        'headmaster_name',
        'tu_head_name',
        'headmaster_nip',
        'tu_head_nip',
        'headmaster_period',
        'tu_head_period',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function extracurriculars(): HasMany
    {
        return $this->hasMany(Extracurricular::class);
    }
}
