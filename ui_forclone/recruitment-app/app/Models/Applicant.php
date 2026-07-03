<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'whatsapp_number',
        'gender',
        'date_of_birth',
        'nationality',
        'city_of_residence',
        'applicant_type',
        'staff_id',
        'bio',
        'address',
        'home_address',
        'emergency_name',
        'emergency_number',
        'highest_qualification',
        'institution',
        'graduation_year',
        'major',
        'certifications',
        'years_experience',
        'skills_proficiency',
        'dismissed',
        'convicted',
        'abide_policies',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
