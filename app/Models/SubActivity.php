<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SubActivity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'level_engineer' => 'boolean',
        'level_qcs' => 'boolean',
        'level_qaqc' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['project_id'] ?? null, fn ($q, $v) => $q->where('project_id', $v))
            ->when($filters['activity_id'] ?? null, fn ($q, $v) => $q->where('activity_id', $v))
            ->when($filters['sub_division_id'] ?? null, fn ($q, $v) => $q->whereHas('activity', fn ($a) => $a->where('sub_division_id', $v)))
            ->when($filters['division_id'] ?? null, fn ($q, $v) => $q->whereHas('activity.subDivision', fn ($a) => $a->where('division_id', $v)))
            ->when($filters['q'] ?? null, fn ($q, $v) => $q->where('name', 'like', "%{$v}%"));
    }
}
