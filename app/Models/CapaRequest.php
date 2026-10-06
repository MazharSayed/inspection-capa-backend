<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class CapaRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'capa_created_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['project_id'] ?? null, fn ($q, $v) => $q->where('project_id', $v))
            ->when($filters['division_id'] ?? null, fn ($q, $v) => $q->where('division_id', $v))
            ->when($filters['activity_id'] ?? null, fn ($q, $v) => $q->where('activity_id', $v))
            ->when($filters['sub_division_id'] ?? null, fn ($q, $v) => $q->whereHas('activity', fn ($a) => $a->where('sub_division_id', $v)))
            ->when($filters['sub_activity'] ?? null, fn ($q, $v) => $q->whereHas('subActivity', fn ($a) => $a->where('name', $v)))
            ->when($filters['created_at'] ?? null, fn ($q, $v) => $q->whereDate('capa_created_at', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['q'] ?? null, fn ($q, $v) => $q->where(function ($w) use ($v) {
                $w->where('defect_type', 'like', "%{$v}%")
                    ->orWhere('approver', 'like', "%{$v}%")
                    ->orWhereHas('project', fn ($p) => $p->where('name', 'like', "%{$v}%"));
            }));
    }
}
