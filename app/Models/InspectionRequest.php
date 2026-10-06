<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
