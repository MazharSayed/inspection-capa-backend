<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
