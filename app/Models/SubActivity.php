<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
