<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $fillable = [
        'applicant_id',
        'job_opening_id',
        'reference_number',
        'current_stage',
        'decision_status',
        'rejection_reason',
        'submitted_at',
        'applicant_type',
        'position_applying_for',
        'subjects_can_teach',
        'grades_preferred',
        'reference_data',
        'available_start_date',
        'commitment_type',
        'personal_statement',
        'previous_school',
        'abide_policies',
        'prev_position',
        'prev_subjects',
        'prev_period',
        'prev_school_2',
        'prev_position_2',
        'prev_period_2',
        'new_app_employer1',
        'new_app_employer2',
        'current_dept',
        'years_served',
        'achievements',
        'challenges',
        'why_continue',
        'other_commitments',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reference_data' => 'array',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function jobOpening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ApplicationNote::class);
    }

    public function logActivity($content, $userId = null)
    {
        return $this->notes()->create([
            'content' => $content,
            'type' => 'system',
            'user_id' => $userId ?? auth()->id(),
        ]);
    }
}
