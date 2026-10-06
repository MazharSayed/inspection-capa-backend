<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InspectionRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'requested_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class)->orderBy('sequence');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['project_id'] ?? null, fn ($q, $v) => $q->where('project_id', $v))
            ->when($filters['division_id'] ?? null, fn ($q, $v) => $q->where('division_id', $v))
            ->when($filters['sub_division_id'] ?? null, fn ($q, $v) => $q->where('sub_division_id', $v))
            ->when($filters['activity_id'] ?? null, fn ($q, $v) => $q->where('activity_id', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['q'] ?? null, fn ($q, $v) => $q->where(function ($w) use ($v) {
                $w->where('technician', 'like', "%{$v}%")
                    ->orWhere('unit', 'like', "%{$v}%")
                    ->orWhereHas('project', fn ($p) => $p->where('name', 'like', "%{$v}%"));
            }));
    }
}
